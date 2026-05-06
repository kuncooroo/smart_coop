<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Kandang;
use App\Models\Device;

class KandangSeeder extends Seeder
{
    public function run(): void
    {
        // pastikan user ada
        $user1 = User::first();
        $user2 = User::skip(1)->first();

        if (!$user1) {
            $this->command->info('User belum ada, jalankan UserSeeder dulu!');
            return;
        }

        $kandang1 = Kandang::create([
            'user_id' => $user1->id,
            'name' => 'Kandang 1',
            'code' => 'KDG001',
            'capacity' => 100,
            'timer_open' => '06:00:00',
            'timer_close' => '18:00:00',
        ]);

        Device::insert([
            [
                'kandang_id' => $kandang1->id,
                'device_id' => 'DHT22_1',
                'device_name' => 'Sensor Suhu K1',
                'status' => 'aktif',
                'connection_status' => 'online',
                'health_status' => 'EXCELLENT',
                'signal_strength' => 90,
                'door_status' => null,
                'light_status' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kandang_id' => $kandang1->id,
                'device_id' => 'SERVO_1',
                'device_name' => 'Pintu K1',
                'status' => 'aktif',
                'connection_status' => 'online',
                'health_status' => 'EXCELLENT',
                'signal_strength' => 80,
                'door_status' => 'TERTUTUP',
                'light_status' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kandang_id' => $kandang1->id,
                'device_id' => 'LAMP_1',
                'device_name' => 'Lampu Pemanas K1',
                'status' => 'aktif',
                'connection_status' => 'offline',
                'health_status' => 'DEGRADED',
                'signal_strength' => 40,
                'door_status' => null,
                'light_status' => 'MATI',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        $kandang2 = Kandang::create([
            'user_id' => $user2 ? $user2->id : $user1->id,
            'name' => 'Kandang 2',
            'code' => 'KDG002',
            'capacity' => 120,
            'timer_open' => '06:00:00',
            'timer_close' => '18:00:00',
        ]);

        Device::insert([
            [
                'kandang_id' => $kandang1->id,
                'device_id' => 'DHT22_2',
                'device_name' => 'Sensor Suhu K2',
                'status' => 'aktif',
                'connection_status' => 'online',
                'health_status' => 'EXCELLENT',
                'signal_strength' => 90,
                'door_status' => null,
                'light_status' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kandang_id' => $kandang1->id,
                'device_id' => 'SERVO_2',
                'device_name' => 'Pintu K2',
                'status' => 'aktif',
                'connection_status' => 'online',
                'health_status' => 'EXCELLENT',
                'signal_strength' => 80,
                'door_status' => 'TERTUTUP',
                'light_status' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kandang_id' => $kandang1->id,
                'device_id' => 'LAMP_2',
                'device_name' => 'Lampu Pemanas K2',
                'status' => 'aktif',
                'connection_status' => 'offline',
                'health_status' => 'DEGRADED',
                'signal_strength' => 40,
                'door_status' => null,
                'light_status' => 'MATI',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
