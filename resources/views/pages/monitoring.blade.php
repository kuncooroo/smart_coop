@extends('layouts.app')
@section('title', 'Monitoring Real-time')

@section('content')

<div class="mb-10">
<h2 class="text-3xl font-bold text-slate-900 mb-2">Monitoring Real-time</h2>
<p class="text-slate-500">Kontrol pintu dan pencahayaan setiap kandang secara individual berdasarkan data sensor terbaru.</p>
</div>

<!-- Grid Monitoring -->

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
@forelse($kandangs as $k)
@php
// Mengambil data sensor terbaru untuk kandang ini melalui relasi hasMany
$latestSensor = $k->sensorData->sortByDesc('created_at')->first();
// Mengambil device actuator (pintu/lampu) melalui relasi hasMany
$actuator = $k->devices->where('device_type', 'actuator')->first();
// Mengambil setting timer melalui relasi hasOne
$setting = $k->setting;
@endphp

    <div class="bg-white rounded-[2.5rem] shadow-sm overflow-hidden border border-slate-100 group hover:shadow-xl transition-all duration-300">
        <!-- Image Header -->
        <div class="h-48 relative overflow-hidden">
            <img src="{{ $k->image ?? 'https://images.unsplash.com/photo-1548550023-2bdb3c5beed7?auto=format&fit=crop&q=80&w=400' }}" 
                 class="w-full h-full object-cover grayscale-[0.2] group-hover:scale-110 transition-transform duration-700" 
                 alt="{{ $k->name }}">
            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent flex flex-col justify-end p-6">
                <h4 class="text-white font-bold text-xl">{{ $k->name }}</h4>
                <p class="text-slate-300 text-xs font-mono uppercase tracking-widest">{{ $k->code }}</p>
            </div>
        </div>

        <!-- Card Content -->
        <div class="p-6 space-y-4">
            <!-- Stats Row -->
            <div class="flex gap-4">
                <div class="flex-1 bg-slate-50 p-4 rounded-2xl">
                    <p class="text-[10px] font-bold text-slate-400 uppercase mb-1">Populasi</p>
                    <div class="flex items-center space-x-2">
                        <i class="fas fa-kiwi-bird text-orange-400 text-xs"></i>
                        <span class="text-lg font-bold text-slate-800">{{ $k->capacity }}</span>
                    </div>
                </div>
                <div class="flex-1 bg-slate-50 p-4 rounded-2xl">
                    <p class="text-[10px] font-bold text-slate-400 uppercase mb-1">Suhu</p>
                    <div class="flex items-center space-x-2">
                        <i class="fas fa-thermometer-half text-red-400 text-xs"></i>
                        <span class="text-lg font-bold text-slate-800">{{ $latestSensor->temperature ?? '0' }}°C</span>
                    </div>
                </div>
            </div>

            <!-- Door Status -->
            <div class="p-4 rounded-2xl flex items-center justify-between {{ ($actuator && $actuator->door_status == 'TERBUKA') ? 'bg-emerald-500 text-white' : 'bg-[#121927] text-white' }}">
                <div class="flex items-center space-x-3">
                    <i class="fas {{ ($actuator && $actuator->door_status == 'TERBUKA') ? 'fa-door-open' : 'fa-door-closed' }}"></i>
                    <div>
                        <p class="text-[8px] uppercase font-bold opacity-70">Status Pintu</p>
                        <p class="font-bold tracking-wider">{{ $actuator->door_status ?? 'OFFLINE' }}</p>
                    </div>
                </div>
                @if($actuator)
                <form action="{{ route('commands.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="device_id" value="{{ $actuator->id }}">
                    <input type="hidden" name="command" value="{{ $actuator->door_status == 'TERBUKA' ? 'CLOSE_DOOR' : 'OPEN_DOOR' }}">
                    <button type="submit" class="bg-white/20 hover:bg-white/30 px-3 py-1 rounded-lg text-[10px] font-bold uppercase transition">Ubah</button>
                </form>
                @endif
            </div>

            <!-- Light/Heater Control -->
            <div class="p-4 rounded-2xl bg-slate-50 flex items-center justify-between {{ ($actuator && $actuator->light_status == 'HIDUP') ? 'ring-2 ring-orange-400 bg-orange-50' : '' }}">
                <div class="flex items-center space-x-3">
                    <i class="fas fa-lightbulb {{ ($actuator && $actuator->light_status == 'HIDUP') ? 'text-orange-500' : 'text-slate-400' }}"></i>
                    <div>
                        <p class="text-[8px] uppercase font-bold text-slate-400">Lampu Pemanas</p>
                        <p class="font-bold text-slate-800 tracking-wider">{{ $actuator->light_status ?? 'OFFLINE' }}</p>
                    </div>
                </div>
                @if($actuator)
                <form action="{{ route('commands.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="device_id" value="{{ $actuator->id }}">
                    <input type="hidden" name="command" value="{{ $actuator->light_status == 'HIDUP' ? 'LIGHT_OFF' : 'LIGHT_ON' }}">
                    <button type="submit" class="w-10 h-5 flex items-center {{ $actuator->light_status == 'HIDUP' ? 'bg-orange-500 justify-end' : 'bg-slate-300' }} rounded-full p-1 cursor-pointer transition-all">
                        <div class="bg-white w-3 h-3 rounded-full shadow-sm"></div>
                    </button>
                </form>
                @endif
            </div>

            <!-- Timer -->
            <div class="p-4 rounded-2xl bg-slate-50 flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <i class="far fa-clock text-orange-400"></i>
                    <div>
                        <p class="text-[8px] uppercase font-bold text-slate-400">Timer Otomatis</p>
                        <p class="font-bold text-slate-800">
                            {{ $setting ? \Carbon\Carbon::parse($setting->timer_open)->format('H:i') : '00:00' }} - 
                            {{ $setting ? \Carbon\Carbon::parse($setting->timer_close)->format('H:i') : '00:00' }}
                        </p>
                    </div>
                </div>
                {{-- <a href="{{ route('kandangs.settings', $k->id) }}" class="p-2 text-slate-400 hover:text-slate-600"> --}}
                    <i class="fas fa-cog"></i>
                </a>
            </div>
        </div>
    </div>
