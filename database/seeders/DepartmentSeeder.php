<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        $departments = [
            ['code' => 'IT', 'name' => 'Information Technology'],
            ['code' => 'FIN', 'name' => 'Finance'],
            ['code' => 'HR', 'name' => 'Human Resources'],
            ['code' => 'MKT', 'name' => 'Marketing'],
            ['code' => 'OPS', 'name' => 'Operations'],
            ['code' => 'GA', 'name' => 'General Affair'],
        ];

        foreach ($departments as $department) {
            DB::table('departments')->insert([
                'code' => $department['code'],
                'name' => $department['name'],
                'description' => null,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
