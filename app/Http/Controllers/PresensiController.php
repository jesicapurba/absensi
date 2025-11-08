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
            // Ambil semua data siswa yang dibutuhkan
            $all_siswa = Siswa::select('id', 'name')->get(); // Sesuaikan 'name' dengan field nama di tabel Anda
            
            // Kirim data ke view
            return view('presensi.create', compact('all_siswa')); 
        

    }
    

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

    $request->validate([
    'name' => 'required|string|max:100',
    'keterangan' => 'required|string|in:Hadir,Izin,Sakit,Alfa',
    'jam_masuk' => 'required|date',
    'jam_pulang' => 'required|date|after_or_equal:datang',  

    ]);

    Presensi::create($request->all());
    

    return redirect()->route('presensi.index')->with('success','Presensi berhasil ditambahakan');
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