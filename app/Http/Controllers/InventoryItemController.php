<?php

namespace App\Http\Controllers;

use App\Http\Requests\InventoryItemRequest;
use App\Models\Category;
use App\Models\Department;
use App\Models\InventoryItem;
use App\Models\Outlet;
use App\Models\Room;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\ActivityLogService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;
use App\Services\InventoryCodeGenerator;

class InventoryItemController extends Controller
{

    public function __construct(
    private ActivityLogService $activityLogService
    ) {
    }
    /**
     * List inventory.
     */
    public function index(Request $request): View
    {
        $user = $request->user();

        $inventories = InventoryItem::query()
            ->accessibleBy($user)
            ->with([
                'category:id,code,name',
                'department:id,code,name',
                'room:id,code,name',
                'outlet:id,code,name',
            ])

            ->when($request->search, function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    $query
                        ->where('inventory_code', 'like', "%{$search}%")
                        ->orWhere('barcode', 'like', "%{$search}%")
                        ->orWhere('name', 'like', "%{$search}%")
                        ->orWhere('brand', 'like', "%{$search}%")
                        ->orWhere('model', 'like', "%{$search}%")
                        ->orWhere('serial_number', 'like', "%{$search}%");
                });
            })

            ->when(
                $request->category_id,
                fn ($query, $categoryId) =>
                    $query->where('category_id', $categoryId)
            )

            ->when(
                $request->location_type,
                fn ($query, $locationType) =>
                    $query->where('location_type', $locationType)
            )

            ->when(
                $request->condition_status,
                fn ($query, $condition) =>
                    $query->where('condition_status', $condition)
            )

            ->when(
                $request->status,
                fn ($query, $status) =>
                    $query->where('status', $status)
            )

            ->latest('id')
            ->paginate(10)
            ->withQueryString();

        $categories = Category::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->get([
                'id',
                'code',
                'name',
            ]);

        return view(
            'inventory.index',
            compact(
                'inventories',
                'categories'
            )
        );
    }

    /**
     * Form tambah inventory.
     */
