@extends('layouts.app')
@section('title', 'Manajemen Hardware')

@section('content')

<div class="mb-10">
<h2 class="text-3xl font-bold text-slate-900 mb-2">Manajemen Hardware</h2>
<p class="text-slate-500">Pantau status konektivitas dan konfigurasi perangkat IoT di setiap kandang.</p>
</div>

<div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
<div class="px-8 py-6 border-b border-slate-50 bg-white">
<h3 class="text-xl font-bold text-slate-800">Daftar Perangkat IoT</h3>
</div>

<div class="overflow-x-auto">
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="text-slate-400 text-[11px] font-bold uppercase tracking-wider border-b border-slate-50">
                <th class="px-8 py-4">Nama Perangkat</th>
                <th class="px-4 py-4">Tipe</th>
                <th class="px-4 py-4">Lokasi / Kandang</th>
                <th class="px-4 py-4">Status</th>
                <th class="px-4 py-4">Terakhir Aktif</th>
                <th class="px-8 py-4 text-right">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-50">
            @forelse($devices as $device)
            <tr class="hover:bg-slate-50/50 transition group">
                <td class="px-8 py-5">
                    <div class="flex items-center space-x-4">
                        <div class="w-10 h-10 {{ $device->status == 'online' ? 'bg-emerald-50 text-emerald-500' : 'bg-slate-100 text-slate-400' }} rounded-xl flex items-center justify-center transition-colors">
                            @if($device->device_type == 'sensor')
                                <i class="fas fa-microchip"></i>
                            @elseif($device->device_type == 'actuator')
                                <i class="fas fa-cogs"></i>
                            @else
                                <i class="fas fa-video"></i>
                            @endif
                        </div>
                        <div>
                            <p class="text-sm font-bold text-slate-800">{{ $device->device_name }}</p>
                            <p class="text-[10px] font-mono text-slate-400 uppercase tracking-tighter">{{ $device->mac_address ?? 'N/A' }}</p>
                        </div>
                    </div>
                </td>
                <td class="px-4 py-5">
                    <span class="text-xs font-medium text-slate-600 capitalize bg-slate-100 px-3 py-1 rounded-full border border-slate-200">
                        {{ $device->device_type }}
                    </span>
                </td>
                <td class="px-4 py-5">
                    <span class="text-sm font-bold text-slate-700">{{ $device->kandang->name ?? 'Tidak Terpasang' }}</span>
                </td>
                <td class="px-4 py-5">
                    <div class="flex items-center space-x-2">
                        <div class="w-2 h-2 rounded-full {{ $device->status == 'online' ? 'bg-emerald-500 animate-pulse' : 'bg-slate-300' }}"></div>
                        <span class="text-[10px] font-bold uppercase {{ $device->status == 'online' ? 'text-emerald-600' : 'text-slate-400' }}">
                            {{ $device->status }}
                        </span>
                    </div>
                </td>
                <td class="px-4 py-5">
                    <span class="text-xs text-slate-500 italic">
                        {{ $device->updated_at ? $device->updated_at->diffForHumans() : 'Belum ada update' }}
                    </span>
                </td>
                <td class="px-8 py-5 text-right">
                    @if($device->device_type == 'actuator')
                        <div class="flex justify-end space-x-2">
                            <form action="{{ route('commands.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="device_id" value="{{ $device->id }}">
                                <input type="hidden" name="command" value="OPEN_DOOR">
                                <button type="submit" class="bg-slate-900 hover:bg-slate-800 text-white px-4 py-2 rounded-xl text-[10px] font-bold uppercase transition">Buka</button>
                            </form>
                            <form action="{{ route('commands.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="device_id" value="{{ $device->id }}">
                                <input type="hidden" name="command" value="CLOSE_DOOR">
                                <button type="submit" class="bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 px-4 py-2 rounded-xl text-[10px] font-bold uppercase transition">Tutup</button>
                            </form>
                        </div>
                    @else
                        <button class="bg-slate-50 hover:bg-slate-100 text-slate-600 px-4 py-2 rounded-xl text-[10px] font-bold uppercase transition border border-slate-100">
                            <i class="fas fa-cog mr-1"></i> Config
                        </button>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-8 py-16 text-center text-slate-400 italic">
                    <div class="flex flex-col items-center opacity-30">
                        <i class="fas fa-microchip text-4xl mb-3"></i>
                        <p class="text-lg font-bold">Tidak Ada Perangkat</p>
                        <p class="text-sm">Belum ada hardware yang terdaftar di sistem ini.</p>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>


</div>
@endsection