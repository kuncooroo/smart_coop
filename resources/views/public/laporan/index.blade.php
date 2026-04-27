@extends('layouts.public')
@section('title', 'Analisis & Laporan')

@section('content')
    <div class="w-full mb-8 flex justify-between items-center">
        <div>
            <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight">Analisis dan Laporan</h2>
            <p class="text-slate-500 text-sm mt-1">Monitoring performa kandang secara real-time.</p>
        </div>

        <form action="{{ route('laporan.export') }}" method="GET" class="flex items-center gap-2">
            <input type="hidden" name="type" value="quick">

            <select name="format"
                class="border border-slate-200 px-3 py-2 rounded-xl text-xs font-bold text-slate-600 focus:ring-0 focus:border-slate-400">
                <option value="csv">CSV</option>
                <option value="pdf">PDF</option>
            </select>

            <button
                class="bg-[#002855] hover:bg-orange-600 text-white px-6 py-3 rounded-xl font-bold transition-all shadow-lg text-sm uppercase tracking-widest flex items-center">
                <i class="fas fa-file-export mr-2"></i> Export
            </button>
        </form>
    </div>


    <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-8">
        @php
            $stats = [
                ['label' => 'Total Device', 'value' => $totalDevices, 'color' => 'text-slate-800'],
                ['label' => 'Online', 'value' => $online, 'color' => 'text-emerald-500'],
                ['label' => 'Offline', 'value' => $offline, 'color' => 'text-rose-500'],
                ['label' => 'Warning', 'value' => $warning, 'color' => 'text-amber-500'],
                ['label' => 'Alert (24h)', 'value' => $alerts24h, 'color' => 'text-pink-500'],
            ];
        @endphp

        @foreach ($stats as $stat)
            <div class="bg-white p-6 rounded-[1.5rem] shadow-sm border border-slate-100 transition-hover hover:shadow-md">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.15em] mb-1">{{ $stat['label'] }}</p>
                <h3 class="text-3xl font-black {{ $stat['color'] }}">{{ $stat['value'] }}</h3>
            </div>
        @endforeach
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
            <div class="px-8 py-5 bg-slate-50/50 border-b border-slate-100">
                <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Status Perangkat</h3>
            </div>
            <div class="p-8 flex justify-center">
                <div class="w-full max-w-[300px]">
                    <canvas id="deviceChart"></canvas>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
            <div class="px-8 py-5 bg-slate-50/50 border-b border-slate-100">
                <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Aktivitas Ayam</h3>
            </div>
            <div class="p-8">
                <canvas id="chickenChart"></canvas>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden mb-8">
        <div class="px-8 py-5 bg-slate-50/50 border-b border-slate-100">
            <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Grafik Suhu (°C)</h3>
        </div>
        <div class="p-8">
            <canvas id="tempChart" height="100"></canvas>
        </div>
    </div>

    <div class="bg-slate-900 p-10 rounded-[2.5rem] text-white shadow-2xl relative overflow-hidden">
        <div class="relative z-10">
            <div class="mb-6">
                <h3 class="text-2xl font-bold tracking-tight">Generate Laporan Kustom</h3>
                <p class="text-slate-400 text-sm">Pilih rentang tanggal untuk mendapatkan laporan mendalam.</p>
            </div>

            <form action="{{ route('laporan.export') }}" method="GET" class="flex flex-wrap items-end gap-6">
                <input type="hidden" name="type" value="filter">

                <div class="flex flex-col gap-2">
                    <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Mulai</label>
                    <input type="date" name="start_date" required
                        class="bg-slate-800 border-none rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-orange-500 text-white">
                </div>

                <div class="flex flex-col gap-2">
                    <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Selesai</label>
                    <input type="date" name="end_date" required
                        class="bg-slate-800 border-none rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-orange-500 text-white">
                </div>

                <div class="flex flex-col gap-2">
                    <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Format</label>
                    <select name="format"
                        class="bg-slate-800 border-none rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-orange-500 text-white min-w-[100px]">
                        <option value="csv">CSV</option>
                        <option value="pdf">PDF</option>
                    </select>
                </div>

                <button
                    class="bg-orange-600 hover:bg-orange-500 text-white px-8 py-3.5 rounded-xl font-bold transition-all shadow-lg text-sm uppercase tracking-[0.1em] flex items-center">
                    <i class="fas fa-cloud-download-alt mr-2"></i> Download Report
                </button>
            </form>
        </div>
        <div class="absolute -right-20 -bottom-20 w-64 h-64 bg-orange-600/10 rounded-full blur-3xl"></div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        Chart.defaults.font.family = "'Plus Jakarta Sans', 'Inter', sans-serif";
        Chart.defaults.color = '#94a3b8';
        Chart.defaults.plugins.tooltip.padding = 12;
        Chart.defaults.plugins.tooltip.borderRadius = 12;
        Chart.defaults.plugins.tooltip.backgroundColor = '#0f172a'; 

        function createGradient(ctx, color) {
            const gradient = ctx.createLinearGradient(0, 0, 0, 400);
            gradient.addColorStop(0, color.replace('1)', '0.2)')); 
            gradient.addColorStop(1, color.replace('1)', '0)')); 
            return gradient;
        }

        const ctxDevice = document.getElementById('deviceChart').getContext('2d');
        new Chart(ctxDevice, {
            type: 'doughnut',
            data: {
                labels: ['Online', 'Warning', 'Offline'],
                datasets: [{
                    data: [{{ $online }}, {{ $warning }}, {{ $offline }}],
                    backgroundColor: ['#10b981', '#f59e0b', '#ef4444'],
                    hoverOffset: 20,
                    borderWidth: 5,
                    borderColor: '#ffffff',
                    borderRadius: 10
                }]
            },
            options: {
                cutout: '75%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            usePointStyle: true,
                            padding: 25,
                            font: {
                                size: 12,
                                weight: '600'
                            }
                        }
                    }
                }
            }
        });

        const ctxChicken = document.getElementById('chickenChart').getContext('2d');
        new Chart(ctxChicken, {
            type: 'line',
            data: {
                labels: {!! json_encode($labels) !!},
                datasets: [{
                        label: 'Masuk',
                        data: {!! json_encode($masuk) !!},
                        borderColor: '#10b981',
                        backgroundColor: createGradient(ctxChicken, 'rgba(16, 185, 129, 1)'),
                        fill: true,
                        tension: 0.4,
                        pointRadius: 0,
                        pointHoverRadius: 6,
                        borderWidth: 3
                    },
                    {
                        label: 'Keluar',
                        data: {!! json_encode($keluar) !!},
                        borderColor: '#ef4444',
                        backgroundColor: createGradient(ctxChicken, 'rgba(239, 68, 68, 1)'),
                        fill: true,
                        tension: 0.4,
                        pointRadius: 0,
                        pointHoverRadius: 6,
                        borderWidth: 3
                    }
                ]
            },
            options: {
                interaction: {
                    intersect: false,
                    mode: 'index'
                },
                plugins: {
                    legend: {
                        align: 'end',
                        labels: {
                            usePointStyle: true,
                            font: {
                                weight: 'bold'
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#f1f5f9',
                            drawBorder: false
                        },
                        border: {
                            dash: [5, 5],
                            display: false
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        border: {
                            display: false
                        }
                    }
                }
            }
        });

        const ctxTemp = document.getElementById('tempChart').getContext('2d');
        new Chart(ctxTemp, {
            type: 'line',
            data: {
                labels: {!! json_encode($labels) !!},
                datasets: [{
                    label: 'Suhu (°C)',
                    data: {!! json_encode($suhu) !!},
                    borderColor: '#3b82f6',
                    borderWidth: 4,
                    backgroundColor: createGradient(ctxTemp, 'rgba(59, 130, 246, 1)'),
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: '#3b82f6',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 7
                }]
            },
            options: {
                interaction: {
                    intersect: false,
                    mode: 'index'
                },
                scales: {
                    y: {
                        grid: {
                            color: '#f1f5f9'
                        },
                        border: {
                            display: false
                        },
                        ticks: {
                            callback: value => value + '°C'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        border: {
                            display: false
                        }
                    }
                }
            }
        });
    </script>
@endsection
