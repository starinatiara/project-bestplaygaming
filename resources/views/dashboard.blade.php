<!DOCTYPE html>
<html lang="id">

<head>
  <title>Dashboard | PS Rental</title>

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
       USER CARD + LOGOUT (sama dengan halaman Ruangan)
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
       KARTU STATISTIK & RUANGAN
    ====================================================== */

    .stat-box { transition: transform 0.2s, box-shadow 0.2s; }
    .stat-box:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,0.06); }

    .stat-icon {
      width: 48px;
      height: 48px;
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 24px;
    }

    .stat-number { font-size: 28px; font-weight: 700; margin: 0; }

    .room-card {
      border: 1px solid #e5e7eb;
      border-radius: 13px;
      background: #ffffff;
      padding: 20px;
      height: 100%;
      transition: 0.2s;
    }

    .room-card:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(0,0,0,0.05); }

    .room-title { font-size: 1rem; font-weight: 600; margin: 0; }
    .room-icon { font-size: 22px; margin-right: 7px; }
    .room-info { color: #6c757d; font-size: 13px; margin-bottom: 7px; }


    .booking-item {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 15px 0;
      border-bottom: 1px solid #eeeeee;
    }

    .booking-item:last-child { border-bottom: none; }
    .booking-time { font-weight: 600; font-size: 15px; }
    .booking-customer { color: #6c757d; font-size: 13px; }

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
       SIDEBAR
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
                  <h6 class="mb-0" id="sidebarUsername">User</h6>
                  <small class="text-muted" id="sidebarRole">Role</small>
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

          <!-- Dashboard (Active) -->
          <li class="pc-item active">
            <a href="/dashboard" class="pc-link">
              <span class="pc-micon"><i class="ti ti-home"></i></span>
              <span class="pc-mtext">Dashboard</span>
            </a>
          </li>

          <!-- SUPERADMIN -->
          <li class="pc-item menu-superadmin">
            <a href="/ruanganAdmin" class="pc-link">
              <span class="pc-micon"><i class="ti ti-device-gamepad"></i></span>
              <span class="pc-mtext">Ruangan</span>
            </a>
          </li>

          <li class="pc-item menu-superadmin">
            <a href="/user" class="pc-link">
              <span class="pc-micon"><i class="ti ti-users"></i></span>
              <span class="pc-mtext">Data User</span>
            </a>
          </li>

          <!-- KASIR -->
          <li class="pc-item menu-kasir">
            <a href="/booking" class="pc-link">
              <span class="pc-micon"><i class="ti ti-calendar-event"></i></span>
              <span class="pc-mtext">Booking</span>
            </a>
          </li>

          <li class="pc-item menu-kasir">
            <a href="/ruangan" class="pc-link">
              <span class="pc-micon"><i class="ti ti-device-gamepad"></i></span>
              <span class="pc-mtext">Ruangan</span>
            </a>
          </li>

          <li class="pc-item menu-kasir">
            <a href="/tracking" class="pc-link">
              <span class="pc-micon"><i class="ti ti-receipt"></i></span>
              <span class="pc-mtext">Tracking</span>
            </a>
          </li>

          <!-- LAPORAN (SEMUA ROLE) -->
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
          <h4 class="mb-1" id="welcomeTitle">Selamat Datang!</h4>
          <p class="text-muted mb-0">Berikut adalah kondisi ruangan PS Rental hari ini.</p>
        </div>
      </div>

      <!-- KARTU STATISTIK -->
      <div class="row mb-3">

        <!-- Total Ruangan -->
        <div class="col-sm-6 col-xl-3 mb-3">
          <div class="card border-0 shadow-sm stat-box mb-0">
            <div class="card-body">
              <div class="d-flex align-items-center">
                <div class="stat-icon bg-light-primary text-primary me-3">
                  <i class="ti ti-device-gamepad"></i>
                </div>
                <div>
                  <h6 class="text-muted mb-1 fs-6">Total Ruangan</h6>
                  <h4 class="mb-0 fw-bold" id="statTotal">0</h4>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Sedang Digunakan -->
        <div class="col-sm-6 col-xl-3 mb-3">
          <div class="card border-0 shadow-sm stat-box mb-0">
            <div class="card-body">
              <div class="d-flex align-items-center">
                <div class="stat-icon bg-light-danger text-danger me-3">
                  <i class="ti ti-player-play"></i>
                </div>
                <div>
                  <h6 class="text-muted mb-1 fs-6">Sedang Digunakan</h6>
                  <h4 class="mb-0 fw-bold" id="statDigunakan">0</h4>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Booking -->
        <div class="col-sm-6 col-xl-3 mb-3">
          <div class="card border-0 shadow-sm stat-box mb-0">
            <div class="card-body">
              <div class="d-flex align-items-center">
                <div class="stat-icon bg-light-warning text-warning me-3">
                  <i class="ti ti-calendar-event"></i>
                </div>
                <div>
                  <h6 class="text-muted mb-1 fs-6">Booking</h6>
                  <h4 class="mb-0 fw-bold" id="statBooking">0</h4>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Kosong -->
        <div class="col-sm-6 col-xl-3 mb-3">
          <div class="card border-0 shadow-sm stat-box mb-0">
            <div class="card-body">
              <div class="d-flex align-items-center">
                <div class="stat-icon bg-light-success text-success me-3">
                  <i class="ti ti-circle-check"></i>
                </div>
                <div>
                  <h6 class="text-muted mb-1 fs-6">Kosong</h6>
                  <h4 class="mb-0 fw-bold" id="statKosong">0</h4>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

      <!-- STATUS RUANGAN + BOOKING -->
      <div class="row">

        <!-- STATUS RUANGAN -->
        <div class="col-xl-9">
          <div class="card">
            <div class="card-header">
              <h5 class="mb-0">Status Ruangan</h5>
            </div>
            <div class="card-body">
              <div class="row g-3" id="daftarRuangan">
                <div class="col-12 text-center text-muted py-4">Memuat data...</div>
              </div>
            </div>
          </div>
        </div>

        <!-- BOOKING HARI INI -->
        <div class="col-xl-3">
          <div class="card">
            <div class="card-header">
              <h5 class="mb-0">Booking Hari Ini</h5>
            </div>
            <div class="card-body" id="daftarBooking">
              <div class="text-center text-muted py-4">
                <i class="ti ti-calendar-off fs-2 d-block mb-2"></i>
                Belum ada booking
              </div>
            </div>
          </div>
        </div>

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
       JAVASCRIPT TEMPLATE
  ========================================================== -->
  <script src="{{ asset('assets/js/plugins/popper.min.js') }}"></script>
  <script src="{{ asset('assets/js/plugins/simplebar.min.js') }}"></script>
  <script src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script>
  <script src="{{ asset('assets/js/script.js') }}"></script>
  <script src="{{ asset('assets/js/theme.js') }}"></script>
  <script src="{{ asset('assets/js/plugins/feather.min.js') }}"></script>

  <!-- =========================================================
       SCRIPT DASHBOARD
  ========================================================== -->
  <script>

    /* CEK LOGIN */
    const role = localStorage.getItem("role");
    const username = localStorage.getItem("username");

    if (!role || !username) {
      window.location.href = "/logout";
    }

    /* ROLE */
    let roleName = "";

    if (role === "superadmin") {
      roleName = "Superadmin";
    }
    else if (role === "kasir") {
      roleName = "Kasir";
    }
    else {
      localStorage.removeItem("role");
      localStorage.removeItem("username");
      window.location.href = "/logout";
    }

    document.getElementById("sidebarUsername").textContent = username;
    document.getElementById("sidebarRole").textContent = roleName;
    document.getElementById("welcomeTitle").textContent = "Selamat Datang, " + roleName + "!";

    /* ROLE MENU */
    const menuKasir = document.querySelectorAll(".menu-kasir");
    const menuSuperadmin = document.querySelectorAll(".menu-superadmin");

    if (role === "kasir") {
      menuKasir.forEach(function (m) { m.style.display = ""; });
      menuSuperadmin.forEach(function (m) { m.style.display = "none"; });
    }
    else if (role === "superadmin") {
      menuSuperadmin.forEach(function (m) { m.style.display = ""; });
      menuKasir.forEach(function (m) { m.style.display = "none"; });
    }

    /* TANGGAL & JAM */
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


  /* =====================================================
     DATA RUANGAN DARI DATABASE
  ====================================================== */

  // Cegah teks dari database dibaca sebagai HTML
  function esc(teks) {
    const div = document.createElement("div");
    div.textContent = teks == null ? "" : String(teks);
    return div.innerHTML;
  }

  function nilai(teks) {
    return (teks === null || teks === undefined || teks === "") ? "-" : esc(teks);
  }

  /*
   * Field tambahan yang dibaca dari /ruangan/data (opsional):
   *   customer, jam_mulai, jam_selesai,
   *   jadwal_berikutnya,
   *   booking: { customer: "...", jam: "19:00 - 22:00" }
   * Kalau belum ada, tampil "-".
   */
  function kartuRuangan(r) {

    const judul =
      '<h6 class="room-title">' +
        '<i class="ti ti-device-gamepad-2 room-icon"></i>' + esc(r.nama_ruangan) +
      '</h6>';

    let badge = "";
    let isi = "";

    // ---------- DIGUNAKAN ----------
    if (r.status_ruangan === "Digunakan") {

      badge = '<span class="badge text-bg-danger">Digunakan</span>';

      isi =
        '<div class="room-info mt-3">Customer : ' + nilai(r.customer) + '</div>' +
        '<div class="room-info">Mulai : ' + nilai(r.jam_mulai) + '</div>' +
        '<div class="room-info">Selesai : ' + nilai(r.jam_selesai) + '</div>';
    }

    // ---------- MAINTENANCE ----------
    else if (r.status_ruangan === "Maintenance") {

      badge = '<span class="badge text-bg-secondary">Maintenance</span>';

      isi =
        '<div class="room-info mt-3">Sedang dalam perbaikan</div>' +
        '<div class="text-center text-muted py-3"><i class="ti ti-tool fs-2"></i></div>';
    }

    // ---------- BOOKING (tersedia tapi sudah ada booking) ----------
    else if (r.booking) {

      badge = '<span class="badge text-bg-warning">Booking</span>';

      isi =
        '<div class="room-info mt-3">Customer : ' + nilai(r.booking.customer) + '</div>' +
        '<div class="room-info">Jam : ' + nilai(r.booking.jam) + '</div>' +
        '<div class="text-center text-warning py-3"><i class="ti ti-calendar-event fs-2"></i></div>';
    }

    // ---------- KOSONG ----------
    else {

      badge = '<span class="badge text-bg-success">Kosong</span>';

      isi =
        '<div class="room-info mt-3">Jadwal berikutnya : ' + nilai(r.jadwal_berikutnya) + '</div>' +
        '<div class="text-center text-muted py-3"><i class="ti ti-device-gamepad-2 fs-2"></i></div>';
    }

    return '' +
      '<div class="col-md-6 col-xl-4">' +
        '<div class="room-card">' +
          '<div class="d-flex justify-content-between align-items-start">' +
            judul + badge +
          '</div>' +
          isi +
        '</div>' +
      '</div>';
  }

  function itemBooking(r) {
    return '' +
      '<div class="booking-item">' +
        '<div>' +
          '<div class="booking-time">' + nilai(r.booking.jam) + '</div>' +
          '<div class="booking-customer">' + nilai(r.booking.customer) + '</div>' +
        '</div>' +
        '<span class="badge text-bg-warning">' + esc(r.nama_ruangan) + '</span>' +
      '</div>';
  }

  async function loadDashboard() {

    const daftar = document.getElementById("daftarRuangan");
    const daftarBooking = document.getElementById("daftarBooking");

    try {

      const response = await fetch("/ruangan/data", {
        method: "GET",
        headers: { "Accept": "application/json" }
      });

      if (response.status === 401) {
        window.location.href = "/logout";
        return;
      }

      if (!response.ok) {
        daftar.innerHTML = '<div class="col-12 text-center text-danger py-4">Gagal memuat data ruangan.</div>';
        return;
      }

      const rooms = await response.json();

      // Statistik
      const digunakan = rooms.filter(function (r) {
        return r.status_ruangan === "Digunakan";
      }).length;

      const dibooking = rooms.filter(function (r) {
        return r.status_ruangan === "Tersedia" && r.booking;
      });

      const kosong = rooms.filter(function (r) {
        return r.status_ruangan === "Tersedia" && !r.booking;
      }).length;

      document.getElementById("statTotal").textContent = rooms.length;
      document.getElementById("statDigunakan").textContent = digunakan;
      document.getElementById("statBooking").textContent = dibooking.length;
      document.getElementById("statKosong").textContent = kosong;

      // Kartu ruangan
      if (rooms.length === 0) {
        daftar.innerHTML = '<div class="col-12 text-center text-muted py-4">Belum ada data ruangan.</div>';
      } else {
        daftar.innerHTML = rooms.map(kartuRuangan).join("");
      }

      // Booking hari ini
      const adaBooking = rooms.filter(function (r) { return r.booking; });

      if (adaBooking.length === 0) {
        daftarBooking.innerHTML =
          '<div class="text-center text-muted py-4">' +
            '<i class="ti ti-calendar-off fs-2 d-block mb-2"></i>Belum ada booking' +
          '</div>';
      } else {
        daftarBooking.innerHTML = adaBooking.map(itemBooking).join("");
      }

    } catch (e) {
      daftar.innerHTML = '<div class="col-12 text-center text-danger py-4">Tidak dapat terhubung ke server.</div>';
    }

  }

  loadDashboard();
  setInterval(loadDashboard, 30000); // perbarui otomatis tiap 30 detik

    /* =====================================================
       LOGOUT (popup di tengah halaman)
    ====================================================== */

    const logoutModal = document.getElementById("logoutModal");

    function logout() {
      logoutModal.classList.add("show");
      logoutModal.setAttribute("aria-hidden", "false");
    }

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