<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Jadwal Pencadangan Database & Data Arsip Otomatis Setiap Hari Pukul 01:00 WIB
Schedule::command('arsip:backup --clean')
    ->dailyAt('01:00')
    ->withoutOverlapping()
    ->onOneServer();
