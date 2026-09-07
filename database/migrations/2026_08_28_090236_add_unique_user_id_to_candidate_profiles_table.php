<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $exists = collect(DB::select("
        select indexname from pg_indexes
        where tablename = 'candidate_profiles'
        and indexname = 'candidate_profiles_user_id_unique'
        "))->isNotEmpty();
        if (! $exists) {
            Schema::table('candidate_profiles', function (Blueprint $table) {
                $table->unique('user_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('candidate_profiles', function (Blueprint $table) {
            $table->dropUnique(['user_id']);
        });
    }
};
