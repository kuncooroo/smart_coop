@extends('layouts.admin')
@section('title', 'Edit Pengguna')

@section('content')
    <div class="w-full mb-6 flex items-center justify-between">
        <div class="flex items-center">
            <a href="{{ route('admin.user.index') }}"
                class="mr-4 bg-white text-slate-400 w-10 h-10 rounded-xl flex items-center justify-center shadow-sm border border-slate-100 hover:text-rose-500 transition-all">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h2 class="text-2xl font-bold text-slate-800 tracking-tight">Edit Profile Pengguna</h2>
        </div>
    </div>

    <div class="w-full bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-6 border-b border-slate-50 bg-slate-50/30">
            <h3 class="text-xs font-bold text-slate-400 uppercase tracking-[0.2em]">Informasi Kredensial & Profil</h3>
        </div>

        @if ($errors->any())
            <div class="m-6 bg-rose-50 text-rose-600 p-4 rounded-xl border border-rose-100">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li class="text-[10px] font-black uppercase tracking-tight">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.user.update', $user->id) }}" method="POST" enctype="multipart/form-data" class="p-8">
            @csrf
            @method('PUT')

            <div class="flex flex-col lg:flex-row gap-12">
                <div class="w-full lg:w-72 flex flex-col">
                    <div class="relative group">
                        <div class="w-full aspect-square rounded-3xl bg-slate-50 border-2 border-dashed border-slate-200 flex flex-col items-center justify-center overflow-hidden relative transition-all group-hover:border-rose-300 shadow-inner">
                            
                            <img id="preview-img"
                                src="{{ $user->profile ? asset('storage/' . $user->profile) : 'https://ui-avatars.com/api/?name=' . urlencode($user->nama_lengkap) . '&background=FFF1F2&color=E11D48&bold=true' }}"
                                class="w-full h-full object-cover">

                            <div class="absolute inset-0 bg-slate-900/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all">
                                <label for="profile" class="cursor-pointer bg-white text-rose-600 p-3 rounded-full shadow-xl hover:scale-110 transition-transform">
                                    <i class="fas fa-camera"></i>
                                </label>
                            </div>
                        </div>
                        
                        <input type="file" name="profile" id="profile" class="hidden" accept="image/*">
                        <p class="text-center text-[10px] text-slate-400 mt-4 font-bold uppercase tracking-tighter">
                            Ubah Foto Profile
                        </p>
                    </div>

                    <div class="mt-6 p-4 bg-rose-50/50 rounded-2xl border border-rose-100 flex flex-col items-center">
                        <span class="text-[9px] font-black text-rose-400 uppercase tracking-widest mb-1">Status Akun</span>
                        <span class="text-xs font-bold text-rose-600 uppercase">Verified User</span>
                    </div>
                </div>

                <div class="flex-1 flex flex-col justify-between">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-10 gap-y-8">

                        <div class="space-y-1 border-b border-slate-200 pb-2 focus-within:border-rose-500 transition-all">
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest">Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', $user->nama_lengkap) }}"
                                class="w-full py-1 bg-transparent focus:outline-none text-lg text-slate-700 font-semibold"
                                placeholder="John Doe" required>
                        </div>

                        <div class="space-y-1 border-b border-slate-200 pb-2 focus-within:border-rose-500 transition-all">
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest">Username</label>
                            <input type="text" name="username" value="{{ old('username', $user->username) }}"
                                class="w-full py-1 bg-transparent focus:outline-none text-lg text-slate-700 font-semibold"
                                placeholder="johndoe" required>
                        </div>

                        <div class="space-y-1 border-b border-slate-200 pb-2 focus-within:border-rose-500 transition-all">
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest">Email Address</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                class="w-full py-1 bg-transparent focus:outline-none text-lg text-slate-700 font-semibold"
                                placeholder="email@example.com" required>
                        </div>

                        <div class="space-y-1 border-b border-slate-200 pb-2 focus-within:border-rose-500 transition-all">
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest">No. Handphone</label>
                            <input type="text" name="no_hp" value="{{ old('no_hp', $user->no_hp) }}"
                                class="w-full py-1 bg-transparent focus:outline-none text-lg text-slate-700 font-semibold"
                                placeholder="0812xxxx">
                        </div>

                        <div class="space-y-1 border-b border-slate-200 pb-2 focus-within:border-rose-500 transition-all">
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest">Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="w-full py-1 bg-transparent focus:outline-none text-lg text-slate-700 font-semibold appearance-none cursor-pointer">
                                <option value="L" {{ $user->jenis_kelamin == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="P" {{ $user->jenis_kelamin == 'P' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>

                        <div class="space-y-1 border-b border-slate-200 pb-2 bg-slate-50/50 px-2 rounded-t-lg">
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest">Aktivitas Terakhir</label>
                            <div class="flex items-center justify-between">
                                <span class="text-sm font-bold text-slate-500 py-1">
                                    {{ $user->last_login ? \Carbon\Carbon::parse($user->last_login)->diffForHumans() : 'Belum pernah login' }}
                                </span>
                                <i class="fas fa-history text-slate-300 text-xs"></i>
                            </div>
                        </div>

                        <div class="space-y-1 border-b border-slate-200 pb-2 focus-within:border-rose-500 transition-all md:col-span-2">
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest">Alamat Lengkap</label>
                            <textarea name="alamat_lengkap" rows="2" 
                                class="w-full py-1 bg-transparent focus:outline-none text-sm text-slate-700 font-semibold resize-none"
                                placeholder="Jl. Nama Jalan No. 123...">{{ old('alamat_lengkap', $user->alamat_lengkap) }}</textarea>
                        </div>
                    </div>

                    <div class="mt-12 flex justify-end gap-4">
                        <a href="{{ route('admin.user.index') }}"
                            class="bg-slate-100 hover:bg-slate-200 text-slate-500 font-bold py-4 px-8 rounded-2xl transition text-[10px] uppercase tracking-widest">
                            Batal
                        </a>
                        <button type="submit"
                            class="bg-rose-600 hover:bg-rose-700 text-white font-bold py-4 px-12 rounded-2xl transition shadow-lg shadow-rose-200 text-xs uppercase tracking-widest">
                            Simpan Perubahan
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        const imageInput = document.getElementById('profile');
        const previewImg = document.getElementById('preview-img');

        imageInput.onchange = evt => {
            const [file] = imageInput.files;
            if (file) {
                previewImg.src = URL.createObjectURL(file);
            }
        }
    </script>
@endsection