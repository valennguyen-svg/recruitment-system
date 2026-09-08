<?php

use App\Http\Controllers\ApplicationController;
use Illuminate\Support\Facades\Route;

Route::get('/applications', [ApplicationController::class, 'index'])->name('applications.index');
    Route::post('/jobs/{jobPost}/apply', [ApplicationController::class, 'store'])->name('applications.store');