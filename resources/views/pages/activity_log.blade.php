@extends('layouts.app')
@section('title', 'Log Aktivitas Sistem')

@section('content')

<div class="mb-10">
<h2 class="text-3xl font-bold text-slate-900 mb-2">Log Aktivitas</h2>
<p class="text-slate-500">Rekam jejak seluruh operasi sistem, sensor, dan kontrol perangkat secara real-time.</p>
</div>

<div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
<div class="px-8 py-6 border-b border-slate-50 flex justify-between items-center bg-white">
<h3 class="text-xl font-bold text-slate-800">Semua Aktivitas</h3>
<button class="bg-slate-900 hover:bg-slate-800 text-white px-6 py-2 rounded-2xl text-xs font-bold transition flex items-center">
<i class="fas fa-filter mr-2"></i> Filter Data
</button>
</div>

<div class="overflow-x-auto">
    <table class="w-full text-left">
        <thead>
            <tr class="text-slate-400 text-[11px] font-bold uppercase tracking-wider border-b border-slate-50">
                <th class="px-8 py-4">Waktu</th>
                <th class="px-4 py-4">Kategori</th>
                <th class="px-4 py-4">Aksi</th>
                <th class="px-4 py-4">Deskripsi</th>
                <th class="px-8 py-4 text-right">Status</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-50">
            @forelse($logs as $log)
            <tr class="hover:bg-slate-50/50 transition group">
                <td class="px-8 py-4">
                    <p class="text-sm font-medium text-slate-600">{{ $log->created_at->format('H:i:s') }}</p>
                    <p class="text-[10px] text-slate-400">{{ $log->created_at->format('d M Y') }}</p>
                </td>
                <td class="px-4 py-4">
                    @php
                        $catClass = $log->category == 'system' ? 'bg-indigo-50 text-indigo-600' : 'bg-slate-100 text-slate-600';
                    @endphp
                    <span class="px-3 py-1 text-[10px] font-bold rounded-full uppercase {{ $catClass }}">
                        {{ $log->category }}
                    </span>
                </td>
                <td class="px-4 py-4 text-sm font-bold text-slate-700">
                    {{ $log->action }}
                </td>
                <td class="px-4 py-4 text-sm text-slate-500 max-w-xs truncate">
                    {{ $log->description ?? '-' }}
                </td>
                <td class="px-8 py-4 text-right">
                    @php
                        $statusClasses = [
                            'success' => 'text-emerald-500',
                            'danger' => 'text-red-500',
                            'warning' => 'text-orange-500',
                            'info' => 'text-blue-500'
                        ];
                        $color = $statusClasses[$log->status] ?? 'text-slate-400';
                    @endphp
                    <div class="flex items-center justify-end space-x-2">
                        <span class="text-[10px] font-bold uppercase {{ $color }}">{{ $log->status }}</span>
                        <div class="w-2 h-2 rounded-full {{ str_replace('text', 'bg', $color) }}"></div>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-8 py-12 text-center text-slate-400 italic">
                    <i class="fas fa-history text-3xl mb-3 block opacity-20"></i>
                    Tidak ada log aktivitas ditemukan.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Custom Pagination Style -->
@if($logs->hasPages())
<div class="px-8 py-6 bg-slate-50/50 border-t border-slate-50">
    {{ $logs->links() }}
</div>
@endif


</div>
@endsection