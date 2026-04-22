@extends('layouts.app')
@section('title', 'Laporan & Analitik')

@section('content')
    <div class="w-full mb-8 flex justify-between items-end">
        <div>
            <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight">Analytics & Reports</h2>
            <p class="text-sm text-slate-400 font-medium mt-1">Visualisasi performa sistem dan ekspor data historis.</p>
        </div>
        <button onclick="submitExport('excel')"
            class="flex items-center gap-2 bg-white border border-slate-200 px-5 py-2.5 rounded-xl text-sm font-bold text-slate-700 hover:bg-slate-50 transition-all shadow-sm">
            <i class="fas fa-upload text-slate-400"></i> Export Data
        </button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 mb-8">
        <div class="bg-white p-5 rounded-2xl border-2 border-purple-50 shadow-sm relative overflow-hidden">
            <i class="fas fa-microchip absolute -right-2 -bottom-2 text-5xl text-slate-100"></i>
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Total Devices</p>
            <h3 class="text-3xl font-black text-slate-800">{{ number_format(\App\Models\Device::count()) }}</h3>
        </div>

        <div class="bg-white p-5 rounded-2xl border-2 border-rose-50 shadow-sm relative overflow-hidden">
            <i class="fas fa-exclamation-triangle absolute -right-2 -bottom-2 text-5xl text-rose-50"></i>
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Warnings</p>
            <h3 class="text-3xl font-black text-rose-500">12</h3>
        </div>

        <div class="bg-white p-5 rounded-2xl border-2 border-purple-50 shadow-sm relative overflow-hidden">
            <i class="fas fa-wifi absolute -right-2 -bottom-2 text-5xl text-slate-100"></i>
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Offline</p>
            <h3 class="text-3xl font-black text-slate-800">{{ \App\Models\Device::where('status', 'offline')->count() }}
            </h3>
        </div>

        <div class="bg-white p-5 rounded-2xl border-2 border-pink-50 shadow-sm relative overflow-hidden">
            <i class="fas fa-bell absolute -right-2 -bottom-2 text-5xl text-pink-50"></i>
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Alerts (24h)</p>
            <h3 class="text-3xl font-black text-pink-600">25</h3>
        </div>

        <div class="bg-white p-5 rounded-2xl border-2 border-indigo-50 shadow-sm relative overflow-hidden">
            <i class="fas fa-history absolute -right-2 -bottom-2 text-5xl text-indigo-50"></i>
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Resp. Time</p>
            <h3 class="text-3xl font-black text-slate-800">15 <span class="text-xs font-bold text-slate-400">ms</span></h3>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm">
            <h4 class="text-sm font-bold text-slate-700 mb-6">Devices Status Overview</h4>
            <div class="h-64 flex items-center justify-center">
                <canvas id="deviceStatusChart"></canvas>
            </div>
        </div>

        <div class="lg:col-span-2 bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm">
            <h4 class="text-sm font-bold text-slate-700 mb-6">Alert Frequency (Last 10 Days)</h4>
            <div class="h-64">
                <canvas id="alertFrequencyChart"></canvas>
            </div>
        </div>
    </div>
    <div class="bg-slate-900 rounded-[2.5rem] p-10 text-white shadow-2xl relative overflow-hidden mb-12">
        <i class="fas fa-file-invoice absolute -right-10 -bottom-10 text-[15rem] text-white/5 -rotate-12"></i>
        <div class="relative z-10">
            <h3 class="text-xl font-bold mb-6 flex items-center gap-3">
                <span class="w-8 h-8 bg-orange-500 rounded-lg flex items-center justify-center text-sm">
                    <i class="fas fa-download"></i>
                </span>
                Generate Detailed Report
            </h3>

            <form action="{{ route('laporan.export') }}" method="GET" id="exportForm"
                class="grid grid-cols-1 md:grid-cols-4 gap-6 items-end">
                <input type="hidden" name="type" id="exportType" value="excel">

                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Category</label>
                    <select name="category"
                        class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-3 text-sm font-bold text-white outline-none focus:ring-2 focus:ring-orange-500">
                        <option class="text-slate-800" value="sensor">Sensor Stats</option>
                        <option class="text-slate-800" value="activity">Device Logs</option>
                    </select>
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Start Date</label>
                    <input type="date" name="start_date" required
                        class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-3 text-sm font-bold text-white outline-none">
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">End Date</label>
                    <input type="date" name="end_date" required
                        class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-3 text-sm font-bold text-white outline-none">
                </div>

                <button type="button" onclick="submitExport('pdf')"
                    class="bg-orange-500 hover:bg-orange-600 text-white font-black py-3.5 rounded-xl text-xs uppercase tracking-widest transition-all">
                    Generate PDF
                </button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        new Chart(document.getElementById('deviceStatusChart'), {
            type: 'doughnut',
            data: {
                labels: ['Online', 'Warning', 'Offline'],
                datasets: [{
                    data: [76, 12, 12],
                    backgroundColor: ['#10b981', '#f59e0b', '#ef4444'],
                    borderWidth: 0,
                    hoverOffset: 20
                }]
            },
            options: {
                cutout: '70%',
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });

        new Chart(document.getElementById('alertFrequencyChart'), {
            type: 'line',
            data: {
                labels: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10'],
                datasets: [{
                    label: 'Critical Alerts',
                    data: [40, 55, 65, 58, 68, 85, 88, 85, 88, 95],
                    borderColor: '#ef4444',
                    tension: 0.4,
                    fill: true,
                    backgroundColor: 'rgba(239, 68, 68, 0.05)'
                }, {
                    label: 'Warning Alerts',
                    data: [20, 35, 45, 30, 48, 55, 50, 75, 70, 90],
                    borderColor: '#f59e0b',
                    tension: 0.4
                }]
            },
            options: {
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });

        function submitExport(format) {
            const form = document.getElementById('exportForm');
            if (form.checkValidity()) {
                document.getElementById('exportType').value = format;
                form.submit();
            } else {
                form.reportValidity();
            }
        }
    </script>
@endsection
