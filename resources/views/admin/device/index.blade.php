@extends('layouts.admin')
@section('title', 'Master Data Device')

@section('content')

    <div class="w-full bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
        <div class="px-8 py-6 bg-slate-900 border-b border-slate-800 flex items-center justify-between">
            <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">
                System Hardware Registry
            </h3>
            <i class="fas fa-server text-slate-500"></i>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 border-b border-slate-100">
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Hardware Info</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Penempatan Kandang</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Pemilik (User)</th>
                        <th class="px-8 py-5 text-right text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Status Control</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-50">
                    @forelse($devices as $d)
                        <tr class="hover:bg-rose-50/30 transition-all group">
                            <td class="px-8 py-6">
                                <div class="flex items-center space-x-4">
                                    <div class="w-12 h-12 bg-slate-100 rounded-2xl flex items-center justify-center text-slate-400 group-hover:bg-rose-100 group-hover:text-rose-600 transition-colors">
                                        <i class="fas fa-microchip text-xl"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-black text-slate-800 uppercase tracking-tight">
                                            {{ $d->device_name }}
                                        </p>
                                        <p class="text-[10px] text-slate-400 font-bold tracking-widest mt-0.5">
                                            ID: {{ $d->device_id ?? 'N/A' }}
                                        </p>
                                    </div>
                                </div>
                            </td>

                            <td class="px-8 py-6">
                                <div class="flex flex-col">
                                    <span class="text-sm font-bold text-slate-700">
                                        <i class="fas fa-home mr-1.5 text-slate-300"></i> {{ $d->kandang->name }}
                                    </span>
                                    <span class="text-[10px] text-slate-400 uppercase mt-1 font-medium">
                                        Area Code: {{ $d->kandang->code ?? 'N/A' }}
                                    </span>
                                </div>
                            </td>

                            <td class="px-8 py-6">
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 bg-indigo-50 rounded-full flex items-center justify-center text-indigo-500 text-xs font-black border border-indigo-100">
                                        {{ strtoupper(substr($d->kandang->user->name, 0, 1)) }}
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-sm font-bold text-slate-800">{{ $d->kandang->user->name }}</span>
                                        <span class="text-[10px] text-slate-400">{{ $d->kandang->user->email ?? 'Account Active' }}</span>
                                    </div>
                                </div>
                            </td>

                            <td class="px-8 py-6 text-right">
                                <span class="px-3 py-1.5 bg-emerald-50 text-emerald-600 border border-emerald-100 rounded-lg text-[9px] font-black uppercase tracking-tighter">
                                    Verified Device
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-8 py-20 text-center">
                                <div class="flex flex-col items-center">
                                    <i class="fas fa-search text-slate-200 text-4xl mb-4"></i>
                                    <p class="text-slate-400 font-black text-[10px] uppercase tracking-[0.2em]">Tidak ada data perangkat ditemukan</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="px-8 py-5 bg-slate-50 border-t border-slate-100 text-right">
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest italic">
                Authorized Admin Access Only
            </p>
        </div>
    </div>

@endsection