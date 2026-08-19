<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TestUserSeeder extends Seeder
{
    public function run(): void
    {
        $superAdmin = DB::table('roles')
            ->where('name', 'super_admin')
            ->first();

        $hoAdmin = DB::table('roles')
            ->where('name', 'ho_admin')
            ->first();

        $outletAdmin = DB::table('roles')
            ->where('name', 'outlet_admin')
            ->first();

        $outlet = DB::table('outlets')
            ->where('code', 'OUT-001')
            ->first();

        /*
        |--------------------------------------------------------------------------
        | Super Admin
        |--------------------------------------------------------------------------
        */

        User::updateOrCreate(
            [
                'email' => 'it.support@wizzmie.com',
            ],
            [
                'name' => 'Super Admin IT',
                'password' => Hash::make('Password123!'),

                'role_id' => $superAdmin->id,

                'department_id' => null,
                'outlet_id' => null,

                'is_active' => true,

                'email_verified_at' => now(),
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | HO Admin
        |--------------------------------------------------------------------------
        */

        User::updateOrCreate(
            [
                'email' => 'ho@wizzmie.com',
            ],
            [
                'name' => 'HO Admin',
                'password' => Hash::make('Password123!'),

                'role_id' => $hoAdmin->id,

                'department_id' => null,
                'outlet_id' => null,

                'is_active' => true,

                'email_verified_at' => now(),
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | Outlet Admin
        |--------------------------------------------------------------------------
        */

        User::updateOrCreate(
            [
                'email' => 'outlet001@wizzmie.com',
            ],
            [
                'name' => 'Outlet Admin 001',
                'password' => Hash::make('Password123!'),

                'role_id' => $outletAdmin->id,

                'department_id' => null,
                'outlet_id' => $outlet->id,

                'is_active' => true,

                'email_verified_at' => now(),
            ]
        );
    }
}
