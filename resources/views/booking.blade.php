<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Booking Ruangan | PS Rental</title>

  <!-- BOOTSTRAP 5 -->
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
    rel="stylesheet">

  <!-- TABLER ICON -->
  <link rel="stylesheet" href="{{ asset('assets/fonts/tabler-icons.min.css') }}">

  <!-- FONT -->
  <link rel="stylesheet" href="{{ asset('assets/fonts/inter/inter.css') }}">

  <style>
    /* ================= GLOBAL ================= */
    body {
      font-family: 'Inter', sans-serif;
      background-color: #f8f9fa;
      color: #212529;
    }

    /* ================= SIDEBAR ================= */
    .sidebar {
      width: 280px;
      min-height: 100vh;
      position: fixed;
      left: 0;
      top: 0;
      background: #ffffff;
      border-right: 1px solid #dee2e6;
      padding: 24px 16px;
      z-index: 1000;
      overflow-y: auto;
      transition: transform 0.25s;
    }

    .brand {
      font-size: 25px;
      font-weight: 700;
      color: #3b82f6;
      text-decoration: none;
      display: block;
      padding: 0 10px 25px;
    }

    .user-card {
      background: #f8f9fa;
      border: 1px solid #e5e7eb;
      border-radius: 16px;
      padding: 18px;
      margin-bottom: 25px;
    }

    .user-avatar {
      width: 48px;
      height: 48px;
      border-radius: 50%;
      object-fit: cover;
    }

    .user-name {
      font-weight: 600;
      margin-bottom: 2px;
    }

    .user-role {
      color: #6c757d;
      font-size: 14px;
    }

    .menu-title {
      font-size: 13px;
      font-weight: 700;
      color: #495057;
      text-transform: uppercase;
      padding: 0 18px;
      margin-bottom: 10px;
    }

    .sidebar-menu {
      list-style: none;
      padding: 0;
      margin: 0;
    }

    .sidebar-menu li {
      margin-bottom: 6px;
    }

    .sidebar-menu a {
      display: flex;
      align-items: center;
      gap: 15px;
      padding: 13px 18px;
      color: #64748b;
      text-decoration: none;
      border-radius: 10px;
      transition: 0.2s;
      font-size: 15px;
    }

    .sidebar-menu a:hover {
      background: #f1f5f9;
      color: #3b82f6;
    }

    .sidebar-menu a.active {
      background: #e8f0ff;
      color: #3b82f6;
      font-weight: 600;
    }

    .sidebar-menu i {
      font-size: 21px;
    }

    .logout-box {
      margin-top: 20px;
    }

    .logout-btn {
      width: 100%;
      background: #ffffff;
      border: 1px solid #e5e7eb;
      color: #dc3545;
      padding: 14px;
      border-radius: 12px;
      text-align: left;
      font-weight: 600;
    }

    /* ================= MAIN ================= */
    .main-content {
      margin-left: 280px;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      transition: margin-left 0.25s ease; /* DITAMBAHKAN */
    }

    .top-header {
      height: 80px;
      background: #ffffff;
      border-bottom: 1px solid #dee2e6;
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0 35px;
    }

    .header-date {
      color: #6c757d;
      font-size: 14px;
    }

    .menu-toggle {
      border: none;
      background: transparent;
      font-size: 24px;
      line-height: 1;
      padding: 0;
    }

    .content {
      padding: 35px;
      flex: 1;
    }

    /* ================= CARD ================= */
    .card {
      border: 0;
      border-radius: 12px;
      box-shadow: 0 .125rem .25rem rgba(0, 0, 0, .075);
    }

    .card-header {
      background: #ffffff;
      border-bottom: 1px solid #eeeeee;
    }

    .bg-light-primary {
      background-color: #e8f0ff !important;
    }

    /* ================= BOOKING ================= */
    .booking-card {
      transition: transform 0.2s, box-shadow 0.2s;
    }

    .booking-card:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
    }

    .price-box {
      background: #f8fafc;
      border: 1px dashed #cbd5e1;
      border-radius: 10px;
    }

    /* ================= FOOTER ================= */
    footer {
      padding: 25px 35px;
      color: #6c757d;
      font-size: 14px;
    }

    /* ================= DITAMBAHKAN: SIDEBAR TOGGLE (DESKTOP) ================= */
    body.sidebar-hidden .sidebar {
      transform: translateX(-100%);
    }

    body.sidebar-hidden .main-content {
      margin-left: 0;
    }

    .menu-toggle {
      font-size: 26px;
      padding: 6px 8px;
      border-radius: 8px;
      color: #495057;
    }

    .menu-toggle:hover {
      background: #f1f5f9;
      color: #3b82f6;
    }

    /* ================= RESPONSIVE ================= */
    @media (max-width: 991px) {
      .sidebar {
        transform: translateX(-100%);
      }

      .sidebar.show {
        transform: translateX(0);
        box-shadow: 0 0 30px rgba(0, 0, 0, 0.15);
      }

      .main-content {
        margin-left: 0;
      }

      .top-header {
        padding: 0 20px;
      }

      .content {
        padding: 20px;
      }

      footer {
        padding: 20px;
      }
    }
  </style>
