@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Detail Siswa</h2>
    <a href="{{ route('siswa.index') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg flex items-center">
            <i class="fas fa-plus mr-2"></i> Kembali
    </a><br><br>
    <div class="card mb-3">Data Siswa</div>
        <div class="card-body">
            <p><strong>Nama:</strong> {{ $siswa->name }}</p>
        </div>
    </div>

    <div class="card">
        <div class="card-header">Daftar Presensi</div>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Keterangan</th>
                            <th>Datang</th>
                            <th>Pulang</th>
                        </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>{{ $siswa->name }}</td>
                        <td>{{$siswa->keterangan }}</td>
                        <td>{{$siswa->jam_masuk }}</td>
                        <td>{{$siswa->jam_pulang }}</td>
                      </tr>
                       
                    </tbody>
                </table>
                <p>Belum ada presensi hari ini.</p>
        </div>
    </div>
</div>
@endsection