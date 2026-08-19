<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('roles')->insert([
            [
                'name' => 'super_admin',
                'description' => 'Super Admin IT dengan akses penuh ke seluruh sistem.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'ho_admin',
                'description' => 'Admin yang mengelola inventaris Head Office.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'outlet_admin',
                'description' => 'Admin yang mengelola inventaris outlet masing-masing.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}