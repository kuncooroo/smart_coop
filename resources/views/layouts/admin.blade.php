<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - ADMIN SMARTGATE</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Inter', sans-serif;
        }

        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
        }
    </style>
</head>

<body class="bg-[#F1F5F9] flex h-screen overflow-hidden text-slate-800">

    <aside class="w-72 bg-[#0F172A] text-white flex flex-col transition-all duration-300 shadow-[4px_0_24px_rgba(0,0,0,0.4)] z-20">

        <div class="p-8 flex items-center space-x-4">
            <div class="bg-rose-600 w-12 h-12 rounded-2xl flex items-center justify-center shadow-lg shadow-rose-600/40 ring-4 ring-rose-600/10 transition-transform duration-500 hover:scale-110 hover:rotate-3">
                <i class="fas fa-user-shield text-white text-xl"></i>
            </div>
            <div class="flex flex-col">
                <span class="font-extrabold text-xl tracking-tighter leading-none uppercase">ADMIN</span>
                <span class="text-[10px] font-bold text-rose-500 tracking-[0.2em] uppercase mt-1">Smartgate Panel</span>
            </div>
        </div>

        <div class="px-8 mt-4 mb-4 flex items-center space-x-2">
            <div class="w-2 h-[2px] bg-rose-600 rounded-full"></div>
            <span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest opacity-80">Management System</span>
        </div>

        <nav class="flex-1 px-4 space-y-1.5 overflow-y-auto custom-scrollbar">
            
            <a href="{{ route('admin.dashboard') }}"
                class="group flex items-center space-x-3 p-3.5 rounded-xl transition-all duration-300 hover:translate-x-2 {{ request()->routeIs('admin.dashboard') ? 'bg-rose-600 text-white shadow-lg shadow-rose-600/30' : 'text-slate-400 hover:bg-slate-800/50 hover:text-white' }}">
                <div class="w-8 flex justify-center">
                    <i class="fas fa-chart-pie text-lg transition-all duration-300 group-hover:scale-125"></i>
                </div>
                <span class="font-bold text-sm">Dashboard</span>
            </a>

            <a href="{{ route('admin.user.index') }}"
                class="group flex items-center space-x-3 p-3.5 rounded-xl transition-all duration-300 hover:translate-x-2 {{ request()->routeIs('admin.user.*') ? 'bg-rose-600 text-white shadow-lg shadow-rose-600/30' : 'text-slate-400 hover:bg-slate-800/50 hover:text-white' }}">
                <div class="w-8 flex justify-center">
                    <i class="fas fa-users text-lg transition-all duration-300 group-hover:scale-125"></i>
                </div>
                <span class="font-bold text-sm">Manajemen User</span>
            </a>

            <a href="{{ route('admin.device.index') }}"
                class="group flex items-center space-x-3 p-3.5 rounded-xl transition-all duration-300 hover:translate-x-2 {{ request()->routeIs('admin.device.*') ? 'bg-rose-600 text-white shadow-lg shadow-rose-600/30' : 'text-slate-400 hover:bg-slate-800/50 hover:text-white' }}">
                <div class="w-8 flex justify-center">
                    <i class="fas fa-microchip text-lg transition-all duration-300 group-hover:scale-125"></i>
                </div>
                <span class="font-bold text-sm">Master Device</span>
            </a>

            <a href="{{ route('admin.kandang.index') }}"
                class="group flex items-center space-x-3 p-3.5 rounded-xl transition-all duration-300 hover:translate-x-2 {{ request()->routeIs('admin.kandang.*') ? 'bg-rose-600 text-white shadow-lg shadow-rose-600/30' : 'text-slate-400 hover:bg-slate-800/50 hover:text-white' }}">
                <div class="w-8 flex justify-center">
                    <i class="fas fa-house-chimney text-lg transition-all duration-300 group-hover:scale-125"></i>
                </div>
                <span class="font-bold text-sm">Data Kandang</span>
            </a>

            @if (auth()->guard('admin')->user()->isSuperAdmin())
            <div class="pt-4 pb-2 px-4">
                <span class="text-[9px] font-black text-slate-600 uppercase tracking-[0.2em]">Super Admin Only</span>
            </div>
            <a href="{{ route('admin.admin.index') }}"
                class="group flex items-center space-x-3 p-3.5 rounded-xl transition-all duration-300 hover:translate-x-2 {{ request()->routeIs('admin.admin.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/30' : 'text-slate-400 hover:bg-slate-800/50 hover:text-white' }}">
                <div class="w-8 flex justify-center">
                    <i class="fas fa-shield-alt text-lg transition-all duration-300 group-hover:scale-125"></i>
                </div>
                <span class="font-bold text-sm">Kelola Admin</span>
            </a>
            @endif
        </nav>

        <div class="p-6 mx-4 mb-6 rounded-2xl bg-slate-900/50 border border-white/5 group transition-all duration-300 hover:bg-rose-500/10 hover:border-rose-500/20">
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit"
                    class="flex items-center justify-center space-x-3 w-full py-1 text-slate-500 group-hover:text-rose-500 transition-colors duration-300">
                    <i class="fas fa-power-off transition-transform group-hover:rotate-90"></i>
                    <span class="text-xs font-black uppercase tracking-widest">Logout Admin</span>
                </button>
            </form>
        </div>
    </aside>

    <main class="flex-1 flex flex-col h-screen overflow-hidden">
        <header class="h-20 bg-white flex items-center justify-between px-10 sticky top-0 z-30 border-b border-slate-200">
            <div class="flex items-center space-x-2">
                <div class="w-2 h-2 bg-rose-600 rounded-full animate-pulse"></div>
                <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">
                    System Administrator Access
                </span>
            </div>

            <div class="flex items-center space-x-6">
                <div class="text-right hidden md:block">
                    <p class="text-sm font-bold text-slate-800 leading-none">
                        {{ auth()->guard('admin')->user()->name }}
                    </p>
                    <p class="text-[10px] font-semibold text-rose-500 uppercase tracking-tighter mt-1">
                        {{ auth()->guard('admin')->user()->role_name ?? 'Administrator' }}
                    </p>
                </div>
                
                <div class="relative group">
                    <div class="w-11 h-11 rounded-xl bg-slate-100 border-2 border-slate-200 flex items-center justify-center text-slate-400 group-hover:border-rose-300 transition-all cursor-pointer">
                        <i class="fas fa-user-gear text-lg"></i>
                    </div>
                </div>
            </div>
        </header>

        <div class="flex-1 p-10 overflow-y-auto custom-scrollbar bg-[#F8FAFC]">
            @yield('content')
        </div>
    </main>

</body>

</html>