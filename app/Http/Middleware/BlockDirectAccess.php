<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class BlockDirectAccess
{
    public function handle(Request $request, Closure $next)
    {
        $referer  = $request->headers->get('referer');
        $fromSelf = $referer && parse_url($referer, PHP_URL_HOST) === $request->getHost();
        $lastPage = session('last_page');

        // URL diketik langsung, dan sudah punya halaman aktif -> kembalikan ke halaman itu
        if (!$fromSelf && $lastPage && $lastPage !== $request->fullUrl()) {
            return redirect($lastPage);
        }

        $response = $next($request);

        if ($response->getStatusCode() === 200) {
            session(['last_page' => $request->fullUrl()]);
        }

        return $response;
    }
}