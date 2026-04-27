@extends('layouts.public')
@section('title', 'Edit Profil Pengguna')

@section('content')
    <div class="w-full mb-6 flex items-center justify-between">
        <div class="flex items-center">
            <a href="{{ route('dashboard') }}"
                class="mr-4 bg-white text-slate-400 w-10 h-10 rounded-xl flex items-center justify-center shadow-sm border border-slate-100 hover:text-orange-500 transition-all">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h2 class="text-2xl font-bold text-slate-800 tracking-tight">Pengaturan Profil</h2>
                <p class="text-xs text-slate-400 font-medium">Kelola informasi akun dan data diri Anda</p>
            </div>
        </div>
    </div>

    <div class="w-full bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-6 border-b border-slate-50 bg-slate-50/30">
            <h3 class="text-xs font-bold text-slate-400 uppercase tracking-[0.2em]">Informasi Akun & Pribadi</h3>
        </div>

        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="p-8">
            @csrf
            @method('PUT')
            <div class="flex flex-col lg:flex-row gap-12">

                <div class="w-full lg:w-72">
                    <div class="relative group">
                        <div class="w-full aspect-square rounded-3xl bg-slate-50 border-2 border-dashed border-slate-200 flex flex-col items-center justify-center overflow-hidden relative transition-all group-hover:border-orange-300">
                            
                            <div id="previewContainer" class="w-full h-full flex items-center justify-center">
                                @if (Auth::user()->profile)
                                    <img id="previewFoto" src="{{ asset('storage/' . Auth::user()->profile) }}" class="w-full h-full object-cover">
                                @else
                                    <div id="previewFallback" class="flex flex-col items-center">
                                        <i class="fas fa-user text-3xl text-slate-200 mb-2"></i>
                                        <span class="text-[10px] text-slate-400 font-bold uppercase">Foto Profil</span>
                                    </div>
                                @endif
                            </div>

                            <div class="absolute inset-0 bg-slate-900/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all">
                                <label for="profile" class="cursor-pointer bg-white text-slate-900 p-3 rounded-full shadow-xl hover:scale-110 transition-transform">
                                    <i class="fas fa-camera"></i>
                                </label>
                            </div>
                        </div>
                        <input type="file" name="profile" id="profile" class="hidden" onchange="previewImage(this)" accept="image/*">
                        <p class="text-center text-[10px] text-slate-400 mt-3 font-bold uppercase tracking-tighter">*Klik ikon kamera untuk ubah foto</p>
                    </div>
                </div>

                <div class="flex-1">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-10 gap-y-8">

                        {{-- Input Username --}}
                        <div class="space-y-1 border-b border-slate-200 pb-2 focus-within:border-orange-500 transition-all">
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest">Username</label>
                            <div class="flex items-center justify-between">
                                <input type="text" name="username" value="{{ old('username', Auth::user()->username) }}"
                                    class="w-full py-1 bg-transparent focus:outline-none text-lg text-slate-700 font-semibold uppercase" placeholder="USERNAME" required>
                                <i class="fas fa-at text-slate-400 text-xl"></i>
                            </div>
                            @error('username')
                                <p class="text-rose-500 text-[10px] mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Input Nama Lengkap --}}
                        <div class="space-y-1 border-b border-slate-200 pb-2 focus-within:border-orange-500 transition-all">
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest">Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', Auth::user()->nama_lengkap) }}"
                                class="w-full py-1 bg-transparent focus:outline-none text-lg text-slate-700 font-semibold uppercase" placeholder="NAMA LENGKAP" required>
                        </div>

                        {{-- Nomor WhatsApp --}}
                        <div class="space-y-1 border-b border-slate-200 pb-2 focus-within:border-orange-500 transition-all">
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest">Nomor WhatsApp</label>
                            <div class="flex items-center justify-between">
                                <input type="text" name="no_hp" value="{{ old('no_hp', Auth::user()->no_hp) }}"
                                    class="w-full py-1 bg-transparent focus:outline-none text-lg text-slate-700 font-semibold uppercase" placeholder="0812xxxx">
                                <i class="fab fa-whatsapp text-slate-400 text-xl"></i>
                            </div>
                        </div>

                        {{-- Jenis Kelamin --}}
                        <div class="space-y-1 border-b border-slate-200 pb-2 focus-within:border-orange-500 transition-all">
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest">Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="w-full py-1 bg-transparent focus:outline-none text-lg text-slate-700 font-semibold appearance-none cursor-pointer">
                                <option value="L" {{ Auth::user()->jenis_kelamin == 'L' ? 'selected' : '' }}>LAKI-LAKI</option>
                                <option value="P" {{ Auth::user()->jenis_kelamin == 'P' ? 'selected' : '' }}>PEREMPUAN</option>
                            </select>
                        </div>

                        {{-- Input Wilayah --}}
                        <div class="space-y-1 border-b border-slate-200 pb-2 focus-within:border-orange-500 transition-all">
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest">Provinsi</label>
                            <input list="list-provinsi" id="provinsi_input" class="w-full py-1 bg-transparent focus:outline-none text-lg text-slate-700 font-semibold uppercase" placeholder="CARI PROVINSI..." autocomplete="off">
                            <input type="hidden" name="provinsi_id" id="provinsi_id">
                            <datalist id="list-provinsi"></datalist>
                        </div>

                        <div class="space-y-1 border-b border-slate-200 pb-2 focus-within:border-orange-500 transition-all">
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest">Kota/Kabupaten</label>
                            <input list="list-kota" id="kota_input" class="w-full py-1 bg-transparent focus:outline-none text-lg text-slate-700 font-semibold uppercase" placeholder="CARI KOTA..." autocomplete="off">
                            <input type="hidden" name="kota_id" id="kota_id">
                            <datalist id="list-kota"></datalist>
                        </div>

                        <div class="space-y-1 border-b border-slate-200 pb-2 focus-within:border-orange-500 transition-all md:col-span-2">
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest">Kecamatan</label>
                            <input list="list-kecamatan" id="kecamatan_input" class="w-full py-1 bg-transparent focus:outline-none text-lg text-slate-700 font-semibold uppercase" placeholder="CARI KECAMATAN..." autocomplete="off">
                            <input type="hidden" name="kecamatan_id" id="kecamatan_id">
                            <datalist id="list-kecamatan"></datalist>
                        </div>

                        <div class="space-y-1 border-b border-slate-200 pb-2 focus-within:border-orange-500 transition-all md:col-span-2">
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest">Alamat Lengkap</label>
                            <textarea name="alamat_lengkap" rows="2" class="w-full py-1 bg-transparent focus:outline-none text-lg text-slate-700 font-semibold uppercase" placeholder="JL. CONTOH NO. 123...">{{ Auth::user()->alamat_lengkap }}</textarea>
                        </div>
                    </div>

                    <div class="mt-12 flex justify-end gap-4">
                        <a href="{{ route('dashboard') }}" class="px-8 py-3 rounded-xl text-sm font-bold text-slate-400 hover:text-slate-600 transition-all uppercase tracking-widest">
                            Batal
                        </a>
                        <button type="submit" class="bg-[#002855] hover:bg-orange-600 text-white font-bold py-3 px-10 rounded-xl transition shadow-lg text-sm uppercase tracking-widest">
                            Simpan Perubahan
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        // JS Wilayah
        let mapProvinsi = {};
        let mapKota = {};
        let mapKecamatan = {};

        async function loadProvinsi() {
            const datalist = document.getElementById('list-provinsi');
            try {
                let res = await fetch("{{ url('/api/provinsi') }}");
                let data = await res.json();
                data.forEach(p => {
                    let option = document.createElement('option');
                    option.value = p.name.toUpperCase();
                    datalist.appendChild(option);
                    mapProvinsi[p.name.toUpperCase()] = p.id;
                });
            } catch (e) { console.error("Gagal load provinsi"); }
        }

        document.getElementById('provinsi_input').addEventListener('input', async function() {
            let id = mapProvinsi[this.value.toUpperCase()];
            if (id) {
                document.getElementById('provinsi_id').value = id;
                const datalistKota = document.getElementById('list-kota');
                datalistKota.innerHTML = '';
                let res = await fetch("{{ url('/api/kota') }}/" + id);
                let data = await res.json();
                data.forEach(k => {
                    let option = document.createElement('option');
                    option.value = k.name.toUpperCase();
                    datalistKota.appendChild(option);
                    mapKota[k.name.toUpperCase()] = k.id;
                });
            }
        });

        document.getElementById('kota_input').addEventListener('input', async function() {
            let id = mapKota[this.value.toUpperCase()];
            if (id) {
                document.getElementById('kota_id').value = id;
                const datalistKec = document.getElementById('list-kecamatan');
                datalistKec.innerHTML = '';
                let res = await fetch("{{ url('/api/kecamatan') }}/" + id);
                let data = await res.json();
                data.forEach(k => {
                    let option = document.createElement('option');
                    option.value = k.name.toUpperCase();
                    datalistKec.appendChild(option);
                    mapKecamatan[k.name.toUpperCase()] = k.id;
                });
            }
        });

        document.getElementById('kecamatan_input').addEventListener('input', function() {
            let id = mapKecamatan[this.value.toUpperCase()];
            if (id) document.getElementById('kecamatan_id').value = id;
        });

        function previewImage(input) {
            const container = document.getElementById('previewContainer');
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    container.innerHTML = `<img id="previewFoto" src="${e.target.result}" class="w-full h-full object-cover">`;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        document.addEventListener('DOMContentLoaded', loadProvinsi);
    </script>
@endsection