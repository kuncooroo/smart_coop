<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Kandang;
// use App\Models\Command;
// use App\Models\DeviceSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MonitoringController extends Controller
{
    public function index()
    {
        $kandangs = Kandang::with([
            'devices',
            'setting',
            'suhus' => function ($q) {
                $q->latest()->limit(1);
            }
        ])->get();

        return view('Public.monitoring.index', compact('kandangs'));
    }

    public function create()
    {
        return view('Public.monitoring.create');
    }

    public function edit($id)
    {
        $kandang = Kandang::findOrFail($id);
        return view('Public.monitoring.edit', compact('kandang'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:kandangs,code',
            'capacity' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('kandang', 'public');
        }

        $kandang = Kandang::create($data);
        $kandang->devices()->create(['device_id' => 'SERVO-' . $kandang->code, 'door_status' => 'TERTUTUP']);
        $kandang->devices()->create(['device_id' => 'LAMP-' . $kandang->code, 'light_status' => 'MATI']);

        return redirect()->route('monitoring.index')->with('success', 'Kandang berhasil dibuat!');
    }

    public function update(Request $request, $id)
    {
        $kandang = Kandang::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:kandangs,code,' . $id,
            'capacity' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            if ($kandang->image) {
                Storage::disk('public')->delete($kandang->image);
            }
            $data['image'] = $request->file('image')->store('kandang', 'public');
        }

        $kandang->update($data);
        return redirect()->route('monitoring.index')->with('success', 'Profil Kandang berhasil diperbarui!');
    }

    public function destroy($id)
    {
        Kandang::destroy($id);
        return back()->with('success', 'Kandang berhasil dihapus!');
    }

    public function updateSettings(Request $request, $kandang_id)
    {
        $request->validate([
            'timer_open' => 'required',
            'timer_close' => 'required',
        ]);

        \App\Models\DeviceSetting::updateOrCreate(
            ['kandang_id' => $kandang_id],
            [
                'timer_open'  => $request->timer_open,
                'timer_close' => $request->timer_close,
                'is_set'      => true,
            ]
        );

        return redirect()->route('monitoring.index')->with('success', 'Jadwal otomatis berhasil diaktifkan!');
    }
}
