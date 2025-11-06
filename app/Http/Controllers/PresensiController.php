<?php

namespace App\Http\Controllers;

use App\Models\Presensi;
use App\Models\Siswa;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\RedirectResponse;

class PresensiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Presensi::query();

        // kalau ada pencarian
        if($request->has('search') && $request->search != ''){
            $query->where('name', 'like', '%' . $request->search . '%')
            ->orWhere('jurusan', 'like', '%' . $request->search . '%');
        }
        
        $presensi = $query->paginate(10);
        return view('presensi.index', compact('presensi'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $siswa = Siswa::findOrFail($request->siswa_id);

        $siswa = \App\Models\Siswa::findOrFail($request->siswa_id);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'jam_masuk' => 'required|date',
            'jam_pulang' => 'required|date|after_or_equal:datang',
        ]);

        
        $datang = Carbon::parse($request->datang);
        $pulang = Carbon::parse($request->pulang);
        
        $siswa = Presensi::findOrFail($request->siswa_id);

        Presensi::create([
            'siswa_id' =>$siswa->id,
            'name' => $request->name,
            'jam_masuk' => $request->jam_masuk,
            'jam_pulang' => $request->jam_pulang,
        ]);


        return redirect()->route('presensi.index')
                        ->with('success', 'Data presensi berhasil ditambahkan.');
    }


    /**
     * Display the specified resource.
     */
    public function update(Request $request, $id)
    {
        // ambil data pengajuan dan karyawan terkait
        $presensi = Presensi::findOrFail($id);
        $siswa = $presensi->siswa;

        $request->validate([
            'name' => 'required|string|max:100',
            'keterangan' => 'required|string|in:Hadir,Izin,Sakit,Alfa',
            'jam_masuk' => 'required|date',
            'jam_pulang' => 'required|date|after_or_equal:datang',
        ]);

       

        // jika karyawan diubah, ambil data karyawan baru
        if ($siswa->id != $request->siswa_id) {
            $siswa = Siswa::findOrFail($request->siswa_id);
        }


    }
    /**
     * Show the form for editing the specified resource.
     */
    public function destroy($id)
    {
        
    }
}