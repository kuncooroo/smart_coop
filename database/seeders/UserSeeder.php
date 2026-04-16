<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'username' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123456'),

            'nama_lengkap' => 'Administrator System',
            'no_hp' => '081234567890',
            'jenis_kelamin' => 'L',

            'provinsi_id' => null,
            'kota_id' => null,
            'kecamatan_id' => null,

            'alamat_lengkap' => 'Jl. Contoh No. 1',
            'profile' => null,
        ]);

        User::create([
            'username' => 'user',
            'email' => 'user@gmail.com',
            'password' => Hash::make('123456'),

            'nama_lengkap' => 'User Biasa',
            'no_hp' => '089876543210',
            'jenis_kelamin' => 'P',

            'provinsi_id' => null,
            'kota_id' => null,
            'kecamatan_id' => null,

            'alamat_lengkap' => 'Jl. User No. 2',
            'profile' => null,
        ]);
    }
}