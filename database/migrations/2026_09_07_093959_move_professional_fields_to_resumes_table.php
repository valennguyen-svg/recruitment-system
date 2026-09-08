<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('resumes', function (Blueprint $table): void {
            $table->string('headline')->nullable()->after('title');
            $table->text('summary')->nullable()->after('headline');
            $table->jsonb('skills')->nullable()->after('summary');
            $table->smallInteger('experience_years')->nullable()->after('skills');
            $table->text('education')->nullable()->after('experience_years');
        });

        // Sao dữ liệu hiện có sang CV mặc định của từng ứng viên
        DB::statement("
            UPDATE resumes r
            SET headline= cp.headline,
                summary= cp.summary,
                skills= cp.skills,
                experience_years = cp.experience_years,
                education= cp.education
            FROM candidate_profiles cp
            WHERE r.candidate_profile_id = cp.id
              AND r.is_default = true
        ");

        Schema::table('candidate_profiles', function (Blueprint $table): void {
            $table->dropColumn([
                'headline',
                'summary',
                'skills',
                'experience_years',
                'education',
            ]);
        });
    }

    public function down(): void
    {
        Schema::table('candidate_profiles', function (Blueprint $table): void {
            $table->string('headline')->nullable();
            $table->text('summary')->nullable();
            $table->jsonb('skills')->nullable();
            $table->smallInteger('experience_years')->nullable();
            $table->text('education')->nullable();
        });

        Schema::table('resumes', function (Blueprint $table): void {
            $table->dropColumn([
                'headline',
                'summary',
                'skills',
                'experience_years',
                'education',
            ]);
        });
    }
};