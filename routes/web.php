<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\CandidateProfileController;
use App\Http\Controllers\JobPostController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ResumeController;
use App\Enums\UserRole;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;

Route::get('/', fn () => view('welcome'));

Route::get('/jobs', [JobPostController::class, 'index'])->name('jobs.index');
Route::get('/jobs/{jobPost}', [JobPostController::class, 'show'])->name('jobs.show');

Route::post('/locale', [LocaleController::class, 'switch'])->name('locale.switch');

Route::get('/auth/google', [GoogleController::class, 'redirect'])->name('google.redirect');
Route::get('/auth/google/callback', [GoogleController::class, 'callback'])->name('google.callback');

Route::get('/dashboard', fn () => view('dashboard'))
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function (): void {
    // Tài khoản
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Đăng ký CV
    Route::get('/candidate/cv/create', [CandidateProfileController::class, 'create'])
        ->name('candidate.cv.create');
    Route::post('/candidate/cv', [CandidateProfileController::class, 'store'])
        ->name('candidate.cv.store');

    // Sửa thông tin CV
    Route::patch('/candidate/profile', [CandidateProfileController::class, 'update'])
        ->name('candidate.profile.update');

    // Tệp CV
    Route::post('/resumes', [ResumeController::class, 'store'])->name('resumes.store');
    Route::patch('/resumes/{resume}', [ResumeController::class, 'update'])->name('resumes.update');
    Route::get('/resumes/{resume}/download', [ResumeController::class, 'download'])->name('resumes.download');
    Route::delete('/resumes/{resume}', [ResumeController::class, 'destroy'])->name('resumes.destroy');

    // Ứng tuyển
    Route::post('/jobs/{jobPost}/apply', [ApplicationController::class, 'store'])->name('applications.store');
    Route::get('/my-applications', [ApplicationController::class, 'index'])->name('applications.index');

    // Thông báo
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.readAll');
});

Route::middleware(['auth', 'role:' . UserRole::RECRUITER->value])->group(function (): void {
    Route::post('/recruiter/jobs/{job}/submit', [JobPostController::class, 'submitForReview'])
        ->name('jobs.submit');
});

Route::middleware(['auth', 'role:' . UserRole::ADMIN->value])->group(function (): void {
    Route::post('/admin/jobs/{job}/approve', [JobPostController::class, 'approve'])->name('jobs.approve');
    Route::post('/admin/jobs/{job}/reject', [JobPostController::class, 'reject'])->name('jobs.reject');
});

Route::middleware(['auth', 'role:' . UserRole::ADMIN->value])
->prefix('admin')
->name('admin.')
->group(function (): void {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

require __DIR__.'/auth.php';