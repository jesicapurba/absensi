@extends('layouts.app') 

@section('content')
<div class="bg-white rounded-lg shadow-xl p-8 max-w-lg mx-auto mt-10">
    <h2 class="text-3xl font-bold text-gray-800 mb-6 border-b pb-3">
        Presensi Masuk Siswa
    </h2>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">{{ session('error') }}</div>
    @endif

    {{-- KODE REALTIME (Jam Digital) --}}
    <div id="realtime-clock" class="text-center text-4xl font-mono text-blue-600 mb-8">
        {{-- Jam akan dimuat di sini oleh JS --}}
    </div>
    
    <form action="{{ route('presensi.storeMasuk') }}" method="POST">
        @csrf 
    
        <div class="mb-4">
            <label for="name" class="block text-gray-700 font-medium">Nama Siswa</label>
            <input type="text" name="name" id="name" required class="border p-2 w-full rounded">
        </div>
    
        <div class="mb-6">
            <label for="keterangan" class="block text-gray-700 font-medium">Keterangan</label>
            <select name="keterangan" id="keterangan" required class="border p-2 w-full rounded">
                <option value="Hadir">Hadir</option>
                <option value="Izin">Izin</option>
                <option value="Sakit">Sakit</option>
            </select>
        </div>
        
        <button type="submit"
                class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-lg transition duration-200">
            Catat Jam Masuk 
        </button>
    </form>

    {{-- TAUTAN KE REKAP --}}
    <a href="{{ route('presensi.index') }}" class="mt-4 inline-block text-gray-600 hover:text-gray-800 text-sm">
        &larr; Lihat Rekap
    </a>
</div>

{{-- SCRIPT JAVASCRIPT UNTUK REALTIME CLOCK --}}
<script>
    function updateClock() {
        const now = new Date();
        const options = { 
            hour: '2-digit', 
            minute: '2-digit', 
            second: '2-digit', 
            hour12: false // Format 24 jam
        };
        const timeString = now.toLocaleTimeString('id-ID', options);
        
        // Format tanggal (Hari, DD Bulan YYYY)
        const dateOptions = { 
            weekday: 'long', 
            year: 'numeric', 
            month: 'long', 
            day: 'numeric' 
        };
        const dateString = now.toLocaleDateString('id-ID', dateOptions);
        
        const clockElement = document.getElementById('realtime-clock');
        if (clockElement) {
            clockElement.innerHTML = `<span class="text-xl block">${dateString}</span>${timeString}`;
        }
    }

    // Panggil fungsi setiap 1 detik
    setInterval(updateClock, 1000);
    // Panggil sekali saat dimuat
    updateClock(); 
</script>
@endsection