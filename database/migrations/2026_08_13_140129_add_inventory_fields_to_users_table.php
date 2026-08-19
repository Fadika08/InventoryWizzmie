<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('role_id')
                ->after('password')
                ->constrained('roles')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('department_id')
                ->nullable()
                ->after('role_id')
                ->constrained('departments')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->foreignId('outlet_id')
                ->nullable()
                ->after('department_id')
                ->constrained('outlets')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->string('phone', 30)
                ->nullable()
                ->after('outlet_id');

            $table->string('profile_photo')
                ->nullable()
                ->after('phone');

            $table->boolean('is_active')
                ->default(true)
                ->after('profile_photo');

            $table->timestamp('last_login_at')
                ->nullable()
                ->after('is_active');

            $table->index('role_id');
            $table->index('department_id');
            $table->index('outlet_id');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['role_id']);
            $table->dropForeign(['department_id']);
            $table->dropForeign(['outlet_id']);

            $table->dropIndex(['role_id']);
            $table->dropIndex(['department_id']);
            $table->dropIndex(['outlet_id']);

            $table->dropColumn([
                'role_id',
                'department_id',
                'outlet_id',
                'phone',
                'profile_photo',
                'is_active',
                'last_login_at',
            ]);
        });
    }
};
