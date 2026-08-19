<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use App\Services\ActivityLogService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function __construct(
        private ActivityLogService $activityLogService
    ) {
    }

    /**
     * Menampilkan profile user yang sedang login.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();

        $user->load([
            'role',
            'department',
            'outlet',
        ]);

        $activities = $user->activityLogs()
            ->latest('created_at')
            ->limit(10)
            ->get();

        return view(
            'profile.edit',
            compact(
                'user',
                'activities'
            )
        );
    }

    /**
     * Update informasi profile.
     */
    public function update(
        ProfileUpdateRequest $request
    ): RedirectResponse {

        /** @var User $user */
        $user = $request->user();

        $oldData = [
            'name' => $user->name,
            'phone' => $user->phone,
            'profile_photo' => $user->profile_photo,
        ];

        $data = [
            'name' => $request->name,
            'phone' => $request->phone,
        ];

        /*
        |--------------------------------------------------------------------------
        | Foto Profile
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

        $this->activityLogService->log(
            'UPDATE',
            'Profile',
            "Mengubah profile {$user->name}",
            $user,
            $oldData,
            [
                'name' => $user->name,
                'phone' => $user->phone,
                'profile_photo' => $user->profile_photo,
            ]
        );

        return back()->with(
            'success',
            'Profile berhasil diperbarui.'
        );
    }

    /**
     * Mengubah password.
     */
    public function password(
        Request $request
    ): RedirectResponse {

        $request->validate([
            'current_password' => [
                'required',
                'current_password',
            ],

            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
            ],
        ], [
            'current_password.current_password' =>
                'Password saat ini tidak sesuai.',

            'password.confirmed' =>
                'Konfirmasi password tidak cocok.',
        ]);

        /** @var User $user */
        $user = $request->user();

        $user->update([
            'password' => Hash::make(
                $request->password
            ),
        ]);

        $this->activityLogService->log(
            'UPDATE',
            'Profile',
            "Mengubah password {$user->name}",
            $user,
            null,
            [
                'password_changed' => true,
            ]
        );

        return back()->with(
            'success',
            'Password berhasil diubah.'
        );
    }
}
