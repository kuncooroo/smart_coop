<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kandang;
use App\Models\User;
use Illuminate\Http\Request;

class KandangController extends Controller
{
    public function index()
    {
        $kandangs = Kandang::with('user')->get();
        return view('Admin.kandang.index', compact('kandangs'));
    }

    public function create()
    {
        $users = User::all();
        return view('Admin.kandang.create', compact('users'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'user_id' => 'required'
        ]);

        Kandang::create($data);

        return redirect()->route('admin.kandang.index');
    }

    public function edit($id)
    {
        $kandang = Kandang::findOrFail($id);
        $users = User::all();

        return view('Admin.kandang.edit', compact('kandang', 'users'));
    }

    public function update(Request $request, $id)
    {
        $kandang = Kandang::findOrFail($id);

        $kandang->update($request->all());

        return redirect()->route('admin.kandang.index');
    }

    public function destroy($id)
    {
        Kandang::destroy($id);
        return back();
    }
}
