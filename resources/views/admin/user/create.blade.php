@extends('layouts.admin')
@section('title', 'Tambah Pengguna Baru')

@section('content')
    <div class="w-full mb-8 flex items-center justify-between">
        <div class="flex items-center">
            <a href="{{ route('admin.user.index') }}"
                class="mr-5 bg-white text-slate-400 w-12 h-12 rounded-2xl flex items-center justify-center shadow-sm border border-slate-100 hover:text-rose-600 hover:shadow-md transition-all group">
                <i class="fas fa-arrow-left group-hover:-translate-x-1 transition-transform"></i>
            </a>
            <div>
                <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight">Tambah Pengguna</h2>
                <p class="text-slate-500 text-sm">Daftarkan akun baru ke dalam sistem database.</p>
            </div>
        </div>
    </div>

    <div class="w-full bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
        <div class="px-10 py-6 border-b border-slate-50 bg-slate-50/50 flex justify-between items-center">
            <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">New User Registration</h3>
            <span
                class="px-4 py-1 bg-white border border-slate-200 rounded-full text-[10px] font-bold text-slate-500 shadow-sm">
                STATUS: DRAFT
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

        <form action="{{ route('admin.user.store') }}" method="POST" enctype="multipart/form-data" class="p-10">
            @csrf

            <div class="flex flex-col lg:flex-row gap-16">
                <div class="w-full lg:w-72 flex flex-col">
                    <div class="relative group mx-auto lg:mx-0 w-64 lg:w-full">
                        <div
                            class="w-full aspect-square rounded-[3rem] bg-slate-50 border-4 border-white shadow-xl overflow-hidden relative transition-all group-hover:ring-4 group-hover:ring-rose-100 ring-1 ring-slate-100">

                            <img id="preview-img"
                                src="https://ui-avatars.com/api/?name=New+User&background=FFF1F2&color=E11D48&bold=true"
                                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">

                            <div
                                class="absolute inset-0 bg-slate-900/40 flex flex-col items-center justify-center opacity-0 group-hover:opacity-100 transition-all backdrop-blur-[2px]">
                                <label for="profile"
                                    class="cursor-pointer bg-white text-rose-600 w-14 h-14 flex items-center justify-center rounded-2xl shadow-2xl hover:scale-110 transition-transform mb-2">
                                    <i class="fas fa-camera text-xl"></i>
                                </label>
                                <span class="text-white text-[10px] font-black uppercase tracking-widest">Upload
                                    Photo</span>
                            </div>

                            <button type="button" id="remove-img-btn"
                                class="hidden absolute top-4 right-4 bg-rose-600 text-white w-10 h-10 rounded-xl items-center justify-center shadow-lg hover:bg-rose-700 transition-all z-10">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>

                        <input type="file" name="profile" id="profile" class="hidden" accept="image/*">
                    </div>
                    <p class="text-center text-[10px] text-slate-400 mt-3 font-bold uppercase tracking-tighter">
                        <i class="fas fa-info-circle mr-1 text-rose-600"></i> Maksimal ukuran file 2MB
                    </p>
                </div>

                <div class="flex-1">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-10">

                        <div class="space-y-2 group">
                            <label
                                class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.15em] group-focus-within:text-rose-600 transition-colors">Nama
                                Lengkap</label>
                            <div class="relative">
                                <i class="far fa-user absolute left-0 top-1/2 -translate-y-1/2 text-slate-300"></i>
                                <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}"
                                    class="w-full pl-7 py-2 bg-transparent border-b-2 border-slate-100 focus:border-rose-500 focus:outline-none text-base text-slate-700 font-bold transition-all"
                                    placeholder="Masukkan nama lengkap" required>
                            </div>
                        </div>

                        <div class="space-y-2 group">
                            <label
                                class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.15em] group-focus-within:text-rose-600 transition-colors">Username</label>
                            <div class="relative">
                                <i class="fas fa-at absolute left-0 top-1/2 -translate-y-1/2 text-slate-300"></i>
                                <input type="text" name="username" value="{{ old('username') }}"
                                    class="w-full pl-7 py-2 bg-transparent border-b-2 border-slate-100 focus:border-rose-500 focus:outline-none text-base text-slate-700 font-bold transition-all"
                                    placeholder="johndoe123" required>
                            </div>
                        </div>

                        <div class="space-y-2 group">
                            <label
                                class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.15em] group-focus-within:text-rose-600 transition-colors">Email
                                Address</label>
                            <div class="relative">
                                <i class="far fa-envelope absolute left-0 top-1/2 -translate-y-1/2 text-slate-300"></i>
                                <input type="email" name="email" value="{{ old('email') }}"
                                    class="w-full pl-7 py-2 bg-transparent border-b-2 border-slate-100 focus:border-rose-500 focus:outline-none text-base text-slate-700 font-bold transition-all"
                                    placeholder="john@example.com" required>
                            </div>
                        </div>

                        <div class="space-y-2 group">
                            <label
                                class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.15em] group-focus-within:text-rose-600 transition-colors">No.
                                Handphone</label>
                            <div class="relative">
                                <i class="fas fa-mobile-alt absolute left-0 top-1/2 -translate-y-1/2 text-slate-300"></i>
                                <input type="text" name="no_hp" value="{{ old('no_hp') }}"
                                    class="w-full pl-7 py-2 bg-transparent border-b-2 border-slate-100 focus:border-rose-500 focus:outline-none text-base text-slate-700 font-bold transition-all"
                                    placeholder="0812xxxxxx">
                            </div>
                        </div>

                        <div class="space-y-2 group">
                            <label
                                class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.15em] group-focus-within:text-rose-600 transition-colors">Jenis
                                Kelamin</label>
                            <div class="relative">
                                <i class="fas fa-venus-mars absolute left-0 top-1/2 -translate-y-1/2 text-slate-300"></i>
                                <select name="jenis_kelamin"
                                    class="w-full pl-7 py-2 bg-transparent border-b-2 border-slate-100 focus:border-rose-500 focus:outline-none text-base text-slate-700 font-bold appearance-none cursor-pointer transition-all">
                                    <option value="" disabled selected>Pilih Jenis Kelamin</option>
                                    <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki
                                    </option>
                                    <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="space-y-2 group">
                            <label
                                class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.15em] group-focus-within:text-rose-600 transition-colors">Password</label>
                            <div class="relative">
                                <i class="fas fa-key absolute left-0 top-1/2 -translate-y-1/2 text-slate-300"></i>
                                <div class="relative">
                                    <i class="fas fa-key absolute left-0 top-1/2 -translate-y-1/2 text-slate-300"></i>

                                    <input type="password" name="password" id="password"
                                        class="w-full pl-7 pr-10 py-2 bg-transparent border-b-2 border-slate-100 focus:border-rose-500 focus:outline-none text-base text-slate-700 font-bold transition-all"
                                        placeholder="••••••••" required>

                                    <button type="button" onclick="togglePassword()"
                                        class="absolute right-0 top-1/2 -translate-y-1/2 text-slate-400 hover:text-rose-600">
                                        <i id="eyeIcon" class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-2 md:col-span-2 group">
                            <label
                                class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.15em] group-focus-within:text-rose-600 transition-colors">Alamat
                                Lengkap</label>
                            <div class="relative">
                                <i class="fas fa-map-marker-alt absolute left-0 top-3 text-slate-300"></i>
                                <textarea name="alamat_lengkap" rows="3"
                                    class="w-full pl-7 py-2 bg-transparent border-b-2 border-slate-100 focus:border-rose-500 focus:outline-none text-sm text-slate-700 font-bold resize-none transition-all"
                                    placeholder="Jl. Merdeka No. 45, Kota... ">{{ old('alamat_lengkap') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="mt-16 flex flex-col sm:flex-row justify-end gap-4">
                        <button type="reset"
                            class="order-2 sm:order-1 bg-slate-100 hover:bg-slate-200 text-slate-500 font-black py-4 px-10 rounded-2xl transition-all text-[10px] uppercase tracking-[0.2em] text-center">
                            Bersihkan Form
                        </button>
                        <button type="submit"
                            class="order-1 sm:order-2 bg-rose-600 hover:bg-rose-700 text-white font-black py-4 px-14 rounded-2xl transition-all shadow-lg shadow-rose-200 text-[10px] uppercase tracking-[0.2em] group">
                            Daftarkan Pengguna
                            <i class="fas fa-user-plus ml-2 group-hover:scale-125 transition-transform"></i>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        const imageInput = document.getElementById('profile');
        const previewImg = document.getElementById('preview-img');
        const removeBtn = document.getElementById('remove-img-btn');
        const defaultAvatar = "https://ui-avatars.com/api/?name=New+User&background=FFF1F2&color=E11D48&bold=true";

        imageInput.onchange = evt => {
            const [file] = imageInput.files;
            if (file) {
                previewImg.src = URL.createObjectURL(file);
                removeBtn.classList.remove('hidden');
                removeBtn.classList.add('flex');
                previewImg.classList.add('animate-pulse');
                setTimeout(() => previewImg.classList.remove('animate-pulse'), 500);
            }
        }

        removeBtn.onclick = () => {
            imageInput.value = "";
            previewImg.src = defaultAvatar;
            removeBtn.classList.add('hidden');
            removeBtn.classList.remove('flex');
        }
    </script>
    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            const icon = document.getElementById('eyeIcon');

            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            } else {
                input.type = "password";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            }
        }
    </script>
@endsection
