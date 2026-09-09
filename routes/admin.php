<?php

use App\Enums\UserRole;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\JobPostController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:' . UserRole::ADMIN->value])
    ->prefix('admin')
    ->name('admin.')
    ->group(function (): void {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::post('/jobs/{job}/approve', [JobPostController::class, 'approve'])->name('jobs.approve');
        Route::post('/jobs/{job}/reject', [JobPostController::class, 'reject'])->name('jobs.reject');
    });