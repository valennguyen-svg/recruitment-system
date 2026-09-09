<?php

use App\Http\Controllers\ResumeController;
use Illuminate\Support\Facades\Route;
    // Quản lý CV
    Route::get('/cv', [ResumeController::class, 'index'])->name('resumes.index');
    Route::get('/cv/create', [ResumeController::class, 'create'])->name('resumes.create');
    Route::post('/cv', [ResumeController::class, 'store'])->name('resumes.store');
    Route::get('/cv/{resume}/edit', [ResumeController::class, 'edit'])->name('resumes.edit');
    Route::patch('/cv/{resume}', [ResumeController::class, 'update'])->name('resumes.update');
    Route::delete('/cv/{resume}', [ResumeController::class, 'destroy'])->name('resumes.destroy');
    Route::get('/cv/{resume}/download', [ResumeController::class, 'download'])->name('resumes.download');
    Route::post('/cv/{resume}/default', [ResumeController::class, 'setDefault'])->name('resumes.default');