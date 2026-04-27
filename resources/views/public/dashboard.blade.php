@extends('layouts.public')
@section('title', 'Dashboard Overview')

@section('content')
    <div class="w-full mb-10 flex justify-between items-center">
        <div>
            <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight mb-1">Dashboard Overview</h2>
            <p class="text-slate-500 text-sm font-medium">Monitoring sistem dan kondisi kandang secara real-time.</p>
        </div>
        <div class="flex items-center space-x-3">
            <span class="flex items-center gap-2 bg-emerald-50 text-emerald-600 px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest border border-emerald-100">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                </span>
                System Live
            </span>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        
        <div class="bg-white p-6 rounded-[2.5rem] shadow-sm border border-slate-100 flex items-center space-x-4 hover:border-blue-200 transition-all group">
            <div class="w-14 h-14 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-500 group-hover:scale-110 transition-transform">
                <i class="fas fa-thermometer-half text-2xl"></i>
            </div>
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Rerata Suhu</p>
                <h2 class="text-2xl font-black text-slate-800 tracking-tight">{{ number_format($avgTemperature, 1) }}°C</h2>
            </div>
        </div>

        <div class="bg-white p-6 rounded-[2.5rem] shadow-sm border border-slate-100 flex items-center space-x-4 hover:border-emerald-200 transition-all group">
            <div class="w-14 h-14 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-500 group-hover:scale-110 transition-transform">
                <i class="fas fa-microchip text-2xl"></i>
            </div>
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Device Online</p>
                <h2 class="text-2xl font-black text-slate-800 tracking-tight">
                    {{ $onlineDevicesCount }}<span class="text-sm text-slate-300 font-bold ml-1">/{{ $totalDevicesCount }}</span>
                </h2>
            </div>
        </div>

        <div class="bg-white p-6 rounded-[2.5rem] shadow-sm border border-slate-100 flex items-center space-x-4 hover:border-indigo-200 transition-all group">
            <div class="w-14 h-14 bg-indigo-50 rounded-2xl flex items-center justify-center text-indigo-500 group-hover:scale-110 transition-transform">
                <i class="fas fa-home text-2xl"></i>
            </div>
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Kandang Aktif</p>
                <h2 class="text-2xl font-black text-slate-800 tracking-tight">
                    {{ $activeKandangCount }}<span class="text-sm text-slate-300 font-bold ml-1">/{{ $totalKandangCount }}</span>
                </h2>
            </div>
        </div>

        <div class="bg-white p-6 rounded-[2.5rem] shadow-sm border border-slate-100 flex items-center space-x-4 hover:border-orange-200 transition-all group">
            <div class="w-14 h-14 {{ $anyDoorOpen ? 'bg-orange-50 text-orange-500' : 'bg-slate-900 text-white' }} rounded-2xl flex items-center justify-center transition-all group-hover:scale-110">
                <i class="fas {{ $anyDoorOpen ? 'fa-door-open' : 'fa-shield-alt' }} text-2xl"></i>
            </div>
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Pintu Terbuka</p>
                <h2 class="text-2xl font-black {{ $anyDoorOpen ? 'text-orange-500' : 'text-slate-800' }} tracking-tight">
                    {{ $openDoorsCount }}<span class="text-sm text-slate-300 font-bold ml-1">/{{ $totalDevicesCount }}</span>
                </h2>
            </div>
        </div>
    </div>

    <div class="w-full">
        <div class="bg-[#002855] p-10 rounded-[3rem] text-white relative overflow-hidden shadow-2xl shadow-blue-900/40">
            <i class="fas fa-chart-line absolute -right-10 -bottom-10 text-white/5 text-[15rem] -rotate-12 pointer-events-none"></i>
            <i class="fas fa-microchip absolute left-1/2 top-0 text-white/5 text-[10rem] -translate-x-1/2 -translate-y-1/2 pointer-events-none"></i>

            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-8">
                <div class="max-w-2xl">
                    <h4 class="text-2xl font-extrabold mb-3 tracking-tight">Analitik Cepat & Monitoring</h4>
                    <p class="text-blue-200/80 text-base leading-relaxed font-medium">
                        Dapatkan akses instan ke seluruh data sensor, pergerakan grafik suhu secara real-time, serta riwayat log aktivitas perangkat Anda. Pantau efisiensi hardware dari satu pintu kendali.
                    </p>
                </div>
                
                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('monitoring.index') }}" class="bg-white text-[#002855] px-8 py-4 rounded-2xl font-black text-xs uppercase tracking-[0.2em] hover:bg-orange-500 hover:text-white transition-all shadow-xl active:scale-95">
                        <i class="fas fa-tv mr-2"></i> Buka Monitoring
                    </a>
                    <a href="{{ route('activity_log') }}" class="bg-blue-800/40 text-white border border-blue-700/50 px-8 py-4 rounded-2xl font-black text-xs uppercase tracking-[0.2em] hover:bg-blue-700 transition-all active:scale-95">
                        <i class="fas fa-history mr-2"></i> Lihat Log
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection