<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Kandang;
use App\Models\SensorData;
use App\Models\ActivityLog;
use App\Models\Device;
use Illuminate\Http\Request;
use App\Exports\SensorExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
    public function index()
    {
        $latestSensor = SensorData::latest('created_at')->first();

        $todaySensors = SensorData::whereDate('created_at', now()->today())->get();
        $totalIn = $todaySensors->sum('chicken_in');
        $totalOut = $todaySensors->sum('chicken_out');

        if (Schema::hasColumn('devices', 'door_status')) {
            $anyDoorOpen = Device::where('door_status', 'TERBUKA')->exists();
        } else {
            $anyDoorOpen = false; 
        }

        $recentActivities = ActivityLog::with('kandang')
            ->latest('created_at')
            ->take(6)
            ->get();

        return view('public.dashboard', compact(
            'latestSensor',
            'totalIn',
            'totalOut',
            'anyDoorOpen',
            'recentActivities'
        ));
    }

    public function monitoring()
    {
        $kandangs = Kandang::with([
            'devices',
            'sensorData' => function ($query) {
                $query->latest()->limit(1);
            }
        ])->get();

        $allSensorData = SensorData::with('kandang')
            ->latest()
            ->limit(10)
            ->get();

        $chartData = SensorData::latest()
            ->limit(20)
            ->get()
            ->reverse();

        return view('Public.monitoring', compact('kandangs', 'allSensorData', 'chartData'));
    }

    public function activityLog()
    {
        $logs = ActivityLog::with(['kandang', 'device'])
            ->latest('created_at')
            ->paginate(15);

        return view('Public.activity_log', compact('logs'));
    }

    public function laporan()
    {
        return view('Public.laporan');
    }

    public function notifikasi()
    {
        return view('Public.notifikasi');
    }

    public function export(Request $request)
    {
        $type = $request->type;
        $kandangId = $request->kandang_id;
        $startDate = $request->start_date;
        $endDate = $request->end_date;

        $filename = 'Laporan_Kandang_' . now()->format('Ymd_His');

        if ($type === 'excel') {
            return Excel::download(
                new SensorExport($kandangId, $startDate, $endDate),
                $filename . '.xlsx'
            );
        }

        if ($type === 'pdf') {
            $query = SensorData::with('kandang');

            if ($kandangId !== 'all') {
                $query->where('kandang_id', $kandangId);
            }

            if ($startDate) {
                $query->whereDate('created_at', '>=', $startDate);
            }

            if ($endDate) {
                $query->whereDate('created_at', '<=', $endDate);
            }

            $data = $query->latest()->get();

            $pdf = Pdf::loadView('pdf.report_sensor', compact('data', 'startDate', 'endDate'));

            return $pdf->download($filename . '.pdf');
        }

        return back()->with('error', 'Format tidak didukung');
    }
}