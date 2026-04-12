<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\DeviceSetting;
use App\Models\Device;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ActivityLogController extends Controller
{
    public function index()
    {
        $logs = ActivityLog::latest()->paginate(50);
        return view('activity_logs', compact('logs'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'device_id' => 'required|string',
            'action' => 'required|string',
            'source' => 'required|in:manual,worker,api',
            'notes' => 'nullable|string'
        ]);

        $log = ActivityLog::create($data);

        return response()->json([
            'success' => true,
            'log' => $log
        ]);
    }

    public function runDoorTimers()
    {
        $settings = DeviceSetting::where('auto_mode', true)->get();

        $now = Carbon::now()->format('H:i');

        foreach ($settings as $setting) {

            $device = Device::where('kandang_id', $setting->kandang_id)
                ->where('device_type', 'actuator')
                ->first();

            if (!$device) continue;

            if ($setting->timer_open && $setting->timer_open == $now) {

                if ($device->door_status != 'TERBUKA') {

                    $device->update([
                        'door_status' => 'TERBUKA'
                    ]);

                    ActivityLog::create([
                        'device_id' => $device->device_id,
                        'action' => 'OPEN_DOOR',
                        'source' => 'worker',
                        'notes' => 'Timer otomatis buka pintu'
                    ]);
                }
            }

            if ($setting->timer_close && $setting->timer_close == $now) {

                if ($device->door_status != 'TERTUTUP') {

                    $device->update([
                        'door_status' => 'TERTUTUP'
                    ]);

                    ActivityLog::create([
                        'device_id' => $device->device_id,
                        'action' => 'CLOSE_DOOR',
                        'source' => 'worker',
                        'notes' => 'Timer otomatis tutup pintu'
                    ]);
                }
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Timer dijalankan'
        ]);
    }
}