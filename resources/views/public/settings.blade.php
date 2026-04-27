@extends('layouts.public')

@section('title', 'Pengaturan')
@section('header_title', 'Konfigurasi Sistem')

@section('content')

    <div class="max-w-4xl mx-auto space-y-6">
        <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100">
            <h3 class="text-lg font-bold text-slate-800 mb-6">Ambang Batas Suhu (Threshold)</h3>
            <form class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Suhu Minimum (°C)</label>
                        <input type="number"
                            class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-lg focus:ring-2 focus:ring-amber-500 outline-none"
                            value="25">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Suhu Maksimum (°C)</label>
                        <input type="number"
                            class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-lg focus:ring-2 focus:ring-amber-500 outline-none"
                            value="32">
                    </div>
                </div>
                <button
                    class="bg-amber-500 hover:bg-amber-600 text-white px-6 py-2 rounded-lg font-semibold transition">Simpan
                    Konfigurasi</button>
            </form>
        </div>
    </div>
@endsection
