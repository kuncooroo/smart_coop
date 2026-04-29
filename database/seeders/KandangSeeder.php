<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kandang;
use App\Models\Device;

class KandangSeeder extends Seeder
{
    public function run(): void
    {
        $kandang1 = Kandang::create([
            'name' => 'Kandang 1',
            'code' => 'KDG001',
            'capacity' => 100,
            'timer_open' => '06:00:00',
            'timer_close' => '18:00:00',
        ]);

        Device::create([
            'kandang_id' => $kandang1->id,
            'device_id' => 'DHT22_1',
            'device_name' => 'Sensor Suhu K1',
            'status' => 'aktif',
            'connection_status' => 'online',
            'health_status' => 'EXCELLENT',
            'signal_strength' => 90,
        ]);

        Device::create([
            'kandang_id' => $kandang1->id,
            'device_id' => 'SERVO_1',
            'device_name' => 'Pintu K1',
            'door_status' => 'TERTUTUP',
            'status' => 'aktif',
            'connection_status' => 'online',
            'health_status' => 'EXCELLENT',
            'signal_strength' => 80,
        ]);

        Device::create([
            'kandang_id' => $kandang1->id,
            'device_id' => 'LAMP_1',
            'device_name' => 'Lampu Pemanas K1',
            'light_status' => 'MATI',
            'status' => 'aktif',
            'connection_status' => 'offline',
            'health_status' => 'DEGRADED',
            'signal_strength' => 40,
        ]);

        $kandang2 = Kandang::create([
            'name' => 'Kandang 2',
            'code' => 'KDG002',
            'capacity' => 120,
            'timer_open' => '06:00:00',
            'timer_close' => '18:00:00',
        ]);

        Device::create([
            'kandang_id' => $kandang2->id,
            'device_id' => 'DHT22_2',
            'device_name' => 'Sensor Suhu K2',
            'status' => 'aktif',
            'connection_status' => 'online',
            'health_status' => 'EXCELLENT',
            'signal_strength' => 95,
        ]);

        Device::create([
            'kandang_id' => $kandang2->id,
            'device_id' => 'SERVO_2',
            'device_name' => 'Pintu K2',
            'door_status' => 'TERTUTUP',
            'status' => 'aktif',
            'connection_status' => 'offline',
            'health_status' => 'CRITICAL',
            'signal_strength' => 10,
        ]);

        Device::create([
            'kandang_id' => $kandang2->id,
            'device_id' => 'LAMP_2',
            'device_name' => 'Lampu Pemanas K2',
            'light_status' => 'MATI',
            'status' => 'non-aktif',
            'connection_status' => 'offline',
            'health_status' => 'MAINTENANCE',
            'signal_strength' => 0,
        ]);
    }
}