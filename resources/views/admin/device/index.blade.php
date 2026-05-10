@extends('layouts.admin')
@section('title', 'Master Data Device')

@section('content')
    <div class="w-full mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight">Device Management</h2>
            @if ($kandang)
                <p class="text-slate-500 text-sm mt-1">
                    Daftar device yang terdaftar pada kandang
                    <span class="font-bold text-rose-600">{{ $kandang->name }}</span>
                </p>
            @else
                <p class="text-slate-500 text-sm mt-1">Seluruh device yang terdaftar dalam sistem ekosistem Anda.</p>
            @endif
        </div>

        <a href="{{ route('admin.device.create', ['kandang_id' => request('kandang_id')]) }}"
            class="inline-flex items-center justify-center px-6 py-3 bg-rose-600 hover:bg-rose-700 text-white rounded-xl font-bold text-sm uppercase tracking-widest transition-all shadow-lg shadow-rose-200 group">

            <i class="fas fa-plus-circle mr-2 group-hover:rotate-12 transition-transform"></i>
            Tambah Device
        </a>
    </div>

    <div class="w-full bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
        <div class="px-8 py-5 bg-slate-50/50 border-b border-slate-100 flex justify-between items-center">
            <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">
                System Hardware Registry
            </h3>

            <div class="flex items-center bg-white px-3 py-1 rounded-full border border-slate-200 shadow-sm">
                <span class="text-[9px] font-black text-rose-600 uppercase tracking-widest">
                    Total: {{ $devices->count() }} Unit
                </span>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-white border-b border-slate-50">

                        <th class="px-8 py-4 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">
                            Info Device
                        </th>

                        <th class="px-8 py-4 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">
                            ID & Barcode
                        </th>

                        <th class="px-8 py-4 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">
                            Lokasi Kandang
                        </th>

                        <th class="px-8 py-4 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">
                            Kesehatan
                        </th>

                        <th class="px-8 py-4 text-right text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">
                            Aksi
                        </th>

                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-50">
                    @forelse($devices as $d)
                        <tr class="hover:bg-rose-50/30 transition-colors">

                            <td class="px-8 py-5">
                                <div class="flex items-center space-x-4">

                                    <div
                                        class="relative w-14 h-14 rounded-2xl overflow-hidden bg-slate-100 flex items-center justify-center border">

                                        @if ($d->profile_image)
                                            <img src="{{ asset('storage/' . $d->profile_image) }}"
                                                class="w-full h-full object-cover">
                                        @else
                                            <i class="fas fa-microchip text-2xl text-slate-300"></i>
                                        @endif

                                        <span
                                            class="absolute bottom-1 right-1 w-3 h-3 rounded-full border-2 border-white
                            {{ $d->status == 'online' ? 'bg-emerald-500' : 'bg-slate-400' }}">
                                        </span>
                                    </div>

                                    <div>
                                        <p class="text-sm font-bold text-slate-800">
                                            {{ $d->device_name }}
                                        </p>

                                        <div class="flex items-center gap-2 mt-1">
                                            <i
                                                class="fas fa-wifi text-[10px]
                                {{ $d->status == 'online' ? 'text-emerald-500' : 'text-slate-300' }}">
                                            </i>

                                            <span class="text-[10px] text-slate-400 font-bold uppercase">
                                                {{ strtoupper($d->status ?? 'offline') }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td class="px-8 py-5">
                                <div
                                    class="bg-white p-2 border rounded-lg shadow-sm w-fit mx-auto flex flex-col items-center">

                                    <div class="barcode-container">
                                        {!! DNS1D::getBarcodeHTML($d->device_id, 'C128', 1.1, 28) !!}
                                    </div>

                                    <p class="text-[9px] font-bold mt-2 text-slate-500 tracking-widest uppercase">
                                        {{ $d->device_id }}
                                    </p>
                                </div>
                            </td>

                            <td class="px-8 py-5">
                                <div class="flex flex-col">
                                    <span class="text-sm font-bold text-slate-600">
                                        {{ $d->kandang->name ?? 'Unassigned' }}
                                    </span>

                                    <span class="text-[10px] text-slate-400 uppercase">
                                        {{ $d->kandang->code ?? 'N/A' }}
                                    </span>
                                </div>
                            </td>

                            <td class="px-8 py-5">

                                @php
                                    $healthConfig = [
                                        'EXCELLENT' => [
                                            'bg' => 'bg-emerald-50',
                                            'text' => 'text-emerald-600',
                                        ],

                                        'DEGRADED' => [
                                            'bg' => 'bg-amber-50',
                                            'text' => 'text-amber-600',
                                        ],

                                        'CRITICAL' => [
                                            'bg' => 'bg-rose-50',
                                            'text' => 'text-rose-600',
                                        ],

                                        'MAINTENANCE' => [
                                            'bg' => 'bg-slate-50',
                                            'text' => 'text-slate-600',
                                        ],
                                    ];

                                    $h =
                                        $healthConfig[$d->health_status ?? 'MAINTENANCE'] ??
                                        $healthConfig['MAINTENANCE'];
                                @endphp

                                <span
                                    class="px-3 py-1 text-[9px] font-black rounded-lg border uppercase {{ $h['bg'] }} {{ $h['text'] }}">
                                    {{ $d->health_status ?? 'MAINTENANCE' }}
                                </span>
                            </td>

                            <td class="px-8 py-5 text-right">
                                <div class="flex justify-end gap-2">

                                    <a href="{{ route('admin.device.edit', $d->id) }}"
                                        class="w-8 h-8 flex items-center justify-center hover:bg-white hover:shadow-md border border-transparent hover:border-slate-100 rounded-lg transition-all group/edit">

                                        <i
                                            class="fas fa-edit text-slate-400 group-hover/edit:text-rose-600 transition-colors">
                                        </i>
                                    </a>

                                    <form action="{{ route('admin.device.destroy', $d->id) }}" method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus device ini?')">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                            class="w-8 h-8 flex items-center justify-center hover:bg-white hover:shadow-md border border-transparent hover:border-slate-100 rounded-lg transition-all group/del">

                                            <i
                                                class="fas fa-trash text-slate-400 group-hover/del:text-rose-600 transition-colors">
                                            </i>
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-8 py-16 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mb-4">
                                        <i class="fas fa-microchip text-slate-200 text-2xl"></i>
                                    </div>

                                    <p class="text-slate-400 font-bold text-sm uppercase tracking-widest">
                                        Device tidak ditemukan
                                    </p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-8 py-3 bg-slate-50/30 border-t border-slate-100">
            <p class="text-[9px] font-bold text-slate-300 uppercase tracking-[0.2em] text-center">
                Secure Administrator Environment &bull; Hardware Data Integrity Verified
            </p>
        </div>
    </div>
@endsection
