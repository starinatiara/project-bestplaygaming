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
    /* =====================================================
       USER CARD + LOGOUT (sama dengan Dashboard)
    ====================================================== */

    :root {
      --pc-sidebar-width: 280px;
    }

    .sidebar-user-row {
      display: flex;
      align-items: stretch;
      gap: 10px;
      margin: 0 15px 15px;
    }

    .sidebar-user-row .pc-user-card {
      flex: 1 1 auto;
      min-width: 0;
      margin: 0 !important;
      box-shadow: none;
      background: #f8f9fa;
      border: 1px solid #e5e7eb;
      border-radius: 16px;
    }

    .sidebar-user-row .pc-user-card .card-body { padding: 16px; }

    .sidebar-logout-btn {
      flex: 0 0 54px;
      display: flex;
      align-items: center;
      justify-content: center;
      background: #ffffff;
      border: 1px solid #e5e7eb;
      border-radius: 16px;
      color: #dc3545;
      font-size: 22px;
      text-decoration: none;
      transition: 0.2s;
    }

    .sidebar-logout-btn:hover { background: #fde8e8; color: #dc3545; }

    /* =====================================================
       BOOKING
    ====================================================== */

    .price-box {
      background: #f8fafc;
      border: 1px dashed #cbd5e1;
      border-radius: 10px;
    }

    /* =====================================================
       POPUP KONFIRMASI LOGOUT
    ====================================================== */

    .lg-overlay {
      position: fixed;
      top: 0; right: 0; bottom: 0; left: 0;
      z-index: 2000;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 16px;
      background: rgba(0, 0, 0, 0.5);
      opacity: 0;
      visibility: hidden;
      transition: opacity 0.25s ease, visibility 0.25s ease;
    }

    .lg-overlay.show { opacity: 1; visibility: visible; }

    .lg-box {
      width: 100%;
      max-width: 300px;
      background: #ffffff;
      border-radius: 22px;
      padding: 12px 8px 8px;
      text-align: center;
      box-shadow: 0 25px 60px rgba(15, 23, 42, 0.25);
      transform: scale(0.85) translateY(20px);
      transition: transform 0.25s ease;
    }

    .lg-overlay.show .lg-box { transform: scale(1) translateY(0); }

    .lg-icon {
      width: 76px;
      height: 76px;
      margin: 18px auto 18px;
      border-radius: 50%;
      background: #fde8e8;
      color: #dc3545;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 36px;
      box-shadow: 0 0 0 10px #fff4f4;
    }

    .lg-text { color: #6c757d; font-size: 14px; margin: 0; padding: 0 16px; }

    .lg-actions { display: flex; gap: 12px; padding: 22px 16px 14px; }

    .lg-actions .btn { flex: 1; padding: 12px; border-radius: 12px; font-weight: 600; }

    .btn-logout-cancel { background: #f1f5f9; border: 1px solid #e5e7eb; color: #475569; }
    .btn-logout-cancel:hover { background: #e2e8f0; color: #1e293b; }
    .btn-logout-confirm { background: #dc3545; border: 1px solid #dc3545; color: #ffffff; }
    .btn-logout-confirm:hover { background: #bb2d3b; border-color: #bb2d3b; color: #ffffff; }
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

        <!-- USER CARD + LOGOUT -->
        <div class="sidebar-user-row">

          <!-- USER CARD -->
          <div class="card pc-user-card" onclick="window.location.href='/profil'" style="cursor:pointer" title="Profil Saya">
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

          <!-- LOGOUT (ikon) -->
          <a href="#" class="sidebar-logout-btn" title="Logout" onclick="logout(); return false;">
            <i class="ti ti-logout"></i>
          </a>

        </div>

        <!-- MENU -->
        <ul class="pc-navbar">
          <li class="pc-item pc-caption">
            <label>Menu</label>
          </li>

          <!-- Dashboard -->
          <li class="pc-item">
            <a href="/dashboard" class="pc-link">
              <span class="pc-micon"><i class="ti ti-home"></i></span>
              <span class="pc-mtext">Dashboard</span>
            </a>
          </li>

          <!-- Booking (Active) -->
          <li class="pc-item active">
            <a href="/booking" class="pc-link">
              <span class="pc-micon"><i class="ti ti-calendar-event"></i></span>
              <span class="pc-mtext">Booking</span>
            </a>
          </li>

          <!-- Ruangan -->
          <li class="pc-item">
            <a href="/ruangan" class="pc-link">
              <span class="pc-micon"><i class="ti ti-device-gamepad"></i></span>
              <span class="pc-mtext">Ruangan</span>
            </a>
          </li>

          <!-- Tracking -->
          <li class="pc-item">
            <a href="/tracking" class="pc-link">
              <span class="pc-micon"><i class="ti ti-receipt"></i></span>
              <span class="pc-mtext">Tracking</span>
            </a>
          </li>

          <!-- Laporan -->
          <li class="pc-item">
            <a href="/laporan" class="pc-link">
              <span class="pc-micon"><i class="ti ti-report"></i></span>
              <span class="pc-mtext">Laporan</span>
            </a>
          </li>
        </ul>

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
          <li class="pc-h-item text-muted">
            <i class="ti ti-calendar me-1"></i>
            <span id="currentDate">-</span>
          </li>
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
          <h4 class="mb-1">Kelola Booking PlayStation</h4>
          <p class="text-muted mb-0">Input reservasi sewa ruangan PS, cek ketersediaan konsol, dan kelola jadwal pelanggan kasir.</p>
        </div>
      </div>

      <!-- NOTIFIKASI SUKSES -->
      <div id="bookingSuccessAlert" class="alert alert-success d-none py-2 px-3 small rounded-3 mb-3 shadow-sm" role="alert"></div>

      <!-- FORM TAMBAH BOOKING -->
      <div class="row">
        <div class="col-12">

          <div class="card border-0 shadow-sm">
            <div class="card-header">
              <h5 class="mb-0">
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
      </div>

      <!--
        Elemen di bawah ini DISEMBUNYIKAN (bukan ditampilkan) karena booking.js
        masih mencari id-nya. Kalau dihapus total, booking.js bisa error.
      -->
      <div class="d-none" aria-hidden="true">
        <div id="roomAvailabilityList"></div>
        <span id="badgeTotalBooking"></span>
        <input type="text" id="searchBooking">
        <select id="filterStatusBooking">
          <option value="all">Semua Status</option>
        </select>
        <table><tbody id="tabelBooking"></tbody></table>
      </div>

    </div>
  </div>

  <!-- =========================================================
       POPUP KONFIRMASI LOGOUT
  ========================================================== -->
  <div class="lg-overlay" id="logoutModal" aria-hidden="true">
    <div class="lg-box" role="dialog" aria-modal="true">

      <div class="lg-icon"><i class="ti ti-logout"></i></div>

      <p class="lg-text">Apakah Anda yakin ingin logout?</p>

      <div class="lg-actions">
        <button type="button" class="btn btn-logout-cancel" id="cancelLogoutBtn">Tidak</button>
        <button type="button" class="btn btn-logout-confirm" id="confirmLogoutBtn">Ya</button>
      </div>

    </div>
  </div>

  <!-- =========================================================
       MODAL EDIT BOOKING (tetap ada, dipakai booking.js)
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
  <script src="{{ asset('assets/js/plugins/popper.min.js') }}"></script>
  <script src="{{ asset('assets/js/plugins/simplebar.min.js') }}"></script>
  <script src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script>
  <script src="{{ asset('assets/js/script.js') }}"></script>
  <script src="{{ asset('assets/js/theme.js') }}"></script>
  <script src="{{ asset('assets/js/plugins/feather.min.js') }}"></script>

  <!-- Script Logika Booking -->
  <script src="{{ asset('assets/js/pages/booking.js') }}"></script>

  <!-- Script layout: tanggal & jam, logout -->
  <script>
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

    // Popup logout di tengah halaman
    const logoutModal = document.getElementById("logoutModal");

    window.logout = function () {
      logoutModal.classList.add("show");
      logoutModal.setAttribute("aria-hidden", "false");
    };

    function tutupModalLogout() {
      logoutModal.classList.remove("show");
      logoutModal.setAttribute("aria-hidden", "true");
    }

    document.getElementById("cancelLogoutBtn").addEventListener("click", tutupModalLogout);

    logoutModal.addEventListener("click", function (e) {
      if (e.target === logoutModal) tutupModalLogout();
    });

    document.addEventListener("keydown", function (e) {
      if (e.key === "Escape") tutupModalLogout();
    });

    document.getElementById("confirmLogoutBtn").addEventListener("click", function () {
      localStorage.removeItem("role");
      localStorage.removeItem("username");
      window.location.href = "/logout";
    });
  </script>

</body>

</html>