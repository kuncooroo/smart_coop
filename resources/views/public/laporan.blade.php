@extends('layouts.app')
@section('title', 'Laporan Data')

@section('content')
    {{-- Header Section --}}
    <div class="w-full mb-8 flex justify-between items-center">
        <div>
            <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight">Laporan & Arsip</h2>
            <p class="text-sm text-slate-400 font-medium mt-1">Ekspor data historis kandang ke format dokumen profesional.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Form Laporan --}}
        <div class="lg:col-span-2 bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
            <div class="bg-slate-50/50 border-b border-slate-100 px-8 py-5">
                <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Konfigurasi Laporan</h3>
            </div>
            
            <form action="{{ route('laporan.export') }}" method="GET" id="exportForm" class="p-8 space-y-6">
                <input type="hidden" name="type" id="exportType" value="excel">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Jenis Data</label>
                        <select name="category" class="w-full bg-slate-50 border border-slate-100 rounded-xl px-4 py-3 text-sm font-bold text-slate-700 focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all outline-none">
                            <option value="sensor">Statistik Sensor Terpadu</option>
                            <option value="population">Populasi Ayam</option>
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Pilih Kandang</label>
                        <select name="kandang_id" class="w-full bg-slate-50 border border-slate-100 rounded-xl px-4 py-3 text-sm font-bold text-slate-700 focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all outline-none">
                            <option value="all">Semua Kandang</option>
                            @foreach(\App\Models\Kandang::all() as $k)
                                <option value="{{ $k->id }}">{{ $k->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Tanggal Mulai</label>
                        <input type="date" name="start_date" required class="w-full bg-slate-50 border border-slate-100 rounded-xl px-4 py-3 text-sm font-bold text-slate-700 focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all outline-none">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Tanggal Selesai</label>
                        <input type="date" name="end_date" required class="w-full bg-slate-50 border border-slate-100 rounded-xl px-4 py-3 text-sm font-bold text-slate-700 focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all outline-none">
                    </div>
                </div>

                <div class="pt-4 flex flex-col sm:flex-row gap-4">
                    <button type="button" onclick="submitExport('excel')" 
                        class="flex-1 bg-emerald-500 hover:bg-emerald-600 text-white px-6 py-4 rounded-xl font-bold transition-all shadow-lg shadow-emerald-100 text-sm uppercase tracking-widest flex items-center justify-center">
                        <i class="fas fa-file-excel mr-2"></i> Export Excel
                    </button>
                    <button type="button" onclick="submitExport('pdf')" 
                        class="flex-1 bg-[#002855] hover:bg-orange-600 text-white px-6 py-4 rounded-xl font-bold transition-all shadow-lg shadow-blue-900/10 text-sm uppercase tracking-widest flex items-center justify-center">
                        <i class="fas fa-file-pdf mr-2"></i> Export PDF
                    </button>
                </div>
            </form>
        </div>

        {{-- Info Sidebar --}}
        <div class="space-y-6">
            <div class="bg-[#002855] rounded-[2rem] p-8 text-white relative overflow-hidden shadow-xl group">
                {{-- Decorative Icon --}}
                <i class="fas fa-archive absolute -right-4 -bottom-4 text-8xl text-white/10 group-hover:scale-110 transition-transform"></i>
                
                <div class="relative z-10">
                    <div class="w-12 h-12 bg-white/10 rounded-2xl flex items-center justify-center mb-6 border border-white/20">
                        <i class="fas fa-info-circle text-xl"></i>
                    </div>
                    <h4 class="text-lg font-bold mb-3">Penyimpanan Otomatis</h4>
                    <p class="text-blue-100/80 text-sm leading-relaxed">
                        Sistem mengarsipkan data setiap <span class="text-orange-400 font-bold">30 hari</span> secara otomatis. Pastikan Anda mengunduh laporan secara rutin untuk arsip fisik.
                    </p>
                </div>
            </div>
            
            <div class="bg-white border border-slate-100 rounded-[2rem] p-8 shadow-sm">
                <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4">Butuh Bantuan?</h4>
                <p class="text-sm text-slate-600 mb-4">Jika terjadi kendala saat mengekspor data dalam jumlah besar, hubungi administrator sistem.</p>
                <a href="#" class="text-sm font-bold text-orange-500 hover:text-orange-600 transition-colors">Buka Dokumentasi →</a>
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