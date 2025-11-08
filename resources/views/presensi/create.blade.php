@extends('layouts.app')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6 max-w-3xl mx-auto">
    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Presensi Siswa Hari Ini</h2>

    <form id="form-presensi" action="{{ route('presensi.store') }}" method="POST">
        @csrf
        
        <div class="mb-4">
            <label for="name" class="block text-gray-700 mb-2">Nama Siswa</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" 
                   class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            {{-- PERBAIKAN: Validasi @error harus menggunakan 'name' bukan 'nama' --}}
            @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        
        <div class="mb-4">
            <label for="keterangan" class="block text-gray-700 mb-2">Keterangan</label>
            {{-- PERBAIKAN: Hapus tag <td> dan atribut class yang tidak perlu di sini --}}
            <select name="keterangan" id="keterangan" 
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                <option disabled selected>-- Pilih Keterangan --</option>  
                <option value="Hadir" {{ old('keterangan') == 'Hadir' ? 'selected' : '' }}>Hadir</option>
                <option value="Izin" {{ old('keterangan') == 'Izin' ? 'selected' : '' }}>Izin</option>
                <option value="Sakit" {{ old('keterangan') == 'Sakit' ? 'selected' : '' }}>Sakit</option>
                <option value="Alfa" {{ old('keterangan') == 'Alfa' ? 'selected' : '' }}>Alfa</option>
            </select>
            @error('keterangan') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>
        
        <hr class="my-6">
        
        <div class="mb-6 text-center">
            <p class="text-lg font-medium text-gray-700 mb-2">Waktu Saat Ini:</p>
            <div id="realtime-clock" class="text-4xl font-bold text-blue-600"></div>
            <p class="text-sm text-gray-500 mt-1">Gunakan tombol di bawah untuk mencatat Jam Datang / Pulang.</p>
        </div>

        <input type="hidden" name="jam_datang" id="jam-datang-input">
        
        <div class="mb-4 flex items-center justify-between p-3 border rounded-lg bg-gray-50">
            <label class="text-gray-700 font-medium">Jam Datang:</label>
            <div id="jam-datang-display" class="text-xl font-semibold text-green-600">--:--</div>
            <button type="button" onclick="recordTime('datang')" 
                    class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded-lg text-sm">
                Catat Datang
            </button>
        </div>

        <input type="hidden" name="jam_pulang" id="jam-pulang-input">

        <div class="mb-6 flex items-center justify-between p-3 border rounded-lg bg-gray-50">
            <label class="text-gray-700 font-medium">Jam Pulang:</label>
            <div id="jam-pulang-display" class="text-xl font-semibold text-red-600">--:--</div>
            <button type="button" onclick="recordTime('pulang')" 
                    class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-lg text-sm">
                Catat Pulang
            </button>
        </div>
        
        <div class="flex justify-end">
            <a href="{{ url('/') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg mr-2">Batal</a>
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">Simpan Presensi</button>
        </div>
    </form>
</div>

<script>
    // Fungsi untuk menampilkan jam real-time
    function updateClock() {
        const now = new Date();
        // Format jam dan menit (HH:MM:SS)
        const timeString = now.toLocaleTimeString('id-ID', { 
            hour: '2-digit', 
            minute: '2-digit', 
            second: '2-digit' 
        });
        document.getElementById('realtime-clock').textContent = timeString;
    }

    // Perbarui jam setiap detik
    setInterval(updateClock, 1000);
    // Jalankan sekali saat load
    updateClock();

    // Fungsi untuk mencatat jam (datang atau pulang)
    function recordTime(type) {
        const now = new Date();
        // Format waktu untuk disimpan di input tersembunyi (HH:MM:SS)
        const timeValue = now.toLocaleTimeString('id-ID', { 
            hour: '2-digit', 
            minute: '2-digit', 
            second: '2-digit' 
        });
        // Format jam dan menit untuk ditampilkan (HH:MM)
        const displayTime = now.toLocaleTimeString('id-ID', { 
            hour: '2-digit', 
            minute: '2-digit' 
        });

        if (type === 'datang') {
            document.getElementById('jam-datang-input').value = timeValue;
            document.getElementById('jam-datang-display').textContent = displayTime;
            alert('Jam Datang telah dicatat: ' + displayTime);
        } else if (type === 'pulang') {
            document.getElementById('jam-pulang-input').value = timeValue;
            document.getElementById('jam-pulang-display').textContent = displayTime;
            alert('Jam Pulang telah dicatat: ' + displayTime);
        }
    }
</script>
@endsection