@extends('layouts.app')
@section('title', 'Monitoring Real-time')

@section('content')

    <div class="mb-10">
        <h2 class="text-3xl font-bold text-slate-900 mb-2">Monitoring Real-time</h2>
        <p class="text-slate-500">Kontrol pintu dan pencahayaan setiap kandang secara individual berdasarkan data sensor
            terbaru.</p>
    </div>
    @if (session('success'))
        <div
            class="mb-6 p-4 bg-emerald-100 border-l-4 border-emerald-500 text-emerald-700 rounded-r-xl flex items-center shadow-sm">
            <i class="fas fa-check-circle mr-3"></i>
            <span class="text-sm font-bold">{{ session('success') }}</span>
        </div>
    @endif

    @if (session('error'))
        <div class="mb-6 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 rounded-r-xl flex items-center shadow-sm">
            <i class="fas fa-exclamation-triangle mr-3"></i>
            <span class="text-sm font-bold">DEBUG: {{ session('error') }}</span>
        </div>
    @endif
    <!-- Grid Monitoring -->

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
        @forelse($kandangs as $k)
            @php
                // Ambil data sensor terbaru
                $latestSensor = $k->sensorData->sortByDesc('created_at')->first();

                // PERBAIKAN DI SINI:
                // Gunakan filter dengan str_contains agar lebih akurat mencari kata SERVO atau LAMP
                $servo = $k->devices
                    ->filter(function ($device) {
                        return str_contains(strtoupper($device->device_id), 'SERVO');
                    })
                    ->first();

                $lamp = $k->devices
                    ->filter(function ($device) {
                        return str_contains(strtoupper($device->device_id), 'LAMP');
                    })
                    ->first();

                $setting = $k->setting;
            @endphp

            <div
                class="bg-white rounded-[2.5rem] shadow-sm overflow-hidden border border-slate-100 group hover:shadow-xl transition-all duration-300">
                <!-- Image Header -->
                <div class="h-48 relative overflow-hidden">
                    <img src="{{ $k->image ?? 'https://images.unsplash.com/photo-1548550023-2bdb3c5beed7?auto=format&fit=crop&q=80&w=400' }}"
                        class="w-full h-full object-cover grayscale-[0.2] group-hover:scale-110 transition-transform duration-700"
                        alt="{{ $k->name }}">
                    <div
                        class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent flex flex-col justify-end p-6">
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
                                <span
                                    class="text-lg font-bold text-slate-800">{{ $latestSensor->temperature ?? '0' }}°C</span>
                            </div>
                        </div>
                    </div>

                    <!-- Door Status -->
                    <div
                        class="p-4 rounded-2xl flex items-center justify-between {{ $servo && $servo->door_status == 'TERBUKA' ? 'bg-emerald-500 text-white shadow-lg shadow-emerald-200' : 'bg-[#121927] text-white' }} transition-all duration-500">
                        <div class="flex items-center space-x-3">
                            <div
                                class="w-10 h-10 flex items-center justify-center rounded-xl {{ $servo && $servo->door_status == 'TERBUKA' ? 'bg-white/20' : 'bg-slate-700' }}">
                                <i
                                    class="fas {{ $servo && $servo->door_status == 'TERBUKA' ? 'fa-door-open' : 'fa-door-closed' }} text-lg"></i>
                            </div>
                            <div>
                                <p class="text-[8px] uppercase font-bold opacity-70">Status Pintu</p>
                                <p class="font-bold tracking-wider text-sm">{{ $servo->door_status ?? 'OFFLINE' }}</p>
                            </div>
                        </div>
                        @if ($servo)
                            <form action="{{ route('commands.store') }}" method="POST" class="m-0">
                                @csrf
                                <input type="hidden" name="device_id" value="{{ $servo->device_id }}">
                                <input type="hidden" name="command"
                                    value="{{ $servo->door_status == 'TERBUKA' ? 'CLOSE_DOOR' : 'OPEN_DOOR' }}">
                                <button type="submit"
                                    class="px-4 py-2 rounded-xl text-[10px] font-bold uppercase transition-all active:scale-95 shadow-md {{ $servo->door_status == 'TERBUKA' ? 'bg-white text-emerald-600 hover:bg-emerald-50' : 'bg-blue-600 text-white hover:bg-blue-700' }}">
                                    {{ $servo->door_status == 'TERBUKA' ? 'Tutup' : 'Buka' }}
                                </button>
                            </form>
                        @else
                            <span class="text-[9px] bg-red-500/20 px-2 py-1 rounded text-red-200 italic">Pintu Null</span>
                        @endif
                    </div>

                    <!-- Light/Heater Control -->
                    <div
                        class="p-4 rounded-2xl bg-slate-50 flex items-center justify-between border border-slate-100 {{ $lamp && $lamp->light_status == 'HIDUP' ? 'ring-2 ring-orange-400 bg-orange-50/50' : '' }} transition-all duration-300">
                        <div class="flex items-center space-x-3">
                            <div
                                class="w-10 h-10 flex items-center justify-center rounded-xl {{ $lamp && $lamp->light_status == 'HIDUP' ? 'bg-orange-100' : 'bg-slate-200' }}">
                                <i
                                    class="fas fa-lightbulb {{ $lamp && $lamp->light_status == 'HIDUP' ? 'text-orange-500' : 'text-slate-400' }}"></i>
                            </div>
                            <div>
                                <p class="text-[8px] uppercase font-bold text-slate-400">Lampu Pemanas</p>
                                <p class="font-bold text-slate-800 text-sm tracking-wider">
                                    {{ $lamp->light_status ?? 'OFFLINE' }}</p>
                            </div>
                        </div>
                        @if ($lamp)
                            <form action="{{ route('commands.store') }}" method="POST" class="m-0">
                                @csrf
                                <input type="hidden" name="device_id" value="{{ $lamp->device_id }}">
                                <input type="hidden" name="command"
                                    value="{{ $lamp->light_status == 'HIDUP' ? 'LIGHT_OFF' : 'LIGHT_ON' }}">

                                <button type="submit"
                                    class="relative inline-flex items-center h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 focus:outline-none {{ $lamp->light_status == 'HIDUP' ? 'bg-orange-500' : 'bg-slate-300' }}">
                                    <span
                                        class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out {{ $lamp->light_status == 'HIDUP' ? 'translate-x-5' : 'translate-x-0' }}"></span>
                                </button>
                            </form>
                        @else
                            <div class="text-right">
                                <span class="text-[9px] bg-red-500/20 px-2 py-1 rounded text-red-500 italic block">Lampu
                                    Null</span>
                                <span class="text-[8px] text-slate-400 block">Cek Seeder!</span>
                            </div>
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
                                <td class="px-8 py-4 text-sm font-medium text-slate-600">
                                    {{ $data->created_at->format('H:i:s') }}</td>
                                <td class="px-4 py-4 text-sm text-slate-600">{{ $data->kandang->name ?? '-' }}</td>
                                <td class="px-4 py-4 text-sm font-bold text-slate-800">{{ $data->temperature }}°C</td>
                                <td class="px-4 py-4">
                                    <span
                                        class="px-3 py-1 text-[10px] font-bold rounded-full {{ $data->chicken_detected ? 'bg-emerald-50 text-emerald-600' : 'bg-slate-100 text-slate-500' }}">
                                        {{ $data->chicken_detected ? 'ADA' : 'TIDAK' }}
                                    </span>
                                </td>
                                <td class="px-4 py-4 text-sm">
                                    <span class="text-emerald-600 font-bold">+{{ $data->chicken_in }}</span> / <span
                                        class="text-red-500 font-bold">-{{ $data->chicken_out }}</span>
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
