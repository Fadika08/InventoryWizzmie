<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['LAPTOP', 'Laptop'],
            ['PC', 'Desktop / PC'],
            ['MONITOR', 'Monitor'],
            ['PRINTER', 'Printer'],
            ['NETWORK', 'Network Device'],
            ['PHONE', 'Smartphone'],
            ['TABLET', 'Tablet'],
            ['CCTV', 'CCTV'],
            ['SERVER', 'Server'],
            ['UPS', 'UPS'],
            ['ROUTER', 'Router'],
            ['SWITCH', 'Switch'],
            ['OTHER', 'Lainnya'],
        ];

        foreach ($categories as [$code, $name]) {

            DB::table('categories')->insert([
                'code' => $code,
                'name' => $name,
                'description' => null,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}