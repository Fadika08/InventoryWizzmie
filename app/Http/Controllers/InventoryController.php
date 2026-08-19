<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();

        $inventories = InventoryItem::query()
            ->with([
                'category',
                'department',
                'room',
                'outlet',
            ])
            ->accessibleBy($user)
            ->latest()
            ->paginate(20);

        return view(
            'inventory.index',
            compact('inventories')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(InventoryItem $inventory)
    {
        $this->authorize(
            'view',
            $inventory
        );

        $inventory->load([
            'category',
            'department',
            'room',
            'outlet',
            'photos',
            'histories.user',
        ]);

        return view(
            'inventory.show',
            compact('inventory')
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
