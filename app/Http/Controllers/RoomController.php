<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoomRequest;
use App\Models\Department;
use App\Models\Room;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RoomController extends Controller
{
    /**
     * List ruangan.
     */
    public function index(Request $request): View
    {
        $search = $request->input('search');
        $departmentId = $request->input('department_id');

        $rooms = Room::query()
            ->with('department:id,code,name')
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

            ->when($departmentId, function ($query) use ($departmentId) {
                $query->where(
                    'department_id',
                    $departmentId
                );
            })

            ->latest()
            ->paginate(10)
            ->withQueryString();

        $departments = Department::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->get([
                'id',
                'code',
                'name',
            ]);

        return view(
            'rooms.index',
            compact(
                'rooms',
                'departments',
                'search',
                'departmentId'
            )
        );
    }

    /**
     * Form tambah.
     */
    public function create(): View
    {
        $departments = Department::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->get([
                'id',
                'code',
                'name',
            ]);

        return view(
            'rooms.create',
            compact('departments')
        );
    }

    /**
     * Simpan.
     */
    public function store(
        RoomRequest $request
    ): RedirectResponse {

        Room::create([
            'department_id' => $request->department_id,
            'code' => strtoupper($request->code),
            'name' => $request->name,
            'floor' => $request->floor,
            'description' => $request->description,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()
            ->route('rooms.index')
            ->with(
                'success',
                'Ruangan berhasil ditambahkan.'
            );
    }

    /**
     * Detail.
     */
    public function show(Room $room): View
    {
        $room->load([
            'department',
        ]);

        $room->loadCount([
            'inventoryItems',
        ]);

        return view(
            'rooms.show',
            compact('room')
        );
    }

    /**
     * Form edit.
     */
    public function edit(Room $room): View
    {
        $departments = Department::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->get([
                'id',
                'code',
                'name',
            ]);

        return view(
            'rooms.edit',
            compact(
                'room',
                'departments'
            )
        );
    }

    /**
     * Update.
     */
    public function update(
        RoomRequest $request,
        Room $room
    ): RedirectResponse {

        $room->update([
            'department_id' => $request->department_id,
            'code' => strtoupper($request->code),
            'name' => $request->name,
            'floor' => $request->floor,
            'description' => $request->description,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()
            ->route('rooms.index')
            ->with(
                'success',
                'Ruangan berhasil diperbarui.'
            );
    }

    /**
     * Hapus.
     */
    public function destroy(Room $room): RedirectResponse
    {
        if ($room->inventoryItems()->exists()) {
            return back()->with(
                'error',
                'Ruangan tidak dapat dihapus karena masih memiliki inventaris.'
            );
        }

        $room->delete();

        return redirect()
            ->route('rooms.index')
            ->with(
                'success',
                'Ruangan berhasil dihapus.'
            );
    }

    /**
     * Aktif / nonaktif.
     */
    public function toggleStatus(
        Room $room
    ): RedirectResponse {

        $room->update([
            'is_active' => !$room->is_active,
        ]);

        $status = $room->is_active
            ? 'diaktifkan'
            : 'dinonaktifkan';

        return back()->with(
            'success',
            "Ruangan berhasil {$status}."
        );
    }
}
