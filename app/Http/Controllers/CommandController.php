<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CommandController extends Controller
{
    public function store(Request $request)
{
    try {
        return back()->with('success', 'Perintah ' . $request->command . ' berhasil dikirim ke ' . $request->device_id);
    } catch (\Exception $e) {
        return back()->with('error', 'Gagal kirim perintah: ' . $e->getMessage());
    }
}
}
