<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Device;
use App\Models\Kandang;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
    public function index(Request $request)
    {
        $kandangId = $request->kandang_id;

        $devices = Device::with('kandang.user')
            ->when($kandangId, function ($query) use ($kandangId) {
                $query->where('kandang_id', $kandangId);
            })
            ->get();

        $kandang = null;

        if ($kandangId) {
            $kandang = Kandang::find($kandangId);
        }

        return view('Admin.device.index', compact('devices', 'kandang'));
    }

    public function create(Request $request)
    {
        $kandangs = Kandang::all();

        $selectedKandang = $request->kandang_id;

        return view('Admin.device.create', compact(
            'kandangs',
            'selectedKandang'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'device_name' => 'required',
            'device_id' => 'required|unique:devices,device_id',
            'kandang_id' => 'required|exists:kandangs,id',
            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('profile_image')) {
            $data['profile_image'] = $request->file('profile_image')
                ->store('devices', 'public');
        }

        Device::create($data);

        return redirect()
            ->route('Admin.devices.index')
            ->with('success', 'Device berhasil ditambahkan');
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

        $request->validate([
            'device_name' => 'required',
            'kandang_id' => 'required|exists:kandangs,id',
            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('profile_image')) {
            $data['profile_image'] = $request->file('profile_image')
                ->store('devices', 'public');
        }

        if ($request->remove_image == "1") {
            $data['profile_image'] = null;
        }

        $device->update($data);

        return redirect()
            ->route('Admin.devices.index')
            ->with('success', 'Device berhasil diupdate');
    }

    public function destroy($id)
    {
        Device::destroy($id);
        return back();
    }
}
