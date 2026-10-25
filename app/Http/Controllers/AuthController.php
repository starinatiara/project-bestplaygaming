<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = DB::table('ms_user')
            ->where('username', $request->username)
            ->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Username atau password salah.',
            ], 422);
        }

        // Akun nonaktif tidak boleh login (datanya tetap tersimpan)
        if (($user->status ?? 'Aktif') !== 'Aktif') {
            return response()->json([
                'message' => 'Akun Anda nonaktif. Silakan hubungi superadmin.',
            ], 403);
        }

        $request->session()->regenerate();
        $request->session()->put('user', [
            'id'       => $user->id_user,
            'nama'     => $user->nama,
            'username' => $user->username,
            'role'     => $user->role,
        ]);

        return response()->json([
            'username' => $user->username,
            'nama'     => $user->nama,
            'role'     => $user->role,
            'redirect' => '/dashboard',
        ]);
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}