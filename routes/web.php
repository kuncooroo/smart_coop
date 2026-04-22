<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Public\AuthController;
use App\Http\Controllers\Public\DashboardController;
use App\Http\Controllers\Public\DeviceController;
use App\Http\Controllers\Public\LaporanController;
use App\Http\Controllers\Public\MonitoringController;
use App\Http\Controllers\Public\ActivityLogController;
use App\Models\Command;
use Illuminate\Http\Request;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::middleware('auth')->group(function () {
    
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/monitoring', [MonitoringController::class, 'index'])->name('monitoring.index');
    Route::get('/monitoring/create', [MonitoringController::class, 'create'])->name('monitoring.create');
    Route::get('/monitoring/{id}/edit', [MonitoringController::class, 'edit'])->name('monitoring.edit');
    Route::post('/monitoring/store', [MonitoringController::class, 'store'])->name('monitoring.store');
    Route::put('/monitoring/update/{id}', [MonitoringController::class, 'update'])->name('monitoring.update');
    Route::delete('/monitoring/destroy/{id}', [MonitoringController::class, 'destroy'])->name('monitoring.destroy');
    Route::put('/monitoring/settings/{kandang_id}', [MonitoringController::class, 'updateSettings'])->name('settings.update');
    Route::post('/commands', [MonitoringController::class, 'storeCommand'])->name('commands.store');
    Route::get('/devices', [DeviceController::class, 'index'])->name('devices.index');
    Route::get('/devices/create', [DeviceController::class, 'create'])->name('devices.create');
    Route::post('/devices', [DeviceController::class, 'store'])->name('devices.store');
    Route::get('/devices/{id}/edit', [DeviceController::class, 'edit'])->name('devices.edit');
    Route::put('/devices/{id}', [DeviceController::class, 'update'])->name('devices.update');
    Route::delete('/devices/{id}', [DeviceController::class, 'destroy'])->name('devices.destroy');
    Route::get('/activity_log', [ActivityLogController::class, 'index'])->name('activity_log');
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/export', [LaporanController::class, 'export'])->name('laporan.export');
    Route::put('/settings/{kandang_id}', [MonitoringController::class, 'update'])->name('settings.update');
    Route::get('/notifikasi', [DashboardController::class, 'notifikasi'])->name('notifikasi');
    Route::post('/commands', function (Request $request) {
        $request->validate([
            'device_id' => 'required',
            'command' => 'required'
        ]);

        Command::create([
            'device_id'    => $request->device_id,
            'command_type' => $request->command,
            'status'       => 'pending'
        ]);

        return back()->with('success', 'Perintah berhasil dikirim ke perangkat.');
    })->name('commands.store');

   
    Route::middleware('can:admin')->prefix('admin')->group(function () {
    });
});