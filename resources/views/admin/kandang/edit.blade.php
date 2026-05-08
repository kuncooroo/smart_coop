@extends('layouts.admin')
@section('title', 'Edit Kandang - ' . $kandang->name)

@section('content')
    <div class="w-full mb-8 flex items-center justify-between">
        <div class="flex items-center">
            <a href="{{ route('admin.kandang.index') }}"
                class="mr-5 bg-white text-slate-400 w-12 h-12 rounded-2xl flex items-center justify-center shadow-sm border border-slate-100 hover:text-rose-600 hover:shadow-md transition-all group">
                <i class="fas fa-arrow-left group-hover:-translate-x-1 transition-transform"></i>
            </a>
            <div>
                <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight">Update Kandang</h2>
                <p class="text-slate-500 text-sm">Modifikasi konfigurasi infrastruktur dan data populasi.</p>
            </div>
        </div>
    </div>

    <div class="w-full bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
        <div class="px-10 py-6 border-b border-slate-50 bg-slate-50/50 flex justify-between items-center">
            <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Infrastructure Update</h3>
            <span
                class="px-4 py-1 bg-rose-50 border border-rose-100 rounded-full text-[10px] font-bold text-rose-600 shadow-sm">
                LOG: {{ $kandang->code }}
            </span>
        </div>

        @if ($errors->any())
            <div class="mx-10 mt-8 bg-rose-50 text-rose-600 p-5 rounded-2xl border border-rose-100 animate-pulse">
                <div class="flex items-center mb-2">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    <span class="text-xs font-bold uppercase tracking-wider">Terjadi Kesalahan Input</span>
                </div>
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li class="text-[11px] font-medium opacity-80">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.kandang.update', $kandang->id) }}" method="POST" enctype="multipart/form-data"
            class="p-10">
            @csrf
            @method('PUT')

            <div class="flex flex-col lg:flex-row gap-16">
                <div class="w-full lg:w-72 flex flex-col">
                    <div class="relative group mx-auto lg:mx-0 w-64 lg:w-full">
                        <div
                            class="w-full aspect-square rounded-[3rem] bg-slate-50 border-4 border-white shadow-xl overflow-hidden relative transition-all group-hover:ring-4 group-hover:ring-rose-100 ring-1 ring-slate-100">

                            @php
                                $currentImage = $kandang->image
                                    ? asset('storage/' . $kandang->image)
                                    : 'https://ui-avatars.com/api/?name=' .
                                        urlencode($kandang->name) .
                                        '&background=F1F5F9&color=64748B&bold=true';
                            @endphp

                            <img id="preview-img" src="{{ $currentImage }}"
                                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">

                            <div
                                class="absolute inset-0 bg-slate-900/40 flex flex-col items-center justify-center opacity-0 group-hover:opacity-100 transition-all backdrop-blur-[2px]">
                                <label for="image"
                                    class="cursor-pointer bg-white text-rose-600 w-14 h-14 flex items-center justify-center rounded-2xl shadow-2xl hover:scale-110 transition-transform mb-2">
                                    <i class="fas fa-camera text-xl"></i>
                                </label>
                                <span class="text-white text-[10px] font-black uppercase tracking-widest">Ganti Foto</span>
                            </div>

                            <button type="button" id="remove-img-btn"
                                class="absolute top-4 right-4 bg-rose-600 text-white w-10 h-10 rounded-xl items-center justify-center shadow-lg hover:bg-rose-700 transition-all z-10 {{ $kandang->image ? 'flex' : 'hidden' }}">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                        <input type="file" name="image" id="image" class="hidden" accept="image/*">
                        <input type="hidden" name="remove_image" id="remove-image-flag" value="0">
                    </div>
                    <p class="text-center text-[10px] text-slate-400 mt-3 font-bold uppercase tracking-tighter">
                        <i class="fas fa-info-circle mr-1 text-rose-600"></i> Maksimal 2MB (JPG/PNG)
                    </p>
                </div>

                <div class="flex-1">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-10">

                        <div class="space-y-2 group">
                            <label
                                class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.15em] group-focus-within:text-rose-600 transition-colors">Nama
                                Kandang</label>
                            <div class="relative">
                                <i class="fas fa-warehouse absolute left-0 top-1/2 -translate-y-1/2 text-slate-300"></i>
                                <input type="text" name="name" value="{{ old('name', $kandang->name) }}"
                                    class="w-full pl-7 py-2 bg-transparent border-b-2 border-slate-100 focus:border-rose-500 focus:outline-none text-base text-slate-700 font-bold transition-all"
                                    placeholder="Contoh: Kandang Utama Alpha" required>
                            </div>
                        </div>

                        <div class="space-y-2 group">
                            <label class="block text-[10px] font-black text-slate-300 uppercase tracking-[0.15em]">Kode Unik
                                Kandang (Read-Only)</label>
                            <div class="relative">
                                <i class="fas fa-lock absolute left-0 top-1/2 -translate-y-1/2 text-slate-200"></i>
                                <input type="text" value="{{ $kandang->code }}"
                                    class="w-full pl-7 py-2 bg-transparent border-b-2 border-slate-50 text-slate-400 font-mono text-base outline-none cursor-not-allowed"
                                    readonly>
                            </div>
                        </div>

                        <div class="space-y-2 group">
                            <label
                                class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.15em] group-focus-within:text-rose-600 transition-colors">Penanggung
                                Jawab (User)</label>
                            <div class="relative">
                                <i class="fas fa-user-shield absolute left-0 top-1/2 -translate-y-1/2 text-slate-300"></i>
                                <select name="user_id"
                                    class="w-full pl-7 py-2 bg-transparent border-b-2 border-slate-100 focus:border-rose-500 focus:outline-none text-base text-slate-700 font-bold appearance-none cursor-pointer transition-all"
                                    required>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}"
                                            {{ old('user_id', $kandang->user_id) == $user->id ? 'selected' : '' }}>
                                            {{ $user->nama_lengkap }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="space-y-2 group">
                            <label
                                class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.15em] group-focus-within:text-rose-600 transition-colors">Kapasitas
                                Maksimal</label>
                            <div class="relative">
                                <i class="fas fa-layer-group absolute left-0 top-1/2 -translate-y-1/2 text-slate-300"></i>
                                <input type="number" name="capacity" value="{{ old('capacity', $kandang->capacity) }}"
                                    class="w-full pl-7 py-2 bg-transparent border-b-2 border-slate-100 focus:border-rose-500 focus:outline-none text-base text-slate-700 font-bold transition-all"
                                    required>
                            </div>
                        </div>

                        <div class="space-y-2 group">
                            <label class="block text-[10px] font-black text-emerald-600 uppercase tracking-[0.15em]">Timer
                                Buka (Auto)</label>
                            <div class="relative">
                                <i class="far fa-clock absolute left-0 top-1/2 -translate-y-1/2 text-slate-300"></i>
                                <input type="time" name="timer_open"
                                    value="{{ old('timer_open', $kandang->timer_open ? \Carbon\Carbon::parse($kandang->timer_open)->format('H:i') : '') }}"
                                    class="w-full pl-7 py-2 bg-transparent border-b-2 border-slate-100 focus:border-emerald-500 focus:outline-none text-base text-slate-700 font-bold transition-all">
                            </div>
                        </div>

                        <div class="space-y-2 group">
                            <label class="block text-[10px] font-black text-rose-600 uppercase tracking-[0.15em]">Timer
                                Tutup (Auto)</label>
                            <div class="relative">
                                <i class="fas fa-history absolute left-0 top-1/2 -translate-y-1/2 text-slate-300"></i>
                                <input type="time" name="timer_close"
                                    value="{{ old('timer_close', $kandang->timer_close ? \Carbon\Carbon::parse($kandang->timer_close)->format('H:i') : '') }}"
                                    class="w-full pl-7 py-2 bg-transparent border-b-2 border-slate-100 focus:border-rose-500 focus:outline-none text-base text-slate-700 font-bold transition-all">
                            </div>
                        </div>

                        <div class="space-y-2 md:col-span-2 group">
                            <label
                                class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.15em] group-focus-within:text-rose-600 transition-colors">Populasi
                                Ayam Saat Ini</label>
                            <div class="relative">
                                <i class="fas fa-kiwi-bird absolute left-0 top-1/2 -translate-y-1/2 text-slate-300"></i>
                                <input type="number" name="current_chicken"
                                    value="{{ old('current_chicken', $kandang->current_chicken) }}"
                                    class="w-full pl-7 py-2 bg-transparent border-b-2 border-slate-100 focus:border-rose-500 focus:outline-none text-base text-slate-700 font-bold transition-all"
                                    required>
                            </div>
                        </div>
                    </div>

                    <div class="mt-16 flex flex-col sm:flex-row justify-end gap-4">
                        <a href="{{ route('admin.kandang.index') }}"
                            class="order-2 sm:order-1 bg-slate-100 hover:bg-slate-200 text-slate-500 font-black py-4 px-10 rounded-2xl transition-all text-[10px] uppercase tracking-[0.2em] text-center">
                            Batal
                        </a>
                        <button type="submit"
                            class="order-1 sm:order-2 bg-rose-600 hover:bg-rose-700 text-white font-black py-4 px-14 rounded-2xl transition-all shadow-lg shadow-slate-200 text-[10px] uppercase tracking-[0.2em] group">
                            Update Kandang
                            <i class="fas fa-check-circle ml-2 group-hover:scale-110 transition-transform"></i>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        const imageInput = document.getElementById('image');
        const previewImg = document.getElementById('preview-img');
        const removeBtn = document.getElementById('remove-img-btn');
        const removeFlag = document.getElementById('remove-image-flag');

        const defaultImage =
            "https://ui-avatars.com/api/?name={{ urlencode($kandang->name) }}&background=F1F5F9&color=64748B&bold=true";

        imageInput.onchange = evt => {
            const [file] = imageInput.files;

            if (file) {
                previewImg.src = URL.createObjectURL(file);

                removeBtn.classList.remove('hidden');
                removeBtn.classList.add('flex');

                removeFlag.value = "0";
            }
        }

        removeBtn.onclick = () => {
            previewImg.src = defaultImage;

            imageInput.value = "";

            removeBtn.classList.add('hidden');
            removeBtn.classList.remove('flex');

            removeFlag.value = "1";
        }
    </script>
@endsection
