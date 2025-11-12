<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\PresensiController;
use App\Models\Presensi;
use App\Models\Siswa;



// ini bagian dari link/url tampilan siswa
Route::get('/siswa',[SiswaController::class, 
'index'])->middleware('auth')->name('siswa.index');

Route::get('/siswa/create',[SiswaController::class, 
'create'])->name('siswa.create');

Route::post('siswa/siswaStore',[SiswaController::class, 
'store'])->name('siswa.store');

Route::get('/siswa/{id}', [SiswaController::class, 
'show'])->name('presensi.show');

Route::get('/siswa/{siswa}/edit',[SiswaController::class, 
'edit'])->name('siswa.edit');

Route::put('/siswa/{siswa}',[SiswaController::class, 
'update'])->name('siswa.update');

Route::delete('siswa/{siswa}',[SiswaController::class, 
'destroy'])->name('siswa.destroy');

// ini bagian dari link/url tampilan presensi
Route::get('/presensi/index', [PresensiController::class, 
'index'])->middleware('auth')->name('presensi.index');

Route::get('/presensi/create', [PresensiController::class, 
'create'])->name('presensi.create');

// Form Masuk (GET)
Route::get('/presensi/masuk/form', [PresensiController::class, 'create'])->name('presensi.create'); 

// Aksi Simpan Masuk (POST)
Route::post('/presensi/masuk', [PresensiController::class, 'storeMasuk'])->name('presensi.storeMasuk');

// Form Pulang (GET) - SOLUSI Method Not Allowed
Route::get('/presensi/pulang/form', [PresensiController::class, 'formPulang'])->name('presensi.formPulang'); 

// Aksi Simpan Pulang (POST)
Route::post('/presensi/pulang', [PresensiController::class, 'storePulang'])->name('presensi.storePulang');

Route::post('presensi', [PresensiController::class, 
'store'])->name('presensi.store');

Route::delete('presensi/{siswa_id}',[PresensiController::class, 
'destroy'])->name('presensi.destroy');

// ini bagian dari link/url tampilan register, login dan logout
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('auth/postRegister', [AuthController::class, 'register'])->name('postRegister');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/siswa', [SiswaController::class, 'index'])->name('siswa.index');

Route::get('/presensi', [PresensiController::class, 'index'])->name('presensi.index');

// // ini bagian dari link/url tampilan dashboard
// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware('auth')->name('dashboard');

// protected routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::resource('siswa', SiswaController::class);
    
    Route::get('/', function () {
        return redirect()->route('dashboard');

        // Rute yang bisa diakses oleh SEMUA pengguna yang sudah login
Route::middleware(['auth'])->group(function () {
    Route::get('/home', function () {
        return view('user.dashboard');
    })->name('home');
});
    });
});
