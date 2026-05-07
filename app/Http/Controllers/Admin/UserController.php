<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->get();
        return view('Admin.user.index', compact('users'));
    }

    public function create()
    {
        return view('Admin.user.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_lengkap'   => 'required|string|max:255',
            'username'       => 'required|unique:users,username',
            'email'          => 'required|email|unique:users,email',
            'password'       => 'required|min:6',
            'no_hp'          => 'nullable',
            'jenis_kelamin'  => 'nullable|in:L,P',
            'alamat_lengkap' => 'nullable',
            'profile'        => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $user = new User();
        $user->nama_lengkap   = $data['nama_lengkap'];
        $user->username       = $data['username'];
        $user->email          = $data['email'];
        $user->password       = bcrypt($data['password']);
        $user->no_hp          = $data['no_hp'] ?? null;
        $user->jenis_kelamin  = $data['jenis_kelamin'] ?? null;
        $user->alamat_lengkap = $data['alamat_lengkap'] ?? null;

        if ($request->hasFile('profile')) {
            $path = $request->file('profile')->store('profiles', 'public');
            $user->profile = $path;
        }

        $user->save();

        return redirect()->route('admin.user.index')->with('success', 'Pengguna baru berhasil didaftarkan');
    }
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('Admin.user.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $data = $request->validate([
            'nama_lengkap'   => 'required|string|max:255',
            'username'       => 'required|unique:users,username,' . $id,
            'email'          => 'required|email|unique:users,email,' . $id,
            'no_hp'          => 'nullable',
            'jenis_kelamin'  => 'nullable|in:L,P',
            'alamat_lengkap' => 'nullable',
            'profile'        => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        if ($request->remove_profile == "1") {
            if ($user->profile && Storage::disk('public')->exists($user->profile)) {
                Storage::disk('public')->delete($user->profile);
                $user->profile = null; 
            }
        }

        $user->nama_lengkap   = $data['nama_lengkap'];
        $user->username       = $data['username'];
        $user->email          = $data['email'];
        $user->no_hp          = $data['no_hp'] ?? null;
        $user->jenis_kelamin  = $data['jenis_kelamin'] ?? null;
        $user->alamat_lengkap = $data['alamat_lengkap'] ?? null;

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        if ($request->hasFile('profile')) {
            if ($user->profile && Storage::disk('public')->exists($user->profile)) {
                Storage::disk('public')->delete($user->profile);
            }

            $path = $request->file('profile')->store('profiles', 'public');
            $user->profile = $path;
        }

        $user->save();

        return redirect()->route('admin.user.index')->with('success', 'Data pengguna berhasil diperbarui');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->profile && Storage::disk('public')->exists($user->profile)) {
            Storage::disk('public')->delete($user->profile);
        }

        $user->delete();
        return back()->with('success', 'User dan data profil berhasil dihapus');
    }
}
