<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventory_loans', function (Blueprint $table) {
            $table->id();

            $table->foreignId('inventory_id')
                ->constrained('inventory_items')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('borrower_id')
                ->constrained('users')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->text('purpose')->nullable();

            $table->timestamp('borrowed_at')->useCurrent();
            $table->timestamp('expected_return_at')->nullable();
            $table->timestamp('returned_at')->nullable();

            $table->enum('status', [
                'borrowed',
                'returned',
                'overdue',
                'lost',
            ])->default('borrowed');

            $table->text('notes')->nullable();

            $table->foreignId('approved_by')
                ->nullable()
                ->constrained('users')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->timestamps();

            $table->index('inventory_id');
            $table->index('borrower_id');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventory_loans');
    }
};
