<?php

use App\Enums\UserRole;
use App\Http\Controllers\JobPostController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:'.UserRole::RECRUITER->value])
    ->prefix('recruiter')
    ->name('recruiter.')
    ->group(function (): void {
        Route::post('/jobs/{job}/submit', [JobPostController::class, 'submitForReview'])->name('jobs.submit');
    });
