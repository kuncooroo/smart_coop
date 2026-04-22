<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SensorData;
use App\Models\Kandang;
use App\Exports\SensorExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    public function index()
    {
        return view('Public.laporan');
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