<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ActivityLogController;

Route::get('/', function () {
    return view('dashboard');
});

Route::get('/', [DashboardController::class, 'index']);

// Log aktivitas
Route::get('/activity-logs', [ActivityLogController::class, 'index'])->name('activity.logs');

// Halaman Pengaturan (Static View / Create Controller if needed)
Route::get('/settings', function () {
    return view('settings');
})->name('settings');

// Route API untuk worker / manual
Route::post('/activity-logs', [ActivityLogController::class, 'store']);
Route::get('/door-timers/run', [ActivityLogController::class, 'runDoorTimers']);