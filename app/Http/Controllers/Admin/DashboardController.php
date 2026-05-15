<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\User;
use App\Models\Device;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'totalAdmin' => Admin::count(),
            'totalSuperAdmin' => Admin::where('role', 'superadmin')->count(),
            'totalUser' => User::count(),
            'totalDevice' => Device::count(),
            'deviceOnline' => Device::where('connection_status', 'online')->count(),
            'deviceOffline' => Device::where('connection_status', 'offline')->count(),
        ];

        return view('Admin.dashboard', $data);
    }
}