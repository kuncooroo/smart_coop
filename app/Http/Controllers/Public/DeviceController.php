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
            'device_id'     => 'required|unique:devices,device_id',
            'device_name'   => 'required|string|max:255',
            'kandang_id'    => 'required|exists:kandangs,id',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->except('profile_image');
        $data['status'] = $request->status ?? 'aktif'; 
        $data['connection_status'] = 'online'; 
        $data['signal_strength'] = rand(70, 100);
        $data['last_updated'] = now();

        if ($request->hasFile('profile_image')) {
            $data['profile_image'] = $request->file('profile_image')->store('devices', 'public');
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
            'device_name'       => 'required|string|max:255',
            'kandang_id'        => 'required|exists:kandangs,id',
            'profile_image'     => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'installation_date' => 'nullable|date',
        ]);

        $data = $request->except(['profile_image', 'remove_image']);

        if ($request->remove_image == "1") {
            if ($device->profile_image) {
                Storage::disk('public')->delete($device->profile_image);
                $device->profile_image = null; 
            }
        }

        if ($request->hasFile('profile_image')) {
            if ($device->profile_image) {
                Storage::disk('public')->delete($device->profile_image);
            }
            $data['profile_image'] = $request->file('profile_image')->store('devices', 'public');
        } else {
            $data['profile_image'] = $device->profile_image;
        }

        $device->update($data);

        return redirect()->route('devices.index')
            ->with('success', 'Perangkat berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $device = Device::findOrFail($id);

        if ($device->profile_image) {
            Storage::disk('public')->delete($device->profile_image);
        }

        $device->delete();

        return redirect()->route('devices.index')
            ->with('success', 'Perangkat berhasil dihapus!');
    }
}