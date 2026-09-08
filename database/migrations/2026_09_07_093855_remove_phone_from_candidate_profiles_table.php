<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("
            UPDATE users u
            SET phone = cp.phone
            FROM candidate_profiles cp
            WHERE cp.user_id = u.id
              AND u.phone IS NULL
              AND cp.phone IS NOT NULL
        ");

        Schema::table('candidate_profiles', function (Blueprint $table): void {
            $table->dropColumn('phone');
        });

        Schema::table('users', function (Blueprint $table): void {
            $table->string('phone', 20)->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('candidate_profiles', function (Blueprint $table): void {
            $table->string('phone', 20)->nullable();
        });

        Schema::table('users', function (Blueprint $table): void {
            $table->string('phone', 255)->nullable()->change();
        });
    }
};