<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\DeviceSetting;
use App\Models\Device;
use App\Models\Kandang;
use App\Services\MqttService;
use Carbon\Carbon;

class CheckDeviceSchedule extends Command
{
    protected $signature = 'schedule:device';
    protected $description = 'Auto schedule device servo based on timer';

    public function handle()
    {
        $now = Carbon::now();
        $currentTime = $now->format('H:i');

        echo "CHECK TIME: {$currentTime}\n";

        $settings = DeviceSetting::where('auto_mode', 1)
            ->whereNotNull('timer_open')
            ->whereNotNull('timer_close')
            ->get();

        foreach ($settings as $setting) {

            echo "----------------------------------------\n";
            echo "KANDANG ID: {$setting->kandang_id}\n";

            $openTime  = Carbon::parse($setting->timer_open)->format('H:i');
            $closeTime = Carbon::parse($setting->timer_close)->format('H:i');

            echo "OPEN: {$openTime} | CLOSE: {$closeTime}\n";

            $kandang = Kandang::find($setting->kandang_id);

            if (!$kandang || !$kandang->code) {
                echo "KANDANG TIDAK VALID\n";
                continue;
            }

            $servo = Device::where('kandang_id', $setting->kandang_id)
                ->where('component_type', 'servo')
                ->first();

            if (!$servo) {
                echo "SERVO TIDAK DITEMUKAN\n";
                continue;
            }
            if (!$setting->timer_open || !$setting->timer_close) {
                continue;
            }
            echo "SERVO: {$servo->device_id}\n";

            $topic = "kandang/{$kandang->code}/servo";

            $isActive = false;

            if ($openTime < $closeTime) {
                $isActive = ($currentTime >= $openTime && $currentTime < $closeTime);
            } else {
                $isActive = ($currentTime >= $openTime || $currentTime < $closeTime);
            }

            $isClosed = ($servo->door_status === 'TERTUTUP');
            $isOpen   = ($servo->door_status === 'TERBUKA');

            if ($isActive && $isClosed) {

                MqttService::publish($topic, 'OPEN');

                echo "SEND COMMAND: OPEN -> {$topic}\n";

                $servo->update([
                    'door_status' => 'TERBUKA',
                    'last_updated' => now()
                ]);
            }

            if (!$isActive && $isOpen) {

                MqttService::publish($topic, 'CLOSE');

                echo "SEND COMMAND: CLOSE -> {$topic}\n";

                $servo->update([
                    'door_status' => 'TERTUTUP',
                    'last_updated' => now()
                ]);
            }
        }

        return Command::SUCCESS;
    }
}
