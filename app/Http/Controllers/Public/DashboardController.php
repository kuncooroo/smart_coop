<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Kandang;
use App\Models\SensorData;
use App\Models\Device;

class DashboardController extends Controller
{
    public function index()
    {
        $avgTemperature = SensorData::whereDate('created_at', now()->today())->avg('temperature')
            ?? SensorData::avg('temperature')
            ?? 0;
        $totalDevicesCount = Device::count();
        $onlineDevicesCount = Device::where('status', 'online')->count();
        $totalKandangCount = Kandang::count();
        $activeKandangCount = Kandang::whereHas('devices', function ($q) {
            $q->where('status', 'online');
        })->count();
        $openDoorsCount = Device::where('door_status', 'TERBUKA')->count();
        $anyDoorOpen = $openDoorsCount > 0;

        return view('Public.dashboard', compact(
            'avgTemperature',
            'totalDevicesCount',
            'onlineDevicesCount',
            'totalKandangCount',
            'activeKandangCount',
            'openDoorsCount',
            'anyDoorOpen'
        ));
    }

    public function notifikasi()
    {
        return view('Public.notifikasi');
    }
}