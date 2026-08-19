<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OutletSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 1; $i <= 78; $i++) {

            $kode = 'OUT-' . str_pad($i, 3, '0', STR_PAD_LEFT);

            DB::table('outlets')->insert([
                'code' => $kode,
                'name' => 'Outlet ' . str_pad($i, 3, '0', STR_PAD_LEFT),

                'address' => null,
                'city' => null,
                'area' => null,
                'phone' => null,
                'manager_name' => null,

                'is_active' => true,

                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
