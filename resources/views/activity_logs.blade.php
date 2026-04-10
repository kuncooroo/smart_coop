@extends('layouts.app')

@section('title', 'Log Aktivitas')
@section('header_title', 'Riwayat Aktivitas Sistem')

@section('content')

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-6 border-b border-slate-100">
            <h3 class="text-lg font-bold text-slate-800">Log Aktivitas Terbaru</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase">Waktu</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase">Device</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase">Aktivitas</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($logs ?? [] as $log)
                        <tr>
                            <td class="px-6 py-4 text-sm text-slate-600">{{ $log->created_at->format('d M Y H:i') }}</td>
                            <td class="px-6 py-4 text-sm font-semibold text-slate-700 uppercase">{{ $log->device_id }}</td>
                            <td class="px-6 py-4 text-sm text-slate-600">{{ $log->activity }}</td>
                            <td class="px-6 py-4">
                                <span
                                    class="px-2 py-1 rounded-lg text-[10px] font-bold bg-blue-50 text-blue-600 border border-blue-100">SUCCESS</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-10 text-center text-slate-400">Tidak ada log aktivitas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
