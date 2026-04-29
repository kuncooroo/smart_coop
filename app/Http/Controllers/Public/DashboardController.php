<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Kandang;
use App\Models\Suhu;
use App\Models\Device;
use App\Models\Deteksi; 
// use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $avgTemperature = Suhu::whereDate('created_at', now()->today())->avg('temperature')
            ?? Suhu::avg('temperature')
            ?? 0;
            
        $totalDevicesCount = Device::count();
        $onlineDevicesCount = Device::where('status', 'online')->count();
        
        $totalKandangCount = Kandang::count();
        $activeKandangCount = Kandang::whereHas('devices', function ($q) {
            $q->where('status', 'online');
        })->count();
    
        $openDoorsCount = Device::where('door_status', 'TERBUKA')->count();
        $anyDoorOpen = $openDoorsCount > 0;

        $latestDetections = Deteksi::with(['kandang', 'device'])
            ->latest()
            ->limit(4)
            ->get();

        return view('Public.dashboard', compact(
            'avgTemperature',
            'totalDevicesCount',
            'onlineDevicesCount',
            'totalKandangCount',
            'activeKandangCount',
            'openDoorsCount',
            'anyDoorOpen',
            'latestDetections'
        ));
    }

    public function notifikasi()
    {
        return view('Public.notifikasi');
    }
}