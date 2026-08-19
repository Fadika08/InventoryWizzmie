<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventory_maintenances', function (Blueprint $table) {
            $table->id();

            $table->foreignId('inventory_id')
                ->constrained('inventory_items')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('reported_by')
                ->constrained('users')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('technician_id')
                ->nullable()
                ->constrained('users')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->text('problem');

            $table->text('action_taken')->nullable();

            $table->enum('status', [
                'reported',
                'in_progress',
                'completed',
                'cancelled',
            ])->default('reported');

            $table->decimal('estimated_cost', 15, 2)->nullable();
            $table->decimal('actual_cost', 15, 2)->nullable();

            $table->timestamp('reported_at')->useCurrent();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();

            $table->text('notes')->nullable();

            $table->index('inventory_id');
            $table->index('status');
            $table->index('reported_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventory_maintenances');
    }
};
