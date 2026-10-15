<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Tracking | PS Rental</title>

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
      transition: transform 0.25s ease;
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

    .sidebar-bottom {
      margin-top: 30px;
    }

    .profile-box {
      border: 1px solid #e5e7eb;
      border-radius: 15px;
      padding: 20px;
      text-align: center;
      background: #ffffff;
    }

    .profile-box i {
      font-size: 28px;
    }

    .profile-box h6 {
      margin-top: 10px;
      margin-bottom: 3px;
    }

    .profile-box small {
      color: #6c757d;
    }

    .logout-box {
      margin-top: 15px;
    }

    .logout-btn {
      width: 100%;
      background: #ffffff;
      border: 1px solid #e5e7eb;
      color: #dc3545;
      padding: 14px;
      border-radius: 12px;
      text-align: left;
    }

    /* ================= MAIN ================= */
    .main-content {
      margin-left: 280px;
      min-height: 100vh;
      transition: margin-left 0.25s ease;
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

    .content {
      padding: 35px;
    }

    /* ================= HAMBURGER ================= */
    .menu-toggle {
      border: none;
      background: transparent;
      font-size: 26px;
      line-height: 1;
      padding: 6px 8px;
      border-radius: 8px;
      color: #495057;
    }

    .menu-toggle:hover {
      background: #f1f5f9;
      color: #3b82f6;
    }

    body.sidebar-hidden .sidebar {
      transform: translateX(-100%);
    }

    body.sidebar-hidden .main-content {
      margin-left: 0;
    }


    /* =====================================================
       TRACKING WRAPPER
    ====================================================== */

    .tracking-wrapper {
      width: 100%;
      max-width: 1000px;
      margin: 0 auto;
    }


    /* =====================================================
       TRACKING CARD
    ====================================================== */

    .tracking-card {
      width: 100%;
      background: #ffffff;
      border: 1px solid #e5e7eb;
      border-radius: 10px;
      overflow: hidden;
    }


    /* =====================================================
       CARD HEADER
    ====================================================== */

    .tracking-header {
      padding: 18px 22px;
      border-bottom: 1px solid #eeeeee;
      background: #ffffff;
    }

    .tracking-header-left {
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .tracking-room-icon {
      font-size: 20px;
      color: #374151;
    }

    .tracking-room-title {
      font-size: 18px;
      font-weight: 600;
      color: #1f2937;
    }


    /* =====================================================
       STATUS
    ====================================================== */

    .status-badge {
      display: inline-block;
      padding: 6px 10px;
      border-radius: 5px;
      background: #e1f7ed;
      color: #179b63;
      font-size: 11px;
      font-weight: 500;
      white-space: nowrap;
    }


    /* =====================================================
       TRACKING BODY
    ====================================================== */

    .tracking-body {
      padding: 22px;
    }

    .tracking-main {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 60px;
    }


    /* =====================================================
       DETAIL CUSTOMER
    ====================================================== */

    .tracking-detail {
      flex: 1;
      max-width: 560px;
    }

    .detail-row {
      display: flex;
      align-items: center;
      margin-bottom: 14px;
      font-size: 13px;
    }

    .detail-row:last-child {
      margin-bottom: 0;
    }

    .detail-label {
      width: 70px;
      color: #374151;
    }

    .detail-separator {
      width: 25px;
      color: #9ca3af;
    }

    .detail-value {
      color: #374151;
      font-weight: 500;
    }


    /* =====================================================
       TIMER
    ====================================================== */

    .timer-wrapper {
      width: 150px;
      height: 150px;
      flex-shrink: 0;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .timer-ring {
      width: 145px;
      height: 145px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      position: relative;
      background:
        conic-gradient(
          #36b56f 0deg,
          #36b56f 290deg,
          #e7edf0 290deg,
          #e7edf0 360deg
        );
    }

    .timer-ring::before {
      content: "";
      position: absolute;
      width: 119px;
      height: 119px;
      border-radius: 50%;
      background: #ffffff;
    }

    .timer-content {
      position: relative;
      z-index: 2;
      text-align: center;
    }

    .timer-value {
      font-size: 19px;
      font-weight: 700;
      line-height: 1.2;
      color: #263238;
    }

    .timer-label {
      margin-top: 4px;
      font-size: 9px;
      color: #8b949e;
    }


    /* =====================================================
       DETAIL HARGA
    ====================================================== */

    .price-section {
      margin-top: 24px;
      border: 1px solid #e5e7eb;
      border-radius: 7px;
      overflow: hidden;
    }

    .price-header {
      padding: 12px 14px;
      background: #ffffff;
      border-bottom: 1px solid #eeeeee;
      color: #374151;
      font-size: 13px;
      font-weight: 600;
    }

    .price-row {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 12px 14px;
      border-bottom: 1px solid #f0f0f0;
      color: #374151;
      font-size: 12px;
    }

    .price-row:last-of-type {
      border-bottom: none;
    }

    .price-value {
      font-weight: 500;
    }


    /* =====================================================
       TOTAL
    ====================================================== */

    .total-section {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 13px 14px;
      background: #edf4f9;
      color: #374151;
      font-size: 13px;
      font-weight: 600;
    }

    .total-price {
      font-weight: 700;
    }


    /* =====================================================
       ACTION BUTTON
    ====================================================== */

    .tracking-actions {
      display: flex;
      align-items: center;
      gap: 8px;
      padding: 10px 16px;
      border-top: 1px solid #eeeeee;
      background: #ffffff;
    }

    .tracking-actions .btn {
      padding: 8px 11px;
      font-size: 11px;
      border-radius: 5px;
      pointer-events: none;
      cursor: default;
    }

    .btn-extend {
      background: #ffffff;
      border: 1px solid #d8dee4;
      color: #6b7280;
    }

    .btn-finish {
      background: #ffffff;
      border: 1px solid #e57373;
      color: #e53935;
    }


    /* =====================================================
       TABLET
    ====================================================== */

    @media (max-width: 991px) {

      .tracking-main {
        gap: 30px;
      }

      .tracking-wrapper {
        max-width: 100%;
      }

      /* Sidebar menjadi drawer */
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
    }


    /* =====================================================
       MOBILE
    ====================================================== */

    @media (max-width: 767px) {

      .tracking-main {
        flex-direction: column;
        align-items: flex-start;
      }

      .timer-wrapper {
        align-self: center;
      }

      .tracking-actions {
        flex-wrap: wrap;
      }
    }
  </style>
</head>

<body>

  <!-- =========================================================
       SIDEBAR
  ========================================================== -->
  <aside class="sidebar" id="sidebar">

    <!-- LOGO -->
    <a href="/dashboard" class="brand">PS Rental</a>

    <!-- USER CARD -->
    <div class="user-card" onclick="window.location.href='/profil'" style="cursor:pointer" title="Profil Saya">
      <div class="d-flex align-items-center">
        <img
          src="{{ asset('assets/images/user/avatar-1.jpg') }}"
          class="user-avatar"
          alt="user">

        <div class="ms-3">
          <div class="user-name" id="sidebarUsername">kasir</div>
          <div class="user-role" id="sidebarRole">Kasir</div>
        </div>
      </div>
    </div>

    <!-- MENU -->
    <div class="menu-title">Menu</div>

    <ul class="sidebar-menu">

      <li>
        <a href="/dashboard">
          <i class="ti ti-home"></i>
          <span>Dashboard</span>
        </a>
      </li>

      <li>
        <a href="/booking">
          <i class="ti ti-calendar-event"></i>
          <span>Booking</span>
        </a>
      </li>

      <li>
        <a href="/ruangan">
          <i class="ti ti-device-gamepad"></i>
          <span>Ruangan</span>
        </a>
      </li>

      <li>
        <a href="/tracking" class="active">
          <i class="ti ti-receipt"></i>
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

    <!-- PROFILE + LOGOUT -->
    <div class="sidebar-bottom">

      <div class="logout-box">
        <button type="button" class="logout-btn" onclick="logout()">
          <i class="ti ti-logout me-2"></i>
          Logout
        </button>
      </div>

    </div>

  </aside>


  <!-- =========================================================
       MAIN
  ========================================================== -->
  <main class="main-content">

    <!-- HEADER -->
    <header class="top-header">

      <!-- HAMBURGER -->
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

      <!-- PAGE TITLE -->
      <div class="row mb-4">
        <div class="col-12">
          <h4 class="mb-1">Tracking Sewa</h4>
          <p class="text-muted mb-0">Pantau waktu sewa ruangan yang sedang digunakan.</p>
        </div>
      </div>

      <!-- TRACKING -->
      <div class="tracking-wrapper">

        <div class="tracking-card">

          <!-- TRACKING HEADER -->
          <div class="tracking-header">
            <div class="d-flex justify-content-between align-items-center">

              <!-- Room -->
              <div class="tracking-header-left">
                <i class="ti ti-device-gamepad-2 tracking-room-icon"></i>
                <span class="tracking-room-title">VIP Room 1</span>
              </div>

              <!-- Status -->
              <span class="status-badge">Sedang Digunakan</span>

            </div>
          </div>

          <!-- TRACKING BODY -->
          <div class="tracking-body">

            <div class="tracking-main">

              <!-- DETAIL CUSTOMER -->
              <div class="tracking-detail">

                <div class="detail-row">
                  <span class="detail-label">Customer</span>
                  <span class="detail-separator">:</span>
                  <span class="detail-value">Budi</span>
                </div>

                <div class="detail-row">
                  <span class="detail-label">Mulai</span>
                  <span class="detail-separator">:</span>
                  <span class="detail-value">19:00</span>
                </div>

                <div class="detail-row">
                  <span class="detail-label">Selesai</span>
                  <span class="detail-separator">:</span>
                  <span class="detail-value">21:00</span>
                </div>

                <div class="detail-row">
                  <span class="detail-label">Durasi</span>
                  <span class="detail-separator">:</span>
                  <span class="detail-value">2 Jam</span>
                </div>

              </div>

              <!-- TIMER -->
              <div class="timer-wrapper">
                <div class="timer-ring">
                  <div class="timer-content">

                    <!-- TIDAK BERJALAN -->
                    <div class="timer-value">00:00:00</div>
                    <div class="timer-label">Sisa waktu</div>

                  </div>
                </div>
              </div>

            </div>

            <!-- DETAIL HARGA -->
            <div class="price-section">

              <div class="price-header">Detail Harga</div>

              <div class="price-row">
                <span>Sewa Ruangan (2 Jam)</span>
                <span class="price-value">Rp 30.000</span>
              </div>

              <div class="price-row">
                <span>Makanan/Minuman</span>
                <span class="price-value">Rp 0</span>
              </div>

              <div class="total-section">
                <span>Total</span>
                <span class="total-price">Rp 30.000</span>
              </div>

            </div>

          </div>

          <!-- ACTION BUTTON -->
          <div class="tracking-actions">

            <button type="button" class="btn btn-extend">
              <i class="ti ti-clock-plus me-1"></i>
              Perpanjang Waktu
            </button>

            <button type="button" class="btn btn-finish">
              <i class="ti ti-circle-check me-1"></i>
              Selesaikan Sewa
            </button>

          </div>

        </div>

      </div>

    </div>

  </main>


  <!-- =========================================================
       JAVASCRIPT
  ========================================================== -->

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    // Toggle sidebar (desktop & mobile)
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

    // Logout
    function logout() {
      if (confirm("Apakah Anda yakin ingin logout?")) {
        localStorage.removeItem("role");
        localStorage.removeItem("username");
        window.location.href = "/login";
      }
    }
  </script>

</body>

</html>