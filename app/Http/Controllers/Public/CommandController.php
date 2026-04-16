<?php

namespace App\Http\Controllers\Public;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Command;
use App\Models\ActivityLog;
use App\Models\Device;

class CommandController extends Controller
{
    public function store(Request $request)
    {
        try {
            $device = Device::where('device_id', $request->device_id)->firstOrFail();

            Command::create([
                'device_id' => $device->device_id, 
                'command_type' => $request->command, 
                'status' => 'pending'
            ]);

            ActivityLog::create([
                'kandang_id' => $device->kandang_id,
                'device_id' => $device->device_id, 
                'category' => 'device',
                'action' => $request->command,
                'status' => 'success',
                'description' => 'Perintah ' . $request->command . ' dikirim ke ' . $device->device_name
            ]);

            return back()->with('success', 'Perintah berhasil dikirim');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }
}
