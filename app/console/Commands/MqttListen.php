<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PhpMqtt\Client\MqttClient;
use PhpMqtt\Client\Exceptions\MqttClientException;
use App\Models\Suhu;
use App\Models\Kandang;
use App\Models\Ayam;
use App\Models\Device;
use App\Events\SensorUpdated;
use App\Events\ChickenUpdated;
use App\Events\ServoUpdated;
use App\Events\LightUpdated;

class MqttListen extends Command
{
    protected $signature = 'mqtt:listen';
    protected $description = 'MQTT Listener Clean Version';

    public function handle()
    {
        $server = '127.0.0.1';
        $port = 1883;
        $clientId = 'laravel_subscriber';

        while (true) {
            try {
                $this->info("Connecting MQTT...");
                $mqtt = new MqttClient($server, $port, $clientId);
                $mqtt->connect();

                $this->info("MQTT Connected");

                $mqtt->subscribe('kandang/+/esp32/status', function ($topic, $message) {

                    $data = json_decode($message, true);
                    if (!$data) return;

                    Device::where('device_id', $data['device_id'] ?? null)->update([
                        'connection_status' => $data['connection_status'] ?? 'online',
                        'health_status' => $data['health_status'] ?? 'EXCELLENT',
                        'signal_strength' => $data['signal_strength'] ?? null,
                        'last_updated' => now(),
                    ]);

                    echo "[ESP32 STATUS] updated\n";
                }, 0);

                $mqtt->subscribe('kandang/+/sensor/dht22', function ($topic, $message) {

                    $data = json_decode($message, true);
                    if (!$data) return;

                    $device = Device::where('device_id', $data['device_id'] ?? null)->first();
                    if (!$device) return;

                    Suhu::create([
                        'kandang_id' => $device->kandang_id,
                        'device_id' => $device->id,
                        'temperature' => $data['temperature'],
                        'humidity' => $data['humidity']
                    ]);

                    event(new SensorUpdated([
                        'kandang_id' => $device->kandang_id,
                        'temperature' => $data['temperature'],
                        'humidity' => $data['humidity']
                    ]));

                    echo "[DHT SENSOR] saved\n";
                }, 0);

                $mqtt->subscribe('kandang/+/dht22/status', function ($topic, $message) {

                    $data = json_decode($message, true);
                    if (!$data) return;

                    Device::where('device_id', $data['device_id'] ?? null)->update([
                        'connection_status' => 'online',
                        'health_status' => $data['health_status'] ?? 'EXCELLENT',
                        'signal_strength' => $data['signal_strength'] ?? null,
                        'last_updated' => now(),
                    ]);

                    echo "[DHT STATUS] updated\n";
                }, 0);

                $mqtt->subscribe('kandang/+/servo/status', function ($topic, $message) {

                    $data = json_decode($message, true);
                    if (!$data) return;

                    $device = Device::where(
                        'device_id',
                        $data['device_id'] ?? null
                    )->first();

                    if (!$device) return;

                    $device->update([
                        'door_status' => $data['state'] === 'OPEN'
                            ? 'TERBUKA'
                            : 'TERTUTUP',

                        'connection_status' => 'online',
                        'last_updated' => now(),
                    ]);

                    event(new ServoUpdated([
                        'kandang_id' => $device->kandang_id,
                        'status' => $data['state'] === 'OPEN'
                            ? 'TERBUKA'
                            : 'TERTUTUP'
                    ]));

                    echo "[SERVO] updated\n";
                }, 0);

                $mqtt->subscribe('kandang/+/led/status', function ($topic, $message) {

                    $data = json_decode($message, true);
                    if (!$data) return;

                    $device = Device::where(
                        'device_id',
                        $data['device_id'] ?? null
                    )->first();

                    if (!$device) return;

                    $device->update([
                        'light_status' => $data['state'] === 'ON'
                            ? 'HIDUP'
                            : 'MATI',

                        'connection_status' => 'online',
                        'last_updated' => now(),
                    ]);

                    event(new LightUpdated([
                        'kandang_id' => $device->kandang_id,
                        'status' => $data['state'] === 'ON'
                            ? 'HIDUP'
                            : 'MATI'
                    ]));

                    echo "[LED] updated\n";
                }, 0);

                $mqtt->subscribe('kandang/ayam', function ($topic, $message) {

                    $data = json_decode($message, true);
                    if (!$data) return;

                    $device = Device::where('device_id', $data['device_id'] ?? null)->first();
                    if (!$device) return;

                    Ayam::create([
                        'kandang_id' => $data['kandang_id'],
                        'device_id' => $device->id,
                        'direction' => $data['direction'],
                        'source' => $data['source']
                    ]);

                    $kandang = Kandang::find($data['kandang_id']);
                    if ($kandang) {
                        if ($data['direction'] === 'IN') {
                            $kandang->current_chicken++;
                        } else {
                            if ($kandang->current_chicken > 0) {
                                $kandang->current_chicken--;
                            }
                        }
                        $kandang->save();
                        event(new ChickenUpdated([
                            'kandang_id' => $kandang->id,
                            'current_chicken' => $kandang->current_chicken,
                        ]));
                    }

                    echo "[AYAM] {$data['direction']}\n";
                }, 1);

                $mqtt->loop(true);
            } catch (MqttClientException | \Exception $e) {
                $this->error("MQTT Error: " . $e->getMessage());
                sleep(5);
            }
        }
    }
}
