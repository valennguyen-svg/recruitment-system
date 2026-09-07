<?php

use App\Constants\LocaleConstants;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\CandidateProfileController;
use App\Http\Controllers\JobPostController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ResumeController;
use App\Enums\UserRole;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::get('/locale/{locale}', [LocaleController::class, 'switch'])
    ->whereIn('locale', LocaleConstants::SUPPORTED)
    ->name('locale.switch');

Route::get('/jobs', [JobPostController::class, 'index'])->name('jobs.index');
Route::get('/jobs/{jobPost}', [JobPostController::class, 'show'])->name('jobs.show');

Route::middleware('auth')->group(function (): void {

    Route::view('/dashboard', 'dashboard')
        ->middleware('verified')
        ->name('dashboard');

    // Tài khoản
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Hồ sơ ứng viên
    Route::get('/candidate/cv/create', [CandidateProfileController::class, 'create'])->name('candidate.cv.create');
    Route::post('/candidate/cv', [CandidateProfileController::class, 'store'])->name('candidate.cv.store');
    Route::patch('/candidate/profile', [CandidateProfileController::class, 'update'])->name('candidate.profile.update');

    // CV
    Route::post('/resumes', [ResumeController::class, 'store'])->name('resumes.store');
    Route::patch('/resumes/{resume}', [ResumeController::class, 'update'])->name('resumes.update');
    Route::delete('/resumes/{resume}', [ResumeController::class, 'destroy'])->name('resumes.destroy');
    Route::get('/resumes/{resume}/download', [ResumeController::class, 'download'])->name('resumes.download');

    // Đơn ứng tuyển
    Route::get('/applications', [ApplicationController::class, 'index'])->name('applications.index');
    Route::post('/jobs/{jobPost}/apply', [ApplicationController::class, 'store'])->name('applications.store');

    // Thông báo
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{notification}/read', [NotificationController::class, 'read'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'readAll'])->name('notifications.readAll');
});

Route::middleware(['auth', 'role:' . UserRole::RECRUITER->value])
    ->prefix('recruiter')
    ->name('recruiter.')
    ->group(function (): void {
        Route::post('/jobs/{job}/submit', [JobPostController::class, 'submitForReview'])->name('jobs.submit');
    });

Route::middleware(['auth', 'role:' . UserRole::ADMIN->value])
    ->prefix('admin')
    ->name('admin.')
    ->group(function (): void {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::post('/jobs/{job}/approve', [JobPostController::class, 'approve'])->name('jobs.approve');
        Route::post('/jobs/{job}/reject', [JobPostController::class, 'reject'])->name('jobs.reject');
    });

require __DIR__ . '/auth.php';