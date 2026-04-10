<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\DoorTimer;
use App\Models\SystemStatus;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ActivityLogController extends Controller
{
    // Tampilkan semua log
    public function index()
    {
        $logs = ActivityLog::latest()->paginate(50);
        return view('activity_logs', compact('logs'));
    }

    // Simpan log manual / worker
    public function store(Request $request)
    {
        $data = $request->validate([
            'device_id' => 'required|string',
            'action' => 'required|string',
            'source' => 'required|in:manual,worker,api',
            'notes' => 'nullable|string'
        ]);

        $log = ActivityLog::create($data);
        return response()->json(['success' => true, 'log' => $log]);
    }

    // Eksekusi timer buka/tutup pintu
    public function runDoorTimers()
    {
        $timers = DoorTimer::where('enabled', true)->get();
        $now = Carbon::now()->format('H:i');

        foreach ($timers as $timer) {
            $status = SystemStatus::firstOrCreate(['device_id' => $timer->device_id]);

            if ($timer->open_time && $timer->open_time == $now && $status->door_status != 'open') {
                $status->door_status = 'open';
                $status->save();

                ActivityLog::create([
                    'device_id' => $timer->device_id,
                    'action' => 'OPEN_DOOR',
                    'source' => 'worker',
                    'notes' => 'Timer otomatis buka pintu'
                ]);
            }

            if ($timer->close_time && $timer->close_time == $now && $status->door_status != 'closed') {
                $status->door_status = 'closed';
                $status->save();

                ActivityLog::create([
                    'device_id' => $timer->device_id,
                    'action' => 'CLOSE_DOOR',
                    'source' => 'worker',
                    'notes' => 'Timer otomatis tutup pintu'
                ]);
            }
        }

        return response()->json(['success' => true]);
    }
}