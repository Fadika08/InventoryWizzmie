<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Outlet;
use App\Models\Role;
use App\Models\User;
use App\Http\Requests\UserRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Services\ActivityLogService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    public function __construct(
    private ActivityLogService $activityLogService
) {
}
    public function index(Request $request): View
    {
        $search = $request->input('search');
        $roleId = $request->input('role_id');
        $status = $request->input('status');

        $users = User::query()
            ->with([
                'role',
                'department',
                'outlet',
            ])

            ->when($search, function ($query) use ($search) {

                $query->where(function ($query) use ($search) {

                    $query->where(
                        'name',
                        'like',
                        "%{$search}%"
                    )

                    ->orWhere(
                        'email',
                        'like',
                        "%{$search}%"
                    )

                    ->orWhere(
                        'phone',
                        'like',
                        "%{$search}%"
                    );

                });

            })

            ->when($roleId, function ($query) use ($roleId) {

                $query->where(
                    'role_id',
                    $roleId
                );

            })

            ->when($status !== null && $status !== '', function ($query) use ($status) {

                $query->where(
                    'is_active',
                    $status
                );

            })

            ->latest()
            ->paginate(15)
            ->withQueryString();

        $roles = Role::query()
            ->orderBy('name')
            ->get();

        return view(
            'users.index',
            compact(
                'users',
                'roles',
                'search',
                'roleId',
                'status'
            )
        );
    }

    public function create(): View
    {
    $roles = Role::query()
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

    return view(
        'users.create',
        compact(
            'roles',
            'departments',
            'outlets'
        )
    );
    }

    public function store(
    UserRequest $request
): RedirectResponse {

    $role = Role::findOrFail(
        $request->role_id
    );

    $departmentId = null;
    $outletId = null;

    if ($role->name === 'ho_admin') {

        $departmentId =
            $request->department_id;

    }

    if ($role->name === 'outlet_admin') {

        $outletId =
            $request->outlet_id;

    }

    $user = User::create([
        'name' => $request->name,

        'email' => $request->email,

        'password' => Hash::make(
            $request->password
        ),

        'role_id' => $request->role_id,

        'department_id' =>
            $departmentId,

        'outlet_id' =>
            $outletId,

        'phone' =>
            $request->phone,

        'is_active' =>
            $request->boolean('is_active', true),
    ]);


    $this->activityLogService->log(
        'CREATE',
        'User',
        "Menambahkan user {$user->name}",
        $user,
        null,
        $user->fresh()->toArray()
    );

    return redirect()
        ->route('users.index')
        ->with(
            'success',
            'User berhasil ditambahkan.'
        );
    }

    public function show(User $user): View
{
    $user->load([
        'role',
        'department',
        'outlet',
    ]);

    $recentActivities = $user->activityLogs()
        ->latest('created_at')
        ->limit(10)
        ->get();

    return view(
        'users.show',
        compact(
            'user',
            'recentActivities'
        )
    );
}

public function edit(User $user): View
{
    $roles = Role::query()
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

    return view(
        'users.edit',
        compact(
            'user',
            'roles',
            'departments',
            'outlets'
        )
    );
}

public function update(
    UserRequest $request,
    User $user
): RedirectResponse {

    $oldData = $user->getOriginal();

    $role = Role::findOrFail(
        $request->role_id
    );

    $departmentId = null;
    $outletId = null;

    if ($role->name === 'ho_admin') {

        $departmentId =
            $request->department_id;

    }

    if ($role->name === 'outlet_admin') {

        $outletId =
            $request->outlet_id;

    }


    $data = [
        'name' => $request->name,

        'email' => $request->email,

        'role_id' => $request->role_id,

        'department_id' =>
            $departmentId,

        'outlet_id' =>
            $outletId,

        'phone' =>
            $request->phone,

       'is_active' => $user->isSuperAdmin()
        ? true
        : $request->boolean('is_active'),
    ];


    /*
    |--------------------------------------------------------------------------
    | Password
    |--------------------------------------------------------------------------
    */

    if ($request->filled('password')) {

        $data['password'] =
            Hash::make(
                $request->password
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Profile Photo
    |--------------------------------------------------------------------------
    */

    if ($request->hasFile('profile_photo')) {

        if ($user->profile_photo) {

            Storage::disk('public')->delete(
                $user->profile_photo
            );
        }

        $data['profile_photo'] =
            $request
                ->file('profile_photo')
                ->store(
                    'profiles',
                    'public'
                );
    }


    $user->update($data);

    $user->refresh();


    /*
    |--------------------------------------------------------------------------
    | Activity Log
    |--------------------------------------------------------------------------
    */

    $this->activityLogService->log(
        'UPDATE',
        'User',
        "Mengubah data user {$user->name}",
        $user,
        $oldData,
        $user->toArray()
    );


    return redirect()
        ->route(
            'users.show',
            $user
        )
        ->with(
            'success',
            'Data user berhasil diperbarui.'
        );
}
    public function toggleStatus(User $user): RedirectResponse
    {
        // Jangan izinkan akun Super Admin dinonaktifkan
        if ($user->isSuperAdmin()) {
            return back()->with(
                'error',
                'Akun Super Admin tidak dapat dinonaktifkan.'
            );
        }

        $oldStatus = $user->is_active;

        $user->update([
            'is_active' => !$user->is_active,
        ]);

        $status = $user->is_active
            ? 'diaktifkan'
            : 'dinonaktifkan';

        $this->activityLogService->log(
            'UPDATE',
            'User',
            "Mengubah status user {$user->name} menjadi {$status}",
            $user,
            [
                'is_active' => $oldStatus,
            ],
            [
                'is_active' => $user->is_active,
            ]
        );

        return back()->with(
            'success',
            "User berhasil {$status}."
        );
    }



}