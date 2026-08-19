<?php

namespace App\Http\Controllers;

use App\Http\Requests\InventoryRequestFormRequest;
use App\Models\Category;
use App\Models\InventoryRequest;
use App\Services\ActivityLogService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;

class InventoryRequestController extends Controller
{
    public function __construct(
        private ActivityLogService $activityLogService
    ) {
    }

    /**
     * Daftar pengajuan barang.
     */
public function index(Request $request): View
{
    $user = $request->user();

    $query = InventoryRequest::query()
        ->with([
            'requester',
            'department',
            'outlet',
            'items.category',
        ])
        ->latest();


    /*
    |--------------------------------------------------------------------------
    | Hak akses data
    |--------------------------------------------------------------------------
    */

    if ($user->isSuperAdmin()) {

        // Super Admin dapat melihat semua pengajuan

    } elseif ($user->isHoAdmin()) {

        $query->whereNull('outlet_id');

        if ($user->department_id) {
            $query->where(
                'department_id',
                $user->department_id
            );
        }

    } elseif ($user->isOutletAdmin()) {

        $query->where(
            'outlet_id',
            $user->outlet_id
        );

    } else {

        // User biasa hanya melihat pengajuan miliknya
        $query->where(
            'requester_id',
            $user->id
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Search
    |--------------------------------------------------------------------------
    */

    if ($request->filled('search')) {

        $search = $request->search;

        $query->where(function ($q) use ($search) {

            $q->where(
                'request_number',
                'like',
                "%{$search}%"
            );

        });
    }


    /*
    |--------------------------------------------------------------------------
    | Filter status
    |--------------------------------------------------------------------------
    */

    if ($request->filled('status')) {

        $query->where(
            'status',
            $request->status
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Pagination
    |--------------------------------------------------------------------------
    */

    $requests = $query
        ->paginate(10)
        ->withQueryString();


    return view(
        'inventory-requests.index',
        compact('requests')
    );
}


    /**
     * Form tambah pengajuan.
     */
    public function create(
        Request $request
    ): View {

        $user = $request->user();

        $categories = Category::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->get([
                'id',
                'code',
                'name',
            ]);

        return view(
            'inventory-requests.create',
            compact(
                'categories'
            )
        );
    }


    /**
     * Simpan pengajuan.
     */
    public function store(
        InventoryRequestFormRequest $request
    ): RedirectResponse {

        $user = $request->user();

        /*
        |--------------------------------------------------------------------------
        | Tentukan lokasi pengajuan
        |--------------------------------------------------------------------------
        */

        if ($user->isOutletAdmin()) {

            if (!$user->outlet_id) {

                return back()
                    ->withErrors([
                        'outlet_id' =>
                            'Akun Outlet Admin belum terhubung dengan outlet.'
                    ])
                    ->withInput();
            }

            /*
            | Outlet Admin selalu menggunakan outlet miliknya.
            */

            $departmentId = null;

            $outletId = $user->outlet_id;
        }

        elseif ($user->isHoAdmin()) {

            /*
            | HO Admin selalu membuat pengajuan Head Office.
            */

            if (!$user->department_id) {

                return back()
                    ->withErrors([
                        'department_id' =>
                            'Akun HO Admin belum terhubung dengan department.'
                    ])
                    ->withInput();
            }

            $departmentId = $user->department_id;

            $outletId = null;
        }

        else {

            /*
            | Super Admin / user lain.
            */

            $departmentId =
                $user->department_id;

            $outletId =
                $user->outlet_id;
        }


        /*
        |--------------------------------------------------------------------------
        | Simpan menggunakan transaction
        |--------------------------------------------------------------------------
        */

        $inventoryRequest = DB::transaction(
            function () use (
                $request,
                $user,
                $departmentId,
                $outletId
            ) {

                /*
                |--------------------------------------------------------------------------
                | Generate nomor pengajuan
                |--------------------------------------------------------------------------
                */

                $requestNumber =
                    'REQ-' .
                    now()->format('Ymd') .
                    '-' .
                    strtoupper(
                        Str::random(6)
                    );


                /*
                |--------------------------------------------------------------------------
                | Header Pengajuan
                |--------------------------------------------------------------------------
                */

                $inventoryRequest =
                    InventoryRequest::create([

                        'request_number' =>
                            $requestNumber,

                        'requester_id' =>
                            $user->id,

                        'department_id' =>
                            $departmentId,

                        'outlet_id' =>
                            $outletId,

                        'request_type' =>
                            $request->request_type,

                        'status' =>
                            'submitted',

                        'reason' =>
                            $request->reason,

                        'notes' =>
                            $request->notes,

                    ]);


                /*
                |--------------------------------------------------------------------------
                | Item Pengajuan
                |--------------------------------------------------------------------------
                */

                foreach (
                    $request->items
                    as $item
                ) {

                    $inventoryRequest
                        ->items()
                        ->create([

                            'category_id' =>
                                $item['category_id']
                                ?? null,

                            'item_name' =>
                                $item['item_name'],

                            'specification' =>
                                $item['specification']
                                ?? null,

                            'quantity' =>
                                $item['quantity'],

                            'notes' =>
                                $item['notes']
                                ?? null,

                        ]);
                }


                return $inventoryRequest;
            }
        );


        /*
        |--------------------------------------------------------------------------
        | Activity Log
        |--------------------------------------------------------------------------
        */

        $inventoryRequest->load([
            'requester',
            'department',
            'outlet',
            'items.category',
        ]);

        $this->activityLogService->log(
            'CREATE',
            'Inventory Request',
            "Membuat pengajuan {$inventoryRequest->request_number}",
            $inventoryRequest,
            null,
            $inventoryRequest->toArray()
        );


        return redirect()
            ->route(
                'inventory-requests.show',
                $inventoryRequest
            )
            ->with(
                'success',
                'Pengajuan barang berhasil dibuat.'
            );
    }


    /**
     * Detail pengajuan.
     */
    public function show(
        Request $request,
        InventoryRequest $inventoryRequest
    ): View {

        $this->authorizeRequest(
            $inventoryRequest
        );

        $inventoryRequest->load([
            'requester',
            'department',
            'outlet',
            'approver',
            'items.category',
        ]);

        return view(
            'inventory-requests.show',
            compact(
                'inventoryRequest'
            )
        );
    }


    /**
     * Batalkan pengajuan.
     */
    public function cancel(
        Request $request,
        InventoryRequest $inventoryRequest
    ): RedirectResponse {

        $this->authorizeRequest(
            $inventoryRequest
        );

        /*
        |--------------------------------------------------------------------------
        | Hanya pengajuan submitted yang bisa dibatalkan.
        |--------------------------------------------------------------------------
        */

        if (
            $inventoryRequest->status !==
            'submitted'
        ) {

            return back()->with(
                'error',
                'Pengajuan yang sudah diproses tidak dapat dibatalkan.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Simpan data lama untuk Activity Log
        |--------------------------------------------------------------------------
        */

        $oldData =
            $inventoryRequest->toArray();


        $inventoryRequest->update([
            'status' => 'cancelled',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Activity Log
        |--------------------------------------------------------------------------
        */

        $this->activityLogService->log(
            'UPDATE',
            'Inventory Request',
            "Membatalkan pengajuan {$inventoryRequest->request_number}",
            $inventoryRequest,
            $oldData,
            $inventoryRequest->fresh()->toArray()
        );


        return redirect()
            ->route(
                'inventory-requests.index'
            )
            ->with(
                'success',
                'Pengajuan berhasil dibatalkan.'
            );
    }


    /**
     * Authorization pengajuan.
     */

/**
 * Menyetujui pengajuan.
 */
    public function approve(
        Request $request,
        InventoryRequest $inventoryRequest
    ): RedirectResponse {

        $user = $request->user();

        /*
        |--------------------------------------------------------------------------
        | Pastikan user memiliki hak approval
        |--------------------------------------------------------------------------
        */

        $this->authorizeApproval(
            $inventoryRequest,
            $user
        );


        /*
        |--------------------------------------------------------------------------
        | Hanya submitted yang bisa disetujui
        |--------------------------------------------------------------------------
        */

        if ($inventoryRequest->status !== 'submitted') {

            return back()->with(
                'error',
                'Pengajuan ini sudah diproses sebelumnya.'
            );
        }


        $oldData =
            $inventoryRequest->toArray();


        /*
        |--------------------------------------------------------------------------
        | Update approval
        |--------------------------------------------------------------------------
        */

        $inventoryRequest->update([

            'status' =>
                'approved',

            'approved_by' =>
                $user->id,

            'approved_at' =>
                now(),

            'rejected_reason' =>
                null,

        ]);


        /*
        |--------------------------------------------------------------------------
        | Activity Log
        |--------------------------------------------------------------------------
        */

        $this->activityLogService->log(

            'UPDATE',

            'Inventory Request',

            "Menyetujui pengajuan {$inventoryRequest->request_number}",

            $inventoryRequest,

            $oldData,

            $inventoryRequest
                ->fresh()
                ->toArray()
        );


        return back()->with(
            'success',
            'Pengajuan berhasil disetujui.'
        );
    }

    /**
 * Menolak pengajuan.
 */
public function reject(
    Request $request,
    InventoryRequest $inventoryRequest
): RedirectResponse {

    $user = $request->user();


    /*
    |--------------------------------------------------------------------------
    | Pastikan user memiliki hak approval
    |--------------------------------------------------------------------------
    */

    $this->authorizeApproval(
        $inventoryRequest,
        $user
    );


    /*
    |--------------------------------------------------------------------------
    | Validasi alasan penolakan
    |--------------------------------------------------------------------------
    */

    $request->validate([
        'rejected_reason' => [
            'required',
            'string',
            'max:2000',
        ],
    ], [
        'rejected_reason.required' =>
            'Alasan penolakan wajib diisi.',
    ]);


    /*
    |--------------------------------------------------------------------------
    | Hanya submitted yang bisa ditolak
    |--------------------------------------------------------------------------
    */

    if ($inventoryRequest->status !== 'submitted') {

        return back()->with(
            'error',
            'Pengajuan ini sudah diproses sebelumnya.'
        );
    }


    $oldData =
        $inventoryRequest->toArray();


    /*
    |--------------------------------------------------------------------------
    | Update rejection
    |--------------------------------------------------------------------------
    */

    $inventoryRequest->update([

        'status' =>
            'rejected',

        'approved_by' =>
            $user->id,

        'approved_at' =>
            now(),

        'rejected_reason' =>
            $request->rejected_reason,

    ]);


    /*
    |--------------------------------------------------------------------------
    | Activity Log
    |--------------------------------------------------------------------------
    */

    $this->activityLogService->log(

        'UPDATE',

        'Inventory Request',

        "Menolak pengajuan {$inventoryRequest->request_number}",

        $inventoryRequest,

        $oldData,

        $inventoryRequest
            ->fresh()
            ->toArray()
    );


    return back()->with(
        'success',
        'Pengajuan berhasil ditolak.'
    );
}

/**
 * Memeriksa hak user untuk melakukan approval.
 */
private function authorizeApproval(
    InventoryRequest $inventoryRequest,
    $user
): void {

    /*
    |--------------------------------------------------------------------------
    | Super Admin
    |--------------------------------------------------------------------------
    */

    if ($user->isSuperAdmin()) {
        return;
    }


    /*
    |--------------------------------------------------------------------------
    | HO Admin
    |--------------------------------------------------------------------------
    |
    | Hanya pengajuan Head Office milik department-nya.
    |
    */

    if ($user->isHoAdmin()) {

        abort_unless(

            $inventoryRequest->outlet_id === null
            &&
            $inventoryRequest->department_id ===
                $user->department_id,

            403,

            'Anda tidak memiliki hak untuk menyetujui pengajuan ini.'
        );

        return;
    }


    /*
    |--------------------------------------------------------------------------
    | Outlet Admin
    |--------------------------------------------------------------------------
    |
    | Hanya pengajuan dari outlet miliknya.
    |
    */

    if ($user->isOutletAdmin()) {

        abort_unless(

            $inventoryRequest->outlet_id ===
                $user->outlet_id,

            403,

            'Anda tidak memiliki hak untuk menyetujui pengajuan outlet ini.'
        );

        return;
    }


    /*
    |--------------------------------------------------------------------------
    | User biasa tidak boleh approval
    |--------------------------------------------------------------------------
    */

    abort(
        403,
        'Anda tidak memiliki hak untuk melakukan approval.'
    );
}

    private function authorizeRequest(
        InventoryRequest $inventoryRequest
    ): void {

        $user =
            request()->user();


        /*
        |--------------------------------------------------------------------------
        | Super Admin
        |--------------------------------------------------------------------------
        */

        if ($user->isSuperAdmin()) {
            return;
        }


        /*
        |--------------------------------------------------------------------------
        | HO Admin
        |--------------------------------------------------------------------------
        */

        if ($user->isHoAdmin()) {

            abort_unless(

                $inventoryRequest->outlet_id === null
                &&
                $inventoryRequest->department_id ===
                    $user->department_id,

                403,

                'Anda tidak memiliki akses ke pengajuan ini.'
            );

            return;
        }


        /*
        |--------------------------------------------------------------------------
        | Outlet Admin
        |--------------------------------------------------------------------------
        */

        if ($user->isOutletAdmin()) {

            abort_unless(

                $inventoryRequest->outlet_id ===
                    $user->outlet_id,

                403,

                'Anda tidak memiliki akses ke pengajuan ini.'
            );

            return;
        }


        /*
        |--------------------------------------------------------------------------
        | User biasa
        |--------------------------------------------------------------------------
        */

        abort_unless(

            $inventoryRequest->requester_id ===
                $user->id,

            403,

            'Anda tidak memiliki akses ke pengajuan ini.'
        );
    }
    public function edit(
    Request $request,
    InventoryRequest $inventoryRequest
): View {

    $user = $request->user();

    /*
    |--------------------------------------------------------------------------
    | Hanya pengajuan submitted yang dapat diedit
    |--------------------------------------------------------------------------
    */

    abort_unless(
        $inventoryRequest->status === 'submitted',
        403,
        'Pengajuan yang sudah diproses tidak dapat diedit.'
    );


    /*
    |--------------------------------------------------------------------------
    | Hanya pemohon sendiri atau Super Admin
    |--------------------------------------------------------------------------
    */

    abort_unless(
        $inventoryRequest->requester_id === $user->id
        ||
        $user->isSuperAdmin(),
        403,
        'Anda tidak memiliki akses untuk mengedit pengajuan ini.'
    );


    $inventoryRequest->load([
        'items.category',
    ]);


    $categories = Category::query()
        ->where('is_active', true)
        ->orderBy('name')
        ->get([
            'id',
            'code',
            'name',
        ]);


    return view(
        'inventory-requests.edit',
        compact(
            'inventoryRequest',
            'categories'
        )
    );
}
    public function update(
    InventoryRequestFormRequest $request,
    InventoryRequest $inventoryRequest
): RedirectResponse {

    $user = $request->user();


    /*
    |--------------------------------------------------------------------------
    | Hanya submitted
    |--------------------------------------------------------------------------
    */

    abort_unless(
        $inventoryRequest->status === 'submitted',
        403,
        'Pengajuan yang sudah diproses tidak dapat diedit.'
    );


    /*
    |--------------------------------------------------------------------------
    | Hak akses
    |--------------------------------------------------------------------------
    */

    abort_unless(
        $inventoryRequest->requester_id === $user->id
        ||
        $user->isSuperAdmin(),
        403,
        'Anda tidak memiliki akses untuk mengedit pengajuan ini.'
    );


    $oldData =
        $inventoryRequest
            ->load('items')
            ->toArray();


    DB::transaction(function () use (
        $request,
        $inventoryRequest
    ) {

        /*
        |--------------------------------------------------------------------------
        | Update Header
        |--------------------------------------------------------------------------
        */

        $inventoryRequest->update([

            'request_type' =>
                $request->request_type,

            'reason' =>
                $request->reason,

            'notes' =>
                $request->notes,

        ]);


        /*
        |--------------------------------------------------------------------------
        | Hapus item lama
        |--------------------------------------------------------------------------
        */

        $inventoryRequest
            ->items()
            ->delete();


        /*
        |--------------------------------------------------------------------------
        | Simpan item baru
        |--------------------------------------------------------------------------
        */

        foreach (
            $request->items
            as $item
        ) {

            $inventoryRequest
                ->items()
                ->create([

                    'category_id' =>
                        $item['category_id']
                        ?? null,

                    'item_name' =>
                        $item['item_name'],

                    'specification' =>
                        $item['specification']
                        ?? null,

                    'quantity' =>
                        $item['quantity'],

                    'notes' =>
                        $item['notes']
                        ?? null,

                ]);
        }

    });


    /*
    |--------------------------------------------------------------------------
    | Activity Log
    |--------------------------------------------------------------------------
    */

    $inventoryRequest->load([
        'items',
        'requester',
        'department',
        'outlet',
    ]);


    $this->activityLogService->log(

        'UPDATE',

        'Inventory Request',

        "Mengubah pengajuan {$inventoryRequest->request_number}",

        $inventoryRequest,

        $oldData,

        $inventoryRequest
            ->fresh()
            ->load('items')
            ->toArray()
    );


    return redirect()
        ->route(
            'inventory-requests.show',
            $inventoryRequest
        )
        ->with(
            'success',
            'Pengajuan berhasil diperbarui.'
        );
}
}
