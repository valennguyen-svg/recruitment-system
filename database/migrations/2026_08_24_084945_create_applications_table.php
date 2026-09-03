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
        Schema::create('applications', function (Blueprint $table) {
        $table->id();
        $table->foreignId('job_post_id')->constrained()->cascadeOnDelete();
        $table->foreignId('candidate_profile_id')->constrained()->cascadeOnDelete();
        $table->foreignId('resume_id')->constrained();
        $table->enum('status', [
            'applied', 'screening', 'interview', 'offer', 'hired', 'rejected', 'withdrawn'
        ])->default('applied');
        $table->text('cover_letter')->nullable();
        $table->timestamp('applied_at')->useCurrent();
        $table->timestamps();

        $table->unique(['job_post_id', 'candidate_profile_id']);
    });
      
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
