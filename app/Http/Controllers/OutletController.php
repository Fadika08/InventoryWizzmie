<?php

namespace App\Http\Controllers;

use App\Http\Requests\OutletRequest;
use App\Models\Outlet;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OutletController extends Controller
{
    /**
     * Menampilkan daftar outlet.
     */
    public function index(Request $request): View
    {
        $search = $request->input('search');

        $outlets = Outlet::query()

            ->withCount([
                'users',
                'inventoryItems',
            ])

            ->when($search, function ($query) use ($search) {

                $query->where(function ($query) use ($search) {

                    $query
                        ->where(
                            'code',
                            'like',
                            "%{$search}%"
                        )

                        ->orWhere(
                            'name',
                            'like',
                            "%{$search}%"
                        )

                        ->orWhere(
                            'city',
                            'like',
                            "%{$search}%"
                        )

                        ->orWhere(
                            'area',
                            'like',
                            "%{$search}%"
                        )

                        ->orWhere(
                            'manager_name',
                            'like',
                            "%{$search}%"
                        );

                });

            })

            ->orderBy('code')

            ->paginate(15)

            ->withQueryString();


        return view(
            'outlets.index',
            compact(
                'outlets',
                'search'
            )
        );
    }


    /**
     * Form tambah outlet.
     */
    public function create(): View
    {
        return view(
            'outlets.create'
        );
    }


    /**
     * Simpan outlet baru.
     */
    public function store(
        OutletRequest $request
    ): RedirectResponse {

        $outlet = Outlet::create([

            'code' => strtoupper(
                trim($request->code)
            ),

            'name' => trim(
                $request->name
            ),

            'address' => $request->address,

            'city' => $request->city,

            'area' => $request->area,

            'phone' => $request->phone,

            'manager_name' =>
                $request->manager_name,

            'is_active' =>
                $request->boolean(
                    'is_active'
                ),

        ]);


        return redirect()
            ->route(
                'outlets.show',
                $outlet
            )
            ->with(
                'success',
                'Outlet berhasil ditambahkan.'
            );
    }


    /**
     * Detail outlet.
     */
    public function show(
        Outlet $outlet
    ): View {

        $outlet->loadCount([
            'users',
            'inventoryItems',
            'inventoryRequests',
        ]);


        $outlet->load([
            'users.role',
        ]);


        return view(
            'outlets.show',
            compact('outlet')
        );
    }


    /**
     * Form edit outlet.
     */
    public function edit(
        Outlet $outlet
    ): View {

        return view(
            'outlets.edit',
            compact('outlet')
        );
    }


    /**
     * Update outlet.
     */
    public function update(
        OutletRequest $request,
        Outlet $outlet
    ): RedirectResponse {

        $outlet->update([

            'code' => strtoupper(
                trim($request->code)
            ),

            'name' => trim(
                $request->name
            ),

            'address' => $request->address,

            'city' => $request->city,

            'area' => $request->area,

            'phone' => $request->phone,

            'manager_name' =>
                $request->manager_name,

            'is_active' =>
                $request->boolean(
                    'is_active'
                ),

        ]);


        return redirect()
            ->route(
                'outlets.show',
                $outlet
            )
            ->with(
                'success',
                'Data outlet berhasil diperbarui.'
            );
    }


    /**
     * Hapus outlet.
     */
    public function destroy(
        Outlet $outlet
    ): RedirectResponse {

        if (
            $outlet
                ->users()
                ->exists()
        ) {

            return back()->with(
                'error',
                'Outlet tidak dapat dihapus karena masih digunakan oleh user.'
            );
        }


        if (
            $outlet
                ->inventoryItems()
                ->exists()
        ) {

            return back()->with(
                'error',
                'Outlet tidak dapat dihapus karena masih memiliki inventaris.'
            );
        }


        if (
            $outlet
                ->inventoryRequests()
                ->exists()
        ) {

            return back()->with(
                'error',
                'Outlet tidak dapat dihapus karena masih memiliki pengajuan.'
            );
        }


        $outlet->delete();


        return redirect()
            ->route(
                'outlets.index'
            )
            ->with(
                'success',
                'Outlet berhasil dihapus.'
            );
    }


    /**
     * Aktif / nonaktif outlet.
     */
    public function toggleStatus(
        Outlet $outlet
    ): RedirectResponse {

        $outlet->update([

            'is_active' =>
                !$outlet->is_active,

        ]);


        $status = $outlet->is_active
            ? 'diaktifkan'
            : 'dinonaktifkan';


        return back()->with(
            'success',
            "Outlet berhasil {$status}."
        );
    }
}