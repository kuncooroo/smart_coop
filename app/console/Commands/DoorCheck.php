<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\SystemStatus;
use App\Models\ActivityLog;
use Carbon\Carbon;

class DoorCheck extends Command
{
    protected $signature = 'door:check';
    protected $description = 'Cek jadwal dan buka/tutup pintu otomatis';

    public function handle()
    {
        $now = Carbon::now();

        // Contoh timer buka pukul 06:00, tutup pukul 18:00
        $door_status = SystemStatus::firstOrNew(['device_id' => 'default']);

        if ($now->format('H:i') === '06:00') {
            $door_status->door_status = 'open';
            $door_status->save();
            ActivityLog::create([
                'device_id' => 'default',
                'activity' => 'Pintu otomatis dibuka',
            ]);
        } elseif ($now->format('H:i') === '18:00') {
            $door_status->door_status = 'closed';
            $door_status->save();
            ActivityLog::create([
                'device_id' => 'default',
                'activity' => 'Pintu otomatis ditutup',
            ]);
        }
    }
}