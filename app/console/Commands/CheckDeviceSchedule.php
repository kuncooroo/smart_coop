<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\DeviceSetting;
use App\Models\Device;
use App\Services\MqttService;
use Carbon\Carbon;

class CheckDeviceSchedule extends Command
{
    protected $signature = 'schedule:device';

    protected $description = 'Check device timer';

    public function handle()
    {
        $now = Carbon::now()->format('H:i');

        echo "CHECK TIME: " . $now . "\n";

        $settings = DeviceSetting::where('is_set', 1)
            ->where('auto_mode', 1)
            ->get();

        foreach ($settings as $setting) {

            echo "SETTING DITEMUKAN\n";

            $openTime = Carbon::parse(
                $setting->timer_open
            )->format('H:i');

            $closeTime = Carbon::parse(
                $setting->timer_close
            )->format('H:i');

            echo "OPEN TIME: " . $openTime . "\n";
            echo "CLOSE TIME: " . $closeTime . "\n";

            $servo = Device::where(
                'kandang_id',
                $setting->kandang_id
            )
                ->where('device_type', 'LIKE', 'SERVO%')
                ->first();

            if (!$servo) {

                echo "SERVO TIDAK DITEMUKAN\n";
                continue;
            }

            echo "SERVO DITEMUKAN\n";

            echo "STATUS: ";
            echo $servo->door_status . "\n";

            if (
                $now >= $openTime &&
                $servo->door_status == 'TERTUTUP'
            ) {

                MqttService::publish(
                    'kandang/servo',
                    'OPEN'
                );

                $servo->door_status = 'TERBUKA';
                $servo->save();

                echo "SERVO OPEN\n";
            }

            if (
                $now >= $closeTime &&
                $servo->door_status == 'TERBUKA'
            ) {

                MqttService::publish(
                    'kandang/servo',
                    'CLOSE'
                );

                $servo->door_status = 'TERTUTUP';
                $servo->save();

                echo "SERVO CLOSE\n";
            }
        }
    }
}
