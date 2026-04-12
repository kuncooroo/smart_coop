<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

// Rute Login
Route::middleware('guest')->group(function () {
    Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/', [AuthController::class, 'login']);
});

// Rute yang membutuhkan Login (Dashboard dkk)
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/monitoring', [DashboardController::class, 'monitoring'])->name('monitoring');
    Route::get('/hardware', [DashboardController::class, 'hardware'])->name('hardware');
    Route::get('/activity_log', [DashboardController::class, 'activityLog'])->name('activity_log');
    Route::get('/laporan', [DashboardController::class, 'laporan'])->name('laporan');
    Route::get('/notifikasi', [DashboardController::class, 'notifikasi'])->name('notifikasi');
});
