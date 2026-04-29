<!DOCTYPE html>

<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - SMARTGATE</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-[#F8FAFC] flex h-screen overflow-hidden text-slate-800">

    <aside
        class="w-72 bg-[#121927] text-white flex flex-col transition-all duration-300 shadow-[4px_0_24px_rgba(0,0,0,0.3)] z-20">

        <div class="p-8 flex items-center space-x-4">
            <div
                class="bg-orange-600 w-12 h-12 rounded-full flex items-center justify-center shadow-lg shadow-orange-600/40 ring-4 ring-orange-600/10 transition-transform duration-500 hover:scale-110 hover:rotate-6">
                <i class="fas fa-door-open text-white text-xl"></i>
            </div>
            <div class="flex flex-col">
                <span class="font-extrabold text-2xl tracking-tighter leading-none uppercase">SMARTGATE</span>
                <span class="text-[10px] font-bold text-orange-500 tracking-[0.3em] uppercase mt-1">Automatic
                    Cage</span>
            </div>
        </div>

        <div class="px-8 mt-4 mb-4 flex items-center space-x-2">
            <div class="w-2 h-[2px] bg-orange-600 rounded-full"></div>
            <span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest opacity-80">Dashboard
                Menu</span>
        </div>

        <nav class="flex-1 px-4 space-y-1.5 overflow-y-auto custom-scrollbar">
            <a href="{{ route('dashboard') }}"
                class="group flex items-center space-x-3 p-3.5 rounded-xl transition-all duration-300 hover:translate-x-2 {{ request()->routeIs('dashboard') ? 'bg-orange-600 text-white shadow-lg shadow-orange-600/30' : 'text-slate-400 hover:bg-slate-800/50 hover:text-white' }}">
                <div class="w-8 flex justify-center">
                    <i
                        class="fas fa-th-large text-lg transition-all duration-300 group-hover:scale-125 group-hover:rotate-12"></i>
                </div>
                <span class="font-bold text-sm">Dashboard</span>
            </a>

            <a href="{{ route('monitoring.index') }}"
                class="group flex items-center space-x-3 p-3.5 rounded-xl transition-all duration-300 hover:translate-x-2 {{ request()->routeIs('monitoring') ? 'bg-orange-600 text-white shadow-lg shadow-orange-600/30' : 'text-slate-400 hover:bg-slate-800/50 hover:text-white' }}">
                <div class="w-8 flex justify-center">
                    <i
                        class="fas fa-eye text-lg transition-all duration-300 group-hover:scale-125 group-hover:rotate-12"></i>
                </div>
                <span class="font-bold text-sm">Monitoring Kandang</span>
            </a>

            <a href="{{ route('devices.index') }}"
                class="group flex items-center space-x-3 p-3.5 rounded-xl transition-all duration-300 hover:translate-x-2 {{ request()->routeIs('hardware') ? 'bg-orange-600 text-white shadow-lg shadow-orange-600/30' : 'text-slate-400 hover:bg-slate-800/50 hover:text-white' }}">
                <div class="w-8 flex justify-center">
                    <i
                        class="fas fa-microchip text-lg transition-all duration-300 group-hover:scale-125 group-hover:rotate-12"></i>
                </div>
                <span class="font-bold text-sm">Device</span>
            </a>

            <a href="{{ route('activity_log') }}"
                class="group flex items-center space-x-3 p-3.5 rounded-xl transition-all duration-300 hover:translate-x-2 {{ request()->routeIs('activity_log') ? 'bg-orange-600 text-white shadow-lg shadow-orange-600/30' : 'text-slate-400 hover:bg-slate-800/50 hover:text-white' }}">
                <div class="w-8 flex justify-center">
                    <i
                        class="fas fa-history text-lg transition-all duration-300 group-hover:scale-125 group-hover:rotate-12"></i>
                </div>
                <span class="font-bold text-sm">Log Aktifitas</span>
            </a>

            <a href="{{ route('laporan.index') }}"
                class="group flex items-center space-x-3 p-3.5 rounded-xl transition-all duration-300 hover:translate-x-2 {{ request()->routeIs('laporan') ? 'bg-orange-600 text-white shadow-lg shadow-orange-600/30' : 'text-slate-400 hover:bg-slate-800/50 hover:text-white' }}">
                <div class="w-8 flex justify-center">
                    <i
                        class="fas fa-chart-bar text-lg transition-all duration-300 group-hover:scale-125 group-hover:rotate-12"></i>
                </div>
                <span class="font-bold text-sm">Analisis & Laporan Data</span>
            </a>
        </nav>

        <div
            class="p-6 mx-4 mb-6 rounded-2xl bg-slate-800/40 border border-white/5 group transition-all duration-300 hover:bg-red-500/10 hover:border-red-500/20">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit"
                    class="flex items-center justify-center space-x-3 w-full py-1 text-slate-500 group-hover:text-red-500 transition-colors duration-300">
                    <i class="fas fa-sign-out-alt rotate-180 transition-transform group-hover:-translate-x-2"></i>
                    <span class="text-xs font-black uppercase tracking-widest">Keluar Sistem</span>
                </button>
            </form>
        </div>
    </aside>

    <main class="flex-1 flex flex-col h-screen overflow-hidden">
        <header
            class="h-20 bg-white/70 backdrop-blur-xl flex items-center justify-between px-10 sticky top-0 z-30 border-b border-slate-200/60">
            <div class="flex items-center space-x-4">


                <span class="text-xs font-semibold text-slate-400 capitalize tracking-wide flex items-center">
                    <i class="fas fa-home text-[10px] mr-2 opacity-50"></i>
                    @php
                        $routeName = request()->route()->getName();
                        $cleanName = explode('.', $routeName)[0];
                    @endphp
                    {{ $cleanName }}
                </span>
            </div>

            <div class="flex items-center space-x-6">
                <div x-data="{ openNotif: false }" class="relative">

                    <button @click="openNotif = !openNotif"
                        class="relative group p-2.5 rounded-xl hover:bg-slate-100 transition-all duration-300">

                        <i class="far fa-bell text-xl text-slate-400 group-hover:text-orange-600 transition-colors"></i>

                        @if (notif_count() > 0)
                            <span
                                class="absolute top-2 right-2 bg-orange-600 text-[9px] text-white w-4 h-4 flex items-center justify-center rounded-full border-2 border-white font-black shadow-sm">
                                {{ notif_count() }}
                            </span>
                        @endif
                    </button>

                    <div x-show="openNotif" @click.away="openNotif = false"
                        class="absolute right-0 mt-3 w-80 bg-white rounded-2xl shadow-xl border p-4 z-50">

                        <div class="flex justify-between items-center mb-3">
                            <h3 class="text-sm font-bold">Notifikasi</h3>

                            <form action="{{ route('notif.read') }}" method="POST">
                                @csrf
                                <button class="text-xs text-orange-600 font-semibold">
                                    Tandai semua
                                </button>
                            </form>
                        </div>

                        <div class="max-h-64 overflow-y-auto space-y-2">

                            @forelse(user_notifications() as $notif)
                                <div class="p-3 rounded-lg bg-slate-50 hover:bg-orange-50 transition">
                                    <p class="text-sm font-semibold">
                                        {{ $notif->data['title'] ?? '-' }}
                                    </p>
                                    <p class="text-xs text-slate-500">
                                        {{ $notif->data['message'] ?? '-' }}
                                    </p>
                                </div>
                            @empty
                                <p class="text-xs text-slate-400 text-center">
                                    Tidak ada notifikasi
                                </p>
                            @endforelse

                        </div>
                    </div>
                </div>

                <div class="h-8 w-[1px] bg-slate-100"></div>

                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" @click.away="open = false"
                        class="flex items-center space-x-3 group focus:outline-none p-1.5 pr-3 rounded-2xl hover:bg-slate-50 transition-all duration-300">

                        <div class="relative">
                            @if (Auth::user()->profile)
                                <img src="{{ asset('storage/' . Auth::user()->profile) }}"
                                    class="w-10 h-10 rounded-xl object-cover ring-2 ring-white shadow-md group-hover:ring-orange-100 transition-all">
                            @else
                                <div
                                    class="w-10 h-10 rounded-xl bg-gradient-to-br from-slate-800 to-slate-900 flex items-center justify-center font-bold text-white ring-2 ring-white shadow-md uppercase text-xs tracking-tighter">
                                    @php
                                        $name = Auth::user()->full_name ?? Auth::user()->username;
                                        $initials = collect(explode(' ', $name))
                                            ->map(fn($n) => mb_substr($n, 0, 1))
                                            ->take(2)
                                            ->join('');
                                    @endphp
                                    {{ $initials }}
                                </div>
                            @endif
                            <div
                                class="absolute -bottom-1 -right-1 w-3.5 h-3.5 bg-emerald-500 border-2 border-white rounded-full">
                            </div>
                        </div>

                        <div class="text-left hidden sm:block">
                            <p
                                class="text-sm font-black text-slate-800 leading-none group-hover:text-orange-600 transition-colors">
                                {{ Auth::user()->nama_lengkap ?? Auth::user()->username }}
                            </p>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">
                                {{ Auth::user()->role }}
                            </p>
                        </div>

                        <i class="fas fa-chevron-down text-[10px] text-slate-300 transition-transform duration-300"
                            :class="open ? 'rotate-180' : ''"></i>
                    </button>

                    <div x-show="open" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                        x-transition:leave-end="opacity-0 scale-95 translate-y-2"
                        class="absolute right-0 mt-3 w-56 bg-white rounded-2xl shadow-2xl shadow-slate-200/50 border border-slate-100 py-2 z-50">

                        <div class="px-4 py-3 border-b border-slate-50 mb-2">
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Akun Saya</p>
                        </div>

                        <a href="{{ route('profile.edit') }}"
                            class="flex items-center space-x-3 px-4 py-2.5 text-sm font-semibold text-slate-600 hover:bg-orange-50 hover:text-orange-600 transition-colors">
                            <i class="far fa-user-circle text-lg opacity-50"></i>
                            <span>Edit Profil</span>
                        </a>

                        <a href="#"
                            class="flex items-center space-x-3 px-4 py-2.5 text-sm font-semibold text-slate-600 hover:bg-orange-50 hover:text-orange-600 transition-colors">
                            <i class="far fa-question-circle text-lg opacity-50"></i>
                            <span>Bantuan</span>
                        </a>
                    </div>
                </div>
            </div>
        </header>

        <div class="flex-1 p-10 overflow-y-auto bg-[#F8FAFC]">
            @yield('content')
        </div>
    </main>


</body>

</html>
