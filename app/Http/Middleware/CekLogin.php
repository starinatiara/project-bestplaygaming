<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CekLogin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->session()->has('user')) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Belum login.'], 401);
            }

            return redirect('/login');
        }

        $response = $next($request);

        // Supaya tombol Back setelah logout tidak menampilkan halaman dari cache
        $response->headers->set('Cache-Control', 'no-cache, no-store, must-revalidate');

        return $response;
    }
}