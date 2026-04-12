<?php

namespace App\Exports;

use App\Models\SensorData;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SensorExport implements FromQuery, WithHeadings, WithMapping
{
    protected $kandangId;
    protected $startDate;
    protected $endDate;

    public function __construct($kandangId, $startDate, $endDate)
    {
        $this->kandangId = $kandangId;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function query()
    {
        $query = SensorData::with('kandang');

        if ($this->kandangId !== 'all') {
            $query->where('kandang_id', $this->kandangId);
        }

        if ($this->startDate) {
            $query->whereDate('created_at', '>=', $this->startDate);
        }

        if ($this->endDate) {
            $query->whereDate('created_at', '<=', $this->endDate);
        }

        return $query->latest();
    }

    public function headings(): array
    {
        return [
            'Waktu',
            'Kandang',
            'Suhu (°C)',
            'Ayam Masuk',
            'Ayam Keluar',
            'Deteksi Gerak',
        ];
    }

    public function map($data): array
    {
        return [
            $data->created_at->format('d/m/Y H:i'),
            $data->kandang->name ?? '-',
            $data->temperature,
            $data->chicken_in,
            $data->chicken_out,
            $data->chicken_detected ? 'Ada' : 'Tidak',
        ];
    }
}