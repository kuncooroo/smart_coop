<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\SensorData;
use App\Models\Command;
use App\Models\Device;

Route::middleware('apikey')->group(function () {

    Route::post('/ingest', function (Request $request) {

        $device = \App\Models\Device::where('device_id', $request->device_id)->first();

        if (!$device) {
            return response()->json([
                'status' => 'error',
                'message' => 'Device tidak ditemukan di tabel devices'
            ], 404);
        }

        $data = SensorData::create([
            'kandang_id' => $device->kandang_id,
            'device_id' => $device->id,
            'temperature' => $request->temperature,
            'chicken_detected' => $request->chicken_detected,
            'chicken_in' => $request->chicken_in,
            'chicken_out' => $request->chicken_out,
        ]);

        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    });

    Route::post('/command_send', function (Request $request) {

        $request->validate([
            'device_id' => 'required',
            'command_type' => 'required'
        ]);

        $cmd = Command::create([
            'device_id' => $request->device_id,
            'command_type' => $request->command_type,
            'status' => 'pending'
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Command masuk antrian',
            'data' => $cmd
        ]);
    });

    Route::get('/commands/{device_id}', function ($device_id) {

        $cmd = Command::where('status', 'pending')
            ->where('device_id', $device_id)
            ->orderBy('created_at', 'asc')
            ->first();

        return response()->json([
            'has_command' => $cmd ? true : false,
            'data' => $cmd
        ]);
    });

    Route::post('/commands/update', function (Request $request) {

        $request->validate([
            'id' => 'required',
            'device_id' => 'required',
            'command_type' => 'required'
        ]);

        $cmd = Command::where('id', $request->id)
            ->where('device_id', $request->device_id)
            ->first();

        if (!$cmd) {
            return response()->json([
                'status' => 'error',
                'message' => 'Command tidak ditemukan'
            ], 404);
        }

        $cmd->update([
            'status' => 'executed'
        ]);

        $device = Device::where('device_id', $request->device_id)->first();

        if ($device) {

            if ($request->command_type == 'OPEN_DOOR') {
                $device->update(['door_status' => 'TERBUKA']);
            }

            if ($request->command_type == 'CLOSE_DOOR') {
                $device->update(['door_status' => 'TERTUTUP']);
            }

            if ($request->command_type == 'LIGHT_ON') {
                $device->update(['light_status' => 'HIDUP']);
            }

            if ($request->command_type == 'LIGHT_OFF') {
                $device->update(['light_status' => 'MATI']);
            }
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Command berhasil dieksekusi'
        ]);
    });
});

Route::get('/chart-data', function () {

    $data = SensorData::latest()->take(10)->get();

    $labels = $data->pluck('created_at')->map(fn($d) => $d->format('H:i'));
    $values = $data->pluck('temperature')->map(fn($t) => (float)$t);

    return response()->json([
        'labels' => $labels,
        'values' => $values,
    ]);
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
