<?php

namespace App\Http\Controllers;

use App\Models\Kandang;
use App\Models\SensorData;
use App\Models\ActivityLog;
use App\Models\Device;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Halaman Utama (Dashboard)
     */
    public function index()
    {
        $latestSensor = SensorData::latest('created_at')->first();
        $todaySensors = SensorData::whereDate('created_at', now()->today())->get();
        $totalIn = $todaySensors->sum('chicken_in');
        $totalOut = $todaySensors->sum('chicken_out');

        $anyDoorOpen = Device::where('device_type', 'actuator')
                            ->where('door_status', 'TERBUKA')
                            ->exists();

        $recentActivities = ActivityLog::with('kandang')
                                      ->latest('created_at')
                                      ->take(6)
                                      ->get();

        return view('pages.dashboard', compact(
            'latestSensor', 
            'totalIn', 
            'totalOut', 
            'anyDoorOpen', 
            'recentActivities'
        ));
    }

    /**
     * Halaman Monitoring Real-time
     */
    public function monitoring() 
    { 
        $kandangs = Kandang::with(['setting', 'devices', 'sensorData' => function($query) {
            $query->latest()->limit(1);
        }])->get();

        $allSensorData = SensorData::with('kandang')->latest()->limit(10)->get();

        return view('pages.monitoring', compact('kandangs', 'allSensorData')); 
    }

    /**
     * Halaman Manajemen Hardware (Dinamis)
     */
    public function hardware() 
    { 
        // Mengambil semua perangkat beserta info kandang tempat perangkat tersebut terpasang
        $devices = Device::with('kandang')->get();
        return view('pages.hardware', compact('devices')); 
    }

    public function activityLog() 
    { 
        $logs = ActivityLog::with(['kandang', 'device'])->latest('created_at')->paginate(15);
        return view('pages.activity_log', compact('logs')); 
    }

    public function laporan() 
    { 
        return view('pages.laporan'); 
    }

    public function notifikasi() 
    { 
        return view('pages.notifikasi'); 
    }
}