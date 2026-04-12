@extends('layouts.app')
@section('title', 'Laporan Data')

@section('content')

<div class="mb-10">
<h2 class="text-3xl font-bold text-slate-900 mb-2">Laporan & Arsip</h2>
<p class="text-slate-500">Ekspor data historis kandang ke dalam format dokumen profesional.</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
<!-- Form Export -->
<div class="lg:col-span-2 bg-white rounded-[2.5rem] shadow-sm border border-slate-100 p-10">
<div class="mb-8">
<h3 class="text-xl font-bold text-slate-800 mb-2">Konfigurasi Laporan</h3>
<p class="text-sm text-slate-400">Pilih rentang waktu dan parameter data untuk diunduh.</p>
</div>

    <form action="#" method="GET" class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-2">
                <label class="text-xs font-bold text-slate-400 uppercase tracking-wider ml-1">Jenis Data</label>
                <select class="w-full bg-slate-50 border-none rounded-2xl p-4 text-sm font-medium text-slate-700 focus:ring-2 focus:ring-slate-900 transition">
                    <option>Statistik Sensor Terpadu</option>
                    <option>Populasi Ayam (Masuk/Keluar)</option>
                    <option>Log Aktivitas Perangkat</option>
                    <option>Laporan Performa Kandang</option>
                </select>
            </div>
            <div class="space-y-2">
                <label class="text-xs font-bold text-slate-400 uppercase tracking-wider ml-1">Pilih Kandang</label>
                <select class="w-full bg-slate-50 border-none rounded-2xl p-4 text-sm font-medium text-slate-700 focus:ring-2 focus:ring-slate-900 transition">
                    <option value="all">Semua Kandang</option>
                    @foreach(\App\Models\Kandang::all() as $k)
                        <option value="{{ $k->id }}">{{ $k->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-2">
                <label class="text-xs font-bold text-slate-400 uppercase tracking-wider ml-1">Tanggal Mulai</label>
                <input type="date" class="w-full bg-slate-50 border-none rounded-2xl p-4 text-sm font-medium text-slate-700 focus:ring-2 focus:ring-slate-900 transition">
            </div>
            <div class="space-y-2">
                <label class="text-xs font-bold text-slate-400 uppercase tracking-wider ml-1">Tanggal Selesai</label>
                <input type="date" class="w-full bg-slate-50 border-none rounded-2xl p-4 text-sm font-medium text-slate-700 focus:ring-2 focus:ring-slate-900 transition">
            </div>
        </div>

        <div class="pt-6 flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-4">
            <button type="button" class="flex-1 bg-emerald-500 hover:bg-emerald-600 text-white font-bold py-4 rounded-2xl transition flex items-center justify-center shadow-lg shadow-emerald-100">
                <i class="fas fa-file-excel mr-2"></i> Export Excel
            </button>
            <button type="button" class="flex-1 bg-slate-900 hover:bg-slate-800 text-white font-bold py-4 rounded-2xl transition flex items-center justify-center shadow-lg shadow-slate-200">
                <i class="fas fa-file-pdf mr-2"></i> Export PDF
            </button>
        </div>
    </form>
</div>

<!-- Info Box -->
<div class="space-y-6">
    <div class="bg-blue-600 rounded-[2.5rem] p-8 text-white relative overflow-hidden shadow-xl">
        <i class="fas fa-cloud-download-alt absolute -right-4 -bottom-4 text-white/10 text-9xl"></i>
        <h4 class="text-lg font-bold mb-4 relative z-10">Penyimpanan Otomatis</h4>
        <p class="text-blue-100 text-sm leading-relaxed relative z-10 mb-6">
            Sistem secara otomatis mengarsipkan data setiap 30 hari untuk menjaga performa database. Pastikan Anda mengunduh laporan bulanan secara rutin.
        </p>
        <div class="relative z-10">
            <span class="text-[10px] font-bold uppercase bg-blue-500 px-3 py-1 rounded-full">Cloud Sync Active</span>
        </div>
    </div>

    <div class="bg-white rounded-[2.5rem] border border-slate-100 p-8 shadow-sm">
        <h4 class="font-bold text-slate-800 mb-4">Riwayat Unduhan</h4>
        <div class="space-y-4">
            <div class="flex items-center justify-between p-3 hover:bg-slate-50 rounded-xl transition cursor-pointer">
                <div class="flex items-center space-x-3">
                    <div class="text-emerald-500 bg-emerald-50 w-8 h-8 rounded-lg flex items-center justify-center text-xs">
                        <i class="fas fa-file-excel"></i>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-700">Laporan_Januari.xlsx</p>
                        <p class="text-[9px] text-slate-400">2 menit yang lalu</p>
                    </div>
                </div>
                <i class="fas fa-chevron-right text-slate-300 text-[10px]"></i>
            </div>
            <!-- ... item lainnya ... -->
        </div>
    </div>
</div>


</div>
@endsection