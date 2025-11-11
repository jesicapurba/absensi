@extends('layouts.app') 

@section('content')
<div class="p-6">
    <h2 class="text-3xl font-bold mb-6">Rekap Absensi Siswa</h2>
    

    @if (auth()->user()->role == 'user')
    <div class="mb-4 space-x-2">
        <a href="{{ route('presensi.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded">
            Absensi Masuk
        </a>
        <a href="{{ route('presensi.formPulang') }}" class="bg-red-500 hover:bg-red-600 text-white py-2 px-4 rounded">
            Absensi Pulang
        </a>
    </div>
    @endif
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">{{ session('error') }}</div>
    @endif

    <div class="overflow-x-auto bg-white shadow rounded-lg">
        <table class="min-w-full leading-normal">
            <thead>
                <tr>
                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Tanggal
                    </th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Nama
                    </th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Keterangan
                    </th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Jam Masuk
                    </th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Jam Pulang
                    </th>
                </tr>
            </thead>
            <tbody>
                {{-- LOOPING DATA ABSENSI --}}
                @forelse ($presensis as $presensi)
                <tr>
                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                        {{ $presensi->created_at->format('d/m/Y') }}
                    </td>
                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                        {{ $presensi->nama }}
                    </td>
                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                        <span class="p-1 rounded text-white text-xs {{ $presensi->keterangan == 'Hadir' ? 'bg-green-500' : 'bg-yellow-500' }}">
                            {{ $presensi->keterangan }}
                        </span>
                    </td>
                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm font-medium">
                        {{ $presensi->jam_masuk ? $presensi->jam_masuk->format('H:i:s') : '-' }}
                    </td>
                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm font-medium">
                        {{ $presensi->jam_pulang ? $presensi->jam_pulang->format('H:i:s') : 'Belum Pulang' }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-4 bg-white text-gray-500">
                        Belum ada data absensi yang tercatat.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection