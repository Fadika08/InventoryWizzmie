<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->input('search');

        $categories = Category::query()
            ->withCount('inventoryItems')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where(
                        'code',
                        'like',
                        "%{$search}%"
                    )
                    ->orWhere(
                        'name',
                        'like',
                        "%{$search}%"
                    );
                });
            })
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view(
            'categories.index',
            compact(
                'categories',
                'search'
            )
        );
    }

    public function create(): View
    {
        return view(
            'categories.create'
        );
    }

    public function store(
        CategoryRequest $request
    ): RedirectResponse {

        Category::create([
            'code' => strtoupper($request->code),
            'name' => $request->name,
            'description' => $request->description,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()
            ->route('categories.index')
            ->with(
                'success',
                'Kategori inventaris berhasil ditambahkan.'
            );
    }

    public function show(
        Category $category
    ): View {

        $totalInventory = $category
            ->inventoryItems()
            ->count();

        return view(
            'categories.show',
            compact(
                'category',
                'totalInventory'
            )
        );
    }
    public function edit(
        Category $category
    ): View {

        return view(
            'categories.edit',
            compact('category')
        );
    }

    public function update(
        CategoryRequest $request,
        Category $category
    ): RedirectResponse {

        $category   ->update([
            'code' => strtoupper($request->code),
            'name' => $request->name,
            'description' => $request->description,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()
            ->route('categories.index')
            ->with(
                'success',
                'Kategori inventaris berhasil diperbarui.'
            );
    }

    public function destroy(
        Category $category
    ): RedirectResponse {

        if (
            $category
                ->inventoryItems()
                ->exists()
        ) {
            return back()->with(
                'error',
                'Kategori tidak dapat dihapus karena masih digunakan oleh inventaris.'
            );
        }

        $category->delete();

        return redirect()
            ->route('categories.index')
            ->with(
                'success',
                'Kategori inventaris berhasil dihapus.'
            );
    }

    public function toggleStatus(
        Category $category
    ): RedirectResponse {

        $category->update([
            'is_active' => !$category->is_active,
        ]);

        $status = $category->is_active
            ? 'diaktifkan'
            : 'dinonaktifkan';

        return back()->with(
            'success',
            "Kategori berhasil {$status}."
        );
    }
}
