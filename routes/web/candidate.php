<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\CandidateProfileController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ResumeController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function (): void {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/candidate/cv/create', [CandidateProfileController::class, 'create'])->name('candidate.cv.create');
    Route::post('/candidate/cv', [CandidateProfileController::class, 'store'])->name('candidate.cv.store');
    Route::patch('/candidate/profile', [CandidateProfileController::class, 'update'])->name('candidate.profile.update');

    Route::post('/resumes', [ResumeController::class, 'store'])->name('resumes.store');
    Route::patch('/resumes/{resume}', [ResumeController::class, 'update'])->name('resumes.update');
    Route::delete('/resumes/{resume}', [ResumeController::class, 'destroy'])->name('resumes.destroy');
    Route::get('/resumes/{resume}/download', [ResumeController::class, 'download'])->name('resumes.download');

    Route::get('/applications', [ApplicationController::class, 'index'])->name('applications.index');
    Route::post('/jobs/{jobPost}/apply', [ApplicationController::class, 'store'])->name('applications.store');
});
