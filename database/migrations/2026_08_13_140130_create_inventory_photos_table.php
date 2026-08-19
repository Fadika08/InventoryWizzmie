<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventory_photos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('inventory_id')
                ->constrained('inventory_items')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->string('file_path');
            $table->string('file_name')->nullable();

            $table->boolean('is_primary')->default(false);

            $table->timestamps();

            $table->index('inventory_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventory_photos');
    }
};
