<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\SensorData;
use App\Models\Command;
use App\Models\SystemStatus;

/*
|--------------------------------------------------------------------------
| API Routes - Smart Chicken Coop
|--------------------------------------------------------------------------
*/

// Group dengan middleware API KEY
Route::middleware('apikey')->group(function () {

    /**
     * 1. INGEST DATA (Simulator / ESP32)
     * Endpoint: POST /api/ingest
     */
    Route::post('/ingest', function (Request $request) {

        SensorData::create([
            'device_id' => $request->device_id,
            'temperature' => $request->temperature,
            'chicken_detected' => $request->chicken_detected,
            'chicken_in' => $request->chicken_in,
            'chicken_out' => $request->chicken_out,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Data berhasil disimpan'
        ]);
    });

    Route::post('/command_send', function (Request $request) {

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

    /**
     * 2. WORKER AMBIL COMMAND
     * Endpoint: GET /api/commands/get
     */
    Route::get('/commands/get', function () {

        $cmd = Command::where('status', 'pending')
            ->orderBy('created_at', 'asc')
            ->first();

        return response()->json([
            'has_command' => $cmd ? true : false,
            'data' => $cmd
        ]);
    });


    /**
     * 3. WORKER UPDATE COMMAND (SELESAI)
     * Endpoint: POST /api/commands/update
     */
    Route::post('/commands/update', function (Request $request) {

        // Update status command
        $cmd = Command::find($request->id);

        if (!$cmd) {
            return response()->json([
                'status' => 'error',
                'message' => 'Command tidak ditemukan'
            ], 404);
        }

        $cmd->update([
            'status' => 'executed'
        ]);

        // Update system status (door & light)
        $status = SystemStatus::firstOrCreate([
            'device_id' => $request->device_id
        ]);

        if ($request->command_type == 'OPEN_DOOR') {
            $status->update(['door_status' => 'open']);
        }

        if ($request->command_type == 'CLOSE_DOOR') {
            $status->update(['door_status' => 'closed']);
        }

        if ($request->command_type == 'TOGGLE_LIGHT') {
            $status->update([
                'light_status' => $status->light_status === 'on' ? 'off' : 'on'
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Command berhasil dieksekusi'
        ]);
    });
});

Route::get('/chart-data', function () {
    // Ambil 10 data terakhir per device
    $data = SensorData::latest()->take(10)->get();

    // Buat labels & values untuk Chart.js
    $labels = $data->pluck('created_at')->map(fn($d) => $d->format('H:i')); // jam:menit
    $values = $data->pluck('temperature')->map(fn($t) => (float)$t);

    return response()->json([
        'labels' => $labels,
        'values' => $values,
    ]);
});
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
