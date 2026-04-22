<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Device;
use App\Models\Kandang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DeviceController extends Controller
{
    public function index()
    {
        $devices = Device::with('kandang')->latest()->get();
        return view('Public.device.index', compact('devices'));
    }

    public function create()
    {
        $kandangs = Kandang::all();
        return view('Public.device.create', compact('kandangs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'device_id'   => 'required|unique:devices,device_id',
            'device_name' => 'required|string|max:255',
            'kandang_id'  => 'required|exists:kandangs,id',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->all();

        // default value
        $data['status'] = 'offline';
        $data['last_online'] = now();

        // upload gambar
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('devices', 'public');
        }

        Device::create($data);

        return redirect()->route('devices.index')
            ->with('success', 'Perangkat berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $device = Device::findOrFail($id);
        $kandangs = Kandang::all();

        return view('Public.device.edit', compact('device', 'kandangs'));
    }

    public function update(Request $request, $id)
    {
        $device = Device::findOrFail($id);

        $request->validate([
            'device_id'   => 'required|unique:devices,device_id,' . $id,
            'device_name' => 'required|string|max:255',
            'kandang_id'  => 'required|exists:kandangs,id',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            if ($device->image) {
                Storage::disk('public')->delete($device->image);
            }

            $data['image'] = $request->file('image')->store('devices', 'public');
        }

        $device->update($data);

        return redirect()->route('devices.index')
            ->with('success', 'Perangkat berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $device = Device::findOrFail($id);

        if ($device->image) {
            Storage::disk('public')->delete($device->image);
        }

        $device->delete();

        return redirect()->route('devices.index')
            ->with('success', 'Perangkat berhasil dihapus!');
    }
}