@extends('layouts.admin')
@section('title', 'Master Data Kandang')

@section('content')
    @if (session('success'))
        <div id="alert-success"
            class="mb-6 mx-auto w-full bg-emerald-50 border border-emerald-200 text-emerald-600 px-4 py-3 rounded-xl flex items-center justify-between shadow-sm animate-fade-in-down">
            <div class="flex items-center">
                <i class="fas fa-check-circle mr-3 text-lg"></i>
                <span class="text-sm font-bold uppercase tracking-wider">{{ session('success') }}</span>
            </div>
            <button onclick="document.getElementById('alert-success').remove()"
                class="text-emerald-500 hover:text-emerald-700 transition-colors">
                <i class="fas fa-times"></i>
            </button>
        </div>
    @endif

    <div class="w-full mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight">Kandang Management</h2>
            <p class="text-slate-500 text-sm mt-1">Monitor kapasitas, populasi ayam, dan otomasi jadwal pintu kandang.</p>
        </div>

        <a href="{{ route('admin.kandang.create') }}"
            class="inline-flex items-center justify-center px-6 py-3 bg-rose-600 hover:bg-rose-700 text-white rounded-xl font-bold text-sm uppercase tracking-widest transition-all shadow-lg shadow-rose-200 group">
            <i class="fas fa-plus-circle mr-2 group-hover:rotate-12 transition-transform"></i>
            Tambah Kandang
        </a>
    </div>

    <div class="w-full bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
        <div class="px-8 py-5 bg-slate-50/50 border-b border-slate-100 flex justify-between items-center">
            <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">
                Infrastructure & Population Registry
            </h3>
            <div class="flex items-center bg-white px-3 py-1 rounded-full border border-slate-200 shadow-sm">
                <span class="text-[9px] font-black text-rose-600 uppercase tracking-widest">
                    Total: {{ $kandangs->count() }} Unit
                </span>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-white border-b border-slate-50">
                        <th class="px-8 py-4 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Info Kandang
                        </th>
                        <th class="px-8 py-4 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Populasi &
                            Kapasitas</th>
                        <th class="px-8 py-4 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Otomasi Timer
                        </th>
                        <th class="px-8 py-4 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">User</th>
                        <th class="px-8 py-4 text-right text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">
                            Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-50">
                    @forelse($kandangs as $k)
                        <tr class="hover:bg-rose-50/30 transition-colors group">
                            <td class="px-8 py-5">
                                <div class="flex items-center space-x-4">
                                    <div class="relative flex-shrink-0">
                                        @if ($k->image)
                                            <img src="{{ asset('storage/' . $k->image) }}" alt="{{ $k->name }}"
                                                class="w-12 h-12 rounded-2xl object-cover border-2 border-white shadow-sm group-hover:shadow-md transition-all">
                                        @else
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($k->name) }}&background=F1F5F9&color=64748B&bold=true&size=128"
                                                alt="{{ $k->name }}"
                                                class="w-12 h-12 rounded-2xl object-cover border-2 border-white shadow-sm group-hover:shadow-md transition-all">
                                        @endif
                                        @if ($k->current_chicken >= $k->capacity && $k->capacity > 0)
                                            <span class="absolute -top-1 -right-1 flex h-3 w-3">
                                                <span
                                                    class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-400 opacity-75"></span>
                                                <span class="relative inline-flex rounded-full h-3 w-3 bg-rose-500"></span>
                                            </span>
                                        @endif
                                    </div>

                                    <div>
                                        <p class="text-sm font-bold text-slate-800 leading-none mb-1.5">{{ $k->name }}
                                        </p>
                                        <div class="flex items-center gap-2">
                                            <p class="text-[10px] text-slate-400 font-bold tracking-widest uppercase">
                                                {{ $k->code }}
                                            </p>
                                            <span
                                                class="text-[9px] bg-slate-100 text-slate-500 px-1.5 py-0.5 rounded-md border border-slate-200">
                                                <i class="fas fa-microchip mr-1"></i> {{ $k->devices->count() }} Devices
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td class="px-8 py-5">
                                <div class="flex flex-col gap-1">
                                    <div class="flex items-center text-xs font-bold text-slate-600">
                                        <i class="fas fa-kiwi-bird mr-2 text-rose-400"></i>
                                        {{ number_format($k->current_chicken) }} / {{ number_format($k->capacity) }} Ekor
                                    </div>
                                    @php
                                        $percent = $k->capacity > 0 ? ($k->current_chicken / $k->capacity) * 100 : 0;
                                        $barColor =
                                            $percent > 90
                                                ? 'bg-rose-500'
                                                : ($percent > 70
                                                    ? 'bg-amber-500'
                                                    : 'bg-emerald-500');
                                    @endphp
                                    <div class="w-24 h-1.5 bg-slate-100 rounded-full overflow-hidden">
                                        <div class="h-full {{ $barColor }} transition-all duration-500"
                                            style="width: {{ min($percent, 100) }}%"></div>
                                    </div>
                                </div>
                            </td>

                            <td class="px-8 py-5">
                                <div class="flex flex-col gap-1">
                                    <span class="text-[10px] font-black text-emerald-600 uppercase flex items-center">
                                        <i class="far fa-clock mr-1.5"></i> Buka:
                                        {{ $k->timer_open ? \Carbon\Carbon::parse($k->timer_open)->format('H:i') : '--:--' }}
                                    </span>
                                    <span class="text-[10px] font-black text-rose-600 uppercase flex items-center">
                                        <i class="far fa-clock mr-1.5"></i> Tutup:
                                        {{ $k->timer_close ? \Carbon\Carbon::parse($k->timer_close)->format('H:i') : '--:--' }}
                                    </span>
                                </div>
                            </td>

                            <td class="px-8 py-5">
                                <div class="flex items-center space-x-2">
                                    <div
                                        class="w-7 h-7 bg-slate-800 rounded-lg flex items-center justify-center text-white text-[9px] font-black border border-slate-700 shadow-sm">
                                        {{ strtoupper(substr($k->user->nama_lengkap ?? '?', 0, 1)) }}
                                    </div>
                                    <span
                                        class="text-xs font-bold text-slate-600">{{ $k->user->nama_lengkap ?? 'Unknown' }}</span>
                                </div>
                            </td>

                            <td class="px-8 py-5 text-right">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('admin.device.index', ['kandang_id' => $k->id]) }}"
                                        class="w-8 h-8 flex items-center justify-center bg-slate-50 hover:bg-rose-600 hover:text-white hover:shadow-md rounded-lg transition-all group/info"
                                        title="Lihat Daftar Device">
                                        <i
                                            class="fas fa-info-circle text-slate-400 group-hover/info:text-white transition-colors"></i>
                                    </a>

                                    <a href="{{ route('admin.kandang.edit', $k->id) }}"
                                        class="w-8 h-8 flex items-center justify-center hover:bg-white hover:shadow-md border border-transparent hover:border-slate-100 rounded-lg transition-all group/edit"
                                        title="Edit Kandang">
                                        <i
                                            class="fas fa-edit text-slate-400 group-hover/edit:text-rose-600 transition-colors"></i>
                                    </a>

                                    <form action="{{ route('admin.kandang.destroy', $k->id) }}" method="POST"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus kandang {{ $k->name }}?')">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                            class="w-8 h-8 flex items-center justify-center hover:bg-white hover:shadow-md border border-transparent hover:border-slate-100 rounded-lg transition-all group/del"
                                            title="Hapus Kandang">
                                            <i
                                                class="fas fa-trash text-slate-400 group-hover/del:text-rose-600 transition-colors"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5"
                                class="px-8 py-16 text-center text-slate-400 uppercase text-[10px] font-black tracking-[0.2em]">
                                <i class="fas fa-inbox block text-2xl mb-2 text-slate-200"></i>
                                Data Kandang Masih Kosong
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-8 py-3 bg-slate-50/30 border-t border-slate-100">
            <p class="text-[9px] font-bold text-slate-300 uppercase tracking-[0.2em] text-center">
                System Infrastructure Map &bull; Automated Environment
            </p>
        </div>
    </div>
@endsection
