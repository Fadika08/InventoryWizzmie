<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("
            ALTER TABLE inventory_items
            MODIFY COLUMN location_type
            ENUM('head_office', 'outlet', 'dbl') NOT NULL
        ");
    }

    public function down(): void
    {
        // Cegah penghapusan pilihan ENUM yang masih digunakan.
        if (
            DB::table('inventory_items')
                ->where('location_type', 'dbl')
                ->exists()
        ) {
            throw new \RuntimeException(
                'Rollback dibatalkan: masih ada inventaris dengan lokasi DBL. '
                . 'Pindahkan inventaris tersebut ke lokasi yang valid terlebih dahulu.'
            );
        }

        DB::statement("
            ALTER TABLE inventory_items
            MODIFY COLUMN location_type
            ENUM('head_office', 'outlet') NOT NULL
        ");
    }
};
