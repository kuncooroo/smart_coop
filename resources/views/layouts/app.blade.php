<!DOCTYPE html>

<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Smart Coop') | Dashboard Dinamis</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc;
        }
    </style>
    @stack('styles')
</head>

<body class="antialiased">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-white border-r border-slate-200 hidden md:flex flex-col">
            <div class="p-6">
                <div class="flex items-center gap-3 text-amber-600">
                    <i data-lucide="layout-dashboard" class="w-8 h-8"></i>
                    <span class="text-xl font-bold tracking-tight text-slate-800">SmartCoop</span>
                </div>
            </div>
            <nav class="flex-1 px-4 space-y-1">
                <a href="{{ url('/') }}"
                    class="flex items-center gap-3 px-4 py-3 {{ Request::is('/') ? 'text-amber-600 bg-amber-50' : 'text-slate-500 hover:bg-slate-50' }} rounded-xl font-medium transition">
                    <i data-lucide="home" class="w-5 h-5"></i> Dashboard
                </a>
                <a href="{{ route('activity.logs') }}"
                    class="flex items-center gap-3 px-4 py-3 {{ Request::is('activity-logs*') ? 'text-amber-600 bg-amber-50' : 'text-slate-500 hover:bg-slate-50' }} rounded-xl transition">
                    <i data-lucide="activity" class="w-5 h-5"></i> Log Aktivitas
                </a>
                <a href="{{ route('settings') }}"
                    class="flex items-center gap-3 px-4 py-3 {{ Request::is('settings*') ? 'text-amber-600 bg-amber-50' : 'text-slate-500 hover:bg-slate-50' }} rounded-xl transition">
                    <i data-lucide="settings" class="w-5 h-5"></i> Pengaturan
                </a>
            </nav>
            <div class="p-6 border-t border-slate-100 text-xs text-slate-400">
                v1.0.2 Build Stable
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto">
            <!-- Header -->
            <header
                class="bg-white/80 backdrop-blur-md sticky top-0 z-10 border-b border-slate-200 px-8 py-4 flex justify-between items-center">
                <h2 class="text-lg font-semibold text-slate-800">@yield('header_title', 'Monitoring Kandang')</h2>
                <div class="flex items-center gap-4">
                    <div
                        class="flex items-center gap-2 px-3 py-1 rounded-full text-sm font-medium border {{ $is_online ?? true ? 'bg-green-50 text-green-600 border-green-100' : 'bg-rose-50 text-rose-600 border-rose-100' }}">
                        <span class="relative flex h-2 w-2">
                            <span
                                class="animate-ping absolute inline-flex h-full w-full rounded-full {{ $is_online ?? true ? 'bg-green-400' : 'bg-rose-400' }} opacity-75"></span>
                            <span
                                class="relative inline-flex rounded-full h-2 w-2 {{ $is_online ?? true ? 'bg-green-500' : 'bg-rose-500' }}"></span>
                        </span>
                        {{ $is_online ?? true ? 'Sistem Aktif' : 'Sistem Offline' }}
                    </div>
                    <button onclick="location.reload()" class="p-2 text-slate-400 hover:text-slate-600 transition">
                        <i data-lucide="refresh-cw" class="w-5 h-5"></i>
                    </button>
                </div>
            </header>

            <div class="p-8">
                @yield('content')
            </div>
        </main>
    </div>

    <script>
        lucide.createIcons();
    </script>
    @stack('scripts')


</body>

</html>
