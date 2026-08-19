<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        $role = DB::table('roles')
            ->where('name', 'super_admin')
            ->first();

        User::updateOrCreate(
            [
                'email' => env(
                    'SUPER_ADMIN_EMAIL',
                    'itsupport@wizzmie.com'
                ),
            ],
            [
                'name' => 'Super Admin IT',

                'password' => Hash::make(
                    env(
                        'SUPER_ADMIN_PASSWORD',
                        'Wizzmie@123'
                    )
                ),

                'role_id' => $role->id,

                'department_id' => null,
                'outlet_id' => null,

                'phone' => null,
                'profile_photo' => null,

                'is_active' => true,

                'email_verified_at' => now(),

                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}
