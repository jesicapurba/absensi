<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth; // Digunakan untuk Auth::id()

class SiswaController extends Controller
{
    public function index(Request $request)
    {
        $query = Siswa::query();

        if ($request->has('search') && $request->search != '') {
            $searchTerm = $request->search;
            
            // Perbaikan: Menggunakan closure untuk pencarian OR yang aman
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%')
                  ->orWhere('asal_sekolah', 'like', '%' . $searchTerm . '%')
                  ->orWhere('jurusan', 'like', '%' . $searchTerm . '%');
            });
        }

        // Pastikan variabel yang dikirimkan ke view adalah 'siswas' agar konsisten dengan foreach di view
        $siswas = $query->paginate(10); 
        return view('siswa.index', compact('siswas')); // Mengirimkan 'siswas'
    }

    public function create()
    {
        return view('siswa.create');
    }

    public function edit(Siswa $siswa)
    {
        return view('siswa.edit', compact('siswa'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            // NIS diubah menjadi required dan unique
            'nis' => 'required|numeric|unique:siswa,nis', 
            'name' => 'required|string|max:255',
            'asal_sekolah'=> 'nullable|string|max:100',
            'jurusan' =>'required|string|in:TKJ,RPL,DKV,ANIMASI',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        try {
            // Tambahkan user_id sebelum menyimpan
            $validatedData['user_id'] = Auth::id(); 
            
            // Simpan data
            Siswa::create($validatedData);

            return redirect()->route('siswa.index')
                ->with('success', 'Data siswa berhasil ditambahkan.');
                
        } catch (\Exception $e) {
            \Log::error('Siswa Store Error: ' . $e->getMessage()); 
            return redirect()->back()
                ->with('error', 'Gagal menyimpan data. Silakan coba lagi.')
                ->withInput();
        }
    }

    public function show($id)
    {
        $siswa = \App\Models\Siswa::with('presensi')->findOrFail($id);
        return view('siswa.show', compact('siswa'));
    }

    public function update(Request $request, Siswa $siswa)
    {
        $request->validate([
            // NIS disesuaikan agar unique kecuali NIS siswa yang sedang diedit
            'nis' => 'required|numeric|unique:siswa,nis,' . $siswa->id, 
            'name' => 'required|string|max:255',
            'asal_sekolah'=> 'nullable|string|max:100',
            'jurusan' => 'required|string|in:TKJ,RPL,DKV,ANIMASI',
        ]);

        // Perbaikan: gunakan $request->only() atau $request->except(['_token', '_method']) 
        // untuk menghindari potensi masalah keamanan jika Anda tidak ingin menyertakan user_id
        $siswa->update($request->only(['nis', 'name', 'asal_sekolah', 'jurusan'])); 

        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil diperbarui.');
    }

    public function destroy(Siswa $siswa): RedirectResponse
    {
        $siswa->delete();

        return redirect()->route('siswa.index')
            ->with('success', 'Data siswa berhasil dihapus.');
    }
}