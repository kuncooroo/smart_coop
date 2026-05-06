<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

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
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6'
        ]);

        $data['password'] = bcrypt($data['password']);

        User::create($data);

        return redirect()->route('admin.user.index')->with('success', 'User berhasil dibuat');
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
            'nama_lengkap' => 'required',
            'username'     => 'required|unique:users,username,' . $id,
            'email'        => 'required|email|unique:users,email,' . $id,
            'no_hp'        => 'nullable',
            'jenis_kelamin' => 'nullable|in:L,P',
            'alamat_lengkap' => 'nullable',
            'profile'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $user->update($data);
        return redirect()->route('admin.user.index')->with('success', 'User diupdate');
    }

    public function destroy($id)
    {
        User::destroy($id);
        return back()->with('success', 'User dihapus');
    }
}
