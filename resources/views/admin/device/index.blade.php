@extends('layouts.admin')
@section('title', 'Master Data Device')

@section('content')
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-8">
        <div class="flex items-center">
            <a href="{{ route('admin.kandang.index') }}"
                class="mr-4 bg-white text-slate-400 w-12 h-12 rounded-2xl flex items-center justify-center shadow-sm border border-slate-100 hover:text-rose-600 hover:border-rose-100 transition-all">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h2 class="text-2xl font-bold text-slate-800 tracking-tight">Device Management</h2>
                @if ($kandang)
                    <p class="text-slate-500 text-sm">
                        Daftar device di kandang <span class="font-bold text-rose-600">{{ $kandang->name }}</span>
                    </p>
                @else
                    <p class="text-slate-500 text-sm">Seluruh device yang terdaftar dalam sistem.</p>
                @endif
            </div>
        </div>

        <a href="{{ route('admin.device.create', ['kandang_id' => request('kandang_id')]) }}"
            class="inline-flex items-center justify-center px-6 py-3 bg-rose-600 hover:bg-rose-700 text-white rounded-xl font-bold text-sm uppercase tracking-widest transition-all shadow-lg shadow-rose-200 group h-fit">
            <i class="fas fa-plus-circle mr-2 group-hover:rotate-12 transition-transform"></i>
            Tambah Device
        </a>
    </div>

    <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
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
                        <th class="px-8 py-4 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Info Device
                        </th>
                        <th class="px-8 py-4 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] text-center">
                            ID & Barcode</th>
                        <th class="px-8 py-4 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Lokasi
                            Kandang</th>
                        <th class="px-8 py-4 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Kesehatan
                        </th>
                        <th class="px-8 py-4 text-right text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">
                            Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-50">
                    @forelse($devices as $d)
                        <tr class="hover:bg-rose-50/30 transition-colors">
                            <td class="px-8 py-5">
                                <div class="flex items-center space-x-4">
                                    <div
                                        class="relative w-14 h-14 rounded-2xl overflow-hidden bg-slate-100 flex items-center justify-center border border-slate-200">
                                        @if ($d->profile_image)
                                            <img src="{{ asset('storage/' . $d->profile_image) }}"
                                                class="w-full h-full object-cover">
                                        @else
                                            <i class="fas fa-microchip text-2xl text-slate-300"></i>
                                        @endif
                                        <span
                                            class="absolute bottom-1 right-1 w-3 h-3 rounded-full border-2 border-white {{ $d->status == 'online' ? 'bg-emerald-500' : 'bg-slate-400' }}"></span>
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-slate-800">{{ $d->device_name }}</p>
                                        <div class="flex items-center gap-2 mt-1">
                                            <i
                                                class="fas fa-wifi text-[10px] {{ $d->status == 'online' ? 'text-emerald-500' : 'text-slate-300' }}"></i>
                                            <span
                                                class="text-[10px] text-slate-400 font-bold uppercase">{{ $d->status ?? 'offline' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td class="px-8 py-5">
                                <div class="flex flex-col items-center">
                                    <div class="bg-white p-2 border rounded-lg shadow-sm">
                                        {!! DNS1D::getBarcodeHTML($d->device_id, 'C128', 1.1, 28) !!}
                                    </div>
                                    <p class="text-[9px] font-bold mt-2 text-slate-500 tracking-widest">{{ $d->device_id }}
                                    </p>
                                </div>
                            </td>

                            <td class="px-8 py-5">
                                <div class="flex flex-col">
                                    <span
                                        class="text-sm font-bold text-slate-600">{{ $d->kandangs->name ?? 'Unassigned' }}</span>
                                    <span
                                        class="text-[10px] text-slate-400 uppercase tracking-tight">{{ $d->kandangs->code ?? 'N/A' }}</span>
                                </div>
                            </td>

                            <td class="px-8 py-5">
                                @php
                                    $health = [
                                        'EXCELLENT' => [
                                            'bg' => 'bg-emerald-50',
                                            'text' => 'text-emerald-600',
                                            'border' => 'border-emerald-100',
                                        ],
                                        'DEGRADED' => [
                                            'bg' => 'bg-amber-50',
                                            'text' => 'text-amber-600',
                                            'border' => 'border-amber-100',
                                        ],
                                        'CRITICAL' => [
                                            'bg' => 'bg-rose-50',
                                            'text' => 'text-rose-600',
                                            'border' => 'border-rose-100',
                                        ],
                                        'MAINTENANCE' => [
                                            'bg' => 'bg-slate-50',
                                            'text' => 'text-slate-600',
                                            'border' => 'border-slate-200',
                                        ],
                                    ];
                                    $status = strtoupper($d->health_status ?? 'MAINTENANCE');
                                    $style = $health[$status] ?? $health['MAINTENANCE'];
                                @endphp
                                <span
                                    class="px-3 py-1 text-[9px] font-black rounded-lg border {{ $style['bg'] }} {{ $style['text'] }} {{ $style['border'] }} uppercase">
                                    {{ $status }}
                                </span>
                            </td>

                            <td class="px-8 py-5 text-right">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('admin.device.edit', $d->id) }}"
                                        class="w-9 h-9 flex items-center justify-center bg-slate-50 text-slate-400 hover:bg-white hover:text-rose-600 hover:shadow-sm border border-transparent hover:border-slate-100 rounded-xl transition-all">
                                        <i class="fas fa-edit text-xs"></i>
                                    </a>
                                    <form action="{{ route('admin.device.destroy', $d->id) }}" method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus device ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                            class="w-9 h-9 flex items-center justify-center bg-slate-50 text-slate-400 hover:bg-white hover:text-rose-600 hover:shadow-sm border border-transparent hover:border-slate-100 rounded-xl transition-all">
                                            <i class="fas fa-trash text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-8 py-20 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mb-4">
                                        <i class="fas fa-microchip text-slate-200 text-3xl"></i>
                                    </div>
                                    <p class="text-slate-400 font-bold text-sm uppercase tracking-[0.2em]">Data Kosong</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-8 py-4 bg-slate-50/30 border-t border-slate-100">
            <p class="text-[9px] font-bold text-slate-300 uppercase tracking-[0.2em] text-center">
                Secure Administrator Environment &bull; Hardware Data Integrity Verified
            </p>
        </div>
    </div>
@endsection
