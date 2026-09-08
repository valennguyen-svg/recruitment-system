<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('job_post_views', function (Blueprint $table): void {
            $table->id();

            $table->foreignId('job_post_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();

            $table->string('session_id', 100)->nullable();
            $table->string('ip_address', 45)->nullable();

            $table->timestamp('viewed_at');

            $table->index(['job_post_id', 'viewed_at']);
            $table->index(['job_post_id', 'user_id', 'viewed_at']);
            $table->index(['job_post_id', 'session_id', 'viewed_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_post_views');
    }
};