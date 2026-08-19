<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Master Data
        |--------------------------------------------------------------------------
        */
        $this->call([
            RoleSeeder::class,
            DepartmentSeeder::class,
            RoomSeeder::class,
            OutletSeeder::class,
            CategorySeeder::class,
            SuperAdminSeeder::class,
            userSeeder::class,
        ]);
    }
}