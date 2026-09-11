<?php

use App\Http\Controllers\Company\StaffController;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use App\Enums\Permission;
use App\Http\Controllers\Company\CommissionController;

Route::middleware(['auth', 'can:' . Permission::COMMISSIONS_MANAGE->value])
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
