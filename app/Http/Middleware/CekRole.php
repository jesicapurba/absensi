<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Siswa;

class CekRole
{
   //middleware untuk mengecek peran (role) pengguna sebelum mengakses suatu halaman
    public function handle(Request $request, Closure $next, string $role): Siswa
    {
        //mengecek apakah pengguna sudah login dan memiliki peran yang sesuai
        if (!$request->user() || $request->user()->role !== $role) {
            abort(403, 'Unauthorized'); //jika tidak sesuai, hentikan proses dengan error 403 (Forbidden)
        }
        //jika sesuai, lanjutkan ke request berikutnya
        return $next($request);
    }
}
