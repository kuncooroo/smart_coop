<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('public.profile.edit');
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'username' => 'required|string|max:255|unique:users,username,' . Auth::id(),
            'nama_lengkap' => 'required|string|max:255',
            'no_hp' => 'nullable',
            'jenis_kelamin' => 'nullable|in:L,P',
            'provinsi_id' => 'nullable',
            'kota_id' => 'nullable',
            'kecamatan_id' => 'nullable',
            'alamat_lengkap' => 'nullable',
            'profile' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        if ($request->hasFile('profile')) {
            if ($user->profile) {
                Storage::disk('public')->delete($user->profile);
            }
            $path = $request->file('profile')->store('profile', 'public');
            $user->profile = $path;
        }
        $user->username = $request->username;
        $user->nama_lengkap = $request->nama_lengkap;
        $user->no_hp = $request->no_hp;
        $user->jenis_kelamin = $request->jenis_kelamin;
        $user->alamat_lengkap = $request->alamat_lengkap;
        $user->provinsi_id = $request->provinsi_id ?: null;
        $user->kota_id = $request->kota_id ?: null;
        $user->kecamatan_id = $request->kecamatan_id ?: null;

        $user->save();

        return redirect()->route('dashboard')->with('success', 'Profil berhasil diperbarui!');
    }

    public function getProvinsi()
    {
        return Http::get('https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json')->json();
    }

    public function getKota($provinsi_id)
    {
        return Http::get("https://www.emsifa.com/api-wilayah-indonesia/api/regencies/{$provinsi_id}.json")->json();
    }

    public function getKecamatan($kota_id)
    {
        return Http::get("https://www.emsifa.com/api-wilayah-indonesia/api/districts/{$kota_id}.json")->json();
    }
}
