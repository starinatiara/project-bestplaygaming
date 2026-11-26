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

    // DITAMBAHKAN: riwayat semua booking (terbaru di atas), bisa difilter rentang tanggal
    public function riwayat(Request $request)
    {
        $data = $request->validate([
            'dari'   => 'nullable|date_format:Y-m-d',
            'sampai' => 'nullable|date_format:Y-m-d',
        ]);

        $query = DB::table('tr_booking as b')
            ->join('ms_customer as c', 'c.id_customer', '=', 'b.id_customer')
            ->join('ms_ruangan as r', 'r.id_ruangan', '=', 'b.id_ruangan')
            ->orderByDesc('b.tanggal_booking')
            ->orderByDesc('b.waktu_mulai')
            ->limit(500);

        if (!empty($data['dari'])) {
            $query->where('b.tanggal_booking', '>=', $data['dari']);
        }

        if (!empty($data['sampai'])) {
            $query->where('b.tanggal_booking', '<=', $data['sampai']);
        }

        $baris = $query->get([
            'b.tanggal_booking',
            'b.waktu_mulai',
            'b.estimasi_selesai',
            'b.status_booking',
            'c.nama_customer',
            'r.nama_ruangan',
            'r.tarif_per_jam',
        ]);

        $hasil = [];

        foreach ($baris as $b) {
            $durasi = (int) round(
                max(0, strtotime($b->estimasi_selesai) - strtotime($b->waktu_mulai)) / 3600
            );

            $hasil[] = [
                'tanggal'        => $b->tanggal_booking,
                'jam_mulai'      => substr($b->waktu_mulai, 0, 5),
                'nama_pelanggan' => $b->nama_customer,
                'ruangan'        => $b->nama_ruangan,
                'durasi'         => $durasi,
                'total'          => $b->tarif_per_jam * $durasi,
                'status'         => $b->status_booking,
            ];
        }

        return response()->json($hasil);
    }

    // =====================================================================
    // DITAMBAHKAN: STATUS RUANGAN DI HALAMAN /ruangan
    // =====================================================================

    // Perbarui status booking sesuai waktu sekarang:
    // Booking -> Sedang Main (jam mulai tiba) -> Selesai (jam selesai lewat)
    public static function sinkronStatus(): void
    {
        $sekarang = Carbon::now(self::ZONA);
        $tanggal  = $sekarang->toDateString();
        $jam      = $sekarang->format('H:i:s');

        // Jam selesai sudah lewat (atau tanggalnya sudah kemarin) -> Selesai
        DB::table('tr_booking')
            ->whereIn('status_booking', self::STATUS_AKTIF)
            ->where(function ($q) use ($tanggal, $jam) {
                $q->where('tanggal_booking', '<', $tanggal)
                  ->orWhere(function ($q2) use ($tanggal, $jam) {
                      $q2->where('tanggal_booking', $tanggal)
                         ->where('estimasi_selesai', '<=', $jam);
                  });
            })
            ->update(['status_booking' => 'Selesai']);

        // Jam mulai sudah tiba dan belum lewat jam selesai -> Sedang Main
        DB::table('tr_booking')
            ->where('status_booking', 'Booking')
            ->where('tanggal_booking', $tanggal)
            ->where('waktu_mulai', '<=', $jam)
            ->where('estimasi_selesai', '>', $jam)
            ->update(['status_booking' => 'Sedang Main']);
    }

    // Data jadwal semua ruangan untuk hari ini (dipakai halaman /ruangan)
    public function jadwalRuangan()
    {
        self::sinkronStatus();

        $tanggal = Carbon::now(self::ZONA)->toDateString();

        $booking = DB::table('tr_booking as b')
            ->join('ms_customer as c', 'c.id_customer', '=', 'b.id_customer')
            ->where('b.tanggal_booking', $tanggal)
            ->whereIn('b.status_booking', self::STATUS_AKTIF)
            ->orderBy('b.waktu_mulai')
            ->get([
                'b.id_booking',
                'b.id_ruangan',
                'b.waktu_mulai',
                'b.estimasi_selesai',
                'b.status_booking',
                'c.nama_customer',
            ])
            ->groupBy('id_ruangan');

        $ruangan = DB::table('ms_ruangan')
            ->orderBy('id_ruangan')
            ->get(['id_ruangan', 'nama_ruangan', 'jenis_ruangan', 'status_ruangan']);

        $hasil = [];

        foreach ($ruangan as $r) {
            $daftar = [];

            foreach ($booking->get($r->id_ruangan, collect()) as $b) {
                $daftar[] = [
                    'id_booking' => $b->id_booking,
                    'mulai'      => substr($b->waktu_mulai, 0, 5),
                    'selesai'    => substr($b->estimasi_selesai, 0, 5),
                    'status'     => $b->status_booking,
                    'nama'       => $b->nama_customer,
                ];
            }

            $hasil[] = [
                'id_ruangan'     => $r->id_ruangan,
                'nama_ruangan'   => $r->nama_ruangan,
                'jenis_ruangan'  => $r->jenis_ruangan,
                'status_ruangan' => $r->status_ruangan,
                'booking'        => $daftar,
            ];
        }

        return response()->json([
            'tanggal' => $tanggal,
            'ruangan' => $hasil,
        ]);
    }

    // Tombol "Selesai": hanya untuk booking yang sedang berjalan.
    // Status menjadi Selesai, sehingga ikut masuk laporan.
    public function selesai($id)
    {
        return $this->ubahStatus(
            $id,
            'Selesai',
            ['Sedang Main'],
            'Booking ditandai selesai.',
            'Hanya booking yang sedang berjalan yang bisa diselesaikan.'
        );
    }

    // Tombol "Batalkan": booking menjadi Dibatalkan, tidak masuk laporan.
    public function batal($id)
    {
        return $this->ubahStatus(
            $id,
            'Dibatalkan',
            self::STATUS_AKTIF,
            'Booking berhasil dibatalkan.',
            'Booking ini sudah selesai atau dibatalkan, jadi tidak dapat dibatalkan lagi.'
        );
    }

    // Ubah status satu booking, hanya jika status sekarang termasuk $statusAsal
    private function ubahStatus($id, string $statusBaru, array $statusAsal, string $pesanSukses, string $pesanGagal)
    {
        // Pastikan status sudah mengikuti waktu sebelum diperiksa
        self::sinkronStatus();

        $booking = DB::table('tr_booking')->where('id_booking', $id)->first();

        if (!$booking) {
            return response()->json(['message' => 'Booking tidak ditemukan.'], 404);
        }

        $diubah = DB::table('tr_booking')
            ->where('id_booking', $id)
            ->whereIn('status_booking', $statusAsal)
            ->update(['status_booking' => $statusBaru]);

        if (!$diubah) {
            return response()->json(['message' => $pesanGagal], 422);
        }

        return response()->json(['message' => $pesanSukses]);
    }

    // =====================================================================
    // DITAMBAHKAN: HALAMAN TRACKING (SEWA YANG SEDANG BERJALAN)
    // =====================================================================

    // Ubah "HH:MM:SS" menjadi jumlah detik sejak tengah malam
    private static function keDetik(string $waktu): int
    {
        $p = array_map('intval', explode(':', $waktu));

        return ($p[0] ?? 0) * 3600 + ($p[1] ?? 0) * 60 + ($p[2] ?? 0);
    }

    // Ubah jumlah detik menjadi "HH:MM:SS"
    private static function dariDetik(int $detik): string
    {
        return sprintf('%02d:%02d:%02d', intdiv($detik, 3600), intdiv($detik % 3600, 60), $detik % 60);
    }

    // Berapa jam (maksimal 5) sewa ini masih bisa diperpanjang.
    // Dibatasi oleh booking berikutnya di ruangan yang sama dan batas pukul 24.00.
    private static function maksTambahJam(object $booking): int
    {
        $akhir = self::keDetik($booking->estimasi_selesai);

        // Sewa harus tetap selesai sebelum pukul 24.00
        $sisaHari = intdiv(86399 - $akhir, 3600);

        $berikut = DB::table('tr_booking')
            ->where('id_ruangan', $booking->id_ruangan)
            ->where('tanggal_booking', $booking->tanggal_booking)
            ->where('id_booking', '<>', $booking->id_booking)
            ->whereIn('status_booking', self::STATUS_AKTIF)
            ->where('waktu_mulai', '>=', $booking->estimasi_selesai)
            ->orderBy('waktu_mulai')
            ->first();

        $batas = $sisaHari;

        if ($berikut) {
            $batas = min($batas, intdiv(self::keDetik($berikut->waktu_mulai) - $akhir, 3600));
        }

        return max(0, min(5, $batas));
    }

    // Daftar ruangan yang sedang disewa saat ini
    public function tracking()
    {
        self::sinkronStatus();

        $sekarang = Carbon::now(self::ZONA);
        $tanggal  = $sekarang->toDateString();

        $baris = DB::table('tr_booking as b')
            ->join('ms_customer as c', 'c.id_customer', '=', 'b.id_customer')
            ->join('ms_ruangan as r', 'r.id_ruangan', '=', 'b.id_ruangan')
            ->where('b.tanggal_booking', $tanggal)
            ->where('b.status_booking', 'Sedang Main')
            ->orderBy('b.waktu_mulai')
            ->get([
                'b.id_booking',
                'b.id_ruangan',
                'b.tanggal_booking',
                'b.waktu_mulai',
                'b.estimasi_selesai',
                'c.nama_customer',
                'r.nama_ruangan',
                'r.jenis_ruangan',
                'r.tarif_per_jam',
            ]);

        $hasil = [];

        foreach ($baris as $b) {
            $mulai = Carbon::createFromFormat('Y-m-d H:i:s', $tanggal . ' ' . $b->waktu_mulai, self::ZONA);
            $akhir = Carbon::createFromFormat('Y-m-d H:i:s', $tanggal . ' ' . $b->estimasi_selesai, self::ZONA);

            $totalDetik = max(1, $akhir->timestamp - $mulai->timestamp);
            $sisaDetik  = max(0, $akhir->timestamp - $sekarang->timestamp);
            $durasiJam  = (int) round($totalDetik / 3600);

            $hasil[] = [
                'id_booking'    => $b->id_booking,
                'nama_ruangan'  => $b->nama_ruangan,
                'jenis_ruangan' => $b->jenis_ruangan,
                'customer'      => $b->nama_customer,
                'mulai'         => substr($b->waktu_mulai, 0, 5),
                'selesai'       => substr($b->estimasi_selesai, 0, 5),
                'durasi_jam'    => $durasiJam,
                'tarif_per_jam' => (int) $b->tarif_per_jam,
                'total_sewa'    => (int) $b->tarif_per_jam * $durasiJam,
                'total_detik'   => $totalDetik,
                'sisa_detik'    => $sisaDetik,
                'maks_tambah'   => self::maksTambahJam($b),
            ];
        }

        return response()->json($hasil);
    }

    // Tombol "Perpanjang Waktu": menambah jam sewa yang sedang berjalan
    public function perpanjang(Request $request, $id)
    {
        $data = $request->validate([
            'tambah_jam' => 'required|integer|min:1|max:5',
        ], [
            'tambah_jam.required' => 'Pilih tambahan waktu terlebih dahulu.',
            'tambah_jam.integer'  => 'Tambahan waktu tidak valid.',
            'tambah_jam.min'      => 'Tambahan waktu minimal 1 jam.',
            'tambah_jam.max'      => 'Tambahan waktu maksimal 5 jam.',
        ]);

        // Pastikan status sudah mengikuti waktu sebelum diperiksa
        self::sinkronStatus();

        $hasil = DB::transaction(function () use ($id, $data) {
            $booking = DB::table('tr_booking')->where('id_booking', $id)->lockForUpdate()->first();

            if (!$booking) {
                return ['kode' => 404, 'message' => 'Booking tidak ditemukan.'];
            }

            if ($booking->status_booking !== 'Sedang Main') {
                return ['kode' => 422, 'message' => 'Hanya sewa yang sedang berjalan yang dapat diperpanjang.'];
            }

            // Kunci baris ruangan supaya tidak bentrok dengan booking baru di saat yang sama
            DB::table('ms_ruangan')->where('id_ruangan', $booking->id_ruangan)->lockForUpdate()->first();

            $maks = self::maksTambahJam($booking);

            if ($data['tambah_jam'] > $maks) {
                return [
                    'kode'    => 422,
                    'message' => $maks <= 0
                        ? 'Sewa tidak dapat diperpanjang karena ada booking berikutnya atau sudah mendekati pukul 24.00.'
                        : 'Perpanjangan maksimal ' . $maks . ' jam karena ada booking berikutnya atau batas pukul 24.00.',
                ];
            }

            $akhirBaru = self::dariDetik(
                self::keDetik($booking->estimasi_selesai) + $data['tambah_jam'] * 3600
            );

            DB::table('tr_booking')
                ->where('id_booking', $id)
                ->update(['estimasi_selesai' => $akhirBaru]);

            return [
                'kode'    => 200,
                'message' => 'Waktu sewa diperpanjang ' . $data['tambah_jam'] . ' jam, selesai pukul '
                    . substr($akhirBaru, 0, 5) . '.',
            ];
        });

        return response()->json(['message' => $hasil['message']], $hasil['kode']);
    }
}