@extends('layouts.admin')
@section('title', 'Master Data Kandang')

@section('content')

    <div class="w-full bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
        <div class="px-8 py-6 bg-slate-900 border-b border-slate-800 flex items-center justify-between">
            <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">
                System Infrastructure Map
            </h3>
            <i class="fas fa-map-marked-alt text-slate-500"></i>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 border-b border-slate-100">
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Informasi Kandang</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Penanggung Jawab (User)</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Status Operasional</th>
                        <th class="px-8 py-5 text-right text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Management</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-50">
                    @forelse($kandangs as $k)
                        <tr class="hover:bg-indigo-50/30 transition-all group">
                            <td class="px-8 py-6">
                                <div class="flex items-center space-x-4">
                                    <div class="w-12 h-12 bg-slate-100 rounded-2xl flex items-center justify-center text-slate-400 group-hover:bg-indigo-100 group-hover:text-indigo-600 transition-all duration-300">
                                        <i class="fas fa-warehouse text-xl"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-black text-slate-800 uppercase tracking-tight">
                                            {{ $k->name }}
                                        </p>
                                        <p class="text-[10px] text-slate-400 font-bold tracking-widest mt-0.5">
                                            CODE: {{ $k->code ?? 'KND-'.str_pad($k->id, 3, '0', STR_PAD_LEFT) }}
                                        </p>
                                    </div>
                                </div>
                            </td>

                            <td class="px-8 py-6">
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 bg-slate-800 rounded-full flex items-center justify-center text-white text-[10px] font-black border border-slate-700">
                                        {{ strtoupper(substr($k->user->name, 0, 1)) }}
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-sm font-bold text-slate-800">{{ $k->user->name }}</span>
                                        <span class="text-[10px] text-slate-400">{{ $k->user->email ?? 'Registered User' }}</span>
                                    </div>
                                </div>
                            </td>

                            <td class="px-8 py-6">
                                <span class="px-3 py-1.5 bg-indigo-50 text-indigo-600 border border-indigo-100 rounded-lg text-[9px] font-black uppercase tracking-widest">
                                    <i class="fas fa-check-circle mr-1"></i> Active
                                </span>
                            </td>

                            <td class="px-8 py-6 text-right">
                                <div class="flex justify-end space-x-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    <button class="w-8 h-8 rounded-lg bg-slate-100 text-slate-500 hover:bg-slate-900 hover:text-white transition-all">
                                        <i class="fas fa-external-link-alt text-xs"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-8 py-20 text-center">
                                <div class="flex flex-col items-center">
                                    <i class="fas fa-folder-open text-slate-200 text-4xl mb-4"></i>
                                    <p class="text-slate-400 font-black text-[10px] uppercase tracking-[0.2em]">Data kandang belum tersedia</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="px-8 py-5 bg-slate-50 border-t border-slate-100 flex justify-between items-center">
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest italic">
                System Infrastructure Registry
            </p>
            <p class="text-[9px] font-black text-slate-300 uppercase tracking-widest">
                v2.0.4-ADMIN
            </p>
        </div>
    </div>

@endsection