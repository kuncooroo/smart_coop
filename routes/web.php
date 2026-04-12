<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Models\Command;
use Illuminate\Http\Request;

Route::middleware('guest')->group(function () {
    Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/', [AuthController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/monitoring', [DashboardController::class, 'monitoring'])->name('monitoring');
    Route::get('/hardware', [DashboardController::class, 'hardware'])->name('hardware');
    Route::get('/activity_log', [DashboardController::class, 'activityLog'])->name('activity_log');
    Route::get('/laporan', [DashboardController::class, 'laporan'])->name('laporan');
    Route::get('/notifikasi', [DashboardController::class, 'notifikasi'])->name('notifikasi');
});

Route::post('/commands', function (Request $request) {

    $request->validate([
        'device_id' => 'required',
        'command' => 'required'
    ]);

    Command::create([
        'device_id' => $request->device_id,
        'command_type' => $request->command,
        'status' => 'pending'
    ]);

    return back()->with('success', 'Command berhasil dikirim');

})->name('commands.store');
