@extends('layouts.app') 

@section('content')
<div class="bg-white rounded-lg shadow-xl p-8 max-w-lg mx-auto mt-10">
    <h2 class="text-3xl font-bold text-gray-800 mb-6 border-b pb-3">
        Catat Presensi Pulang Siswa
    </h2>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">{{ session('error') }}</div>
    @endif

    <form action="{{ route('presensi.storePulang') }}" method="POST">
        @csrf
        
        <div class="mb-6">
            <label for="name" class="block text-gray-700 font-semibold mb-2">Nama Siswa</label>
            {{-- Nama input adalah 'nama_pulang' sesuai Controller storePulang --}}
            <input type="text" name="name" id="name" value="{{ old('name') }}" 
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500" 
                   required>
            @error('name') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
        </div>
        

        <div class="flex justify-between items-center">
            <a href="{{ route('presensi.index') }}" class="text-gray-600 hover:text-gray-800">
                &larr; Lihat Rekap
            </a>
            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-6 rounded-lg transition duration-200">
                Catat Jam Pulang 
            </button>
        </div>
    </form>
</div>
@endsection