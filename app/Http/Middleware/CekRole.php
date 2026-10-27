<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CekRole
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->session()->get('user');

        if (!$user || !in_array($user['role'], $roles, true)) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Akses ditolak.'], 403);
            }

            return redirect('/dashboard');
        }

        return $next($request);
    }
}