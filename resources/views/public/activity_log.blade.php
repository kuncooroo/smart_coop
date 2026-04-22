@extends('layouts.app')
@section('title', 'Log Aktivitas Sistem')

@section('content')
    <div class="w-full mb-8 flex justify-between items-center">
        <div>
            <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight">Log Aktivitas</h2>
            <p class="text-slate-500 text-sm mt-1">Rekam jejak real-time operasional sistem dan perangkat.</p>
        </div>
        <button class="bg-[#002855] hover:bg-orange-600 text-white px-6 py-3 rounded-xl font-bold transition-all shadow-lg text-sm uppercase tracking-widest">
            <i class="fas fa-filter mr-2"></i> Filter Data
        </button>
    </div>

    <div class="w-full bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
        <div class="px-8 py-5 bg-slate-50/50 border-b border-slate-100">
            <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">System Event History</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-white border-b border-slate-50">
                        <th class="px-8 py-4 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Waktu</th>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Kategori</th>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Aksi</th>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Deskripsi</th>
                        <th class="px-8 py-4 text-right text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($logs as $log)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            {{-- Waktu --}}
                            <td class="px-8 py-5">
                                <div class="flex flex-col">
                                    <span class="text-sm font-bold text-slate-700">{{ $log->created_at->format('H:i:s') }}</span>
                                    <span class="text-[10px] text-slate-400 font-medium">{{ $log->created_at->format('d M Y') }}</span>
                                </div>
                            </td>

                            {{-- Kategori --}}
                            <td class="px-6 py-5">
                                @php
                                    $catColor = $log->category == 'system' ? 'bg-indigo-50 text-indigo-600 border-indigo-100' : 'bg-slate-50 text-slate-600 border-slate-100';
                                @endphp
                                <span class="px-3 py-1 text-[9px] font-black rounded-lg border uppercase tracking-wider {{ $catColor }}">
                                    {{ $log->category }}
                                </span>
                            </td>

                            {{-- Aksi --}}
                            <td class="px-6 py-5">
                                <span class="text-sm font-bold text-slate-800 uppercase tracking-tight">{{ $log->action }}</span>
                            </td>

                            {{-- Deskripsi --}}
                            <td class="px-6 py-5">
                                <p class="text-sm text-slate-500 max-w-xs leading-relaxed">
                                    {{ $log->description ?? '-' }}
                                </p>
                            </td>

                            {{-- Status --}}
                            <td class="px-8 py-5 text-right">
                                @php
                                    $statusConfig = [
                                        'success' => ['text' => 'text-emerald-600', 'bg' => 'bg-emerald-500', 'label' => 'Success'],
                                        'danger'  => ['text' => 'text-rose-600', 'bg' => 'bg-rose-500', 'label' => 'Danger'],
                                        'warning' => ['text' => 'text-amber-600', 'bg' => 'bg-amber-500', 'label' => 'Warning'],
                                        'info'    => ['text' => 'text-blue-600', 'bg' => 'bg-blue-500', 'label' => 'Info'],
                                    ];
                                    $st = $statusConfig[$log->status] ?? ['text' => 'text-slate-400', 'bg' => 'bg-slate-400', 'label' => $log->status];
                                @endphp
                                <div class="flex items-center justify-end gap-3">
                                    <span class="text-[10px] font-black uppercase tracking-[0.1em] {{ $st['text'] }}">
                                        {{ $st['label'] }}
                                    </span>
                                    <div class="relative flex h-2 w-2">
                                        @if($log->status == 'success')
                                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full {{ $st['bg'] }} opacity-20"></span>
                                        @endif
                                        <span class="relative inline-flex rounded-full h-2 w-2 {{ $st['bg'] }}"></span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-8 py-16 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mb-4">
                                        <i class="fas fa-history text-slate-200 text-2xl"></i>
                                    </div>
                                    <p class="text-slate-400 font-bold text-sm uppercase tracking-widest">Tidak ada log aktivitas</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if ($logs->hasPages())
            <div class="px-8 py-6 bg-slate-50/30 border-t border-slate-50">
                {{ $logs->links() }}
            </div>
        @endif
    </div>
@endsection