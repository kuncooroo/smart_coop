<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function index()
    {
        $admins = Admin::latest()->get();
        return view('admin.admin.index', compact('admins'));
    }

    public function create()
    {
        return view('admin.admin.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:admins',
            'password' => 'required|min:6',
            'role' => 'required',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $avatar = null;

        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar')->store('avatars', 'public');
        }

        Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'phone' => $request->phone,
            'avatar' => $avatar,
        ]);

        return redirect()->route('admin.admin.index')
            ->with('success', 'Admin berhasil ditambahkan');
    }

    public function edit($id)
    {
        $admin = Admin::findOrFail($id);
        return view('admin.admin.edit', compact('admin'));
    }

    public function update(Request $request, $id)
    {
        $admin = Admin::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'email' => "required|email|unique:admins,email,$id",
            'role' => 'required',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        if ($request->remove_avatar == "1") {
            if ($admin->avatar && Storage::disk('public')->exists($admin->avatar)) {
                Storage::disk('public')->delete($admin->avatar);

                $admin->avatar = null;
                $admin->save();
            }
        }

        $admin->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ]);

        if ($request->password) {
            $admin->update([
                'password' => Hash::make($request->password)
            ]);
        }

        if ($request->hasFile('avatar')) {

            if ($admin->avatar && Storage::disk('public')->exists($admin->avatar)) {
                Storage::disk('public')->delete($admin->avatar);
            }

            $path = $request->file('avatar')->store('avatars', 'public');

            $admin->avatar = $path;
            $admin->save();
        }

        return redirect()->route('admin.admin.index')->with('success', 'Admin berhasil diupdate');
    }

    public function destroy($id)
    {
        Admin::findOrFail($id)->delete();
        return back()->with('success', 'Admin berhasil dihapus');
    }
}
