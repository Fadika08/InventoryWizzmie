<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventory_requests', function (Blueprint $table) {
            $table->id();

            $table->string('request_number', 50)->unique();

            $table->foreignId('requester_id')
                ->constrained('users')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('department_id')
                ->nullable()
                ->constrained('departments')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->foreignId('outlet_id')
                ->nullable()
                ->constrained('outlets')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->enum('request_type', [
                'new_item',
                'replacement',
                'additional',
                'other',
            ])->default('new_item');

            $table->enum('status', [
                'draft',
                'submitted',
                'processing',
                'approved',
                'rejected',
                'completed',
                'cancelled',
            ])->default('draft');

            $table->text('reason');
            $table->text('notes')->nullable();

            $table->foreignId('approved_by')
                ->nullable()
                ->constrained('users')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->timestamp('approved_at')->nullable();

            $table->text('rejected_reason')->nullable();

            $table->timestamp('completed_at')->nullable();

            $table->timestamps();

            $table->index('requester_id');
            $table->index('department_id');
            $table->index('outlet_id');
            $table->index('status');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventory_requests');
    }
};