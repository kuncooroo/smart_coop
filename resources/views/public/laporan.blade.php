@extends('layouts.app')
@section('title', 'Laporan Data')

@section('content')
<div class="mb-10">
    <h2 class="text-3xl font-bold text-slate-900 mb-2">Laporan & Arsip</h2>
    <p class="text-slate-500">Ekspor data historis kandang ke dalam format dokumen profesional.</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <div class="lg:col-span-2 bg-white rounded-[2.5rem] shadow-sm border border-slate-100 p-10">
        <h3 class="text-xl font-bold text-slate-800 mb-6">Konfigurasi Laporan</h3>

        <form action="{{ route('laporan.export') }}" method="GET" id="exportForm" class="space-y-6">
            <input type="hidden" name="type" id="exportType" value="excel">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="text-xs font-bold text-slate-400 uppercase tracking-wider ml-1">Jenis Data</label>
                    <select name="category" class="w-full bg-slate-50 border-none rounded-2xl p-4 text-sm font-medium text-slate-700">
                        <option value="sensor">Statistik Sensor Terpadu</option>
                        <option value="population">Populasi Ayam</option>
                    </select>
                </div>
                <div class="space-y-2">
                    <label class="text-xs font-bold text-slate-400 uppercase tracking-wider ml-1">Pilih Kandang</label>
                    <select name="kandang_id" class="w-full bg-slate-50 border-none rounded-2xl p-4 text-sm font-medium text-slate-700">
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
                    <input type="date" name="start_date" required class="w-full bg-slate-50 border-none rounded-2xl p-4 text-sm font-medium text-slate-700">
                </div>
                <div class="space-y-2">
                    <label class="text-xs font-bold text-slate-400 uppercase tracking-wider ml-1">Tanggal Selesai</label>
                    <input type="date" name="end_date" required class="w-full bg-slate-50 border-none rounded-2xl p-4 text-sm font-medium text-slate-700">
                </div>
            </div>

            <div class="pt-6 flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-4">
                <button type="button" onclick="submitExport('excel')" class="flex-1 bg-emerald-500 hover:bg-emerald-600 text-white font-bold py-4 rounded-2xl transition flex items-center justify-center shadow-lg shadow-emerald-100">
                    <i class="fas fa-file-excel mr-2"></i> Export Excel
                </button>
                <button type="button" onclick="submitExport('pdf')" class="flex-1 bg-slate-900 hover:bg-slate-800 text-white font-bold py-4 rounded-2xl transition flex items-center justify-center shadow-lg shadow-slate-200">
                    <i class="fas fa-file-pdf mr-2"></i> Export PDF
                </button>
            </div>
        </form>
    </div>

    <div class="space-y-6">
        <div class="bg-blue-600 rounded-[2.5rem] p-8 text-white relative overflow-hidden shadow-xl">
            <h4 class="text-lg font-bold mb-4">Penyimpanan Otomatis</h4>
            <p class="text-blue-100 text-sm mb-6">Sistem mengarsipkan data setiap 30 hari. Pastikan Anda mengunduh laporan secara rutin.</p>
        </div>
    </div>
</div>

<script>
    function submitExport(format) {
        document.getElementById('exportType').value = format;
        document.getElementById('exportForm').submit();
    }
</script>
@endsection