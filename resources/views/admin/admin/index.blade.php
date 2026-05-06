@extends('layouts.admin')
@section('title', 'System Administrator Registry')

@section('content')

    <div class="w-full bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
        <div class="px-8 py-6 bg-slate-900 border-b border-slate-800 flex items-center justify-between">
            <h3 class="text-[10px] font-black text-amber-500 uppercase tracking-[0.2em]">
                Internal Staff Credentials
            </h3>
            <div class="flex items-center space-x-2">
                <span class="text-[9px] font-bold text-slate-500 uppercase tracking-widest">Security Level: Encrypted</span>
                <i class="fas fa-lock text-amber-500 text-xs"></i>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 border-b border-slate-100">
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Administrator Info</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Email Address</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Access Role</th>
                        <th class="px-8 py-5 text-right text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Management</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-50">
                    @foreach($admins as $admin)
                        <tr class="hover:bg-amber-50/30 transition-all group">
                            <td class="px-8 py-6">
                                <div class="flex items-center space-x-4">
                                    <div class="w-12 h-12 bg-slate-100 rounded-2xl flex items-center justify-center text-slate-400 group-hover:bg-amber-100 group-hover:text-amber-600 transition-all duration-300">
                                        <i class="fas fa-user-shield text-xl"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-black text-slate-800 uppercase tracking-tight">
                                            {{ $admin->name }}
                                        </p>
                                        <p class="text-[10px] text-slate-400 font-bold tracking-widest mt-0.5">
                                            STAFF ID: #{{ str_pad($admin->id, 3, '0', STR_PAD_LEFT) }}
                                        </p>
                                    </div>
                                </div>
                            </td>

                            <td class="px-8 py-6">
                                <div class="flex items-center space-x-2">
                                    <div class="w-2 h-2 rounded-full bg-emerald-400"></div>
                                    <span class="text-sm font-medium text-slate-600">{{ $admin->email }}</span>
                                </div>
                            </td>

                            <td class="px-8 py-6">
                                <span class="px-3 py-1.5 bg-slate-900 text-amber-500 rounded-lg text-[9px] font-black uppercase tracking-[0.1em] border border-slate-800">
                                    {{ $admin->role }}
                                </span>
                            </td>

                            <td class="px-8 py-6">
                                <div class="flex justify-end items-center space-x-2 opacity-0 group-hover:opacity-100 transition-all duration-300">
                                    <a href="{{ route('admin.admin.edit', $admin->id) }}"
                                        class="w-9 h-9 flex items-center justify-center rounded-xl bg-slate-100 text-slate-400 hover:bg-amber-500 hover:text-white transition-all">
                                        <i class="fas fa-pen text-xs"></i>
                                    </a>

                                    <form action="{{ route('admin.admin.destroy', $admin->id) }}" method="POST"
                                        onsubmit="return confirm('Hapus akun administrator ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                            class="w-9 h-9 flex items-center justify-center rounded-xl bg-slate-100 text-slate-400 hover:bg-rose-600 hover:text-white transition-all">
                                            <i class="fas fa-trash-alt text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="px-8 py-5 bg-slate-50 border-t border-slate-100 flex justify-between items-center">
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                Root System Authorization Required
            </p>
            <div class="flex items-center text-amber-600 space-x-1">
                <i class="fas fa-circle text-[6px]"></i>
                <span class="text-[9px] font-black uppercase tracking-widest">High-Level Data</span>
            </div>
        </div>
    </div>

@endsection