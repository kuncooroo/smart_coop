<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Device;
use App\Models\Suhu;
use App\Models\Ayam;
use App\Models\Kandang;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $daftarKandang = Kandang::all();

        if ($daftarKandang->isEmpty()) {
            return "Data kandang tidak ditemukan.";
        }

        $kandangId = $request->get('kandang_id', $daftarKandang->first()->id);
        $kandang = Kandang::with(['devices'])->find($kandangId);
        $current_chicken = $kandang->current_chicken ?? 0;
        $capacity = $kandang->capacity ?? 0;
        $last_temp = Suhu::where('kandang_id', $kandangId)->latest()->value('temperature') ?? 0;
        $firstDevice = $kandang->devices->first();
        $door_status = $firstDevice ? $firstDevice->door_status : 'TIDAK ADA ALAT';
        $labels = [];
        $chicken_data = [];
        $temp_data = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $labels[] = $date->format('d M');

            $chicken_data[] = Ayam::where('kandang_id', $kandangId)
                ->whereDate('created_at', $date)
                ->where('direction', 'IN')
                ->count();

            $temp_data[] = round(Suhu::where('kandang_id', $kandangId)
                ->whereDate('created_at', $date)
                ->avg('temperature') ?? 0, 1);
        }
        $online = Device::where('kandang_id', $kandangId)->where('connection_status', 'online')->count();
        $offline = Device::where('kandang_id', $kandangId)->where('connection_status', 'offline')->count();
        $health_stats = [
            'excellent'   => Device::where('kandang_id', $kandangId)->where('health_status', 'EXCELLENT')->count(),
            'degraded'    => Device::where('kandang_id', $kandangId)->where('health_status', 'DEGRADED')->count(),
            'critical'    => Device::where('kandang_id', $kandangId)->where('health_status', 'CRITICAL')->count(),
            'maintenance' => Device::where('kandang_id', $kandangId)->where('health_status', 'MAINTENANCE')->count(),
        ];
        $manual_count = Ayam::where('kandang_id', $kandangId)->where('source', 'MANUAL')->count();
        $auto_count = Ayam::where('kandang_id', $kandangId)->whereIn('source', ['CAM', 'AUTO'])->count();

        return view('Public.laporan.index', compact(
            'daftarKandang',
            'kandangId',
            'current_chicken',
            'capacity',
            'last_temp',
            'door_status',
            'labels',
            'chicken_data',
            'temp_data',
            'online',
            'offline',
            'health_stats',
            'manual_count',
            'auto_count'
        ));
    }
    public function export(Request $request)
    {
        $format = $request->get('format', 'csv');

        $kandangId = $request->kandang_id;
        $data = \App\Models\Ayam::where('kandang_id', $kandangId)->get();
        $avgSuhu = \App\Models\Suhu::where('kandang_id', $kandangId)
            ->avg('temperature');

        if ($format === 'csv') {

            $filename = "laporan.csv";

            $headers = [
                "Content-type" => "text/csv",
                "Content-Disposition" => "attachment; filename=$filename",
            ];

            $callback = function () use ($data) {
                $file = fopen('php://output', 'w');

                fputcsv($file, ['ID', 'Direction', 'Source', 'Tanggal']);

                foreach ($data as $row) {
                    fputcsv($file, [
                        $row->id,
                        $row->direction,
                        $row->source,
                        $row->created_at
                    ]);
                }

                fclose($file);
            };

            return response()->stream($callback, 200, $headers);
        }

        if ($format === 'pdf') {

            $totalMasuk = $data->where('direction', 'IN')->count();
            $totalKeluar = $data->where('direction', 'OUT')->count();

            $avgSuhu = \App\Models\Suhu::where('kandang_id', $kandangId)
                ->avg('temperature');

            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('Public.laporan.export_pdf', [
                'data' => $data,
                'totalMasuk' => $totalMasuk,
                'totalKeluar' => $totalKeluar,
                'avgSuhu' => round($avgSuhu ?? 0, 1)
            ]);

            return $pdf->download('laporan.pdf');
        }
    }
}
