<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfilController extends Controller
{
    private function ambilUser(Request $request)
    {
        $sesi = $request->session()->get('user');

        if (!$sesi) {
            return null;
        }

        return DB::table('ms_user')->where('id_user', $sesi['id'])->first();
    }

    public function show(Request $request)
    {
        $user = $this->ambilUser($request);

        if (!$user) {
            return response()->json(['message' => 'Belum login.'], 401);
        }

        return response()->json([
            'nama'     => $user->nama,
            'username' => $user->username,
            'role'     => $user->role,
        ]);
    }

    public function update(Request $request)
    {
        $user = $this->ambilUser($request);

        if (!$user) {
            return response()->json(['message' => 'Belum login.'], 401);
        }

        $request->validate([
            'nama'          => 'required|string|max:50',
            'username'      => [
                'required', 'string', 'max:50',
                Rule::unique('ms_user', 'username')->ignore($user->id_user, 'id_user'),
            ],
            'password_baru' => 'nullable|string|min:6|confirmed',
            'password_lama' => 'required_with:password_baru',
        ], [
            'nama.required'                => 'Nama lengkap wajib diisi.',
            'username.required'            => 'Username wajib diisi.',
            'username.unique'              => 'Username sudah dipakai akun lain.',
            'password_baru.min'            => 'Password baru minimal 6 karakter.',
            'password_baru.confirmed'      => 'Konfirmasi password baru tidak sama.',
            'password_lama.required_with'  => 'Password lama wajib diisi untuk mengganti password.',
        ]);

        $data = [
            'nama'     => $request->nama,
            'username' => $request->username,
        ];

        if ($request->filled('password_baru')) {
            if (!Hash::check($request->password_lama, $user->password)) {
                return response()->json(['message' => 'Password lama salah.'], 422);
            }

            $data['password'] = Hash::make($request->password_baru);
        }

        DB::table('ms_user')->where('id_user', $user->id_user)->update($data);

        $request->session()->put('user', [
            'id'       => $user->id_user,
            'nama'     => $data['nama'],
            'username' => $data['username'],
            'role'     => $user->role,
        ]);

        return response()->json([
            'message'  => 'Profil berhasil diperbarui.',
            'nama'     => $data['nama'],
            'username' => $data['username'],
            'role'     => $user->role,
        ]);
    }
}