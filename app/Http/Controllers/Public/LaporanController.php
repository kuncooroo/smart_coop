<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Device;
use App\Models\SensorData;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    public function index()
    {
        // ======================
        // SUMMARY
        // ======================
        $totalDevices = Device::count();
        $online = Device::where('status', 'online')->count();
        $offline = Device::where('status', 'offline')->count();
        $warning = Device::where('health_status', '!=', 'EXCELLENT')->count();

        // ALERT 24 JAM
        $alerts24h = SensorData::where('created_at', '>=', now()->subDay())
            ->where('chicken_detected', false)
            ->count();

        // ======================
        // DATA GRAFIK
        // ======================
        $data = SensorData::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('SUM(chicken_in) as masuk'),
            DB::raw('SUM(chicken_out) as keluar'),
            DB::raw('AVG(temperature) as suhu')
        )
            ->where('created_at', '>=', now()->subDays(10))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $labels = $data->pluck('date')->map(fn($d) => Carbon::parse($d)->format('d M'));
        $masuk  = $data->pluck('masuk');
        $keluar = $data->pluck('keluar');
        $suhu   = $data->pluck('suhu');

        return view('Public.laporan.index', compact(
            'totalDevices',
            'online',
            'offline',
            'warning',
            'alerts24h',
            'labels',
            'masuk',
            'keluar',
            'suhu'
        ));
    }

    public function export(Request $request)
{
    // ======================
    // AMBIL DATA
    // ======================
    if ($request->type == 'quick') {
        $data = SensorData::where('created_at', '>=', now()->subDays(10))->get();
    } else {
        $data = SensorData::whereBetween('created_at', [
            $request->start_date,
            $request->end_date
        ])->get();
    }

    $format = $request->format ?? 'csv';

    // ======================
    // PDF (DOWNLOAD FILE)
    // ======================
    if ($format == 'pdf') {

        $totalMasuk = $data->sum('chicken_in');
        $totalKeluar = $data->sum('chicken_out');
        $avgSuhu = round($data->avg('temperature'), 2);

        $pdf = Pdf::loadView('Public.laporan.export_pdf', compact(
            'data',
            'totalMasuk',
            'totalKeluar',
            'avgSuhu'
        ));

        return $pdf->stream('laporan-kandang.pdf'); // 🔥 INI YANG BIKIN DOWNLOAD
    }

    // ======================
    // CSV
    // ======================
    $filename = "laporan.csv";

    $headers = [
        "Content-Type" => "text/csv",
        "Content-Disposition" => "attachment; filename=$filename",
    ];

    $callback = function () use ($data) {
        $file = fopen('php://output', 'w');

        fputcsv($file, ['Tanggal', 'Suhu', 'Ayam Masuk', 'Ayam Keluar']);

        foreach ($data as $row) {
            fputcsv($file, [
                $row->created_at,
                $row->temperature,
                $row->chicken_in,
                $row->chicken_out
            ]);
        }

        fclose($file);
    };

    return response()->stream($callback, 200, $headers);
}
}