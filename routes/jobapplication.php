<?php

use App\Enums\UserRole;
use App\Http\Controllers\ApplicationController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:' . UserRole::CANDIDATE->value])->group(function (): void {
    Route::get('/applications', [ApplicationController::class, 'index'])->name('applications.index');
    Route::post('/jobs/{jobPost}/apply', [ApplicationController::class, 'store'])->name('applications.store');
});