public function create(Request $request): View
{
    $user = $request->user();

    $categories = Category::query()
        ->where('is_active', true)
        ->orderBy('name')
        ->get([
            'id',
            'code',
            'name',
        ]);

    /*
    |--------------------------------------------------------------------------
    | Default
    |--------------------------------------------------------------------------
    */

    $departments = collect();
    $outlets = collect();

    /*
    |--------------------------------------------------------------------------
    | Super Admin
    | Bisa membuat inventory Head Office maupun Outlet
    |--------------------------------------------------------------------------
    */

    if ($user->isSuperAdmin()) {

        $departments = Department::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->get([
                'id',
                'code',
                'name',
            ]);

        $outlets = Outlet::query()
            ->where('is_active', true)
            ->orderBy('code')
            ->get([
                'id',
                'code',
                'name',
                'city',
                'area',
            ]);
    }

    /*
    |--------------------------------------------------------------------------
    | HO Admin
    | Hanya boleh membuat inventory Head Office
    |--------------------------------------------------------------------------
    */

    elseif ($user->isHoAdmin()) {

        $departments = Department::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->get([
                'id',
                'code',
                'name',
            ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Outlet Admin
    | Hanya boleh membuat inventory di outlet sendiri
    |--------------------------------------------------------------------------
    */

    elseif ($user->isOutletAdmin()) {

        if (!$user->outlet_id) {
            abort(
                403,
                'Akun Outlet Admin belum terhubung dengan outlet.'
            );
        }

        $outlets = Outlet::query()
            ->whereKey($user->outlet_id)
            ->where('is_active', true)
            ->get([
                'id',
                'code',
                'name',
                'city',
                'area',
            ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Rooms
    |--------------------------------------------------------------------------
    */

    $rooms = collect();

    return view(
        'inventory.create',
        compact(
            'categories',
            'departments',
            'rooms',
            'outlets'
        )
    );
}

    /**
     * Simpan inventory.
     */
public function store(
    InventoryItemRequest $request,
    InventoryCodeGenerator $codeGenerator
): RedirectResponse {

   $user = $request->user();

/*
|--------------------------------------------------------------------------
| Tentukan lokasi berdasarkan role
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

    $locationType = 'outlet';

    $departmentId = null;

    $roomId = null;

    // PENTING:
    // Outlet Admin SELALU menggunakan outlet miliknya
    $outletId = $user->outlet_id;

} elseif ($user->isHoAdmin()) {

    $locationType = 'head_office';

    $departmentId = $request->department_id;

    $roomId = $request->room_id;

    $outletId = null;

} else {

    // Super Admin
    $locationType = $request->location_type;

    $departmentId =
        $locationType === 'head_office'
            ? $request->department_id
            : null;

    $roomId =
        $locationType === 'head_office'
            ? $request->room_id
            : null;

    $outletId =
        $locationType === 'outlet'
            ? $request->outlet_id
            : null;
}


$inventory = DB::transaction(function () use (
    $request,
    $user,
    $codeGenerator,
    $locationType,
    $departmentId,
    $roomId,
    $outletId
) {

        /*
        |--------------------------------------------------------------------------
        | Buat public code terlebih dahulu
        |--------------------------------------------------------------------------
        */

        $inventory = InventoryItem::create([
            'inventory_code' => 'TEMP-' . str()->uuid(),

            'public_code' => (string) str()->uuid(),

            'barcode' => 'TEMP-' . str()->uuid(),

            'name' => $request->name,

            'category_id' => $request->category_id,

            'brand' => $request->brand,

            'model' => $request->model,

            'serial_number' => $request->serial_number,

            'specification' => $request->specification,

            'location_type' => $request->location_type,

            'location_type' => $locationType,

            'department_id' => $departmentId,

            'room_id' => $roomId,

            'outlet_id' => $outletId,

            'condition_status' =>
                $request->condition_status,

            'status' =>
                $request->status,

            'purchase_date' =>
                $request->purchase_date,

            'purchase_price' =>
                $request->purchase_price,

            'warranty_start' =>
                $request->warranty_start,

            'warranty_end' =>
                $request->warranty_end,

            'description' =>
                $request->description,

            'created_by' =>
                $user->id,

            'updated_by' =>
                $user->id,

        ]);


        /*
        |--------------------------------------------------------------------------
        | Load relationship untuk generator
        |--------------------------------------------------------------------------
        */

        $inventory->load([
            'category',
            'department',
            'outlet',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Generate kode inventaris
        |--------------------------------------------------------------------------
        */

        $inventoryCode =
            $codeGenerator->generate($inventory);


        /*
        |--------------------------------------------------------------------------
        | Barcode
        |--------------------------------------------------------------------------
        */

        $barcode = 'WZM-' .
            now()->format('Y') .
            '-' .
            str_pad(
                $inventory->id,
                8,
                '0',
                STR_PAD_LEFT
            );


        $inventory->update([
            'inventory_code' => $inventoryCode,

            'barcode' => $barcode,
        ]);


        /*
        |--------------------------------------------------------------------------
        | Upload foto
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('primary_photo')) {

            $path = $request
                ->file('primary_photo')
                ->store(
                    'inventory',
                    'public'
                );

            $inventory->update([
                'primary_photo' => $path,
            ]);
        }


        return $inventory;
    });

    $this->activityLogService->log(
    'CREATE',
    'Inventory',
    "Menambahkan inventaris {$inventory->inventory_code}",
    $inventory,
    null,
    $inventory->fresh()->toArray()
    );

    return redirect()
        ->route(
            'inventory.show',
            $inventory
        )
        ->with(
            'success',
            'Inventaris berhasil ditambahkan.'
        );
}

    /**
     * Detail inventory.
     */
    public function show(
        InventoryItem $inventory
    ): View {

        $this->authorizeInventory($inventory);

        $inventory->load([
            'category',
            'department',
            'room',
            'outlet',
            'creator',
            'updater',
        ]);

        return view(
            'inventory.show',
            compact('inventory')
        );
    }

    /**
     * Form edit.
     */
    public function edit(
        Request $request,
        InventoryItem $inventory
    ): View {

        $this->authorizeInventory($inventory);

        $categories = Category::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        $departments = Department::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        $outlets = Outlet::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        if ($request->user()->isOutletAdmin()) {
            $outlets = $outlets->where(
                'id',
                $request->user()->outlet_id
            );
        }

        $rooms = collect();

        if ($inventory->department_id) {
            $rooms = Room::query()
                ->where(
                    'department_id',
                    $inventory->department_id
                )
                ->where('is_active', true)
                ->orderBy('name')
                ->get();
        }

        return view(
            'inventory.edit',
            compact(
                'inventory',
                'categories',
                'departments',
                'outlets',
                'rooms'
            )
        );
    }

    /**
     * Update inventory.
     */
  public function update(
    InventoryItemRequest $request,
    InventoryItem $inventory
): RedirectResponse {

    $this->authorizeInventory($inventory);

    /*
    |--------------------------------------------------------------------------
    | Simpan kondisi sebelum perubahan
    |--------------------------------------------------------------------------
    */

    $oldData = $inventory->getOriginal();


    /*
    |--------------------------------------------------------------------------
    | Data yang akan diperbarui
    |--------------------------------------------------------------------------
    */
    $user = $request->user();

    if ($user->isOutletAdmin()) {

        if (!$user->outlet_id) {
            abort(
                403,
                'Akun Outlet Admin belum terhubung dengan outlet.'
            );
        }

        $locationType = 'outlet';

        $departmentId = null;

        $roomId = null;

        $outletId = $user->outlet_id;

    } elseif ($user->isHoAdmin()) {

        $locationType = 'head_office';

        $departmentId = $request->department_id;

        $roomId = $request->room_id;

        $outletId = null;

    } else {

        $locationType = $request->location_type;

        $departmentId =
            $locationType === 'head_office'
                ? $request->department_id
                : null;

        $roomId =
            $locationType === 'head_office'
                ? $request->room_id
                : null;

        $outletId =
            $locationType === 'outlet'
                ? $request->outlet_id
                : null;
    }
    $data = [

        'name' =>
            $request->name,

        'category_id' =>
            $request->category_id,

        'brand' =>
            $request->brand,

        'model' =>
            $request->model,

        'serial_number' =>
            $request->serial_number,

        'specification' =>
            $request->specification,

        'location_type' =>
            $locationType,

        'department_id' =>
            $departmentId,

        'room_id' =>
            $roomId,

        'outlet_id' =>
            $outletId,

        'condition_status' =>
            $request->condition_status,

        'status' =>
            $request->status,

        'purchase_date' =>
            $request->purchase_date,

        'purchase_price' =>
            $request->purchase_price,

        'warranty_start' =>
            $request->warranty_start,

        'warranty_end' =>
            $request->warranty_end,

        'description' =>
            $request->description,

        'updated_by' =>
            $user->id,
    ];


    /*
    |--------------------------------------------------------------------------
    | Upload foto baru
    |--------------------------------------------------------------------------
    */

    if ($request->hasFile('primary_photo')) {

        if ($inventory->primary_photo) {

            Storage::disk('public')->delete(
                $inventory->primary_photo
            );
        }

        $data['primary_photo'] =
            $request
                ->file('primary_photo')
                ->store(
                    'inventory',
                    'public'
                );
    }


    /*
    |--------------------------------------------------------------------------
    | Update database
    |--------------------------------------------------------------------------
    */

    $inventory->update($data);


    /*
    |--------------------------------------------------------------------------
    | Refresh data terbaru
    |--------------------------------------------------------------------------
    */

    $inventory->refresh();


    /*
    |--------------------------------------------------------------------------
    | Activity Log
    |--------------------------------------------------------------------------
    */

    $this->activityLogService->log(
        'UPDATE',
        'Inventory',
        "Mengubah inventaris {$inventory->inventory_code}",
        $inventory,
        $oldData,
        $inventory->toArray()
    );


    return redirect()
        ->route(
            'inventory.show',
            $inventory
        )
        ->with(
            'success',
            'Inventaris berhasil diperbarui.'
        );
}

    /**
     * Soft delete.
     */
    public function destroy(
        Request $request,
        InventoryItem $inventory
    ): RedirectResponse {

        $this->authorizeInventory($inventory);

        $oldData = $inventory->toArray();


        $inventory->update([
            'updated_by' => $request->user()->id,
            'status' => 'disposed',
        ]);


        $this->activityLogService->log(
            'DELETE',
            'Inventory',
            "Mengarsipkan inventaris {$inventory->inventory_code}",
            $inventory,
            $oldData,
            $inventory->fresh()->toArray()
        );


        $inventory->delete();


        return redirect()
            ->route('inventory.index')
            ->with(
                'success',
                'Inventaris berhasil diarsipkan.'
            );
    }

    /**
     * Endpoint untuk mengambil ruangan berdasarkan department.
     */
    public function rooms(
        Request $request
    ) {
        $request->validate([
            'department_id' => [
                'required',
                'exists:departments,id',
            ],
        ]);

        return Room::query()
            ->where(
                'department_id',
                $request->department_id
            )
            ->where('is_active', true)
            ->orderBy('name')
            ->get([
                'id',
                'code',
                'name',
            ]);
    }

    public function publicShow(
    string $public_code
): View {

    $inventory = InventoryItem::query()
        ->with([
            'category',
            'department',
            'room',
            'outlet',
        ])
        ->where(
            'public_code',
            $public_code
        )
        ->firstOrFail();

    return view(
        'inventory.public',
        compact('inventory')
    );
}

    public function scanner(): View
    {
        return view('inventory.scanner');
    }

    public function searchBarcode(
    Request $request
): RedirectResponse {

    $request->validate([
        'barcode' => [
            'required',
            'string',
            'max:100',
        ],
    ]);

    $inventory = InventoryItem::query()
        ->accessibleBy($request->user())
        ->where(
            'barcode',
            $request->barcode
        )
        ->first();

    if (!$inventory) {

        return back()->with(
            'error',
            'Inventaris dengan barcode tersebut tidak ditemukan atau Anda tidak memiliki akses.'
        );
    }

    return redirect()->route(
        'inventory.show',
        $inventory
    );
}
    /**
     * Pastikan inventory dapat diakses user.
     */
    private function authorizeInventory(
        InventoryItem $inventory
    ): void {

        $user = request()->user();

        $allowed = InventoryItem::query()
            ->accessibleBy($user)
            ->whereKey($inventory->id)
            ->exists();

        abort_unless(
            $allowed,
            403,
            'Anda tidak memiliki akses ke inventaris ini.'
        );
    }

}
