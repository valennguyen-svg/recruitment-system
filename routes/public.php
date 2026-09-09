<?php

use App\Constants\LocaleConstants;
use App\Http\Controllers\JobPostController;
use App\Http\Controllers\LocaleController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::get('/locale/{locale}', [LocaleController::class, 'switch'])
    ->whereIn('locale', LocaleConstants::SUPPORTED)
    ->name('locale.switch');

Route::get('/jobs', [JobPostController::class, 'index'])->name('jobs.index');
Route::get('/jobs/{jobPost}', [JobPostController::class, 'show'])->name('jobs.show');

Route::view('/dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');