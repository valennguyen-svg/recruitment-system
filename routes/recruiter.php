<?php

use App\Enums\Permission;
use App\Enums\UserRole;
use App\Http\Controllers\JobPostController;
use App\Http\Controllers\Recruiter\CommissionController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'can:'.Permission::COMMISSIONS_VIEW->value])
    ->prefix('recruiter')
    ->name('recruiter.')
    ->group(function (): void {
        Route::get('/commissions', [CommissionController::class, 'index'])->name('commissions.index');
    });

Route::middleware(['auth', 'role:'.UserRole::RECRUITER->value])
    ->prefix('recruiter')
    ->name('recruiter.')
    ->group(function (): void {
        Route::post('/jobs/{job}/submit', [JobPostController::class, 'submitForReview'])->name('jobs.submit');
    });
