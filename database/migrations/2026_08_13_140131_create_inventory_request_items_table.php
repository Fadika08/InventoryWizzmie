<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventory_request_items', function (Blueprint $table) {
            $table->id();

            $table->foreignId('request_id')
                ->constrained('inventory_requests')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreignId('category_id')
                ->nullable()
                ->constrained('categories')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->string('item_name');

            $table->text('specification')->nullable();

            $table->unsignedInteger('quantity')->default(1);

            $table->text('notes')->nullable();

            $table->timestamps();

            $table->index('request_id');
            $table->index('category_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventory_request_items');
    }
};
