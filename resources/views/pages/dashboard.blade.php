@extends('layouts.app')
@section('title', 'Dashboard Overview')

@section('content')

    <div class="mb-10">
        <h2 class="text-3xl font-bold text-slate-900 mb-2">Dashboard Overview</h2>
        <p class="text-slate-500">Ringkasan kondisi seluruh kandang hari ini secara real-time.</p>
    </div>

    <!-- Stats Grid -->

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
        <!-- Suhu Card -->
        <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100 flex items-center space-x-4">
            <div class="w-14 h-14 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-500">
                <i class="fas fa-thermometer-half text-2xl"></i>
            </div>
            <div>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Suhu Terbaru</p>
                <h2 class="text-2xl font-bold text-slate-800">{{ $latestSensor->temperature ?? '0' }}°C</h2>
            </div>
        </div>

        <!-- Ayam Masuk -->
        <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100 flex items-center space-x-4">
            <div class="w-14 h-14 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-500">
                <i class="fas fa-arrow-down text-2xl"></i>
            </div>
            <div>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Ayam Masuk (Hari Ini)</p>
                <h2 class="text-2xl font-bold text-slate-800">{{ $totalIn }} <span
                        class="text-sm font-normal text-slate-400">Ekor</span></h2>
            </div>
        </div>

        <!-- Ayam Keluar -->
        <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100 flex items-center space-x-4">
            <div class="w-14 h-14 bg-red-50 rounded-2xl flex items-center justify-center text-red-500">
                <i class="fas fa-arrow-up text-2xl"></i>
            </div>
            <div>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Ayam Keluar (Hari Ini)</p>
                <h2 class="text-2xl font-bold text-slate-800">{{ $totalOut }} <span
                        class="text-sm font-normal text-slate-400">Ekor</span></h2>
            </div>
        </div>

        <!-- Status Pintu -->
        <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100 flex items-center space-x-4">
            <div
                class="w-14 h-14 {{ $anyDoorOpen ? 'bg-orange-50 text-orange-500' : 'bg-slate-900 text-white' }} rounded-2xl flex items-center justify-center transition-colors">
                <i class="fas {{ $anyDoorOpen ? 'fa-door-open' : 'fa-door-closed' }} text-2xl"></i>
            </div>
            <div>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Sistem Pintu</p>
                <h2 class="text-2xl font-bold text-slate-800 uppercase text-sm tracking-tight">
                    {{ $anyDoorOpen ? 'Ada Terbuka' : 'Semua Tertutup' }}
                </h2>
            </div>
        </div>


    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Aktivitas Table -->
        <div class="lg:col-span-2 bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
            <div class="px-8 py-6 border-b border-slate-50 flex justify-between items-center bg-white">
                <h3 class="text-xl font-bold text-slate-800">Aktivitas Terbaru</h3>
                <a href="{{ route('activity_log') }}" class="text-blue-500 text-xs font-bold hover:underline">Lihat
                    Semua</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="text-slate-400 text-[11px] font-bold uppercase tracking-wider border-b border-slate-50">
                            <th class="px-8 py-4">Waktu</th>
                            <th class="px-4 py-4">Kandang</th>
                            <th class="px-4 py-4">Aksi</th>
                            <th class="px-8 py-4 text-right">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($recentActivities as $log)
                            <tr class="hover:bg-slate-50/50 transition group">
                                <td class="px-8 py-4">
                                    <p class="text-sm font-medium text-slate-600">{{ $log->created_at->format('H:i') }}</p>
                                    <p class="text-[10px] text-slate-400">{{ $log->created_at->format('d M') }}</p>
                                </td>
                                <td class="px-4 py-4">
                                    <span
                                        class="text-sm font-bold text-slate-700">{{ $log->kandang->name ?? 'System' }}</span>
                                </td>
                                <td class="px-4 py-4 text-sm text-slate-500">
                                    {{ $log->action }}
                                </td>
                                <td class="px-8 py-4 text-right">
                                    @php
                                        $statusClasses = [
                                            'success' => 'bg-emerald-50 text-emerald-600',
                                            'danger' => 'bg-red-50 text-red-600',
                                            'warning' => 'bg-orange-50 text-orange-600',
                                            'info' => 'bg-blue-50 text-blue-600',
                                        ];
                                        $class = $statusClasses[$log->status] ?? 'bg-slate-100 text-slate-600';
                                    @endphp
                                    <span
                                        class="px-3 py-1 text-[10px] font-bold rounded-full uppercase {{ $class }}">
                                        {{ $log->status }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-8 py-10 text-center text-slate-400 italic">Belum ada aktivitas
                                    tercatat.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Quick Info / Tip -->
        <div class="space-y-6">
            <div class="bg-slate-900 rounded-[2.5rem] p-8 text-white relative overflow-hidden shadow-xl">
                <i class="fas fa-lightbulb absolute -right-4 -top-4 text-white/10 text-9xl rotate-12"></i>
                <h4 class="text-xl font-bold mb-4 relative z-10">Smart Tip</h4>
                <p class="text-slate-400 text-sm leading-relaxed relative z-10">
                    Suhu ideal untuk kandang ayam berkisar antara <span class="text-orange-400 font-bold">28°C -
                        32°C</span>.
                    Jika suhu melewati batas, pastikan sistem pemanas otomatis bekerja atau buka pintu ventilasi.
                </p>
                <div class="mt-8 relative z-10">
                    <a href="{{ route('monitoring') }}"
                        class="inline-block bg-white text-slate-900 px-6 py-3 rounded-2xl font-bold text-sm hover:bg-slate-100 transition">
                        Cek Monitoring
                    </a>
                </div>
            </div>

            <div class="bg-white rounded-[2.5rem] border border-slate-100 p-8 shadow-sm">
                <h4 class="font-bold text-slate-800 mb-4">Ringkasan Sistem</h4>
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-slate-500">Kandang Aktif</span>
                        <span class="font-bold text-slate-800">{{ \App\Models\Kandang::count() }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-slate-500">Total Perangkat</span>
                        <span class="font-bold text-slate-800">{{ \App\Models\Device::count() }}</span>
                    </div>
                </div>
            </div>
        </div>


    </div>
@endsection
