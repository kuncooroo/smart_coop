<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            [
                'username' => 'admin',
                'password' => Hash::make('admin123'),
                'full_name' => 'Administrator Utama',
                'email' => 'admin@smartfarm.com',
                'role' => 'admin',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'operator1',
                'password' => Hash::make('operator123'),
                'full_name' => 'Operator Kandang 1',
                'email' => 'operator1@smartfarm.com',
                'role' => 'operator',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
