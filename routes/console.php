<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command('job:expire')
    ->dailyAt('00:30')
    ->timezone('Asia/HO_CHI_MINH')
    ->withoutOverlapping()
    ->appendOutputTo(storage_path('logs/jobs-expire.log'));
