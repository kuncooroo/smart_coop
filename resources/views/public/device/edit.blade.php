@extends('layouts.app')
@section('title', 'Edit Device')

@section('content')
<style>
    input[type="date"]::-webkit-inner-spin-button,
    input[type="date"]::-webkit-calendar-picker-indicator {
        position: absolute;
        left: 0; top: 0; width: 100%; height: 100%;
        margin: 0; padding: 0; cursor: pointer; opacity: 0;
    }
</style>

<div class="w-full mb-6 flex items-center justify-between">
    <div class="flex items-center">
        <a href="{{ route('devices.index') }}" class="mr-4 bg-white text-slate-400 w-10 h-10 rounded-xl flex items-center justify-center shadow-sm border border-slate-100 hover:text-orange-500 transition-all">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h2 class="text-2xl font-bold text-slate-800 tracking-tight">Edit Device</h2>
    </div>
</div>

<div class="w-full bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
    <div class="p-6 border-b border-slate-50 bg-slate-50/30">
        <h3 class="text-xs font-bold text-slate-400 uppercase tracking-[0.2em]">Device Information</h3>
    </div>

    <form action="{{ route('devices.update', $device->id) }}" method="POST" enctype="multipart/form-data" class="p-8">
        @csrf
        @method('PUT')
        
        <div class="flex flex-col lg:flex-row gap-12">
            
            <div class="w-full lg:w-72 flex flex-col">
                <div class="relative group">
                    <div class="w-full aspect-square rounded-3xl bg-slate-50 border-2 border-dashed border-slate-200 flex flex-col items-center justify-center overflow-hidden relative transition-all group-hover:border-orange-300">
                        @if($device->profile_image)
                            <img src="{{ asset('storage/'.$device->profile_image) }}" class="w-full h-full object-cover">
                        @else
                            <i class="fas fa-camera text-3xl text-slate-200 mb-2"></i>
                            <span class="text-[10px] text-slate-400 font-bold uppercase">Device Photo</span>
                        @endif

                        <div class="absolute inset-0 bg-slate-900/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all">
                            <label for="profile_image" class="cursor-pointer bg-white text-slate-900 p-3 rounded-full shadow-xl hover:scale-110 transition-transform">
                                <i class="fas fa-plus"></i>
                            </label>
                        </div>
                    </div>
                    <input type="file" name="profile_image" id="profile_image" class="hidden">
                </div>

                <div class="mt-6 p-4 bg-slate-50 rounded-2xl border border-slate-100 flex flex-col items-center justify-center">
                    <div class="bg-white p-2 rounded-lg shadow-sm border border-white">
                        {!! DNS1D::getBarcodeHTML($device->device_id, 'C128', 1.2, 33) !!}
                    </div>
                    <p class="text-[9px] font-bold mt-2 text-slate-400 tracking-[0.2em] uppercase">{{ $device->device_id }}</p>
                </div>
            </div>

            <div class="flex-1 flex flex-col justify-between">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-10 gap-y-8">
                    
                    <div class="space-y-1 border-b border-slate-200 pb-2 focus-within:border-orange-500 transition-all">
                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest">Device Name</label>
                        <input type="text" name="device_name" value="{{ old('device_name', $device->device_name) }}" class="w-full py-1 bg-transparent focus:outline-none text-lg text-slate-700 font-semibold uppercase" placeholder="Nama Perangkat" required>
                    </div>

                    <div class="space-y-1 border-b border-slate-200 pb-2 bg-slate-50/50 px-2 rounded-t-lg transition-all">
                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest">Device ID (Locked)</label>
                        <div class="flex items-center justify-between">
                            <input type="text" value="{{ $device->device_id }}" class="w-full py-1 bg-transparent focus:outline-none text-lg text-slate-400 font-semibold uppercase cursor-not-allowed" readonly>
                            <i class="fas fa-lock text-slate-300"></i>
                        </div>
                    </div>

                    <div class="space-y-1 border-b border-slate-200 pb-2 focus-within:border-orange-500 transition-all md:col-span-2">
                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest">Location (Kandang)</label>
                        <select name="kandang_id" class="w-full py-1 bg-transparent focus:outline-none text-lg text-slate-700 font-semibold appearance-none cursor-pointer" required>
                            @foreach($kandangs as $kandang)
                                <option value="{{ $kandang->id }}" {{ $device->kandang_id == $kandang->id ? 'selected' : '' }}>
                                    {{ $kandang->name }} ({{ $kandang->code }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="space-y-1 border-b border-slate-200 pb-2 focus-within:border-orange-500 transition-all relative">
                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest">Installation Date</label>
                        <div class="flex items-center justify-between">
                            <input type="date" name="installation_date" value="{{ \Carbon\Carbon::parse($device->installation_date)->format('Y-m-d') }}" class="w-full py-1 bg-transparent focus:outline-none text-lg text-slate-700 font-semibold cursor-pointer z-10">
                            <i class="far fa-calendar-alt text-slate-400 absolute right-0 bottom-3"></i>
                        </div>
                    </div>

                    <div class="space-y-1" x-data="{ active: {{ $device->status == 'aktif' ? 'true' : 'false' }} }">
                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest">Activation Status</label>
                        <div class="flex items-center py-2">
                            <input type="hidden" name="status" :value="active ? 'aktif' : 'non-aktif'">
                            <button type="button" @click="active = !active" :class="active ? 'bg-slate-900' : 'bg-slate-200'" class="w-10 h-5 rounded-full relative p-1 transition-colors duration-200">
                                <div :class="active ? 'translate-x-5' : 'translate-x-0'" class="w-3 h-3 bg-white rounded-full shadow-sm transform transition-transform duration-200"></div>
                            </button>
                            <span class="ml-3 text-[10px] font-bold uppercase tracking-widest" :class="active ? 'text-emerald-600' : 'text-slate-400'" x-text="active ? 'Aktif' : 'Non-Aktif'"></span>
                        </div>
                    </div>
                </div>

                <div class="mt-8 flex justify-end items-end">
                    <button type="submit" class="bg-[#002855] hover:bg-orange-600 text-white font-bold py-4 px-12 rounded-2xl transition shadow-lg text-sm uppercase tracking-widest">
                        Update Device
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection