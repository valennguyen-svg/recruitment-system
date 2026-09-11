<?php

use App\Enums\Permission;
use App\Http\Controllers\Company\CommissionController;
use App\Http\Controllers\Company\JobPostController;
use App\Http\Controllers\Company\StaffController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'can:'.Permission::JOBS_CREATE->value])
    ->prefix('company')
    ->name('company.')
    ->group(function (): void {
        Route::get('/jobs', [JobPostController::class, 'index'])->name('jobs.index');
        Route::get('/jobs/create', [JobPostController::class, 'create'])->name('jobs.create');
        Route::post('/jobs', [JobPostController::class, 'store'])->name('jobs.store');
        Route::get('/jobs/{job}/edit', [JobPostController::class, 'edit'])->name('jobs.edit');
        Route::patch('/jobs/{job}', [JobPostController::class, 'update'])->name('jobs.update');
        Route::delete('/jobs/{job}', [JobPostController::class, 'destroy'])->name('jobs.destroy');
    });

Route::middleware(['auth', 'can:'.Permission::COMMISSIONS_MANAGE->value])
    ->prefix('company')
    ->name('company.')
    ->group(function (): void {
        Route::get('/commissions', [CommissionController::class, 'index'])->name('commissions.index');
        Route::patch('/commissions/{commission}/approve', [CommissionController::class, 'approve'])->name('commissions.approve');
        Route::patch('/commissions/{commission}/paid', [CommissionController::class, 'markPaid'])->name('commissions.paid');
        Route::patch('/commissions/{commission}/void', [CommissionController::class, 'void'])->name('commissions.void');
    });

Route::middleware(['auth', 'can:manageStaff,'.User::class])
    ->prefix('company')
    ->name('company.')
    ->group(function (): void {
        Route::get('/staff', [StaffController::class, 'index'])->name('staff.index');
        Route::get('/staff/create', [StaffController::class, 'create'])->name('staff.create');
        Route::post('/staff', [StaffController::class, 'store'])->name('staff.store');
        Route::get('/staff/{staff}/edit', [StaffController::class, 'edit'])->name('staff.edit');
        Route::patch('/staff/{staff}', [StaffController::class, 'update'])->name('staff.update');
        Route::delete('/staff/{staff}', [StaffController::class, 'destroy'])->name('staff.destroy');
    });
