<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kandang;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KandangController extends Controller
{
    public function index()
    {
        $kandangs = Kandang::with(['user', 'devices'])->get();
        return view('admin.kandang.index', compact('kandangs'));
    }

    public function create()
    {
        $users = User::all();
        return view('admin.kandang.create', compact('users'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'            => 'required|string|max:255',
            'code'            => 'required|string|unique:kandangs,code',
            'user_id'         => 'required|exists:users,id',
            'capacity'        => 'required|integer|min:0',
            'current_chicken' => 'required|integer|min:0',
            'timer_open'      => 'nullable',
            'timer_close'     => 'nullable',
            'image'           => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('kandang', 'public');
        }

        Kandang::create($data);

        return redirect()->route('admin.kandang.index')->with('success', 'Kandang berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $kandang = Kandang::findOrFail($id);
        $users = User::all();
        return view('admin.kandang.edit', compact('kandang', 'users'));
    }

    public function update(Request $request, $id)
    {
        $kandang = Kandang::findOrFail($id);

        $data = $request->validate([
            'name'            => 'required|string|max:255',
            'user_id'         => 'required|exists:users,id', 
            'capacity'        => 'required|integer|min:0',
            'current_chicken' => 'required|integer|min:0',
            'timer_open'      => 'nullable',
            'timer_close'     => 'nullable',
            'image'           => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($kandang->image) {
                Storage::disk('public')->delete($kandang->image);
            }
            $data['image'] = $request->file('image')->store('kandang', 'public');
        }

        $kandang->update($data);

        return redirect()->route('admin.kandang.index')->with('success', 'Data kandang berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $kandang = Kandang::findOrFail($id);

        if ($kandang->image) {
            Storage::disk('public')->delete($kandang->image);
        }

        $kandang->delete();
        return back()->with('success', 'Kandang berhasil dihapus!');
    }
}
