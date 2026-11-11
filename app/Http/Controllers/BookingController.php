<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    private const ZONA = 'Asia/Jakarta';

    // Booking dengan status ini dianggap masih memakai ruangan
    private const STATUS_AKTIF = ['Booking', 'Sedang Main'];

    // Simpan booking baru
    public function store(Request $request)
    {
        // Rapikan nomor HP: buang spasi dan tanda hubung
        $request->merge([
            'no_telepon' => preg_replace('/[\s\-]+/', '', (string) $request->input('no_telepon')),
        ]);

        $data = $request->validate([
            'nama_customer' => 'required|string|max:50',
            'no_telepon'    => ['required', 'regex:/^\+?[0-9]{8,15}$/'],
            'id_ruangan'    => 'required|integer',
            'tanggal'       => 'required|date_format:Y-m-d',
            'jam_mulai'     => 'required|date_format:H:i',
            'durasi'        => 'required|integer|min:1|max:5',
        ], [
            'nama_customer.required' => 'Nama pelanggan wajib diisi.',
            'nama_customer.max'      => 'Nama pelanggan maksimal 50 karakter.',
            'no_telepon.required'    => 'Nomor HP wajib diisi.',
            'no_telepon.regex'       => 'Nomor HP tidak valid. Gunakan 8 sampai 15 angka.',
            'id_ruangan.required'    => 'Ruangan wajib dipilih.',
            'id_ruangan.integer'     => 'Ruangan tidak valid.',
            'tanggal.required'       => 'Tanggal wajib diisi.',
            'tanggal.date_format'    => 'Format tanggal tidak valid.',
            'jam_mulai.required'     => 'Jam mulai wajib diisi.',
            'jam_mulai.date_format'  => 'Format jam mulai tidak valid.',
            'durasi.required'        => 'Durasi sewa wajib dipilih.',
            'durasi.min'             => 'Durasi sewa minimal 1 jam.',
            'durasi.max'             => 'Durasi sewa maksimal 5 jam.',
        ]);

        $sesi = $request->session()->get('user');

        $ruangan = DB::table('ms_ruangan')->where('id_ruangan', $data['id_ruangan'])->first();

        if (!$ruangan) {
            return response()->json(['message' => 'Ruangan tidak ditemukan.'], 422);
        }

        if ($ruangan->status_ruangan === 'Maintenance') {
            return response()->json([
                'message' => $ruangan->nama_ruangan . ' sedang Maintenance dan tidak dapat dipesan.',
            ], 422);
        }

        $sekarang = Carbon::now(self::ZONA);

        if ($data['tanggal'] < $sekarang->toDateString()) {
            return response()->json(['message' => 'Tanggal booking tidak boleh sebelum hari ini.'], 422);
        }

        $mulai   = Carbon::createFromFormat('Y-m-d H:i', $data['tanggal'] . ' ' . $data['jam_mulai'], self::ZONA);
        $selesai = $mulai->copy()->addHours((int) $data['durasi']);

        // Jam mulai yang sudah lewat jauh tidak boleh dipesan (toleransi 15 menit)
        if ($mulai->lt($sekarang->copy()->subMinutes(15))) {
            return response()->json([
                'message' => 'Jam mulai sudah lewat. Pilih jam yang belum terlewat.',
            ], 422);
        }

        // Kolom jam hanya menyimpan satu hari, jadi sewa harus selesai sebelum pukul 24.00
        if ($selesai->toDateString() !== $mulai->toDateString()) {
            return response()->json([
                'message' => 'Waktu sewa harus selesai sebelum pukul 24.00. Kurangi durasi atau majukan jam mulai.',
            ], 422);
        }

        $hasil = DB::transaction(function () use ($data, $sesi, $ruangan, $mulai, $selesai) {
            // Kunci baris ruangan supaya dua kasir tidak memesan jam yang sama bersamaan
            DB::table('ms_ruangan')
                ->where('id_ruangan', $ruangan->id_ruangan)
                ->lockForUpdate()
                ->first();

            $bentrok = DB::table('tr_booking')
                ->where('id_ruangan', $ruangan->id_ruangan)
                ->where('tanggal_booking', $data['tanggal'])
                ->whereIn('status_booking', self::STATUS_AKTIF)
                ->where('waktu_mulai', '<', $selesai->format('H:i:s'))
                ->where('estimasi_selesai', '>', $mulai->format('H:i:s'))
                ->first();

            if ($bentrok) {
                return [
                    'error' => $ruangan->nama_ruangan . ' sudah dipesan pada pukul '
                        . substr($bentrok->waktu_mulai, 0, 5) . ' - '
                        . substr($bentrok->estimasi_selesai, 0, 5)
                        . '. Pilih jam atau ruangan lain.',
                ];
            }

            // Pelanggan dicari lewat nomor HP, kalau belum ada dibuat baru
            $customer = DB::table('ms_customer')
                ->where('no_telepon', $data['no_telepon'])
                ->first();

            if ($customer) {
                $idCustomer = $customer->id_customer;

                if ($customer->nama_customer !== $data['nama_customer']) {
                    DB::table('ms_customer')
                        ->where('id_customer', $idCustomer)
                        ->update(['nama_customer' => $data['nama_customer']]);
                }
            } else {
                $idCustomer = DB::table('ms_customer')->insertGetId([
                    'nama_customer' => $data['nama_customer'],
                    'no_telepon'    => $data['no_telepon'],
                ]);
            }

            $idBooking = DB::table('tr_booking')->insertGetId([
                'id_user'          => $sesi['id'],
                'id_customer'      => $idCustomer,
                'id_ruangan'       => $ruangan->id_ruangan,
                'tanggal_booking'  => $data['tanggal'],
                'waktu_mulai'      => $mulai->format('H:i:s'),
                'estimasi_selesai' => $selesai->format('H:i:s'),
                'status_booking'   => 'Booking',
            ]);

            return ['id_booking' => $idBooking];
        });

        if (isset($hasil['error'])) {
            return response()->json(['message' => $hasil['error']], 422);
        }

        return response()->json([
            'message'    => 'Booking untuk ' . $data['nama_customer'] . ' di ' . $ruangan->nama_ruangan
                . ' pada pukul ' . $mulai->format('H:i') . ' - ' . $selesai->format('H:i')
                . ' berhasil disimpan.',
            'id_booking' => $hasil['id_booking'],
            'total'      => $ruangan->tarif_per_jam * (int) $data['durasi'],
        ], 201);
    }

    // Jadwal yang sudah terisi pada satu ruangan di satu tanggal
    public function jadwal(Request $request)
    {
        $data = $request->validate([
            'id_ruangan' => 'required|integer',
            'tanggal'    => 'required|date_format:Y-m-d',
        ]);

        $baris = DB::table('tr_booking as b')
            ->join('ms_customer as c', 'c.id_customer', '=', 'b.id_customer')
            ->where('b.id_ruangan', $data['id_ruangan'])
            ->where('b.tanggal_booking', $data['tanggal'])
            ->whereIn('b.status_booking', self::STATUS_AKTIF)
            ->orderBy('b.waktu_mulai')
            ->get(['b.waktu_mulai', 'b.estimasi_selesai', 'b.status_booking', 'c.nama_customer']);

        $hasil = [];

        foreach ($baris as $b) {
            $hasil[] = [
                'mulai'   => substr($b->waktu_mulai, 0, 5),
                'selesai' => substr($b->estimasi_selesai, 0, 5),
                'status'  => $b->status_booking,
                'nama'    => $b->nama_customer,
            ];
        }

        return response()->json($hasil);
    }
}