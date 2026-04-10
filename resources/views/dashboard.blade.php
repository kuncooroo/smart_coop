@extends('layouts.app')

@section('title', 'Dashboard')
@section('header_title', 'Monitoring Kandang Terintegrasi')

@section('content')

<div class="space-y-8">
<!-- Top Stats -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
<!-- Rata-rata Suhu -->
<div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
<div class="flex items-center justify-between mb-4">
<div class="p-2 bg-amber-100 text-amber-600 rounded-lg"><i data-lucide="thermometer"></i></div>
<span class="text-xs font-semibold text-green-500">Live</span>
</div>
<h4 class="text-slate-500 text-sm font-medium">Suhu Rata-rata</h4>
<p class="text-2xl font-bold text-slate-800">{{ number_format($avg_temp ?? 0, 1) }}°C</p>
</div>

    <!-- Total Ayam -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
        <div class="flex items-center justify-between mb-4">
            <div class="p-2 bg-blue-100 text-blue-600 rounded-lg"><i data-lucide="hash"></i></div>
            <span class="text-xs font-semibold text-slate-400">Total</span>
        </div>
        <h4 class="text-slate-500 text-sm font-medium">Total Ayam</h4>
        <p class="text-2xl font-bold text-slate-800">{{ $total_chickens ?? 0 }} Ekor</p>
    </div>

    <!-- Unit Aktif -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
        <div class="flex items-center justify-between mb-4">
            <div class="p-2 bg-purple-100 text-purple-600 rounded-lg"><i data-lucide="eye"></i></div>
            <span class="text-xs font-semibold text-amber-500">YOLO</span>
        </div>
        <h4 class="text-slate-500 text-sm font-medium">Aktif Kandang</h4>
        <p class="text-2xl font-bold text-slate-800">{{ count($latest_data ?? []) }} Unit</p>
    </div>

    <!-- Status Pintu -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
        <div class="flex items-center justify-between mb-4">
            <div class="p-2 bg-green-100 text-green-600 rounded-lg"><i data-lucide="unlock"></i></div>
        </div>
        <h4 class="text-slate-500 text-sm font-medium">Status Pintu</h4>
        <p class="text-2xl font-bold text-slate-800">Auto Mode</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Control Panel -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
        <h3 class="text-lg font-bold text-slate-800 mb-6 flex items-center gap-2">
            <i data-lucide="sliders" class="text-amber-500"></i> Kontrol Manual
        </h3>

        <div class="space-y-6">
            <div>
                <label class="block text-sm font-semibold text-slate-600 mb-3">Pilih Unit Kandang</label>
                <select id="device_id" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-amber-500 outline-none transition">
                    @foreach ($latest_data ?? [] as $data)
                        <option value="{{ $data->device_id }}">
                            {{ strtoupper(str_replace('_', ' ', $data->device_id)) }}
                        </option>
                    @endforeach
                    @if (empty($latest_data))
                        <option disabled>Tidak ada device aktif</option>
                    @endif
                </select>
            </div>

            <div class="grid grid-cols-1 gap-3">
                <button onclick="sendCmd('OPEN_DOOR')" class="group flex items-center justify-between w-full p-4 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 rounded-xl transition border border-emerald-100">
                    <span class="font-semibold">Buka Pintu</span>
                    <i data-lucide="door-open" class="group-hover:translate-x-1 transition"></i>
                </button>
                <button onclick="sendCmd('CLOSE_DOOR')" class="group flex items-center justify-between w-full p-4 bg-rose-50 hover:bg-rose-100 text-rose-700 rounded-xl transition border border-rose-100">
                    <span class="font-semibold">Tutup Pintu</span>
                    <i data-lucide="door-closed" class="group-hover:translate-x-1 transition"></i>
                </button>
                <button onclick="sendCmd('TOGGLE_LIGHT')" class="group flex items-center justify-between w-full p-4 bg-amber-50 hover:bg-amber-100 text-amber-700 rounded-xl transition border border-amber-100">
                    <span class="font-semibold">Toggle Lampu</span>
                    <i data-lucide="lightbulb" class="group-hover:scale-110 transition"></i>
                </button>
            </div>
        </div>

        <div id="feedback" class="mt-6 hidden animate-in fade-in duration-300">
            <div class="p-4 rounded-xl text-sm font-medium text-center" id="feedback-content"></div>
        </div>
    </div>

    <!-- Monitoring Table -->
    <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-6 border-b border-slate-50 flex justify-between items-center">
            <h3 class="text-lg font-bold text-slate-800">Status Sensor Real-time</h3>
            <span class="text-xs text-slate-400 font-medium tracking-wider uppercase">Live Update</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase">Device</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase text-center">Populasi</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase">Suhu & YOLO</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($latest_data ?? [] as $row)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="px-6 py-4">
                                <div class="font-bold text-slate-700 uppercase tracking-tight">{{ $row->device_id }}</div>
                                <div class="text-[10px] text-slate-400">Last: {{ method_exists($row->updated_at, 'diffForHumans') ? $row->updated_at->diffForHumans() : $row->updated_at }}</div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="text-xl font-bold text-amber-600">{{ ($row->chicken_in ?? 0) - ($row->chicken_out ?? 0) }}</span>
                                <p class="text-[10px] text-slate-400">Ekor Aktif</p>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2 text-slate-700 font-semibold mb-1">
                                    <i data-lucide="thermometer" class="w-4 h-4 {{ $row->temperature > 30 ? 'text-rose-500' : 'text-blue-500' }}"></i>
                                    {{ $row->temperature }}°C
                                </div>
                                @if ($row->chicken_detected)
                                    <span class="px-2 py-0.5 bg-green-100 text-green-700 rounded-md text-[10px] font-bold border border-green-200 uppercase tracking-widest">Ayam Terdeteksi</span>
                                @else
                                    <span class="px-2 py-0.5 bg-slate-100 text-slate-400 rounded-md text-[10px] font-bold border border-slate-200 uppercase tracking-widest">Kosong</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    @php
                                        $is_device_online = isset($row->updated_at) && (is_string($row->updated_at) ? true : $row->updated_at->gt(now()->subMinutes(5)));
                                    @endphp
                                    <div class="w-2 h-2 rounded-full {{ $is_device_online ? 'bg-green-500' : 'bg-rose-500' }}"></div>
                                    <span class="text-xs font-medium text-slate-600">
                                        {{ $is_device_online ? 'Online' : 'Offline' }}
                                    </span>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-10 text-center text-slate-400 italic">Belum ada data sensor yang masuk.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Chart Section -->
