<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Device;
use App\Models\Suhu;
use App\Models\Ayam;
use App\Models\Deteksi;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function index()
    {
        $totalDevices = Device::count();
        $online = Device::where('status', 'online')->count();
        $offline = Device::where('status', 'offline')->count();
        $warning = Device::where('health_status', '!=', 'EXCELLENT')->count();

        $alerts24h = Deteksi::where('created_at', '>=', now()->subDay())
            ->where('is_valid', false)
            ->count();

        $dates = collect(range(0, 9))->map(function ($i) {
            return now()->subDays(9 - $i)->format('Y-m-d');
        });

        $data = $dates->map(function ($date) {

            $masuk = (int) Ayam::whereDate('created_at', $date)
                ->where('direction', 'IN')
                ->count();

            $keluar = (int) Ayam::whereDate('created_at', $date)
                ->where('direction', 'OUT')
                ->count();

            $suhu = (float) Suhu::whereDate('created_at', $date)
                ->avg('temperature');

            return [
                'date' => (string) $date,
                'masuk' => $masuk,
                'keluar' => $keluar,
                'suhu' => round($suhu ?? 0, 2)
            ];
        });

        $labels = $data->pluck('date')->map(function ($d) {
            return Carbon::parse($d)->format('d M');
        })->values()->toArray();

        $masuk = $data->pluck('masuk')->map(fn($v) => (int)$v)->values()->toArray();
        $keluar = $data->pluck('keluar')->map(fn($v) => (int)$v)->values()->toArray();
        $suhu = $data->pluck('suhu')->map(fn($v) => (float)$v)->values()->toArray();

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
}