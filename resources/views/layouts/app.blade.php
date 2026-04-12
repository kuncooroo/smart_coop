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

    <!-- Sidebar -->
    <aside class="w-72 bg-[#121927] text-white flex flex-col transition-all duration-300">
        <!-- Logo Section -->
        <div class="p-8 flex items-center space-x-3">
            <div class="bg-orange-500 p-2 rounded-lg">
                <i class="fas fa-bolt text-white text-xl"></i>
            </div>
            <span class="font-bold text-2xl tracking-tighter">SMARTGATE</span>
        </div>

        <div class="px-6 mb-4 text-[10px] font-bold text-slate-500 uppercase tracking-widest">
            Menu Utama
        </div>

        <nav class="flex-1 px-4 space-y-2 overflow-y-auto">
            <a href="{{ route('dashboard') }}"
                class="flex items-center space-x-3 p-3.5 rounded-xl transition {{ request()->routeIs('dashboard') ? 'bg-orange-600 text-white' : 'text-slate-400 hover:bg-slate-800/50' }}">
                <i class="fas fa-th-large w-5"></i>
                <span class="font-medium">Dashboard</span>
            </a>
            
            <a href="{{ route('monitoring') }}"
                class="flex items-center space-x-3 p-3.5 rounded-xl transition {{ request()->routeIs('monitoring') ? 'bg-orange-600 text-white' : 'text-slate-400 hover:bg-slate-800/50' }}">
                <i class="fas fa-eye w-5"></i>
                <span class="font-medium">Monitoring Kandang</span>
            </a>

            <a href="{{ route('hardware') }}"
                class="flex items-center space-x-3 p-3.5 rounded-xl transition {{ request()->routeIs('hardware') ? 'bg-orange-600 text-white' : 'text-slate-400 hover:bg-slate-800/50' }}">
                <i class="fas fa-microchip w-5"></i>
                <span class="font-medium">Hardware</span>
            </a>

            <a href="{{ route('activity_log') }}"
                class="flex items-center space-x-3 p-3.5 rounded-xl transition {{ request()->routeIs('activity-log') ? 'bg-orange-600 text-white' : 'text-slate-400 hover:bg-slate-800/50' }}">
                <i class="fas fa-history w-5"></i>
                <span class="font-medium">Activity Log</span>
            </a>

            <a href="{{ route('laporan') }}"
                class="flex items-center space-x-3 p-3.5 rounded-xl transition {{ request()->routeIs('laporan') ? 'bg-orange-600 text-white' : 'text-slate-400 hover:bg-slate-800/50' }}">
                <i class="fas fa-chart-bar w-5"></i>
                <span class="font-medium">Laporan Data</span>
            </a>
        </nav>

        <!-- Logout -->
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

    <!-- Main Content -->
    <main class="flex-1 flex flex-col h-screen overflow-hidden">
        <!-- Header -->
        <header class="h-20 bg-white/80 backdrop-blur-md flex items-center justify-between px-10 sticky top-0 z-10 border-b border-slate-100">
            <div class="flex items-center space-x-2 text-sm font-medium text-slate-400">
                <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></div>
                <span>Monitoring</span>
            </div>
            
            <div class="flex items-center space-x-6">
                <!-- Notification -->
                <div class="relative">
                    <i class="far fa-bell text-xl text-slate-400"></i>
                    <span class="absolute -top-1 -right-1 bg-red-500 text-[10px] text-white w-4 h-4 flex items-center justify-center rounded-full border-2 border-white">3</span>
                </div>

                <!-- User Profile -->
                <div class="flex items-center space-x-3 pl-6 border-l border-slate-100">
                    <div class="text-right">
                        <p class="text-xs font-bold text-slate-800 uppercase tracking-tight">Administrator</p>
                        <p class="text-[10px] font-semibold text-emerald-500 uppercase">System Active</p>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center font-bold text-slate-600 border border-slate-200">
                        AD
                    </div>
                </div>
            </div>
        </header>

        <!-- Content Area -->
        <div class="flex-1 p-10 overflow-y-auto">
            @yield('content')
        </div>
    </main>

</body>
</html>