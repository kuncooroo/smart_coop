<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        Admin::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@gmail.com',
            'password' => Hash::make('password123'),
            'phone' => '081234567890',
            'role' => 'superadmin',
        ]);

        Admin::create([
            'name' => 'Admin 1',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password123'),
            'phone' => '081234567891',
            'role' => 'admin',
        ]);

        Admin::factory()->count(3)->create();
    }
}