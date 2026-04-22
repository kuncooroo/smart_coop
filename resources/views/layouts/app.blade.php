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
body { font-family: 'Inter', sans-serif; }
</style>
</head>
<body class="bg-[#F8FAFC] flex h-screen overflow-hidden text-slate-800">

<aside class="w-72 bg-[#121927] text-white flex flex-col transition-all duration-300 shadow-[4px_0_24px_rgba(0,0,0,0.3)] z-20">
    
    <div class="p-8 flex items-center space-x-4">
        <div class="bg-orange-600 w-12 h-12 rounded-full flex items-center justify-center shadow-lg shadow-orange-600/40 ring-4 ring-orange-600/10 transition-transform duration-500 hover:scale-110 hover:rotate-6">
            <i class="fas fa-door-open text-white text-xl"></i>
        </div>
        <div class="flex flex-col">
            <span class="font-extrabold text-2xl tracking-tighter leading-none uppercase">SMARTGATE</span>
            <span class="text-[10px] font-bold text-orange-500 tracking-[0.3em] uppercase mt-1">Automatic Cage</span>
        </div>
    </div>

    <div class="px-8 mt-4 mb-4 flex items-center space-x-2">
        <div class="w-2 h-[2px] bg-orange-600 rounded-full"></div>
        <span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest opacity-80">Dashboard Menu</span>
    </div>

    <nav class="flex-1 px-4 space-y-1.5 overflow-y-auto custom-scrollbar">
        <a href="{{ route('dashboard') }}"
            class="group flex items-center space-x-3 p-3.5 rounded-xl transition-all duration-300 hover:translate-x-2 {{ request()->routeIs('dashboard') ? 'bg-orange-600 text-white shadow-lg shadow-orange-600/30' : 'text-slate-400 hover:bg-slate-800/50 hover:text-white' }}">
            <div class="w-8 flex justify-center">
                <i class="fas fa-th-large text-lg transition-all duration-300 group-hover:scale-125 group-hover:rotate-12"></i>
            </div>
            <span class="font-bold text-sm">Dashboard</span>
        </a>

        <a href="{{ route('monitoring') }}"
            class="group flex items-center space-x-3 p-3.5 rounded-xl transition-all duration-300 hover:translate-x-2 {{ request()->routeIs('monitoring') ? 'bg-orange-600 text-white shadow-lg shadow-orange-600/30' : 'text-slate-400 hover:bg-slate-800/50 hover:text-white' }}">
            <div class="w-8 flex justify-center">
                <i class="fas fa-eye text-lg transition-all duration-300 group-hover:scale-125 group-hover:rotate-12"></i>
            </div>
            <span class="font-bold text-sm">Monitoring Kandang</span>
        </a>

        <a href="{{ route('devices.index') }}"
            class="group flex items-center space-x-3 p-3.5 rounded-xl transition-all duration-300 hover:translate-x-2 {{ request()->routeIs('hardware') ? 'bg-orange-600 text-white shadow-lg shadow-orange-600/30' : 'text-slate-400 hover:bg-slate-800/50 hover:text-white' }}">
            <div class="w-8 flex justify-center">
                <i class="fas fa-microchip text-lg transition-all duration-300 group-hover:scale-125 group-hover:rotate-12"></i>
            </div>
            <span class="font-bold text-sm">Hardware</span>
        </a>

        <a href="{{ route('activity_log') }}"
            class="group flex items-center space-x-3 p-3.5 rounded-xl transition-all duration-300 hover:translate-x-2 {{ request()->routeIs('activity_log') ? 'bg-orange-600 text-white shadow-lg shadow-orange-600/30' : 'text-slate-400 hover:bg-slate-800/50 hover:text-white' }}">
            <div class="w-8 flex justify-center">
                <i class="fas fa-history text-lg transition-all duration-300 group-hover:scale-125 group-hover:rotate-12"></i>
            </div>
            <span class="font-bold text-sm">Activity Log</span>
        </a>

        <a href="{{ route('laporan') }}"
            class="group flex items-center space-x-3 p-3.5 rounded-xl transition-all duration-300 hover:translate-x-2 {{ request()->routeIs('laporan') ? 'bg-orange-600 text-white shadow-lg shadow-orange-600/30' : 'text-slate-400 hover:bg-slate-800/50 hover:text-white' }}">
            <div class="w-8 flex justify-center">
                <i class="fas fa-chart-bar text-lg transition-all duration-300 group-hover:scale-125 group-hover:rotate-12"></i>
            </div>
            <span class="font-bold text-sm">Laporan Data</span>
        </a>
    </nav>

    <div class="p-6 mx-4 mb-6 rounded-2xl bg-slate-800/40 border border-white/5 group transition-all duration-300 hover:bg-red-500/10 hover:border-red-500/20">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="flex items-center justify-center space-x-3 w-full py-1 text-slate-500 group-hover:text-red-500 transition-colors duration-300">
                <i class="fas fa-sign-out-alt rotate-180 transition-transform group-hover:-translate-x-2"></i>
                <span class="text-xs font-black uppercase tracking-widest">Keluar Sistem</span>
            </button>
        </form>
    </div>
</aside>

<main class="flex-1 flex flex-col h-screen overflow-hidden">
    <header class="h-20 bg-white/80 backdrop-blur-md flex items-center justify-between px-10 sticky top-0 z-10 border-b border-slate-100">
        <div class="flex items-center space-x-2 text-sm font-medium text-slate-400">
            <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></div>
            <span class="capitalize">{{ str_replace('.', ' / ', request()->route()->getName()) }}</span>
        </div>
        
        <div class="flex items-center space-x-6">
            <div class="relative cursor-pointer hover:bg-slate-50 p-2 rounded-full transition">
                <i class="far fa-bell text-xl text-slate-400"></i>
                <span class="absolute top-1 right-1 bg-red-500 text-[10px] text-white w-4 h-4 flex items-center justify-center rounded-full border-2 border-white font-bold">3</span>
            </div>
            <div class="flex items-center space-x-3 pl-6 border-l border-slate-100">
                <div class="text-right hidden md:block">
                    <p class="text-xs font-bold text-slate-800 uppercase tracking-tight">
                        {{ Auth::user()->full_name ?? Auth::user()->username }}
                    </p>
                    <p class="text-[10px] font-semibold text-emerald-500 uppercase tracking-wider">
                        {{ Auth::user()->role }} • Online
                    </p>
                </div>
                
                @if(Auth::user()->profile_image)
                    <img src="{{ asset('storage/' . Auth::user()->profile_image) }}" 
                         alt="Profile" 
                         class="w-10 h-10 rounded-xl object-cover border border-slate-200">
                @else
                    <div class="w-10 h-10 rounded-xl bg-slate-900 flex items-center justify-center font-bold text-white border border-slate-800 shadow-lg shadow-slate-200 uppercase">
                        @php
                            $name = Auth::user()->full_name ?? Auth::user()->username;
                            $initials = collect(explode(' ', $name))->map(fn($n) => mb_substr($n, 0, 1))->take(2)->join('');
                        @endphp
                        {{ $initials }}
                    </div>
                @endif
            </div>
        </div>
    </header>

    <div class="flex-1 p-10 overflow-y-auto bg-[#F8FAFC]">
        @yield('content')
    </div>
</main>


</body>
</html>