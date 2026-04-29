@extends('layouts.public')
@section('title', 'Analisis & Laporan')

@section('content')
    <div class="w-full mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight">Analisis Laporan</h2>
            <div class="flex items-center gap-3 mt-2">
                <form action="{{ route('laporan.index') }}" method="GET">
                    <div class="flex items-center gap-2 bg-white border border-slate-200 px-4 py-2 rounded-xl shadow-sm">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Unit Kandang:</label>
                        <select name="kandang_id" onchange="this.form.submit()"
                            class="text-sm font-bold text-slate-700 outline-none bg-transparent">
                            @foreach ($daftarKandang as $k)
                                <option value="{{ $k->id }}" {{ $kandangId == $k->id ? 'selected' : '' }}>
                                    {{ $k->name }} ({{ $k->code }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                </form>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <form action="{{ route('laporan.export') }}" method="GET" class="flex items-center gap-2">
                <input type="hidden" name="kandang_id" value="{{ $kandangId }}">
                <select name="format"
                    class="bg-white border border-slate-200 px-3 py-3 rounded-xl text-xs font-bold text-slate-600 outline-none shadow-sm">
                    <option value="csv">CSV</option>
                    <option value="pdf">PDF</option>
                </select>
                <button
                    class="bg-[#002855] hover:bg-orange-600 text-white px-6 py-3 rounded-xl font-bold transition-all shadow-lg text-sm uppercase tracking-widest flex items-center">
                    <i class="fas fa-file-export mr-2"></i> Export Data
                </button>
            </form>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100 relative overflow-hidden group">
            <div class="relative z-10">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Okupansi Kandang</p>
                <h3 class="text-3xl font-black text-slate-800">{{ $current_chicken }} <span
                        class="text-sm font-medium text-slate-400">/ {{ $capacity }}</span></h3>
                <div class="w-full bg-slate-100 h-1.5 rounded-full mt-4">
                    <div class="bg-emerald-500 h-full rounded-full transition-all duration-700"
                        style="width: {{ $capacity > 0 ? ($current_chicken / $capacity) * 100 : 0 }}%"></div>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100 relative overflow-hidden">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Suhu Terakhir</p>
            <h3 class="text-3xl font-black text-[#002855]">{{ $last_temp }}°C</h3>
            <p class="text-[10px] text-emerald-500 font-bold mt-2 uppercase tracking-widest"><i
                    class="fas fa-check-circle mr-1"></i> Stabil</p>
        </div>

        <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100 relative overflow-hidden">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Status Pintu</p>
            <div class="mt-2">
                <span
                    class="px-4 py-2 text-[10px] font-black rounded-xl border uppercase {{ $door_status == 'TERBUKA' ? 'bg-emerald-50 text-emerald-600 border-emerald-100' : 'bg-rose-50 text-rose-600 border-rose-100' }}">
                    {{ $door_status }}
                </span>
            </div>
        </div>

        <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100 relative overflow-hidden">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Koneksi Alat</p>
            <div class="flex items-center gap-3 mt-2">
                <div class="relative flex">
                    <span
                        class="animate-ping absolute inline-flex h-full w-full rounded-full {{ $online > 0 ? 'bg-emerald-400' : 'bg-rose-400' }} opacity-75"></span>
                    <span
                        class="relative inline-flex rounded-full h-3 w-3 {{ $online > 0 ? 'bg-emerald-500' : 'bg-rose-500' }}"></span>
                </div>
                <span class="text-sm font-bold text-slate-700">{{ $online > 0 ? 'Online' : 'Offline' }}</span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 mb-8">
        <div class="lg:col-span-8 space-y-8">
            <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100">
                <h4 class="text-sm font-black text-slate-800 uppercase tracking-widest mb-8 flex items-center">
                    <i class="fas fa-chart-line mr-3 text-[#002855]"></i> Tren Populasi (7 Hari)
                </h4>
                <canvas id="chickenChart" height="300"></canvas>
            </div>

            <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100">
                <h4 class="text-sm font-black text-slate-800 uppercase tracking-widest mb-8 flex items-center">
                    <i class="fas fa-temperature-high mr-3 text-orange-500"></i> Rata-Rata Suhu
                </h4>
                <canvas id="tempChart" height="250"></canvas>
            </div>
        </div>

        <div class="lg:col-span-4 space-y-8">
            <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100">
                <h4 class="text-center text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-8">Status
                    Kesehatan Alat</h4>
                <canvas id="healthChart"></canvas>
            </div>

            <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100">
                <h4 class="text-center text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-8">Metode
                    Pencatatan</h4>
                <canvas id="modeChart"></canvas>
            </div>
        </div>
    </div>

    <div class="bg-[#002855] p-10 rounded-[3rem] text-white shadow-2xl relative overflow-hidden group">
        <i
            class="fas fa-file-invoice absolute -right-10 -bottom-10 text-white/5 text-[15rem] -rotate-12 group-hover:scale-110 transition-transform duration-700"></i>

        <div class="relative z-10 flex flex-col md:flex-row justify-between items-center gap-8">
            <div class="text-center md:text-left">
                <h3 class="text-2xl font-black tracking-tight mb-2">Generate Laporan Kustom</h3>
                <p class="text-blue-200/70 text-sm max-w-md font-medium">Pilih rentang tanggal untuk mengunduh data detail
                    dalam format pilihan Anda.</p>
            </div>

            <form action="{{ route('laporan.export') }}" method="GET"
                class="flex flex-wrap justify-center gap-4 bg-white/5 p-6 rounded-[2.5rem] border border-white/10 backdrop-blur-md">
                <input type="hidden" name="kandang_id" value="{{ $kandangId }}">
                <div class="flex gap-4">
                    <div class="flex flex-col gap-1">
                        <span class="text-[9px] font-black text-blue-300 uppercase ml-1">Dari Tanggal</span>
                        <input type="date" name="start_date"
                            class="bg-white text-slate-800 rounded-xl px-4 py-2.5 text-xs font-bold outline-none border-none focus:ring-2 focus:ring-orange-500">
                    </div>
                    <div class="flex flex-col gap-1">
                        <span class="text-[9px] font-black text-blue-300 uppercase ml-1">Sampai Tanggal</span>
                        <input type="date" name="end_date"
                            class="bg-white text-slate-800 rounded-xl px-4 py-2.5 text-xs font-bold outline-none border-none focus:ring-2 focus:ring-orange-500">
                    </div>
                </div>
                <div class="flex items-end">
                    <button
                        class="bg-orange-600 hover:bg-orange-500 text-white px-8 py-3 rounded-xl font-black transition-all shadow-xl text-[10px] uppercase tracking-[0.2em] flex items-center">
                        <i class="fas fa-download mr-2"></i> Download
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const labels = {!! json_encode($labels) !!};
        Chart.defaults.font.family = "'Plus Jakarta Sans', sans-serif";

        new Chart(document.getElementById('chickenChart'), {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Populasi',
                    data: {!! json_encode($chicken_data) !!},
                    borderColor: '#002855',
                    backgroundColor: 'rgba(0, 40, 85, 0.05)',
                    fill: true,
                    tension: 0.4,
                    borderWidth: 4,
                    pointRadius: 4
                }]
            }
        });

        new Chart(document.getElementById('tempChart'), {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Suhu (°C)',
                    data: {!! json_encode($temp_data) !!},
                    borderColor: '#f97316',
                    borderWidth: 4,
                    tension: 0.4
                }]
            }
        });

        new Chart(document.getElementById('healthChart'), {
            type: 'doughnut',
            data: {
                labels: ['Excellent', 'Degraded', 'Critical', 'Maintenance'],
                datasets: [{
                    data: [
                        {{ $health_stats['excellent'] }},
                        {{ $health_stats['degraded'] }},
                        {{ $health_stats['critical'] }},
                        {{ $health_stats['maintenance'] }}
                    ],
                    backgroundColor: ['#10b981', '#f59e0b', '#ef4444', '#64748b'],
                    borderWidth: 0
                }]
            },
            options: {
                cutout: '75%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            usePointStyle: true,
                            font: {
                                size: 10,
                                weight: 'bold'
                            }
                        }
                    }
                }
            }
        });

        new Chart(document.getElementById('modeChart'), {
            type: 'pie',
            data: {
                labels: ['Auto/Cam', 'Manual'],
                datasets: [{
                    data: [{{ $auto_count }}, {{ $manual_count }}],
                    backgroundColor: ['#6366f1', '#f59e0b'],
                    borderWidth: 0
                }]
            },
            options: {
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            usePointStyle: true,
                            font: {
                                size: 10,
                                weight: 'bold'
                            }
                        }
                    }
                }
            }
        });
    </script>
@endsection
