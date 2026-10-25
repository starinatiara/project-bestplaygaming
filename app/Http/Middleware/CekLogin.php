<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class CekLogin
{
    public function handle(Request $request, Closure $next): Response
    {
        $sesi = $request->session()->get('user');
        $diizinkan = false;

        if ($sesi) {
            // Cek ulang ke database: akun yang dihapus atau dinonaktifkan langsung ditolak
            $akun = DB::table('ms_user')->where('id_user', $sesi['id'])->first();
            $diizinkan = $akun && ($akun->status ?? 'Aktif') === 'Aktif';
        }

        if (!$diizinkan) {
            $request->session()->flush();

            if ($request->expectsJson()) {
                return response()->json(['message' => 'Belum login atau akun nonaktif.'], 401);
            }

            return redirect('/login');
        }

        $response = $next($request);

        // Supaya tombol Back setelah logout tidak menampilkan halaman dari cache
        $response->headers->set('Cache-Control', 'no-cache, no-store, must-revalidate');

        return $response;
    }
}