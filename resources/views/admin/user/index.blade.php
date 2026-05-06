@extends('layouts.admin')
@section('title', 'Manajemen Pengguna')

@section('content')
    @if (session('success'))
        <div id="alert-success"
            class="mb-6 mx-auto w-full bg-rose-50 border border-rose-200 text-rose-600 px-4 py-3 rounded-xl flex items-center justify-between shadow-sm animate-fade-in-down">
            <div class="flex items-center">
                <i class="fas fa-check-circle mr-3 text-lg"></i>
                <span class="text-sm font-bold uppercase tracking-wider">{{ session('success') }}</span>
            </div>
            <button onclick="document.getElementById('alert-success').remove()"
                class="text-rose-500 hover:text-rose-700 transition-colors">
                <i class="fas fa-times"></i>
            </button>
        </div>
    @endif

    <div class="w-full mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div>
                <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight">User Management</h2>
                <p class="text-slate-500 text-sm mt-1">Otoritas penuh untuk mengelola akses dan kredensial ekosistem.</p>
            </div>
        </div>

        <a href="{{ route('admin.user.create') }}"
            class="inline-flex items-center justify-center px-6 py-3 bg-rose-600 hover:bg-rose-700 text-white rounded-xl font-bold text-sm uppercase tracking-widest transition-all shadow-lg shadow-rose-200 group">
            <i class="fas fa-user-plus mr-2 group-hover:rotate-12 transition-transform"></i>
            Tambah User
        </a>
    </div>

    <div class="w-full bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
        <div class="px-8 py-5 bg-slate-50/50 border-b border-slate-100 flex justify-between items-center">
            <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">
                Daftar Pengguna Terdaftar
            </h3>

            <div class="flex items-center space-x-4">
                <div class="flex items-center bg-white px-3 py-1 rounded-full border border-slate-200 shadow-sm">
                    <span class="text-[9px] font-black text-rose-600 uppercase tracking-widest">
                        Total: {{ $users->count() }} User
                    </span>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-white border-b border-slate-50">
                        <th class="px-8 py-4 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Profil
                            Pengguna</th>
                        <th class="px-8 py-4 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Kontak &
                            Akses</th>
                        <th class="px-8 py-4 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Status
                            Verifikasi</th>
                        <th class="px-8 py-4 text-right text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">
                            Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-50">
                    @forelse($users as $user)
                        <tr class="hover:bg-rose-50/30 transition-colors group">
                            <td class="px-8 py-5">
                                <div class="flex items-center space-x-4">
                                    <div
                                        class="w-14 h-14 bg-rose-100 rounded-2xl flex items-center justify-center text-rose-600 font-black border border-rose-200 group-hover:bg-rose-600 group-hover:text-white transition-all duration-300">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-slate-800 leading-none mb-1.5">
                                            {{ $user->name }}
                                        </p>
                                        <p class="text-[10px] text-slate-400 font-bold tracking-widest uppercase">
                                            UID: #{{ str_pad($user->id, 4, '0', STR_PAD_LEFT) }}
                                        </p>
                                    </div>
                                </div>
                            </td>

                            <td class="px-8 py-5">
                                <div class="flex items-center space-x-2">
                                    <i class="far fa-envelope text-rose-400 text-xs"></i>
                                    <span class="text-sm font-bold text-slate-600">{{ $user->email }}</span>
                                </div>
                            </td>

                            <td class="px-8 py-5">
                                <span
                                    class="px-3 py-1 text-[9px] font-black rounded-lg border uppercase bg-emerald-50 text-emerald-600 border-emerald-100 flex w-fit items-center">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-2"></span>
                                    Active
                                </span>
                            </td>

                            <td class="px-8 py-5 text-right">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('admin.user.edit', $user->id) }}"
                                        class="w-8 h-8 flex items-center justify-center hover:bg-rose-100 rounded-lg transition-all group/edit">
                                        <i class="fas fa-edit text-slate-400 group-hover/edit:text-rose-600"></i>
                                    </a>

                                    <form action="{{ route('admin.user.destroy', $user->id) }}" method="POST"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                            class="w-8 h-8 flex items-center justify-center hover:bg-rose-100 rounded-lg transition-all group/del">
                                            <i class="fas fa-trash text-slate-400 group-hover/del:text-rose-600"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-8 py-16 text-center">
                                <div class="flex flex-col items-center">
                                    <div
                                        class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mb-4 border border-slate-100">
                                        <i class="fas fa-users-slash text-slate-200 text-2xl"></i>
                                    </div>
                                    <p class="text-slate-400 font-bold text-sm uppercase tracking-widest">
                                        Database User Kosong
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
                Secure Administrator Environment &bull; Data Integrity Verified
            </p>
        </div>
    </div>
@endsection
