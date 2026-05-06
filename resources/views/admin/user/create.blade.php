@extends('layouts.admin')
@section('title', 'Tambah Pengguna Baru')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight">Buat Akun</h2>
            <p class="text-slate-500 text-sm mt-1">Daatarkan pengguna baru ke dalam ekosistem sistem.</p>
        </div>
        <a href="{{ route('admin.user.index') }}" class="text-slate-400 hover:text-rose-600 transition-colors">
            <i class="fas fa-arrow-left mr-2"></i> Kembali
        </a>
    </div>

    <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
        <div class="px-8 py-6 bg-slate-900 border-b border-slate-800 flex items-center justify-between">
            <h3 class="text-[10px] font-black text-rose-500 uppercase tracking-[0.2em]">
                Identity Registration Form
            </h3>
            <i class="fas fa-user-plus text-slate-600"></i>
        </div>

        <form action="{{ route('admin.user.store') }}" method="POST" class="p-8 space-y-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Nama Lengkap</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-300">
                            <i class="fas fa-user text-xs"></i>
                        </span>
                        <input type="text" name="name" value="{{ old('name') }}" 
                            class="w-full pl-11 pr-4 py-4 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-bold text-slate-700 focus:outline-none focus:ring-2 focus:ring-rose-500/20 focus:border-rose-500 transition-all"
                            placeholder="John Doe">
                    </div>
                    @error('name') <p class="text-[10px] text-rose-500 font-bold mt-1 ml-1">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Alamat Email</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-300">
                            <i class="fas fa-envelope text-xs"></i>
                        </span>
                        <input type="email" name="email" value="{{ old('email') }}"
                            class="w-full pl-11 pr-4 py-4 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-bold text-slate-700 focus:outline-none focus:ring-2 focus:ring-rose-500/20 focus:border-rose-500 transition-all"
                            placeholder="example@mail.com">
                    </div>
                    @error('email') <p class="text-[10px] text-rose-500 font-bold mt-1 ml-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="space-y-2">
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Password</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-300">
                        <i class="fas fa-lock text-xs"></i>
                    </span>
                    <input type="password" name="password" 
                        class="w-full pl-11 pr-4 py-4 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-bold text-slate-700 focus:outline-none focus:ring-2 focus:ring-rose-500/20 focus:border-rose-500 transition-all"
                        placeholder="••••••••">
                </div>
                <p class="text-[9px] text-slate-400 font-medium ml-1 mt-1 italic">*Minimal 6 karakter dengan kombinasi angka</p>
                @error('password') <p class="text-[10px] text-rose-500 font-bold mt-1 ml-1">{{ $message }}</p> @enderror
            </div>

            <div class="pt-4 flex items-center justify-end space-x-4">
                <button type="reset" class="text-[10px] font-black text-slate-400 uppercase tracking-widest hover:text-slate-600 transition-colors">
                    Reset Form
                </button>
                <button type="submit" 
                    class="bg-rose-600 hover:bg-rose-700 text-white px-10 py-4 rounded-2xl font-black text-xs uppercase tracking-widest transition-all shadow-lg shadow-rose-200">
                    Simpan Database
                </button>
            </div>
        </form>

        <div class="px-8 py-4 bg-slate-50 border-t border-slate-100 text-center">
            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">
                Data will be encrypted and stored in the secure node
            </p>
        </div>
    </div>
</div>
@endsection