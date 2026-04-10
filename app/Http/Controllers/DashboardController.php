<?php

namespace App\Http\Controllers;

use App\Models\SensorData;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil data terbaru tiap device
        $latest_data = SensorData::latest()
            ->get()
            ->unique('device_id');

        // Rata-rata suhu
        $avg_temp = $latest_data->avg('temperature');

        // Total ayam
        $total_chickens = $latest_data->sum(function ($row) {
            return $row->chicken_in - $row->chicken_out;
        });

        // Data chart (sementara)
        $chart_labels = ['10:00', '10:15', '10:30'];
        $chart_values = [28, 29, 30];

        // Ambil data terakhir
        $last_update = SensorData::latest()->first();

        // Status sistem
        $is_online = $last_update && $last_update->updated_at->gt(now()->subMinutes(5));
        
        // Kirim ke view
        return view('dashboard', compact(
            'latest_data',
            'avg_temp',
            'total_chickens',
            'chart_labels',
            'chart_values',
            'is_online'
        ));
    }
}
