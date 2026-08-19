<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Ambil Role
        |--------------------------------------------------------------------------
        */

        $hoAdminRole = Role::where('name', 'ho_admin')->firstOrFail();

        $outletAdminRole = Role::where(
            'name',
            'outlet_admin'
        )->firstOrFail();


        /*
        |--------------------------------------------------------------------------
        | HO ADMIN
        |--------------------------------------------------------------------------
        */

        User::updateOrCreate(
            [
                'email' => 'ho@wizzmie.com',
            ],
            [
                'name' => 'HO Admin',

                'password' => Hash::make(
                    'Password123!'
                ),

                'role_id' => $hoAdminRole->id,

                'department_id' => null,

                'outlet_id' => null,

                'phone' => null,

                'profile_photo' => null,

                'is_active' => true,
            ]
        );


        /*
        |--------------------------------------------------------------------------
        | OUTLET ADMIN
        |--------------------------------------------------------------------------
        */

        User::updateOrCreate(
            [
                'email' => 'outlet001@wizzmie.com',
            ],
            [
                'name' => 'Outlet Admin 001',

                'password' => Hash::make(
                    'Password123!'
                ),

                'role_id' => $outletAdminRole->id,

                'department_id' => null,

                'outlet_id' => null,

                'phone' => null,

                'profile_photo' => null,

                'is_active' => true,
            ]
        );
    }
}