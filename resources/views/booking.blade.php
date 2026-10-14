<!DOCTYPE html>
<html lang="id">

<head>
  <title>Booking Ruangan | PS Rental</title>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Font -->
  <link rel="stylesheet" href="{{ asset('assets/fonts/inter/inter.css') }}">

  <!-- Icons -->
  <link rel="stylesheet" href="{{ asset('assets/fonts/tabler-icons.min.css') }}">

  <!-- Template CSS -->
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/style-preset.css') }}">

  <style>
    .booking-card {
      transition: transform 0.2s, box-shadow 0.2s;
    }

    .booking-card:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(0,0,0,0.06);
    }

    .price-box {
      background: #f8fafc;
      border: 1px dashed #cbd5e1;
      border-radius: 10px;
    }
  </style>
</head>

<body
  data-pc-preset="preset-1"
  data-pc-sidebar-caption="true"
  data-pc-layout="vertical"
  data-pc-direction="ltr"
  data-pc-theme_contrast=""
  data-pc-theme="light">

  <!-- =========================================================
       SIDEBAR KASIR
  ========================================================== -->
  <nav class="pc-sidebar">
    <div class="navbar-wrapper">

      <!-- LOGO -->
      <div class="m-header">
        <a href="/dashboard" class="b-brand text-primary">
          <span class="fw-bold fs-4">PS Rental</span>
        </a>
      </div>

      <!-- SIDEBAR CONTENT -->
      <div class="navbar-content">

        <!-- USER CARD -->
        <div class="card pc-user-card">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div class="flex-shrink-0">
                <img src="{{ asset('assets/images/user/avatar-1.jpg') }}" class="user-avtar wid-45 rounded-circle" alt="user">
              </div>
              <div class="flex-grow-1 ms-3">
                <h6 class="mb-0" id="sidebarUsername">Kasir</h6>
                <small class="text-muted" id="sidebarRole">Kasir</small>
              </div>
            </div>
          </div>
        </div>

        <!-- MENU -->
        <ul class="pc-navbar">
          <li class="pc-item pc-caption">
            <label>Menu Kasir</label>
          </li>

          <!-- Dashboard -->
          <li class="pc-item">
            <a href="/dashboard" class="pc-link">
              <span class="pc-micon">
                <i class="ti ti-home"></i>
              </span>
              <span class="pc-mtext">Dashboard</span>
            </a>
          </li>

          <!-- Booking (Active) -->
          <li class="pc-item active">
            <a href="/booking" class="pc-link">
              <span class="pc-micon">
                <i class="ti ti-calendar-event"></i>
              </span>
              <span class="pc-mtext">Booking</span>
            </a>
          </li>

          <!-- Ruangan -->
          <li class="pc-item">
            <a href="/ruangan" class="pc-link">
              <span class="pc-micon">
                <i class="ti ti-device-gamepad-2"></i>
              </span>
              <span class="pc-mtext">Ruangan</span>
            </a>
          </li>

          <!-- Tracking -->
          <li class="pc-item">
            <a href="/tracking" class="pc-link">
              <span class="pc-micon">
                <i class="ti ti-clock-play"></i>
              </span>
              <span class="pc-mtext">Tracking</span>
            </a>
          </li>

          <!-- Laporan -->
          <li class="pc-item">
            <a href="/laporan" class="pc-link">
              <span class="pc-micon">
                <i class="ti ti-report"></i>
              </span>
              <span class="pc-mtext">Laporan</span>
            </a>
          </li>
        </ul>

        <!-- LOGOUT -->
        <div class="card mt-3">
          <div class="card-body p-3">
            <a href="#" class="d-flex align-items-center text-danger text-decoration-none" onclick="logout(); return false;">
              <i class="ti ti-logout me-2 fs-5"></i>
              <span class="fw-semibold">Logout</span>
            </a>
          </div>
        </div>

      </div>
    </div>
  </nav>

  <!-- =========================================================
       HEADER
  ========================================================== -->
  <header class="pc-header">
    <div class="header-wrapper">
      <div class="me-auto pc-mob-drp">
        <ul class="list-unstyled mb-0">
          <li class="pc-h-item pc-sidebar-collapse">
            <a href="#" class="pc-head-link ms-0" id="sidebar-hide">
              <i class="ti ti-menu-2"></i>
            </a>
          </li>
          <li class="pc-h-item pc-sidebar-popup">
            <a href="#" class="pc-head-link ms-0" id="mobile-collapse">
              <i class="ti ti-menu-2"></i>
            </a>
          </li>
        </ul>
      </div>

      <div class="ms-auto">
        <ul class="list-unstyled mb-0 d-flex align-items-center gap-3">
          <!-- Tanggal -->
          <li class="pc-h-item text-muted">
            <i class="ti ti-calendar me-1"></i>
            <span id="currentDate">-</span>
          </li>
          <!-- Jam -->
          <li class="pc-h-item text-muted">
            <i class="ti ti-clock me-1"></i>
            <span id="currentTime">-</span>
          </li>
        </ul>
      </div>
    </div>
  </header>

  <!-- =========================================================
       MAIN CONTENT
  ========================================================== -->
  <div class="pc-container">
    <div class="pc-content">

      <!-- JUDUL HALAMAN -->
      <div class="row mb-3">
        <div class="col-12">
          <h4 class="mb-1">Kelola Booking PlayStation BestPlay</h4>
          <p class="text-muted mb-0">Input reservasi sewa ruangan PS, cek ketersediaan konsol, dan kelola jadwal pelanggan kasir.</p>
        </div>
      </div>

      <!-- NOTIFIKASI SUKSES -->
      <div id="bookingSuccessAlert" class="alert alert-success d-none py-2 px-3 small rounded-3 mb-3 shadow-sm" role="alert"></div>

      <!-- GRID UTAMA -->
      <div class="row g-3">

        <!-- =====================================================
             KOLOM KIRI: FORM TAMBAH BOOKING
        ====================================================== -->
        <div class="col-lg-5">
          <div class="card shadow-sm h-100">
            <div class="card-header py-3">
              <h5 class="mb-0 fs-6 fw-semibold">
                <i class="ti ti-calendar-plus me-1 text-primary"></i> Tambah Booking Baru
              </h5>
            </div>

            <div class="card-body">
              <form id="formTambahBooking">

                <!-- Nama Pelanggan -->
                <div class="mb-3">
                  <label class="form-label small fw-semibold text-secondary">Nama Pelanggan <span class="text-danger">*</span></label>
                  <input
                    type="text"
                    id="customerName"
                    class="form-control"
                    placeholder="Masukkan nama pelanggan"
                    required>
                </div>

                <!-- No HP -->
                <div class="mb-3">
                  <label class="form-label small fw-semibold text-secondary">Nomor WhatsApp / HP <span class="text-danger">*</span></label>
                  <input
                    type="text"
                    id="customerPhone"
                    class="form-control"
                    placeholder="08xxxxxxxxxx"
                    required>
                </div>

                <!-- Pilihan Ruangan -->
                <div class="mb-3">
                  <label class="form-label small fw-semibold text-secondary">Pilih Ruangan PS <span class="text-danger">*</span></label>
                  <select id="bookingRoom" class="form-select" required>
                    <option value="PS Room 1">PS Room 1 (PS5 - Rp 20.000/jam)</option>
                    <option value="PS Room 2">PS Room 2 (PS5 - Rp 20.000/jam)</option>
                    <option value="PS Room 3" selected>PS Room 3 (PS4 - Rp 15.000/jam)</option>
                    <option value="PS Room 4">PS Room 4 (PS4 - Rp 15.000/jam)</option>
                    <option value="VIP Room 1">VIP Room 1 (PS5 VIP - Rp 30.000/jam)</option>
                    <option value="VIP Room 2">VIP Room 2 (PS5 VIP - Rp 30.000/jam)</option>
                  </select>
                </div>

                <!-- Tanggal & Jam -->
                <div class="row g-2 mb-3">
                  <div class="col-6">
                    <label class="form-label small fw-semibold text-secondary">Tanggal <span class="text-danger">*</span></label>
                    <input type="date" id="bookingDate" class="form-control" required>
                  </div>
                  <div class="col-6">
                    <label class="form-label small fw-semibold text-secondary">Jam Mulai <span class="text-danger">*</span></label>
                    <input type="time" id="bookingTime" class="form-control" value="13:00" required>
                  </div>
                </div>

                <!-- Durasi Sewa -->
                <div class="mb-3">
                  <label class="form-label small fw-semibold text-secondary">Durasi Sewa <span class="text-danger">*</span></label>
                  <select id="bookingDuration" class="form-select" required>
                    <option value="1">1 Jam</option>
                    <option value="2" selected>2 Jam</option>
                    <option value="3">3 Jam</option>
                    <option value="4">4 Jam</option>
                    <option value="5">5 Jam</option>
                  </select>
                </div>

                <!-- Catatan Tambahan -->
                <div class="mb-3">
                  <label class="form-label small fw-semibold text-secondary">Catatan (Opsional)</label>
                  <textarea id="bookingNote" class="form-control" rows="2" placeholder="Contoh: Permintaan tambahan stik, game tertentu..."></textarea>
                </div>

                <!-- Estimasi Biaya -->
                <div class="price-box p-3 mb-3">
                  <div class="d-flex justify-content-between align-items-center">
                    <span class="small text-muted fw-semibold">Estimasi Total Biaya:</span>
                    <strong class="text-primary fs-6" id="estimatedPriceDisplay">Rp 30.000</strong>
                  </div>
                </div>

                <!-- Tombol Aksi -->
                <div class="d-flex gap-2">
                  <button type="submit" class="btn btn-primary flex-fill">
                    <i class="ti ti-calendar-plus me-1"></i> Simpan Booking
                  </button>
                  <button type="reset" class="btn btn-light" onclick="setTimeout(updateEstimatedPrice, 100)">
                    Reset
                  </button>
                </div>

              </form>
            </div>
          </div>
        </div>

        <!-- =====================================================
             KOLOM KANAN: STATUS RUANGAN & DAFTAR BOOKING
        ====================================================== -->
        <div class="col-lg-7">

          <!-- KETERSEDIAAN RUANGAN -->
          <div class="card shadow-sm mb-3">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
              <h5 class="mb-0 fs-6 fw-semibold">
                <i class="ti ti-device-gamepad-2 me-1 text-primary"></i> Status Ketersediaan Ruangan Saat Ini
              </h5>
              <small class="text-muted">Klik kartu untuk memilih di form</small>
            </div>
            <div class="card-body">
              <div class="row" id="roomAvailabilityList">
                <!-- Render dinamis via booking.js -->
              </div>
            </div>
          </div>

          <!-- TABEL DAFTAR BOOKING -->
          <div class="card shadow-sm">
            <div class="card-header py-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
              <h5 class="mb-0 fs-6 fw-semibold">
                <i class="ti ti-list me-1 text-primary"></i> Daftar Reservasi Booking
              </h5>
              <span class="badge bg-light-primary text-primary px-3 py-2" id="badgeTotalBooking">
                Memuat data...
              </span>
            </div>

            <!-- Toolbar Pencarian & Filter -->
            <div class="card-body border-bottom py-2">
              <div class="row g-2">
                <div class="col-md-7">
                  <div class="input-group input-group-sm">
                    <span class="input-group-text bg-light border-end-0">
                      <i class="ti ti-search text-muted"></i>
                    </span>
                    <input
                      type="text"
                      id="searchBooking"
                      class="form-control border-start-0"
                      placeholder="Cari pelanggan, HP, atau ruangan..."
                      onkeyup="renderBookingsTable()">
                  </div>
                </div>
                <div class="col-md-5">
                  <select id="filterStatusBooking" class="form-select form-select-sm" onchange="renderBookingsTable()">
                    <option value="all">Semua Status</option>
                    <option value="Booking">Booking</option>
                    <option value="Sedang Main">Sedang Main</option>
                    <option value="Selesai">Selesai</option>
                  </select>
                </div>
              </div>
            </div>

            <!-- Tabel -->
            <div class="table-responsive">
              <table class="table table-hover align-middle mb-0 small">
                <thead class="table-light">
                  <tr>
                    <th style="width: 40px;">No</th>
                    <th>ID</th>
                    <th>Pelanggan</th>
                    <th>Ruangan</th>
                    <th>Jadwal</th>
                    <th>Durasi</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th class="text-center" style="width: 110px;">Aksi</th>
                  </tr>
                </thead>
                <tbody id="tabelBooking">
                  <!-- Render dinamis via booking.js -->
                </tbody>
              </table>
            </div>

          </div>

        </div>

      </div>

    </div>
  </div>

  <!-- =========================================================
       MODAL EDIT BOOKING
  ========================================================== -->
  <div class="modal fade" id="modalEditBooking" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">

        <div class="modal-header">
          <h5 class="modal-title fw-bold">
            <i class="ti ti-edit me-1"></i> Edit Data Booking
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <form id="formEditBooking">
          <input type="hidden" id="editBookingId">

          <div class="modal-body">
            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label small fw-semibold text-secondary">Nama Pelanggan</label>
                <input type="text" id="editCustomerName" class="form-control" required>
              </div>

              <div class="col-md-6">
                <label class="form-label small fw-semibold text-secondary">Nomor HP</label>
                <input type="text" id="editCustomerPhone" class="form-control" required>
              </div>

              <div class="col-md-6">
                <label class="form-label small fw-semibold text-secondary">Ruangan</label>
                <select id="editBookingRoom" class="form-select" required>
                  <option value="PS Room 1">PS Room 1</option>
                  <option value="PS Room 2">PS Room 2</option>
                  <option value="PS Room 3">PS Room 3</option>
                  <option value="PS Room 4">PS Room 4</option>
                  <option value="VIP Room 1">VIP Room 1</option>
                  <option value="VIP Room 2">VIP Room 2</option>
                </select>
              </div>

              <div class="col-md-6">
                <label class="form-label small fw-semibold text-secondary">Status</label>
                <select id="editBookingStatus" class="form-select" required>
                  <option value="Booking">Booking</option>
                  <option value="Sedang Main">Sedang Main</option>
                  <option value="Selesai">Selesai</option>
                  <option value="Dibatalkan">Dibatalkan</option>
                </select>
              </div>

              <div class="col-md-6">
                <label class="form-label small fw-semibold text-secondary">Tanggal</label>
                <input type="date" id="editBookingDate" class="form-control" required>
              </div>

              <div class="col-md-6">
                <label class="form-label small fw-semibold text-secondary">Jam Mulai</label>
                <input type="time" id="editBookingTime" class="form-control" required>
              </div>

              <div class="col-md-6">
                <label class="form-label small fw-semibold text-secondary">Durasi Sewa</label>
                <select id="editBookingDuration" class="form-select" required>
                  <option value="1">1 Jam</option>
                  <option value="2">2 Jam</option>
                  <option value="3">3 Jam</option>
                  <option value="4">4 Jam</option>
                  <option value="5">5 Jam</option>
                </select>
              </div>

              <div class="col-12">
                <label class="form-label small fw-semibold text-secondary">Catatan</label>
                <textarea id="editBookingNote" class="form-control" rows="2"></textarea>
              </div>
            </div>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary">
              <i class="ti ti-device-floppy me-1"></i> Simpan Perubahan
            </button>
          </div>
        </form>

      </div>
    </div>
  </div>

  <!-- =========================================================
       FOOTER
  ========================================================== -->
  <footer class="pc-footer">
    <div class="footer-wrapper container-fluid">
      <div class="row">
        <div class="col-sm my-1">
          <p class="m-0">PS Rental © 2026</p>
        </div>
        <div class="col-auto my-1">
          <p class="m-0 text-muted">Sistem Informasi Rental PS (2 User)</p>
        </div>
      </div>
    </div>
  </footer>

  <!-- =========================================================
       JAVASCRIPT
  ========================================================== -->
  <script src="{{ asset('assets/js/plugins/popper.min.js') }}"></script>
  <script src="{{ asset('assets/js/plugins/simplebar.min.js') }}"></script>
  <script src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script>
  <script src="{{ asset('assets/js/script.js') }}"></script>
  <script src="{{ asset('assets/js/theme.js') }}"></script>
  <script src="{{ asset('assets/js/plugins/feather.min.js') }}"></script>

  <!-- Script Logika Booking -->
  <script src="{{ asset('assets/js/pages/booking.js') }}"></script>

</body>

</html>