@extends('layouts.app')
@section('title', 'Pusat Notifikasi')

@section('content')
    <div class="bg-white rounded-lg shadow overflow-hidden max-w-3xl">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center bg-slate-50">
            <h3 class="text-lg font-semibold text-gray-800">Peringatan & Info Terkini</h3>
            <button class="text-sm text-blue-600 hover:underline">Tandai semua dibaca</button>
        </div>

        <div class="divide-y divide-gray-100">
            <div class="p-4 hover:bg-slate-50 flex items-start space-x-4 bg-red-50">
                <div
                    class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center flex-shrink-0 text-red-600 font-bold">
                    !</div>
                <div class="flex-1">
                    <h4 class="text-sm font-bold text-gray-800">Peringatan Suhu Tinggi</h4>
                    <p class="text-sm text-gray-600 mt-1">Suhu kandang mencapai 34°C. Kipas darurat telah dihidupkan
                        otomatis.</p>
                    <p class="text-xs text-gray-400 mt-2">10 menit yang lalu</p>
                </div>
            </div>

            <div class="p-4 hover:bg-slate-50 flex items-start space-x-4">
                <div
                    class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center flex-shrink-0 text-blue-600 font-bold">
                    i</div>
                <div class="flex-1">
                    <h4 class="text-sm font-bold text-gray-800">Pintu Dibuka Otomatis</h4>
                    <p class="text-sm text-gray-600 mt-1">Sesuai jadwal timer (06:00), pintu kandang utama telah berhasil
                        dibuka.</p>
                    <p class="text-xs text-gray-400 mt-2">Pagi ini, 06:00 AM</p>
                </div>
            </div>

            <div class="p-4 hover:bg-slate-50 flex items-start space-x-4">
                <div
                    class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center flex-shrink-0 text-green-600 font-bold">
                    ✓</div>
                <div class="flex-1">
                    <h4 class="text-sm font-bold text-gray-800">Sistem Berjalan Normal</h4>
                    <p class="text-sm text-gray-600 mt-1">Pengecekan harian selesai. Semua hardware merespon dengan baik.
                    </p>
                    <p class="text-xs text-gray-400 mt-2">Kemarin, 23:55 PM</p>
                </div>
            </div>
        </div>
    </div>
@endsection
