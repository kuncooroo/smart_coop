@extends('layouts.app')
@section('title', 'Tambah Kandang Baru')

@section('content')
    <div class="w-full mb-6 flex items-center justify-between">
        <div class="flex items-center">
            <a href="{{ route('monitoring.index') }}"
                class="mr-4 bg-white text-slate-400 w-10 h-10 rounded-xl flex items-center justify-center shadow-sm border border-slate-100 hover:text-orange-500 transition-all">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h2 class="text-2xl font-bold text-slate-800 tracking-tight">Tambah Kandang</h2>
                <p class="text-xs text-slate-400 font-medium">Daftarkan unit kandang baru ke dalam sistem</p>
            </div>
        </div>
    </div>

    <div class="w-full bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-6 border-b border-slate-50 bg-slate-50/30">
            <h3 class="text-xs font-bold text-slate-400 uppercase tracking-[0.2em]">Informasi Kandang</h3>
        </div>

        <form action="{{ route('monitoring.store') }}" method="POST" enctype="multipart/form-data" class="p-8">
            @csrf
            <div class="flex flex-col lg:flex-row gap-12">

                <div class="w-full lg:w-72">
                    <div class="relative group">
                        <div
                            class="w-full aspect-square rounded-3xl bg-slate-50 border-2 border-dashed border-slate-200 flex flex-col items-center justify-center overflow-hidden relative transition-all group-hover:border-orange-300">
                            <i class="fas fa-camera text-3xl text-slate-200 mb-2"></i>
                            <span class="text-[10px] text-slate-400 font-bold uppercase">Foto Kandang</span>
                            
                            <div
                                class="absolute inset-0 bg-slate-900/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all">
                                <label for="image"
                                    class="cursor-pointer bg-white text-slate-900 p-3 rounded-full shadow-xl hover:scale-110 transition-transform">
                                    <i class="fas fa-plus"></i>
                                </label>
                            </div>
                        </div>
                        <input type="file" name="image" id="image" class="hidden" accept="image/*">
                        <p class="text-center text-[10px] text-slate-400 mt-3 font-bold uppercase tracking-tighter">*MAX 2MB</p>
                    </div>
                </div>

                <div class="flex-1">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-10 gap-y-8">
                        <div class="space-y-1 border-b border-slate-200 pb-2 focus-within:border-orange-500 transition-all md:col-span-2">
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest">Nama Kandang</label>
                            <input type="text" name="name" value="{{ old('name') }}"
                                class="w-full py-1 bg-transparent focus:outline-none text-lg text-slate-700 font-semibold uppercase"
                                placeholder="Contoh: Kandang Utama" required>
                        </div>

                        <div class="space-y-1 border-b border-slate-200 pb-2 focus-within:border-orange-500 transition-all">
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest">Kode Unik</label>
                            <div class="flex items-center justify-between">
                                <input type="text" name="code" value="{{ old('code') }}"
                                    class="w-full py-1 bg-transparent focus:outline-none text-lg text-slate-700 font-semibold uppercase"
                                    placeholder="KDG-001" required>
                                <i class="fas fa-tag text-slate-400 text-xl"></i>
                            </div>
                        </div>

                        <div class="space-y-1 border-b border-slate-200 pb-2 focus-within:border-orange-500 transition-all">
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest">Kapasitas (Ekor)</label>
                            <div class="flex items-center justify-between">
                                <input type="number" name="capacity" value="{{ old('capacity') }}"
                                    class="w-full py-1 bg-transparent focus:outline-none text-lg text-slate-700 font-semibold"
                                    placeholder="100" required>
                                <i class="fas fa-feather text-slate-400 text-xl"></i>
                            </div>
                        </div>
                    </div>

                    <div class="mt-12 flex justify-end gap-4">
                        <a href="{{ route('monitoring.index') }}" 
                           class="bg-slate-100 hover:bg-slate-200 text-slate-500 font-bold py-3 px-8 rounded-xl transition text-xs uppercase tracking-widest flex items-center">
                            Batal
                        </a>
                        <button type="submit"
                            class="bg-[#002855] hover:bg-orange-600 text-white font-bold py-3 px-10 rounded-xl transition shadow-lg text-sm uppercase tracking-widest">
                            Simpan Kandang Baru
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection