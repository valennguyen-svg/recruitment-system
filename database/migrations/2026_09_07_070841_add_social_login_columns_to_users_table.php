<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table): void {
            $table->string('provider', 50)->nullable()->after('password');
            $table->string('provider_id')->nullable()->after('provider');
            $table->string('avatar')->nullable()->after('provider_id');
            $table->index(
                ['provider', 'provider_id'],
                'users_provider_provider_id_index',
            );
        });
        Schema::table('users', function (Blueprint $table): void {
            $table->boolean('is_active')->default(true)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table): void {
            $table->dropIndex('users_provider_provider_id_index');
            $table->dropColumn([
                'provider',
                'provider_id',
                'avatar',
            ]);
        });
    }
};
