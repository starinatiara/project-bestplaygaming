<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    // Daftar semua akun
    public function index()
    {
        $users = DB::table('ms_user')
            ->select('id_user', 'nama', 'username', 'role', 'status')
            ->orderBy('id_user')
            ->get();

        return response()->json($users);
    }

    // Tambah akun baru
    public function store(Request $request)
    {
        $data = $request->validate([
            'nama'     => 'required|string|max:50',
            'username' => 'required|string|max:50|unique:ms_user,username',
            'password' => 'required|string|min:6',
            'role'     => ['required', Rule::in(['superadmin', 'kasir'])],
            'status'   => ['nullable', Rule::in(['Aktif', 'Nonaktif'])],
        ], [
            'nama.required'     => 'Nama lengkap wajib diisi.',
            'username.required' => 'Username wajib diisi.',
            'username.unique'   => 'Username sudah dipakai akun lain.',
            'password.required' => 'Password wajib diisi.',
            'password.min'      => 'Password minimal 6 karakter.',
            'role.required'     => 'Role wajib dipilih.',
            'role.in'           => 'Role tidak valid.',
            'status.in'         => 'Status tidak valid.',
        ]);

        $id = DB::table('ms_user')->insertGetId([
            'nama'     => $data['nama'],
            'username' => $data['username'],
            'password' => Hash::make($data['password']),
            'role'     => $data['role'],
            'status'   => $data['status'] ?? 'Aktif',
        ]);

        return response()->json([
            'message' => 'User berhasil ditambahkan.',
            'id_user' => $id,
        ], 201);
    }

    // Ubah akun
    public function update(Request $request, $id)
    {
        $user = DB::table('ms_user')->where('id_user', $id)->first();

        if (!$user) {
            return response()->json(['message' => 'User tidak ditemukan.'], 404);
        }

        $data = $request->validate([
            'nama'     => 'required|string|max:50',
            'username' => [
                'required', 'string', 'max:50',
                Rule::unique('ms_user', 'username')->ignore($id, 'id_user'),
            ],
            'password' => 'nullable|string|min:6',
            'role'     => ['required', Rule::in(['superadmin', 'kasir'])],
            'status'   => ['required', Rule::in(['Aktif', 'Nonaktif'])],
        ], [
            'nama.required'     => 'Nama lengkap wajib diisi.',
            'username.required' => 'Username wajib diisi.',
            'username.unique'   => 'Username sudah dipakai akun lain.',
            'password.min'      => 'Password minimal 6 karakter.',
            'role.in'           => 'Role tidak valid.',
            'status.required'   => 'Status wajib dipilih.',
            'status.in'         => 'Status tidak valid.',
        ]);

        $sesi = $request->session()->get('user');
        $akunSendiri = $sesi && (int) $sesi['id'] === (int) $id;

        // Role dan status akun yang sedang dipakai tidak boleh diubah
        if ($akunSendiri && $data['role'] !== $user->role) {
            return response()->json([
                'message' => 'Role akun yang sedang Anda pakai tidak dapat diubah.',
            ], 422);
        }

        if ($akunSendiri && $data['status'] !== 'Aktif') {
            return response()->json([
                'message' => 'Akun yang sedang Anda pakai tidak dapat dinonaktifkan.',
            ], 422);
        }

        $ubah = [
            'nama'     => $data['nama'],
            'username' => $data['username'],
            'role'     => $data['role'],
            'status'   => $data['status'],
        ];

        // Password hanya diubah kalau diisi
        if (!empty($data['password'])) {
            $ubah['password'] = Hash::make($data['password']);
        }

        DB::table('ms_user')->where('id_user', $id)->update($ubah);

        // Kalau yang diubah akun sendiri, perbarui session
        if ($akunSendiri) {
            $request->session()->put('user', [
                'id'       => $user->id_user,
                'nama'     => $ubah['nama'],
                'username' => $ubah['username'],
                'role'     => $user->role,
            ]);
        }

        return response()->json(['message' => 'User berhasil diperbarui.']);
    }

    // Hapus akun (hanya untuk akun yang belum punya data)
    public function destroy(Request $request, $id)
    {
        $user = DB::table('ms_user')->where('id_user', $id)->first();

        if (!$user) {
            return response()->json(['message' => 'User tidak ditemukan.'], 404);
        }

        $sesi = $request->session()->get('user');

        if ($sesi && (int) $sesi['id'] === (int) $id) {
            return response()->json([
                'message' => 'Anda tidak dapat menghapus akun yang sedang digunakan.',
            ], 422);
        }

        if ($user->role === 'superadmin'
            && DB::table('ms_user')->where('role', 'superadmin')->count() <= 1) {
            return response()->json([
                'message' => 'Superadmin terakhir tidak dapat dihapus.',
            ], 422);
        }

        try {
            DB::table('ms_user')->where('id_user', $id)->delete();
        } catch (QueryException $e) {
            // Akun sudah dipakai di tabel lain (misalnya tr_booking)
            return response()->json([
                'message' => 'Akun ini sudah tercatat pada data booking, jadi tidak dapat dihapus. Ubah statusnya menjadi Nonaktif agar datanya tetap tersimpan.',
            ], 422);
        }

        return response()->json(['message' => 'User berhasil dihapus.']);
    }
}