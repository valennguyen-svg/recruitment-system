<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('applications', function (Blueprint $table): void {
            $table->jsonb('resume_snapshot')->nullable()->after('resume_id');
        });

        // Xoá CV không được xoá đơn ứng tuyển — snapshot vẫn giữ nội dung
        Schema::table('applications', function (Blueprint $table): void {
            $table->dropForeign(['resume_id']);

            $table->foreign('resume_id')
                ->references('id')
                ->on('resumes')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('applications', function (Blueprint $table): void {
            $table->dropForeign(['resume_id']);

            $table->foreign('resume_id')
                ->references('id')
                ->on('resumes')
                ->cascadeOnDelete();

            $table->dropColumn('resume_snapshot');
        });
    }
};