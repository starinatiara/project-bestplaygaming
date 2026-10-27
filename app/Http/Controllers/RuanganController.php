<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class RuanganController extends Controller
{
    private const JENIS  = ['PS5', 'PS4'];
    private const STATUS = ['Tersedia', 'Digunakan', 'Maintenance'];

    // Aturan validasi (dipakai tambah dan ubah)
    private function aturan($idDiabaikan = null): array
    {
        $unik = Rule::unique('ms_ruangan', 'nama_ruangan');

        if ($idDiabaikan !== null) {
            $unik = $unik->ignore($idDiabaikan, 'id_ruangan');
        }

        return [
            'nama_ruangan'   => ['required', 'string', 'max:15', $unik],
            'jenis_ruangan'  => ['required', Rule::in(self::JENIS)],
            'tarif_per_jam'  => ['required', 'integer', 'min:5000', 'max:1000000'],
            'status_ruangan' => ['required', Rule::in(self::STATUS)],
        ];
    }

    private function pesan(): array
    {
        return [
            'nama_ruangan.required'   => 'Nama ruangan wajib diisi.',
            'nama_ruangan.max'        => 'Nama ruangan maksimal 15 karakter.',
            'nama_ruangan.unique'     => 'Nama ruangan sudah dipakai ruangan lain.',
            'jenis_ruangan.required'  => 'Kategori konsol wajib dipilih.',
            'jenis_ruangan.in'        => 'Kategori konsol tidak valid.',
            'tarif_per_jam.required'  => 'Tarif per jam wajib diisi.',
            'tarif_per_jam.integer'   => 'Tarif per jam harus berupa angka.',
            'tarif_per_jam.min'       => 'Tarif per jam minimal Rp 5.000.',
            'tarif_per_jam.max'       => 'Tarif per jam terlalu besar.',
            'status_ruangan.required' => 'Status ruangan wajib dipilih.',
            'status_ruangan.in'       => 'Status ruangan tidak valid.',
        ];
    }

    // Daftar semua ruangan (boleh diakses superadmin dan kasir)
    public function index()
    {
        $ruangan = DB::table('ms_ruangan')
            ->select('id_ruangan', 'nama_ruangan', 'jenis_ruangan', 'tarif_per_jam', 'status_ruangan')
            ->orderBy('id_ruangan')
            ->get();

        return response()->json($ruangan);
    }

    // Tambah ruangan baru
    public function store(Request $request)
    {
        $data = $request->validate($this->aturan(), $this->pesan());

        $id = DB::table('ms_ruangan')->insertGetId([
            'nama_ruangan'   => $data['nama_ruangan'],
            'jenis_ruangan'  => $data['jenis_ruangan'],
            'tarif_per_jam'  => $data['tarif_per_jam'],
            'status_ruangan' => $data['status_ruangan'],
        ]);

        return response()->json([
            'message'    => 'Ruangan berhasil ditambahkan.',
            'id_ruangan' => $id,
        ], 201);
    }

    // Ubah ruangan
    public function update(Request $request, $id)
    {
        $ruangan = DB::table('ms_ruangan')->where('id_ruangan', $id)->first();

        if (!$ruangan) {
            return response()->json(['message' => 'Ruangan tidak ditemukan.'], 404);
        }

        $data = $request->validate($this->aturan($id), $this->pesan());

        DB::table('ms_ruangan')->where('id_ruangan', $id)->update([
            'nama_ruangan'   => $data['nama_ruangan'],
            'jenis_ruangan'  => $data['jenis_ruangan'],
            'tarif_per_jam'  => $data['tarif_per_jam'],
            'status_ruangan' => $data['status_ruangan'],
        ]);

        return response()->json(['message' => 'Ruangan berhasil diperbarui.']);
    }

    // Hapus ruangan (hanya untuk ruangan yang belum punya data booking)
    public function destroy($id)
    {
        $ruangan = DB::table('ms_ruangan')->where('id_ruangan', $id)->first();

        if (!$ruangan) {
            return response()->json(['message' => 'Ruangan tidak ditemukan.'], 404);
        }

        try {
            DB::table('ms_ruangan')->where('id_ruangan', $id)->delete();
        } catch (QueryException $e) {
            // Ruangan sudah dipakai di tabel lain (misalnya tr_booking)
            return response()->json([
                'message' => 'Ruangan ini sudah tercatat pada data booking, jadi tidak dapat dihapus. Ubah statusnya menjadi Maintenance agar tidak dipakai lagi.',
            ], 422);
        }

        return response()->json(['message' => 'Ruangan berhasil dihapus.']);
    }
}
