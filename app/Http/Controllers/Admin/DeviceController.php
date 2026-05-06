<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Device;
use App\Models\Kandang;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
    public function index()
    {
        $devices = Device::with('kandang.user')->get();
        return view('Admin.device.index', compact('devices'));
    }

    public function create()
    {
        $kandangs = Kandang::all();
        return view('Admin.device.create', compact('kandangs'));
    }

    public function store(Request $request)
    {
        Device::create($request->all());
        return redirect()->route('admin.device.index');
    }

    public function edit($id)
    {
        $device = Device::findOrFail($id);
        $kandangs = Kandang::all();

        return view('Admin.device.edit', compact('device', 'kandangs'));
    }

    public function update(Request $request, $id)
    {
        $device = Device::findOrFail($id);
        $device->update($request->all());

        return redirect()->route('admin.device.index');
    }

    public function destroy($id)
    {
        Device::destroy($id);
        return back();
    }
}
