@extends('layouts.admin')
@section('title', 'Admin Dashboard')

@section('content')
    <div class="w-full mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight">Dashboard Overview</h2>
            <p class="text-slate-500 text-sm mt-1">Monitoring sistem dan kondisi kandang secara real-time.</p>
        </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">

        <div
            class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100 flex items-center space-x-5 hover:border-rose-200 transition-all group">
            <div
                class="w-16 h-16 bg-rose-50 rounded-2xl flex items-center justify-center text-rose-500 group-hover:scale-110 group-hover:rotate-3 transition-transform duration-300">
                <i class="fas fa-user-shield text-3xl"></i>
            </div>
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1">Total Administrator</p>
                <h2 class="text-3xl font-black text-slate-800 tracking-tight">
                    {{ \App\Models\Admin::count() }}
                    <span class="text-sm text-slate-300 font-bold ml-1 uppercase">Akun</span>
                </h2>
            </div>
        </div>

        <div
            class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100 flex items-center space-x-5 hover:border-indigo-200 transition-all group">
            <div
                class="w-16 h-16 bg-indigo-50 rounded-2xl flex items-center justify-center text-indigo-500 group-hover:scale-110 group-hover:-rotate-3 transition-transform duration-300">
                <i class="fas fa-crown text-3xl"></i>
            </div>
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1">Super Admin</p>
                <h2 class="text-3xl font-black text-slate-800 tracking-tight">
                    {{ \App\Models\Admin::where('role', 'superadmin')->count() }}
                    <span class="text-sm text-slate-300 font-bold ml-1 uppercase">Akses</span>
                </h2>
            </div>
        </div>
    </div>

    <div class="w-full">
        <h3 class="text-xl font-black text-slate-800 tracking-tight mb-6">Quick Management</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <a href="{{ route('admin.user.index') }}"
                class="bg-white p-6 rounded-[2rem] border border-slate-100 flex items-center justify-between hover:bg-rose-600 group transition-all duration-300">
                <div class="flex items-center space-x-4">
                    <div
                        class="w-12 h-12 bg-slate-50 rounded-xl flex items-center justify-center text-slate-400 group-hover:bg-white/20 group-hover:text-white transition-colors">
                        <i class="fas fa-users-cog"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-800 group-hover:text-white transition-colors">Kelola Pengguna</h4>
                        <p class="text-xs text-slate-400 group-hover:text-rose-100 transition-colors">Manajemen akses user
                            publik.</p>
                    </div>
                </div>
                <i
                    class="fas fa-chevron-right text-slate-200 group-hover:text-white group-hover:translate-x-2 transition-all"></i>
            </a>

            <a href="{{ route('admin.device.index') }}"
                class="bg-white p-6 rounded-[2rem] border border-slate-100 flex items-center justify-between hover:bg-indigo-600 group transition-all duration-300">
                <div class="flex items-center space-x-4">
                    <div
                        class="w-12 h-12 bg-slate-50 rounded-xl flex items-center justify-center text-slate-400 group-hover:bg-white/20 group-hover:text-white transition-colors">
                        <i class="fas fa-microchip"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-800 group-hover:text-white transition-colors">Master Device</h4>
                        <p class="text-xs text-slate-400 group-hover:text-indigo-100 transition-colors">Konfigurasi hardware
                            sistem.</p>
                    </div>
                </div>
                <i
                    class="fas fa-chevron-right text-slate-200 group-hover:text-white group-hover:translate-x-2 transition-all"></i>
            </a>

        </div>
    </div>
@endsection
