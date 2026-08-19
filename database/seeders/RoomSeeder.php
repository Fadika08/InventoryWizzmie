<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoomSeeder extends Seeder
{
    public function run(): void
    {
        $rooms = [
            'IT' => [
                ['code' => 'IT-001', 'name' => 'Ruang IT'],
                ['code' => 'IT-002', 'name' => 'Ruang Server'],
            ],

            'FIN' => [
                ['code' => 'FIN-001', 'name' => 'Ruang Finance'],
            ],

            'HR' => [
                ['code' => 'HR-001', 'name' => 'Ruang HR'],
            ],

            'MKT' => [
                ['code' => 'MKT-001', 'name' => 'Ruang Marketing'],
            ],

            'OPS' => [
                ['code' => 'OPS-001', 'name' => 'Ruang Operations'],
            ],

            'GA' => [
                ['code' => 'GA-001', 'name' => 'Ruang General Affair'],
            ],
        ];

        foreach ($rooms as $departmentCode => $departmentRooms) {

            $department = DB::table('departments')
                ->where('code', $departmentCode)
                ->first();

            if (!$department) {
                continue;
            }

            foreach ($departmentRooms as $room) {
                DB::table('rooms')->insert([
                    'department_id' => $department->id,
                    'code' => $room['code'],
                    'name' => $room['name'],
                    'description' => null,
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
