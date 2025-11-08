@extends('layouts.app')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-gray-800">Daftar Presensi Harian Siswa</h2>
        {{-- Perbaikan struktur tombol Kembali --}}
        <a href="{{ route('dashboard') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg flex items-center">
            <i class="fas fa-arrow-left mr-2"></i> Kembali
        </a>
    </div>
    
    <div class="mb-4 text-center p-3 border rounded-lg bg-indigo-50">
        <p class="text-lg font-medium text-gray-700">Waktu Saat Ini:</p>
        <div id="realtime-clock" class="text-4xl font-bold text-indigo-700">--:--:--</div>
    </div>

    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">{{ session('success') }}</div>
    @endif
    @if(session('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">{{ session('error') }}</div>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200">
            <thead>
                <tr class="bg-gray-100 text-gray-700 uppercase text-sm leading-normal">
                    <th class="py-3 px-4 text-left">#</th>
                    <th class="py-3 px-4 text-left">Nama Lengkap</th>
                    <th class="py-3 px-4 text-center">Keterangan</th>
                    <th class="py-3 px-4 text-center w-1/4">Aksi Jam Datang</th>
                    <th class="py-3 px-4 text-center w-1/4">Aksi Jam Pulang</th>
                    <th class="py-3 px-4 text-center">Detail Siswa</th>
                </tr>
            </thead>
            <tbody>
            {{-- Menggunakan $siswa untuk perulangan dan pagination --}}
            @foreach($presensi as $k)
                <tr class="border-b border-gray-200 hover:bg-gray-50 text-sm">
                    {{-- Pagination dan data Siswa --}}
                    <td class="py-3 px-4">{{ $loop->iteration + ($siswa->currentPage() - 1) * $siswa->perPage() }}</td>
                    <td class="py-3 px-4 font-medium">{{ $k->name ?? 'NAMA TIDAK TERSEDIA' }}</td>
                    
                   
                    
                    {{-- FORMULIR Aksi Jam Datang --}}
                    <td class="py-3 px-4 text-center">
                        <form action="{{ route('presensi.store') }}" method="POST" class="form-masuk inline" onsubmit="return recordTime(event, 'datang', '{{ $k->id }}')">
                            @csrf
                            <input type="hidden" name="siswa_id" value="{{ $k->id }}">
                            <input type="hidden" name="name" value="{{ $k->name }}">
                            <input type="hidden" name="keterangan" id="keterangan_masuk_{{ $k->id }}">
                            <input type="hidden" name="jam_masuk" id="jam_masuk_input_{{ $k->id }}">

                            <button type="submit" 
                                    class="bg-green-500 hover:bg-green-600 text-white text-xs px-3 py-2 rounded font-semibold w-full">
                                Catat Datang <span id="time_masuk_{{ $k->id }}">--:--</span>
                            </button>
                        </form>
                    </td>
                    
                    {{-- FORMULIR Aksi Jam Pulang --}}
                    <td class="py-3 px-4 text-center">
                        <form action="{{ route('presensi.store') }}" method="POST" class="form-pulang inline" onsubmit="return recordTime(event, 'pulang', '{{ $k->id }}')">
                            @csrf
                            <input type="hidden" name="siswa_id" value="{{ $k->id }}">
                            <input type="hidden" name="jam_pulang" id="jam_pulang_input_{{ $k->id }}">

                            <button type="submit" 
                                    class="bg-red-500 hover:bg-red-600 text-white text-xs px-3 py-2 rounded font-semibold w-full">
                                Catat Pulang <span id="time_pulang_{{ $k->id }}">--:--</span>
                            </button>
                        </form>
                    </td>

                    {{-- Kolom Detail Siswa --}}
                    <td class="py-3 px-4 text-center">
                        <a href="{{ route('siswa.show', $k->id) }}" class="text-indigo-500 hover:text-indigo-700 text-xs font-semibold">
                            Detail
                        </a>
                    </td>
                </tr>
            
                <tr>
                    <td colspan="6" class="py-4 px-4 text-center">Tidak ada data siswa ditemukan.</td>
                </tr>
            @endforeach
            <a href= "{{ route('presensi.create') }}" >Presensi</a>
            </tbody>
        </table>
    </div>

<script>
    // 1. FUNGSI JAM REAL-TIME
    function updateClock() {
        const now = new Date();
        const timeString = now.toLocaleTimeString('id-ID', { 
            hour: '2-digit', 
            minute: '2-digit', 
            second: '2-digit' 
        });
        document.getElementById('realtime-clock').textContent = timeString;
    }
    setInterval(updateClock, 1000);
    updateClock();

    // 2. FUNGSI UNTUK MENCATAT WAKTU (DATANG ATAU PULANG)
    function recordTime(event, type, siswaId) {
        event.preventDefault(); 
        
        const form = event.target;
        
        const now = new Date();
        const timeValue = now.toLocaleTimeString('id-ID', { 
            hour: '2-digit', 
            minute: '2-digit', 
            second: '2-digit',
            hour12: false
        });
        const displayTime = now.toLocaleTimeString('id-ID', { 
            hour: '2-digit', 
            minute: '2-digit',
            hour12: false
        });

        let confirmMessage = '';
        
        if (type === 'datang') {
            const keterangan = document.getElementById(`keterangan_${siswaId}`).value;
            
            document.getElementById(`keterangan_datang_${siswaId}`).value = keterangan;
            document.getElementById(`jam_datang_input_${siswaId}`).value = timeValue;
            
            confirmMessage = `Catat Datang (${keterangan}) pada ${displayTime}?`;

        } else if (type === 'pulang') {
            document.getElementById(`jam_pulang_input_${siswaId}`).value = timeValue;
            
            confirmMessage = `Catat Pulang pada ${displayTime}?`;
        }
        
        if (confirm(confirmMessage)) {
            // Perbarui tampilan waktu di tombol setelah konfirmasi
            document.getElementById(`time_${type}_${siswaId}`).textContent = displayTime;
            
            // Lanjutkan submit form
            form.submit();
        }
        
        return false;
    }
</script>

@endsection