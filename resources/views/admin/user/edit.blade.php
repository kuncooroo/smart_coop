    @extends('layouts.admin')
    @section('title', 'Edit Pengguna')

    @section('content')
        <div class="w-full mb-8 flex items-center justify-between">
            <div class="flex items-center">
                <a href="{{ route('admin.user.index') }}"
                    class="mr-5 bg-white text-slate-400 w-12 h-12 rounded-2xl flex items-center justify-center shadow-sm border border-slate-100 hover:text-rose-600 hover:shadow-md transition-all group">
                    <i class="fas fa-arrow-left group-hover:-translate-x-1 transition-transform"></i>
                </a>
                <div>
                    <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight">Edit Profile</h2>
                    <p class="text-slate-500 text-sm">Perbarui informasi kredensial dan data personal pengguna.</p>
                </div>
            </div>
        </div>

        <div class="w-full bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
            <div class="px-10 py-6 border-b border-slate-50 bg-slate-50/50 flex justify-between items-center">
                <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">User Account Identification</h3>
                <span
                    class="px-4 py-1 bg-white border border-slate-200 rounded-full text-[10px] font-bold text-slate-500 shadow-sm">
                    UID: #{{ str_pad($user->id, 4, '0', STR_PAD_LEFT) }}
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

            <form action="{{ route('admin.user.update', $user->id) }}" method="POST" enctype="multipart/form-data"
                class="p-10">
                @csrf
                @method('PUT')

                <input type="hidden" name="remove_profile" id="remove-profile-flag" value="0">

                <div class="flex flex-col lg:flex-row gap-16">
                    <div class="w-full lg:w-72 flex flex-col">
                        <div class="relative group mx-auto lg:mx-0 w-64 lg:w-full">
                            <div
                                class="w-full aspect-square rounded-[3rem] bg-slate-50 border-4 border-white shadow-xl overflow-hidden relative transition-all group-hover:ring-4 group-hover:ring-rose-100 ring-1 ring-slate-100">

                                <img id="preview-img"
                                    src="{{ $user->profile ? asset('storage/' . $user->profile) : 'https://ui-avatars.com/api/?name=' . urlencode($user->nama_lengkap) . '&background=FFF1F2&color=E11D48&bold=true' }}"
                                    class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">

                                <div
                                    class="absolute inset-0 bg-slate-900/40 flex flex-col items-center justify-center opacity-0 group-hover:opacity-100 transition-all backdrop-blur-[2px]">
                                    <label for="profile"
                                        class="cursor-pointer bg-white text-rose-600 w-14 h-14 flex items-center justify-center rounded-2xl shadow-2xl hover:scale-110 transition-transform mb-2">
                                        <i class="fas fa-camera text-xl"></i>
                                    </label>
                                    <span class="text-white text-[10px] font-black uppercase tracking-widest">Update
                                        Photo</span>
                                </div>

                                <button type="button" id="btn-remove-profile"
                                    class="absolute top-4 right-4 bg-rose-500 text-white w-10 h-10 rounded-2xl shadow-lg flex items-center justify-center hover:scale-110 transition-transform z-20 {{ $user->profile ? '' : 'hidden' }}">
                                    <i class="fas fa-trash text-sm"></i>
                                </button>
                            </div>

                            <input type="file" name="profile" id="profile" class="hidden" accept="image/*">
                        </div>

                        <div class="mt-8 space-y-3">
                            <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100 flex items-center gap-4">
                                <div
                                    class="w-8 h-8 bg-slate-400 rounded-lg flex items-center justify-center text-white text-xs">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <div>
                                    <p
                                        class="text-[9px] font-black text-slate-400 uppercase tracking-widest leading-none mb-1">
                                        Terdaftar Sejak</p>
                                    <p class="text-xs font-bold text-slate-600">{{ $user->created_at->format('d M Y') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex-1">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-10">

                            <div class="space-y-2 group">
                                <label
                                    class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.15em] group-focus-within:text-rose-600 transition-colors">Nama
                                    Lengkap</label>
                                <div class="relative">
                                    <i class="far fa-user absolute left-0 top-1/2 -translate-y-1/2 text-slate-300"></i>
                                    <input type="text" name="nama_lengkap"
                                        value="{{ old('nama_lengkap', $user->nama_lengkap) }}"
                                        class="w-full pl-7 py-2 bg-transparent border-b-2 border-slate-100 focus:border-rose-500 focus:outline-none text-base text-slate-700 font-bold transition-all"
                                        placeholder="Masukkan nama lengkap" required>
                                </div>
                            </div>

                            <div class="space-y-2 group">
                                <label
                                    class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.15em] group-focus-within:text-rose-600 transition-colors">Username</label>
                                <div class="relative">
                                    <i class="fas fa-at absolute left-0 top-1/2 -translate-y-1/2 text-slate-300"></i>
                                    <input type="text" name="username" value="{{ old('username', $user->username) }}"
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
                                    <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                        class="w-full pl-7 py-2 bg-transparent border-b-2 border-slate-100 focus:border-rose-500 focus:outline-none text-base text-slate-700 font-bold transition-all"
                                        placeholder="john@example.com" required>
                                </div>
                            </div>

                            <div class="space-y-2 group">
                                <label
                                    class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.15em] group-focus-within:text-rose-600 transition-colors">No.
                                    Handphone</label>
                                <div class="relative">
                                    <i
                                        class="fas fa-mobile-alt absolute left-0 top-1/2 -translate-y-1/2 text-slate-300"></i>
                                    <input type="text" name="no_hp" value="{{ old('no_hp', $user->no_hp) }}"
                                        class="w-full pl-7 py-2 bg-transparent border-b-2 border-slate-100 focus:border-rose-500 focus:outline-none text-base text-slate-700 font-bold transition-all"
                                        placeholder="0812xxxxxx">
                                </div>
                            </div>

                            <div class="space-y-2 group">
                                <label
                                    class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.15em] group-focus-within:text-rose-600 transition-colors">Jenis
                                    Kelamin</label>
                                <div class="relative">
                                    <i
                                        class="fas fa-venus-mars absolute left-0 top-1/2 -translate-y-1/2 text-slate-300"></i>
                                    <select name="jenis_kelamin"
                                        class="w-full pl-7 py-2 bg-transparent border-b-2 border-slate-100 focus:border-rose-500 focus:outline-none text-base text-slate-700 font-bold appearance-none cursor-pointer transition-all">

                                        <option value=""
                                            {{ old('jenis_kelamin', $user->jenis_kelamin) == null ? 'selected' : '' }}>
                                            Pilih Jenis Kelamin
                                        </option>

                                        <option value="L"
                                            {{ old('jenis_kelamin', $user->jenis_kelamin) == 'L' ? 'selected' : '' }}>
                                            Laki-laki
                                        </option>

                                        <option value="P"
                                            {{ old('jenis_kelamin', $user->jenis_kelamin) == 'P' ? 'selected' : '' }}>
                                            Perempuan
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="space-y-2 group">
                                <label
                                    class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.15em] group-focus-within:text-rose-600 transition-colors">Password
                                    Baru (Opsional)</label>
                                <div class="relative">
                                    <i class="fas fa-key absolute left-0 top-1/2 -translate-y-1/2 text-slate-300"></i>
                                    <input type="password" name="password"
                                        class="w-full pl-7 py-2 bg-transparent border-b-2 border-slate-100 focus:border-rose-500 focus:outline-none text-base text-slate-700 font-bold transition-all"
                                        placeholder="••••••••">
                                </div>
                                <p class="text-[9px] text-slate-400 font-medium italic">*Kosongkan jika tidak ingin
                                    mengubah password</p>
                            </div>

                            <div class="space-y-2 md:col-span-2 group">
                                <label
                                    class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.15em] group-focus-within:text-rose-600 transition-colors">Alamat
                                    Lengkap</label>
                                <div class="relative">
                                    <i class="fas fa-map-marker-alt absolute left-0 top-3 text-slate-300"></i>
                                    <textarea name="alamat_lengkap" rows="3"
                                        class="w-full pl-7 py-2 bg-transparent border-b-2 border-slate-100 focus:border-rose-500 focus:outline-none text-sm text-slate-700 font-bold resize-none transition-all"
                                        placeholder="Jl. Merdeka No. 45, Kota... ">{{ old('alamat_lengkap', $user->alamat_lengkap) }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="mt-16 flex flex-col sm:flex-row justify-end gap-4">
                            <a href="{{ route('admin.user.index') }}"
                                class="order-2 sm:order-1 bg-slate-100 hover:bg-slate-200 text-slate-500 font-black py-4 px-10 rounded-2xl transition-all text-[10px] uppercase tracking-[0.2em] text-center">
                                Batalkan
                            </a>
                            <button type="submit"
                                class="order-1 sm:order-2 bg-rose-600 hover:bg-rose-700 text-white font-black py-4 px-14 rounded-2xl transition-all shadow-lg shadow-rose-200 text-[10px] uppercase tracking-[0.2em] group">
                                Simpan Perubahan
                                <i class="fas fa-check-circle ml-2 group-hover:scale-125 transition-transform"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <script>
            const imageInput = document.getElementById('profile');
            const previewImg = document.getElementById('preview-img');
            const btnRemove = document.getElementById('btn-remove-profile');
            const removeFlag = document.getElementById('remove-profile-flag');
            const defaultAvatar =
                "https://ui-avatars.com/api/?name={{ urlencode($user->nama_lengkap) }}&background=FFF1F2&color=E11D48&bold=true";

            imageInput.onchange = evt => {
                const [file] = imageInput.files;
                if (file) {
                    previewImg.src = URL.createObjectURL(file);
                    btnRemove.classList.remove('hidden');
                    removeFlag.value = "0";
                    previewImg.classList.add('animate-pulse');
                    setTimeout(() => previewImg.classList.remove('animate-pulse'), 500);
                }
            }

            btnRemove.onclick = () => {
                previewImg.src = defaultAvatar;
                btnRemove.classList.add('hidden');
                imageInput.value = "";
                removeFlag.value = "1";
            }
        </script>
    @endsection
