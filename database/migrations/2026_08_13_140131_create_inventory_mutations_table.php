<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventory_mutations', function (Blueprint $table) {
            $table->id();

            $table->foreignId('inventory_id')
                ->constrained('inventory_items')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Previous Location
            |--------------------------------------------------------------------------
            */
            $table->foreignId('from_department_id')
                ->nullable()
                ->constrained('departments')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->foreignId('from_room_id')
                ->nullable()
                ->constrained('rooms')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->foreignId('from_outlet_id')
                ->nullable()
                ->constrained('outlets')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | New Location
            |--------------------------------------------------------------------------
            */
            $table->foreignId('to_department_id')
                ->nullable()
                ->constrained('departments')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->foreignId('to_room_id')
                ->nullable()
                ->constrained('rooms')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->foreignId('to_outlet_id')
                ->nullable()
                ->constrained('outlets')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->text('reason');

            $table->enum('status', [
                'requested',
                'approved',
                'completed',
                'rejected',
            ])->default('requested');

            $table->foreignId('requested_by')
                ->constrained('users')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('approved_by')
                ->nullable()
                ->constrained('users')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->timestamp('requested_at')->useCurrent();
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('completed_at')->nullable();

            $table->text('notes')->nullable();

            $table->index('inventory_id');
            $table->index('status');
            $table->index('requested_by');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventory_mutations');
    }
};
