<?php

use App\Enums\UserRole;
use App\Http\Controllers\CandidateProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:'.UserRole::CANDIDATE->value])->group(function (): void {
    Route::get('/candidate/cv/create', [CandidateProfileController::class, 'create'])->name('candidate.cv.create');
    Route::post('/candidate/cv', [CandidateProfileController::class, 'store'])->name('candidate.cv.store');
    Route::patch('/candidate/profile', [CandidateProfileController::class, 'update'])->name('candidate.profile.update');
});
