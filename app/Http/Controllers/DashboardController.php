<?php

namespace App\Http\Controllers;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    private const ZONA = 'Asia/Jakarta';

    // Data dashboard (dipakai kasir dan superadmin).
    // Status ruangan dihitung dari data booking hari ini, bukan dari kolom manual.
    public function data()
    {
        // Pastikan status booking sudah mengikuti jam sekarang
        BookingController::sinkronStatus();

        $sekarang = Carbon::now(self::ZONA);
        $tanggal  = $sekarang->toDateString();

        $booking = DB::table('tr_booking as b')
            ->join('ms_customer as c', 'c.id_customer', '=', 'b.id_customer')
            ->where('b.tanggal_booking', $tanggal)
            ->whereIn('b.status_booking', ['Booking', 'Sedang Main'])
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

        $hasil          = [];
        $bookingHariIni = [];
        $ringkasan      = [
            'total'       => $ruangan->count(),
            'digunakan'   => 0,
            'booking'     => 0,
            'kosong'      => 0,
            'maintenance' => 0,
        ];

        foreach ($ruangan as $r) {
            $daftar   = $booking->get($r->id_ruangan, collect());
            $berjalan = $daftar->firstWhere('status_booking', 'Sedang Main');
            $berikut  = $daftar->firstWhere('status_booking', 'Booking');

            $item = [
                'id_ruangan'    => $r->id_ruangan,
                'nama_ruangan'  => $r->nama_ruangan,
                'jenis_ruangan' => $r->jenis_ruangan,
                'status'        => 'Kosong',
                'customer'      => null,
                'jam_mulai'     => null,
                'jam_selesai'   => null,
                'sisa_detik'    => null,
                'booking'       => null,
            ];

            if ($r->status_ruangan === 'Maintenance') {
                $item['status'] = 'Maintenance';
                $ringkasan['maintenance']++;

            } elseif ($berjalan) {
                $akhir = Carbon::createFromFormat(
                    'Y-m-d H:i:s',
                    $tanggal . ' ' . $berjalan->estimasi_selesai,
                    self::ZONA
                );

                $item['status']      = 'Digunakan';
                $item['customer']    = $berjalan->nama_customer;
                $item['jam_mulai']   = substr($berjalan->waktu_mulai, 0, 5);
                $item['jam_selesai'] = substr($berjalan->estimasi_selesai, 0, 5);
                $item['sisa_detik']  = max(0, $akhir->timestamp - $sekarang->timestamp);
                $ringkasan['digunakan']++;

            } elseif ($berikut) {
                $item['status']  = 'Booking';
                $item['booking'] = [
                    'customer' => $berikut->nama_customer,
                    'jam'      => substr($berikut->waktu_mulai, 0, 5) . ' - '
                                . substr($berikut->estimasi_selesai, 0, 5),
                ];
                $ringkasan['booking']++;

            } else {
                $ringkasan['kosong']++;
            }

            // Semua booking yang belum dimulai hari ini
            foreach ($daftar as $b) {
                if ($b->status_booking === 'Booking') {
                    $bookingHariIni[] = [
                        'mulai'        => substr($b->waktu_mulai, 0, 5),
                        'jam'          => substr($b->waktu_mulai, 0, 5) . ' - '
                                          . substr($b->estimasi_selesai, 0, 5),
                        'customer'     => $b->nama_customer,
                        'nama_ruangan' => $r->nama_ruangan,
                    ];
                }
            }

            $hasil[] = $item;
        }

        return response()->json([
            'tanggal'          => $tanggal,
            'ringkasan'        => $ringkasan,
            'ruangan'          => $hasil,
            'booking_hari_ini' => collect($bookingHariIni)->sortBy('mulai')->values()->all(),
        ]);
    }
}