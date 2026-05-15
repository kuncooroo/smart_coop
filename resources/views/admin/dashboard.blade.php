@extends('layouts.admin')
@section('title', 'Super Admin Dashboard')

@section('content')
    <div class="w-full mb-10 flex justify-between items-center">
        <div>
            <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight mb-1">Super Admin Panel</h2>
            <p class="text-slate-500 text-sm font-medium">Ringkasan ekosistem sistem IoT dan manajemen akun.</p>
        </div>
        <div class="hidden md:flex items-center space-x-2 bg-indigo-50 px-4 py-2 rounded-xl border border-indigo-100">
            <div class="w-2 h-2 bg-indigo-500 rounded-full animate-pulse"></div>
            <span class="text-indigo-700 text-[10px] font-black uppercase tracking-widest">Sistem Aktif</span>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
        <div
            class="bg-white p-6 rounded-[2.5rem] shadow-sm border border-slate-100 flex items-center space-x-4 hover:border-blue-200 transition-all group">
            <div
                class="w-14 h-14 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-500 group-hover:scale-110 transition-transform">
                <i class="fas fa-users text-2xl"></i>
            </div>
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">User Publik</p>
                <h2 class="text-2xl font-black text-slate-800 tracking-tight">{{ $totalUser }}</h2>
            </div>
        </div>

        <div
            class="bg-white p-6 rounded-[2.5rem] shadow-sm border border-slate-100 flex items-center space-x-4 hover:border-emerald-200 transition-all group">
            <div
                class="w-14 h-14 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-500 group-hover:scale-110 transition-transform">
                <i class="fas fa-microchip text-2xl"></i>
            </div>
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Perangkat</p>
                <h2 class="text-2xl font-black text-slate-800 tracking-tight">
                    {{ $deviceOnline }}<span class="text-sm text-slate-300 font-bold ml-1">/{{ $totalDevice }}</span>
                </h2>
            </div>
        </div>

        <div
            class="bg-white p-6 rounded-[2.5rem] shadow-sm border border-slate-100 flex items-center space-x-4 hover:border-rose-200 transition-all group">
            <div
                class="w-14 h-14 bg-rose-50 rounded-2xl flex items-center justify-center text-rose-500 group-hover:scale-110 transition-transform">
                <i class="fas fa-user-shield text-2xl"></i>
            </div>
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Staff Admin</p>
                <h2 class="text-2xl font-black text-slate-800 tracking-tight">{{ $totalAdmin }}</h2>
            </div>
        </div>

        <div
            class="bg-white p-6 rounded-[2.5rem] shadow-sm border border-slate-100 flex items-center space-x-4 hover:border-amber-200 transition-all group">
            <div
                class="w-14 h-14 bg-amber-50 rounded-2xl flex items-center justify-center text-amber-500 group-hover:scale-110 transition-transform">
                <i class="fas fa-crown text-2xl"></i>
            </div>
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">SuperAdmin</p>
                <h2 class="text-2xl font-black text-slate-800 tracking-tight">{{ $totalSuperAdmin }}</h2>
            </div>
        </div>
    </div>

    <div class="w-full mb-12">
        <div class="mb-6">
            <h3 class="text-2xl font-black text-slate-800 tracking-tight">Manajemen Kontrol</h3>
            <p class="text-slate-500 text-sm font-medium">Kelola seluruh entitas di dalam ekosistem.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div
                class="bg-[#002855] p-8 rounded-[2.5rem] text-white flex items-center justify-between group overflow-hidden relative shadow-lg shadow-blue-900/20">
                <i
                    class="fas fa-users-cog absolute -right-4 -bottom-4 text-white/5 text-8xl -rotate-12 pointer-events-none"></i>
                <div class="relative z-10">
                    <h4 class="text-lg font-bold mb-1">Database Pengguna</h4>
                    <p class="text-blue-200/70 text-xs">Atur akun dan pantau login pengguna.</p>
                </div>
                <a href="{{ route('admin.user.index') }}"
                    class="relative z-50 cursor-pointer bg-white text-[#002855] px-6 py-3 rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-orange-500 hover:text-white transition-all shadow-xl">
                    Kelola User
                </a>
            </div>

            <div
                class="bg-slate-900 p-8 rounded-[2.5rem] text-white flex items-center justify-between group overflow-hidden relative shadow-lg shadow-slate-900/20">
                <i
                    class="fas fa-microchip absolute -right-4 -bottom-4 text-white/5 text-8xl -rotate-12 pointer-events-none"></i>
                <div class="relative z-10">
                    <h4 class="text-lg font-bold mb-1">Pusat Kendali Device</h4>
                    <p class="text-slate-400 text-xs">Monitoring status dan kesehatan sensor.</p>
                </div>
                <a href="{{ route('admin.device.index') }}"
                    class="relative z-50 cursor-pointer bg-white/10 border border-white/20 text-white px-6 py-3 rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-white hover:text-slate-900 transition-all">
                    Buka Device
                </a>
            </div>
        </div>
    </div>
@endsection
