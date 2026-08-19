<?php

namespace App\Http\Controllers;

use App\Http\Requests\DepartmentRequest;
use App\Models\Department;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DepartmentController extends Controller
{
    /**
     * Menampilkan seluruh divisi.
     */
    public function index(Request $request): View
    {
        $search = $request->input('search');

        $departments = Department::query()
            ->withCount('users')
            ->withCount('rooms')
            ->withCount('inventoryItems')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('code', 'like', "%{$search}%")
                        ->orWhere('name', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view(
            'departments.index',
            compact('departments', 'search')
        );
    }

    /**
     * Form tambah divisi.
     */
    public function create(): View
    {
        return view('departments.create');
    }

    /**
     * Simpan divisi baru.
     */
    public function store(
        DepartmentRequest $request
    ): RedirectResponse {

        Department::create([
            'code' => strtoupper($request->code),
            'name' => $request->name,
            'description' => $request->description,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()
            ->route('departments.index')
            ->with('success', 'Divisi berhasil ditambahkan.');
    }

    /**
     * Detail divisi.
     */
    public function show(
        Department $department
    ): View {

        $department->loadCount([
            'users',
            'rooms',
            'inventoryItems',
        ]);

        return view(
            'departments.show',
            compact('department')
        );
    }

    /**
     * Form edit.
     */
    public function edit(
        Department $department
    ): View {

        return view(
            'departments.edit',
            compact('department')
        );
    }

    /**
     * Update divisi.
     */
    public function update(
        DepartmentRequest $request,
        Department $department
    ): RedirectResponse {

        $department->update([
            'code' => strtoupper($request->code),
            'name' => $request->name,
            'description' => $request->description,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()
            ->route('departments.index')
            ->with('success', 'Divisi berhasil diperbarui.');
    }

    /**
     * Hapus divisi.
     */
    public function destroy(
        Department $department
    ): RedirectResponse {

        /*
        |--------------------------------------------------------------------------
        | Jangan hapus jika masih memiliki data terkait
        |--------------------------------------------------------------------------
        */

        if ($department->users()->exists()) {
            return back()->with(
                'error',
                'Divisi tidak dapat dihapus karena masih memiliki user.'
            );
        }

        if ($department->rooms()->exists()) {
            return back()->with(
                'error',
                'Divisi tidak dapat dihapus karena masih memiliki ruangan.'
            );
        }

        if ($department->inventoryItems()->exists()) {
            return back()->with(
                'error',
                'Divisi tidak dapat dihapus karena masih memiliki inventaris.'
            );
        }

        $department->delete();

        return redirect()
            ->route('departments.index')
            ->with('success', 'Divisi berhasil dihapus.');
    }

    /**
     * Toggle status aktif/nonaktif.
     */
    public function toggleStatus(
        Department $department
    ): RedirectResponse {

        $department->update([
            'is_active' => !$department->is_active,
        ]);

        $status = $department->is_active
            ? 'diaktifkan'
            : 'dinonaktifkan';

        return back()->with(
            'success',
            "Divisi berhasil {$status}."
        );
    }
}