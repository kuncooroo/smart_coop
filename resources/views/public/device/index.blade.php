@extends('layouts.app')
@section('title', 'Daftar Hardware')

@section('content')
    <div class="w-full mb-8 flex justify-between items-center">
        <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight">Hardware Management</h2>
        <a href="{{ route('devices.create') }}"
            class="bg-[#002855] hover:bg-orange-600 text-white px-6 py-3 rounded-xl font-bold transition-all shadow-lg text-sm uppercase tracking-widest">
            <i class="fas fa-plus mr-2"></i> Add Device
        </a>
    </div>

    <div class="w-full bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead class="bg-slate-50/50 border-b border-slate-100">
                <tr>
                    <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Device Info</th>
                    <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">ID & Barcode</th>
                    <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Location</th>
                    <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">System Health
                    </th>
                    <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @foreach ($devices as $device)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        {{-- Device Info --}}
                        <td class="px-8 py-6">
                            <div class="flex items-center space-x-4">
                                <div
                                    class="w-14 h-14 rounded-2xl overflow-hidden bg-slate-100 flex items-center justify-center border border-slate-200">
                                    @if ($device->profile_image)
                                        <img src="{{ asset('storage/' . $device->profile_image) }}"
                                            class="w-full h-full object-cover">
                                    @else
                                        <i class="fas fa-microchip text-2xl text-slate-300"></i>
                                    @endif
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-slate-800">
                                        {{ $device->device_name ?? 'Unnamed Device' }}</p>
                                    <div class="flex items-center gap-2 mt-1">
                                        <i
                                            class="fas fa-wifi text-[10px] {{ $device->status == 'online' ? 'text-emerald-500' : 'text-slate-300' }}"></i>
                                        <span
                                            class="text-[10px] text-slate-400 font-bold uppercase tracking-tight">{{ $device->signal_strength ?? 0 }}%
                                            Signal</span>
                                    </div>
                                </div>
                            </div>
                        </td>

                        {{-- Barcode --}}
                        <td class="px-8 py-6">
                            <div
                                class="bg-white p-2 border border-slate-100 rounded-lg inline-block text-center shadow-sm group hover:border-orange-200 transition-all">
                                {!! DNS1D::getBarcodeHTML($device->device_id, 'C128', 1.1, 28) !!}
                                <p class="text-[9px] font-bold mt-1 text-slate-500 tracking-widest">{{ $device->device_id }}
                                </p>
                            </div>
                        </td>

                        {{-- Location --}}
                        <td class="px-8 py-6">
                            <div class="flex flex-col">
                                <span
                                    class="text-sm font-bold text-slate-600">{{ $device->kandang->name ?? 'Unassigned' }}</span>
                                <span
                                    class="text-[10px] text-slate-400 font-medium uppercase tracking-tighter">{{ $device->kandang->code ?? 'N/A' }}</span>
                            </div>
                        </td>

                        {{-- Status & Health (Versi dengan Keterangan Jelas) --}}
                        <td class="px-8 py-6">
                            <div class="flex flex-col gap-3">
                                <div class="flex items-center gap-2">
                                    <div class="flex items-center justify-center w-5">
                                        @if ($device->status == 'online')
                                            <span class="relative flex h-2 w-2">
                                                <span
                                                    class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                                <span
                                                    class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                                            </span>
                                        @else
                                            <span class="relative inline-flex rounded-full h-2 w-2 bg-rose-500"></span>
                                        @endif
                                    </div>
                                    <span
                                        class="text-[10px] font-black uppercase tracking-widest {{ $device->status == 'online' ? 'text-emerald-600' : 'text-rose-600' }}">
                                        {{ $device->status }}
                                    </span>
                                </div>

                                @php
                                    $healthConfig = [
                                        'EXCELLENT' => [
                                            'bg' => 'bg-emerald-50',
                                            'text' => 'text-emerald-600',
                                            'border' => 'border-emerald-100',
                                            'icon' => 'fa-check-circle',
                                            'desc' => 'Hardware Normal',
                                        ],
                                        'DEGRADED' => [
                                            'bg' => 'bg-amber-50',
                                            'text' => 'text-amber-600',
                                            'border' => 'border-amber-100',
                                            'icon' => 'fa-exclamation-triangle',
                                            'desc' => 'Ada Masalah Kecil',
                                        ],
                                        'CRITICAL' => [
                                            'bg' => 'bg-rose-50',
                                            'text' => 'text-rose-600',
                                            'border' => 'border-rose-100',
                                            'icon' => 'fa-radiation',
                                            'desc' => 'Bahaya / Rusak',
                                        ],
                                        'MAINTENANCE' => [
                                            'bg' => 'bg-slate-50',
                                            'text' => 'text-slate-600',
                                            'border' => 'border-slate-100',
                                            'icon' => 'fa-tools',
                                            'desc' => 'Sedang Perbaikan',
                                        ],
                                    ];
                                    $h = $healthConfig[$device->health_status] ?? $healthConfig['MAINTENANCE'];
                                @endphp

                                <div
                                    class="flex items-center gap-2 px-3 py-1.5 rounded-xl border {{ $h['bg'] }} {{ $h['border'] }} {{ $h['text'] }} w-fit">
                                    <i class="fas {{ $h['icon'] }} text-[10px]"></i>
                                    <div class="flex flex-col leading-none">
                                        <span
                                            class="text-[9px] font-black uppercase tracking-widest">{{ $device->health_status }}</span>
                                        <span class="text-[8px] opacity-70 font-bold">{{ $h['desc'] }}</span>
                                    </div>
                                </div>
                            </div>
                        </td>
                        {{-- Actions --}}
                        <td class="px-8 py-6">
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('devices.edit', $device->id) }}"
                                    class="w-8 h-8 rounded-lg flex items-center justify-center text-slate-400 hover:bg-orange-50 hover:text-orange-500 transition-all">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('devices.destroy', $device->id) }}" method="POST"
                                    onsubmit="return confirm('Hapus perangkat?')">
                                    @csrf @method('DELETE')
                                    <button
                                        class="w-8 h-8 rounded-lg flex items-center justify-center text-slate-400 hover:bg-rose-50 hover:text-rose-500 transition-all">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
