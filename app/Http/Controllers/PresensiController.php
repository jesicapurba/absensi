<?php

namespace App\Http\Controllers;

use App\Models\Presensi;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PresensiController extends Controller
{
    /**
     * Menampilkan rekap data presensi (presensi.index)
     */
    public function index()
    {
       // PresensiController@index
    $presensis = Presensi::with('siswa')->latest()->get(); 
    return view('presensi.index', compact('presensis'));
    }
    
    /**
     * Menampilkan form untuk Jam Masuk (presensi.create/masuk)
     * Kita bisa arahkan rute 'create' ke view form masuk.
     */
    public function create()
    {
        // Mengarahkan ke form Masuk (misalnya: resources/views/presensi/create.blade.php)
        return view('presensi.create');
    }

    // --- LOGIKA SIMPAN MASUK (storeMasuk) ---
    public function storeMasuk(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'keterangan' => 'required|in:Hadir,Izin,Sakit',
        ]);

        $namaSiswa = $validated['name'];
        $hariIni = Carbon::today(); // Mengambil tanggal hari ini (00:00:00)

        // 1. Pengecekan Absen Harian (SOLUSI ABSEN 1X SEHARI)
        $presensiHariIni = Presensi::where('name', $namaSiswa)
                                    ->whereDate('jam_masuk', $hariIni)
                                    ->first();

        if ($presensiHariIni) {
            // Jika record sudah ada untuk hari ini
            return redirect()->back()
                             ->with('error', 'Anda (' . $namaSiswa . ') sudah melakukan presensi hari ini. Tidak bisa absen dua kali.')
                             ->withInput();
        }

        try {
            // Tentukan waktu masuk
            $jamMasuk = Carbon::now();

            // 2. Simpan Data
            Presensi::create([
                'name' => $namaSiswa,
                'keterangan' => $validated['keterangan'],
                'jam_masuk' => $jamMasuk,
                // jam_pulang akan NULL
            ]);

            // 3. Redirect Sukses
            return redirect()->route('presensi.index')
                             ->with('success', 'Absensi ' . $namaSiswa . ' berhasil dicatat sebagai ' . $validated['keterangan'] . '!');

        } catch (\Exception $e) {
            ('Presensi Store Error: ' . $e->getMessage());
            return redirect()->back()
                             ->with('error', 'Gagal menyimpan data. Silakan coba lagi.')
                             ->withInput();
        }
    }
    
    // ... (metode lainnya)


    // --- LOGIKA SIMPAN PULANG (storePulang) ---
    public function storePulang(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $today = now()->toDateString();
        $presensi = Presensi::where('name', $request->name)
                            ->whereDate('jam_masuk', $today)
                            ->whereNull('jam_pulang') // Hanya yang belum pulang
                            ->first();

        if (!$presensi) {
            return redirect()->route('presensi.index')->with('error', 'Data masuk hari ini tidak ditemukan atau sudah pulang!');
        }

        // Update data Jam Pulang
        $presensi->update([
            'jam_pulang' => now(), // Waktu real-time server
        ]);

        return redirect()->route('presensi.index')->with('success', 'Presensi Pulang berhasil dicatat!');
    }
}