</head>

<body>

  <!-- =========================================================
       SIDEBAR KASIR
  ========================================================== -->
  <aside class="sidebar" id="sidebar">

    <!-- LOGO -->
    <a href="/dashboard" class="brand">PS Rental</a>

    <!-- USER CARD -->
    <div class="user-card">
      <div class="d-flex align-items-center">
        <img
          src="{{ asset('assets/images/user/avatar-1.jpg') }}"
          class="user-avatar"
          alt="user">

        <div class="ms-3">
          <div class="user-name" id="sidebarUsername">Kasir</div>
          <div class="user-role" id="sidebarRole">Kasir</div>
        </div>
      </div>
    </div>

    <!-- MENU -->
    <div class="menu-title">Menu Kasir</div>

    <ul class="sidebar-menu">

      <li>
        <a href="/dashboard">
          <i class="ti ti-home"></i>
          <span>Dashboard</span>
        </a>
      </li>

      <li>
        <a href="/booking" class="active">
          <i class="ti ti-calendar-event"></i>
          <span>Booking</span>
        </a>
      </li>

      <li>
        <a href="/ruangan">
          <i class="ti ti-device-gamepad-2"></i>
          <span>Ruangan</span>
        </a>
      </li>

      <li>
        <a href="/tracking">
          <i class="ti ti-clock-play"></i>
          <span>Tracking</span>
        </a>
      </li>

      <li>
        <a href="/laporan">
          <i class="ti ti-report"></i>
          <span>Laporan</span>
        </a>
      </li>

    </ul>

    <!-- LOGOUT -->
    <div class="logout-box">
      <button type="button" class="logout-btn" onclick="logout()">
        <i class="ti ti-logout me-2"></i>
        Logout
      </button>
    </div>

  </aside>

  <!-- =========================================================
       MAIN
  ========================================================== -->
  <main class="main-content">

    <!-- HEADER -->
    <header class="top-header">

      <!-- DITAMBAHKAN: d-lg-none dihapus agar hamburger tampil di desktop -->
      <div>
        <button type="button" class="menu-toggle" id="menuToggle" aria-label="Toggle sidebar">
          <i class="ti ti-menu-2"></i>
        </button>
      </div>

      <div class="header-date d-flex align-items-center gap-3">
        <span>
          <i class="ti ti-calendar me-1"></i>
          <span id="currentDate">-</span>
        </span>
        <span>
          <i class="ti ti-clock me-1"></i>
          <span id="currentTime">-</span>
        </span>
      </div>

    </header>

    <!-- CONTENT -->
    <div class="content">

      <!-- JUDUL HALAMAN -->
      <div class="row mb-3">
        <div class="col-12">
          <h4 class="mb-1">Kelola Booking PlayStation</h4>
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

    <!-- FOOTER -->
    <footer>
      <div class="row">
        <div class="col-sm my-1">
          <p class="m-0">PS Rental © 2026</p>
        </div>
        <div class="col-auto my-1">
          <p class="m-0 text-muted">Sistem Informasi Rental PS (2 User)</p>
        </div>
      </div>
    </footer>

  </main>

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
       JAVASCRIPT
  ========================================================== -->

  <!-- Bootstrap JS (sudah termasuk Popper) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Script Logika Booking -->
  <script src="{{ asset('assets/js/pages/booking.js') }}"></script>

  <!-- Script layout: toggle sidebar, tanggal & jam -->
  <script>
    // DITAMBAHKAN: Toggle sidebar (desktop & mobile)
    const sidebar = document.getElementById("sidebar");
    const menuToggle = document.getElementById("menuToggle");

    if (menuToggle) {
      menuToggle.addEventListener("click", function () {
        if (window.innerWidth >= 992) {
          // Desktop: sembunyikan / tampilkan sidebar
          document.body.classList.toggle("sidebar-hidden");
        } else {
          // Mobile: buka / tutup sidebar
          sidebar.classList.toggle("show");
        }
      });
    }

    // Tanggal & jam
    function updateDateTime() {
      const now = new Date();

      document.getElementById("currentDate").textContent =
        now.toLocaleDateString("id-ID", {
          weekday: "long",
          year: "numeric",
          month: "long",
          day: "numeric"
        });

      document.getElementById("currentTime").textContent =
        now.toLocaleTimeString("id-ID", {
          hour: "2-digit",
          minute: "2-digit",
          second: "2-digit"
        });
    }

    updateDateTime();
    setInterval(updateDateTime, 1000);

    // Logout (dipakai hanya jika belum didefinisikan di booking.js)
    if (typeof window.logout !== "function") {
      window.logout = function () {
        if (confirm("Apakah Anda yakin ingin logout?")) {
          localStorage.removeItem("role");
          localStorage.removeItem("username");
          window.location.href = "/login";
        }
      };
    }
  </script>

</body>

</html>