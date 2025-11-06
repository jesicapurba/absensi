<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\SiswaController;

class SiswaController extends Controller
{
    public function index(Request $request)
    {
        // ini buat mengambil query dari table karyawan
        $query = Siswa::query();

        // kalau ada pencarian 
        if($request->has('search') && $request->search != ''){
            $query->where('name', 'like', '%' . $request->search . '%')
            ->orWhere('asal_sekolah', 'like', '%' . $request->search . '%')
            ->orWhere('jurusan', 'like', '%' . $request->search . '%');
        }

        $siswa = $query->paginate(10);
        return view('siswa.index', compact('siswa'));
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
             $request->validate([
            'nis' => 'nullable|max:50',
            'name' => 'required|string|max:255',
            'asal_sekolah'=> 'nullable|max:100',
            'jurusan' =>'required|string|in:TKJ,RPL,DKV,ANIMASI',
        ]);

        
        Siswa::create(array_merge($request->all(), ['user_id' =>Auth::id()]));

        return redirect()->route('siswa.index')
            ->with('success', 'Data siswa berhasil ditambahkan.');
    }

    public function show($id)
    {
        $siswa = \App\Models\Siswa::with('presensi')->findOrFail($id);
        return view('siswa.show', compact('siswa'));
    }


    public function update(Request $request, Siswa $siswa)
    {
        $request->validate([
            'nis' => 'nullable|max:50',
            'name' => 'required|string|max:255',
            'asal_sekolah'=> 'nullable|max:100',
            'jurusan' => 'required|string|in:TKJ,RPL,DKV,ANIMASI',
        ]);

        $siswa->update($request->all());

        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil diperbarui.');
    }

    public function destroy(Siswa $siswa): RedirectResponse
    {
        $siswa->delete();

        return redirect()->route('siswa.index')
            ->with('success', 'Data siswa berhasil dihapus.');
    }
}