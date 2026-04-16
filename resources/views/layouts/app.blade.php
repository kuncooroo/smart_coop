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

<aside class="w-72 bg-[#121927] text-white flex flex-col transition-all duration-300">
    <div class="p-8 flex items-center space-x-3">
        <div class="bg-orange-500 p-2 rounded-lg shadow-lg shadow-orange-500/20">
            <i class="fas fa-bolt text-white text-xl"></i>
        </div>
        <span class="font-bold text-2xl tracking-tighter">SMARTGATE</span>
    </div>

    <div class="px-6 mb-4 text-[10px] font-bold text-slate-500 uppercase tracking-widest">
        Menu Utama
    </div>

    <nav class="flex-1 px-4 space-y-2 overflow-y-auto">
        <a href="{{ route('dashboard') }}"
            class="flex items-center space-x-3 p-3.5 rounded-xl transition {{ request()->routeIs('dashboard') ? 'bg-orange-600 text-white shadow-lg shadow-orange-600/20' : 'text-slate-400 hover:bg-slate-800/50' }}">
            <i class="fas fa-th-large w-5"></i>
            <span class="font-medium">Dashboard</span>
        </a>
        
        <a href="{{ route('monitoring') }}"
            class="flex items-center space-x-3 p-3.5 rounded-xl transition {{ request()->routeIs('monitoring') ? 'bg-orange-600 text-white shadow-lg shadow-orange-600/20' : 'text-slate-400 hover:bg-slate-800/50' }}">
            <i class="fas fa-eye w-5"></i>
            <span class="font-medium">Monitoring Kandang</span>
        </a>

        <a href="{{ route('hardware') }}"
            class="flex items-center space-x-3 p-3.5 rounded-xl transition {{ request()->routeIs('hardware') ? 'bg-orange-600 text-white shadow-lg shadow-orange-600/20' : 'text-slate-400 hover:bg-slate-800/50' }}">
            <i class="fas fa-microchip w-5"></i>
            <span class="font-medium">Hardware</span>
        </a>

        <a href="{{ route('activity_log') }}"
            class="flex items-center space-x-3 p-3.5 rounded-xl transition {{ request()->routeIs('activity_log') ? 'bg-orange-600 text-white shadow-lg shadow-orange-600/20' : 'text-slate-400 hover:bg-slate-800/50' }}">
            <i class="fas fa-history w-5"></i>
            <span class="font-medium">Activity Log</span>
        </a>

        <a href="{{ route('laporan') }}"
            class="flex items-center space-x-3 p-3.5 rounded-xl transition {{ request()->routeIs('laporan') ? 'bg-orange-600 text-white shadow-lg shadow-orange-600/20' : 'text-slate-400 hover:bg-slate-800/50' }}">
            <i class="fas fa-chart-bar w-5"></i>
            <span class="font-medium">Laporan Data</span>
        </a>
    </nav>

    <div class="p-6 border-t border-slate-800">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="flex items-center space-x-3 text-slate-400 hover:text-red-400 transition w-full group">
                <i class="fas fa-sign-out-alt rotate-180 group-hover:-translate-x-1 transition-transform"></i>
                <span class="font-medium">Keluar</span>
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