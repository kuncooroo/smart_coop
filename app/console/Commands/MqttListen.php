<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PhpMqtt\Client\MqttClient;
use App\Models\Suhu;
use App\Models\Kandang;

class MqttListen extends Command
{
    protected $signature = 'mqtt:listen';

    protected $description = 'Listen MQTT';

    public function handle()
    {
        $mqtt = new MqttClient(
            '127.0.0.1',
            1883,
            'laravel_subscriber'
        );

        $mqtt->connect();

        echo "MQTT CONNECTED\n";

        $mqtt->subscribe('kandang/sensor', function ($topic, $message) {

            echo "MESSAGE MASUK:\n";
            echo $message . "\n";

            $data = json_decode($message, true);

            try {

                Suhu::create([
                    'kandang_id' => $data['kandang_id'],
                    'device_id' => $data['device_id'],
                    'temperature' => $data['temperature']
                ]);

                Kandang::where('id', $data['kandang_id'])
                    ->update([
                        'current_chicken' => $data['current_chicken']
                    ]);

                echo "BERHASIL INSERT DATABASE\n";
            } catch (\Exception $e) {

                echo "ERROR DATABASE:\n";
                echo $e->getMessage();
            }
        }, 0);

        $mqtt->loop(true);
    }
}
