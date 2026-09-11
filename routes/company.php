<?php

use App\Http\Controllers\Company\StaffController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

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