@empty
    <!-- Tampilan jika database kandangs kosong -->
    <div class="col-span-full bg-white p-12 rounded-[2.5rem] border border-dashed border-slate-200 text-center">
        <div class="flex flex-col items-center opacity-40">
            <i class="fas fa-house-damage text-5xl mb-4"></i>
            <h3 class="text-xl font-bold">Belum Ada Kandang</h3>
            <p>Silakan tambahkan data kandang di menu Master Data.</p>
        </div>
    </div>
@endforelse


</div>

<div class="grid grid-cols-1 xl:grid-cols-2 gap-8">
<div class="bg-white rounded-[2rem] shadow-sm p-8 border border-slate-100">
<h3 class="text-xl font-bold text-slate-800 mb-6">Grafik Suhu & Deteksi Ayam</h3>
<div class="h-72 flex items-center justify-center bg-slate-50 rounded-2xl border border-dashed">
<p class="text-slate-400">[ Grafik akan muncul saat ada data sensor ]</p>
</div>
</div>

<!-- Table History -->
<div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
    <div class="px-8 py-6 border-b border-slate-50 flex justify-between items-center">
        <h3 class="text-xl font-bold text-slate-800">Riwayat Sensor Terkini</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="text-slate-400 text-[11px] font-bold uppercase tracking-wider border-b border-slate-50">
                    <th class="px-8 py-4">Waktu</th>
                    <th class="px-4 py-4">Kandang</th>
                    <th class="px-4 py-4">Suhu</th>
                    <th class="px-4 py-4">Deteksi</th>
                    <th class="px-4 py-4">Masuk/Keluar</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($allSensorData ?? [] as $data)
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-8 py-4 text-sm font-medium text-slate-600">{{ $data->created_at->format('H:i:s') }}</td>
                    <td class="px-4 py-4 text-sm text-slate-600">{{ $data->kandang->name ?? '-' }}</td>
                    <td class="px-4 py-4 text-sm font-bold text-slate-800">{{ $data->temperature }}°C</td>
                    <td class="px-4 py-4">
                        <span class="px-3 py-1 text-[10px] font-bold rounded-full {{ $data->chicken_detected ? 'bg-emerald-50 text-emerald-600' : 'bg-slate-100 text-slate-500' }}">
                            {{ $data->chicken_detected ? 'ADA' : 'TIDAK' }}
                        </span>
                    </td>
                    <td class="px-4 py-4 text-sm">
                        <span class="text-emerald-600 font-bold">+{{ $data->chicken_in }}</span> / <span class="text-red-500 font-bold">-{{ $data->chicken_out }}</span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-8 py-10 text-center opacity-30">Data sensor kosong.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>


</div>
@endsection