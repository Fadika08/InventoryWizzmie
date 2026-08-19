<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventory_items', function (Blueprint $table) {
            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Identity
            |--------------------------------------------------------------------------
            */
            $table->string('inventory_code', 50)->unique();

            // Digunakan untuk URL publik barcode / QR
            $table->uuid('public_code')->unique();

            // Nilai barcode
            $table->string('barcode', 100)->unique();

            /*
            |--------------------------------------------------------------------------
            | Basic Information
            |--------------------------------------------------------------------------
            */
            $table->string('name');

            $table->foreignId('category_id')
                ->constrained('categories')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->string('brand', 100)->nullable();
            $table->string('model', 100)->nullable();
            $table->string('serial_number', 150)->nullable();

            $table->text('specification')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Location
            |--------------------------------------------------------------------------
            */
            $table->enum('location_type', [
                'head_office',
                'outlet',
            ]);

            $table->foreignId('department_id')
                ->nullable()
                ->constrained('departments')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->foreignId('room_id')
                ->nullable()
                ->constrained('rooms')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->foreignId('outlet_id')
                ->nullable()
                ->constrained('outlets')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Condition & Status
            |--------------------------------------------------------------------------
            */
            $table->enum('condition_status', [
                'good',
                'minor_damage',
                'major_damage',
                'not_usable',
                'lost',
            ])->default('good');

            $table->enum('status', [
                'active',
                'borrowed',
                'maintenance',
                'mutation',
                'lost',
                'disposed',
            ])->default('active');

            /*
            |--------------------------------------------------------------------------
            | Purchase
            |--------------------------------------------------------------------------
            */
            $table->date('purchase_date')->nullable();

            $table->decimal('purchase_price', 15, 2)->nullable();

            $table->date('warranty_start')->nullable();
            $table->date('warranty_end')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Additional Information
            |--------------------------------------------------------------------------
            */
            $table->text('description')->nullable();

            $table->string('primary_photo')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Audit User
            |--------------------------------------------------------------------------
            */
            $table->foreignId('created_by')
                ->constrained('users')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('updated_by')
                ->nullable()
                ->constrained('users')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->timestamps();

            // Soft delete, bukan menghapus permanen
            $table->softDeletes();

            /*
            |--------------------------------------------------------------------------
            | Index
            |--------------------------------------------------------------------------
            */
            $table->index('category_id');
            $table->index('department_id');
            $table->index('room_id');
            $table->index('outlet_id');
            $table->index('location_type');
            $table->index('condition_status');
            $table->index('status');
            $table->index('serial_number');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventory_items');
    }
};