<div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h3 class="text-lg font-bold text-slate-800">Analitik Suhu Kandang</h3>
            <p class="text-sm text-slate-500">Menampilkan rata-rata suhu dari semua unit</p>
        </div>
    </div>
    <div class="h-80 w-full">
        <canvas id="tempChart"></canvas>
    </div>
</div>


</div>
@endsection

@push('scripts')

<script>
const ctx = document.getElementById('tempChart').getContext('2d');
const gradient = ctx.createLinearGradient(0, 0, 0, 400);
gradient.addColorStop(0, 'rgba(245, 158, 11, 0.4)');
gradient.addColorStop(1, 'rgba(245, 158, 11, 0)');

let chart = new Chart(ctx, {
    type: &#39;line&#39;,
    data: {
        labels: [],
        datasets: [{
            label: &#39;Suhu (°C)&#39;,
            data: [],
            borderColor: &#39;#f59e0b&#39;,
            backgroundColor: gradient,
            fill: true,
            tension: 0.4,
            borderWidth: 3,
            pointBackgroundColor: &#39;#fff&#39;,
            pointBorderColor: &#39;#f59e0b&#39;,
            pointBorderWidth: 2
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
            x: { grid: { display: false } },
            y: { grid: { color: &#39;#e2e8f0&#39; } }
        }
    }
});

async function loadChart() {
    try {
        const res = await fetch(&#39;/api/chart-data&#39;);
        const data = await res.json();
        chart.data.labels = data.labels;
        chart.data.datasets[0].data = data.values;
        chart.update();
    } catch (err) {
        console.error(&quot;Gagal load chart:&quot;, err);
    }
}

loadChart();
setInterval(loadChart, 5000);

// Fungsi Command Manual
function sendCmd(cmd) {
    const deviceId = document.getElementById(&#39;device_id&#39;).value;
    const fb = document.getElementById(&#39;feedback&#39;);
    const fbc = document.getElementById(&#39;feedback-content&#39;);
    
    fb.classList.remove(&#39;hidden&#39;);
    fbc.className = &quot;p-4 rounded-xl text-sm font-medium text-center bg-amber-50 text-amber-600&quot;;
    fbc.innerText = `Mengirim perintah ${cmd} ke ${deviceId}...`;

    // Simulasi fetch API
    setTimeout(() =&gt; {
        fbc.className = &quot;p-4 rounded-xl text-sm font-medium text-center bg-emerald-50 text-emerald-700&quot;;
        fbc.innerText = `Berhasil: ${cmd} dijalankan pada ${deviceId}`;
        setTimeout(() =&gt; fb.classList.add(&#39;hidden&#39;), 3000);
    }, 1000);
}


</script>

@endpush