<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Jadwal Ruangan | PS Rental</title>

  <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- BOOTSTRAP 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- TABLER ICON -->
  <link rel="stylesheet" href="{{ asset('assets/fonts/tabler-icons.min.css') }}">

  <!-- FONT -->
  <link rel="stylesheet" href="{{ asset('assets/fonts/inter/inter.css') }}">

  <!-- TEMPLATE CSS (sama seperti dashboard, supaya font seragam) -->
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/style-preset.css') }}">

  <style>
    /* ===== GLOBAL ===== */
    body { background-color: #f8f9fa; color: #212529; }

    /* ===== SIDEBAR (SAMA DENGAN DASHBOARD) ===== */
    .sidebar { width: 280px; min-height: 100vh; position: fixed; left: 0; top: 0; background: #ffffff; border-right: 1px solid #dee2e6; padding: 24px 16px; z-index: 1000; }
    .brand { font-size: 25px; font-weight: 700; color: #3b82f6; text-decoration: none; display: block; padding: 0 10px 25px; }

    .user-card { background: #f8f9fa; border: 1px solid #e5e7eb; border-radius: 16px; padding: 18px; margin-bottom: 25px; }
    .user-avatar { width: 48px; height: 48px; border-radius: 50%; object-fit: cover; }
    .user-name { font-weight: 600; margin-bottom: 2px; }
    .user-role { color: #6c757d; font-size: 14px; }

    .menu-title { font-size: 13px; font-weight: 700; color: #495057; text-transform: uppercase; padding: 0 18px; margin-bottom: 10px; }
    .sidebar-menu { list-style: none; padding: 0; margin: 0; }
    .sidebar-menu li { margin-bottom: 6px; }
    .sidebar-menu a { display: flex; align-items: center; gap: 15px; padding: 13px 18px; color: #64748b; text-decoration: none; border-radius: 10px; transition: 0.2s; font-size: 15px; }
    .sidebar-menu a:hover { background: #f1f5f9; color: #3b82f6; }
    .sidebar-menu a.active { background: #e8f0ff; color: #3b82f6; font-weight: 600; }
    .sidebar-menu i { font-size: 21px; }

    .sidebar-bottom { margin-top: 30px; }
    .profile-box { border: 1px solid #e5e7eb; border-radius: 15px; padding: 20px; text-align: center; background: #ffffff; }
    .profile-box i { font-size: 28px; }
    .profile-box h6 { margin-top: 10px; margin-bottom: 3px; }
    .profile-box small { color: #6c757d; }
    .logout-box { margin-top: 15px; }
    .logout-btn { width: 100%; background: #ffffff; border: 1px solid #e5e7eb; color: #dc3545; padding: 14px; border-radius: 12px; text-align: left; }

    /* ===== MAIN + HEADER (SAMA DENGAN DASHBOARD) ===== */
    .main-content { margin-left: 280px; min-height: 100vh; }
    .top-header { height: 80px; background: #ffffff; border-bottom: 1px solid #dee2e6; display: flex; align-items: center; justify-content: space-between; padding: 0 35px; }
    .header-title { font-size: 20px; font-weight: 600; margin: 0; }
    .header-date { color: #6c757d; font-size: 14px; }
    .content { padding: 35px; }
    footer { padding: 25px 35px; color: #6c757d; font-size: 14px; }

    /* ===== TOMBOL HAMBURGER + SIDEBAR COLLAPSE ===== */
    .menu-toggle { border: 0; background: transparent; color: #495057; font-size: 24px; line-height: 1; padding: 6px 10px; border-radius: 8px; cursor: pointer; transition: 0.2s; }
    .menu-toggle:hover { background: #f1f5f9; color: #3b82f6; }
    .sidebar { transition: transform 0.25s ease; }
    .main-content { transition: margin-left 0.25s ease; }
    body.sidebar-collapsed .sidebar { transform: translateX(-100%); }
    body.sidebar-collapsed .main-content { margin-left: 0; }

    /* ===== KHUSUS HALAMAN RUANGAN ===== */
    .schedule-slot { height: 28px; border-radius: 5px; width: 100%; }
    .slot-empty { background: #dff4e7; }
    .slot-booking { background: #ffedc2; }
    .slot-used { background: #f6d5d9; }
    .room-name { font-weight: 600; margin-bottom: 6px; }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 991px) {
      .sidebar { position: relative; width: 100%; min-height: auto; }
      .main-content { margin-left: 0; }
      .top-header { padding: 0 20px; }
      .content { padding: 20px; }
      body.sidebar-collapsed .sidebar { display: none; transform: none; }
    }

    /* ===== DITAMBAHKAN: SIDEBAR MODE DRAWER DI MOBILE (SAMA SEPERTI BOOKING) ===== */
    @media (max-width: 991px) {
      body .sidebar,
      body.sidebar-collapsed .sidebar {
        display: block;
        position: fixed;
        width: 280px;
        min-height: 100vh;
        overflow-y: auto;
        transform: translateX(-100%);
      }

      body .sidebar.show,
      body.sidebar-collapsed .sidebar.show {
        transform: translateX(0);
        box-shadow: 0 0 30px rgba(0, 0, 0, 0.15);
      }
    }
    /* ===== DITAMBAHKAN: POPUP KONFIRMASI LOGOUT ===== */
    #logoutModal .modal-content { border: 0; border-radius: 22px; padding: 12px 8px 8px; text-align: center; box-shadow: 0 25px 60px rgba(15, 23, 42, 0.25); }
    #logoutModal.modal.fade .modal-dialog { transform: scale(0.85) translateY(20px); transition: transform 0.25s ease, opacity 0.25s ease; }
    #logoutModal.modal.show .modal-dialog { transform: scale(1) translateY(0); }
    .logout-modal-icon { width: 76px; height: 76px; margin: 14px auto 18px; border-radius: 50%; background: #fde8e8; color: #dc3545; display: flex; align-items: center; justify-content: center; font-size: 36px; box-shadow: 0 0 0 10px #fff4f4; }
    .logout-modal-title { font-size: 21px; font-weight: 700; margin-bottom: 8px; }
    .logout-modal-text { color: #6c757d; font-size: 14px; margin-bottom: 0; }
    .logout-modal-actions { display: flex; gap: 12px; padding: 22px 16px 14px; }
    .logout-modal-actions .btn { flex: 1; padding: 12px; border-radius: 12px; font-weight: 600; }
    .btn-logout-cancel { background: #f1f5f9; border: 1px solid #e5e7eb; color: #475569; }
    .btn-logout-cancel:hover { background: #e2e8f0; color: #1e293b; }
    .btn-logout-confirm { background: #dc3545; border: 1px solid #dc3545; color: #ffffff; }
    .btn-logout-confirm:hover { background: #bb2d3b; border-color: #bb2d3b; color: #ffffff; }

    /* ===== DITAMBAHKAN: SLOT JADWAL BISA DIKLIK ===== */
    .slot-maint { background: #e9ecef; }
    .schedule-slot.slot-click { cursor: pointer; transition: box-shadow 0.15s ease; }
    .schedule-slot.slot-click:hover { box-shadow: inset 0 0 0 2px rgba(0, 0, 0, 0.18); }
    #modalAksiBooking .modal-content { border: 0; border-radius: 18px; box-shadow: 0 25px 60px rgba(15, 23, 42, 0.25); }
    #modalAksiBooking dt { font-size: 12px; font-weight: 600; color: #6c757d; margin-bottom: 2px; }
    #modalAksiBooking dd { margin-bottom: 12px; font-weight: 500; }

    /* =====================================================
       DITAMBAHKAN: TAMPILAN JADWAL (TIMELINE)
    ===================================================== */
    .page-title { font-weight: 700; letter-spacing: -0.01em; }

    .summary-chips { display: flex; flex-wrap: wrap; gap: 8px; }
    .chip { display: inline-flex; align-items: center; gap: 8px; background: #ffffff; border: 1px solid #e5e7eb; border-radius: 999px; padding: 6px 14px 6px 10px; font-size: 13px; color: #475569; box-shadow: 0 1px 2px rgba(15, 23, 42, 0.04); }
    .chip b { color: #0f172a; font-weight: 700; }
    .chip .dot { width: 9px; height: 9px; border-radius: 50%; }
    .dot.is-empty { background: #22a06b; }
    .dot.is-booking { background: #f5b301; }
    .dot.is-used { background: #e5484d; }
    .dot.is-maint { background: #94a3b8; }

    .schedule-card { border: 0; border-radius: 18px; background: #ffffff; box-shadow: 0 1px 3px rgba(15, 23, 42, 0.06), 0 10px 28px rgba(15, 23, 42, 0.05); overflow: hidden; }
    .schedule-head { display: flex; justify-content: space-between; align-items: center; gap: 12px; padding: 18px 24px; border-bottom: 1px solid #eef0f3; }
    .schedule-head h5 { margin: 0; font-weight: 700; }
    .schedule-head .hint { font-size: 13px; color: #94a3b8; }
    .date-pill { background: #eaf1ff; color: #2f6fed; font-weight: 600; font-size: 12.5px; padding: 6px 14px; border-radius: 999px; white-space: nowrap; }
    .schedule-body { padding: 10px 24px 22px; }

    .timeline-scroll { overflow-x: auto; padding-bottom: 6px; }
    .timeline { --n: 15; --label-w: 190px; min-width: calc(var(--label-w) + var(--n) * 76px); }

    .tl-row { display: grid; grid-template-columns: var(--label-w) 1fr; align-items: stretch; border-bottom: 1px solid #f0f2f5; }
    .tl-row:last-child { border-bottom: 0; }

    .tl-label { padding: 14px 14px 14px 0; display: flex; flex-direction: column; justify-content: center; gap: 6px; }
    .tl-head .tl-label { font-size: 11.5px; text-transform: uppercase; letter-spacing: 0.07em; color: #94a3b8; font-weight: 600; padding: 12px 14px 12px 0; }
    .tl-hours { display: grid; grid-template-columns: repeat(var(--n), 1fr); }
    .tl-hour { padding: 12px 0 12px 6px; font-size: 12px; font-weight: 600; color: #94a3b8; border-left: 1px solid #e9edf2; }
    .tl-hour.is-now { color: #e5484d; }

    .tl-name { font-weight: 700; font-size: 15px; color: #0f172a; }
    .tl-meta { display: flex; align-items: center; gap: 6px; flex-wrap: wrap; }
    .tl-type { font-size: 11px; font-weight: 600; padding: 2px 8px; border-radius: 6px; background: #f1f5f9; color: #64748b; }
    .tl-status { font-size: 11px; font-weight: 600; padding: 2px 9px; border-radius: 999px; }
    .tl-status.is-empty { background: #e6f6ee; color: #177a4f; }
    .tl-status.is-booking { background: #fff4d6; color: #946200; }
    .tl-status.is-used { background: #fde8ea; color: #b4232c; }
    .tl-status.is-maint { background: #eef1f5; color: #64748b; }

    .tl-track { position: relative; min-height: 70px; background-color: #f6fbf8; background-image: linear-gradient(to right, #e4ebe7 1px, transparent 1px); background-size: calc(100% / var(--n)) 100%; }
    .tl-track.is-maint { background-color: #f3f4f6; background-image: repeating-linear-gradient(135deg, rgba(148, 163, 184, 0.2) 0 8px, transparent 8px 16px); }
    .tl-maint-text { position: absolute; top: 0; right: 0; bottom: 0; left: 0; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 600; color: #94a3b8; letter-spacing: 0.05em; pointer-events: none; }

    .tl-past { position: absolute; top: 0; bottom: 0; left: 0; background: rgba(15, 23, 42, 0.04); pointer-events: none; }
    .tl-now { position: absolute; top: 0; bottom: 0; width: 2px; margin-left: -1px; background: #e5484d; z-index: 3; pointer-events: none; }

    .tl-bar { position: absolute; top: 11px; bottom: 11px; border-radius: 10px; border-left: 4px solid; padding: 0 12px; display: flex; flex-direction: column; justify-content: center; overflow: hidden; cursor: pointer; z-index: 2; transition: transform 0.15s ease, box-shadow 0.15s ease; }
    .tl-bar:hover { transform: translateY(-1px); box-shadow: 0 6px 14px rgba(15, 23, 42, 0.12); }
    .tl-bar.is-booking { background: #fff4d6; border-color: #f5b301; color: #7a5200; }
    .tl-bar.is-used { background: #fde8ea; border-color: #e5484d; color: #a1222b; }
    .tl-bar-name { font-weight: 700; font-size: 13px; line-height: 1.25; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .tl-bar-time { font-size: 11.5px; opacity: 0.85; line-height: 1.25; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }

    .legend-row { display: flex; flex-wrap: wrap; align-items: center; gap: 8px 22px; margin-top: 18px; padding-top: 16px; border-top: 1px solid #eef0f3; font-size: 13px; color: #64748b; }
    .legend-row .item { display: inline-flex; align-items: center; gap: 8px; }
    .legend-row .dot { width: 10px; height: 10px; border-radius: 50%; }
    .legend-row .note { margin-left: auto; color: #94a3b8; }

    #modalAksiBooking .modal-content { border-radius: 20px; }
    #modalAksiBooking .modal-title { font-weight: 700; }

    @media (max-width: 767px) {
      .timeline { --label-w: 150px; }
      .schedule-head, .schedule-body { padding-left: 16px; padding-right: 16px; }
      .legend-row .note { margin-left: 0; width: 100%; }
    }
  </style>
</head>

<body>

<!-- ===================== SIDEBAR ===================== -->
<!-- DITAMBAHKAN: id="sidebar" -->
<aside class="sidebar" id="sidebar">

  <a href="/dashboard" class="brand">PS Rental</a>

  <!-- USER CARD + LOGOUT (satu baris) -->
  <div style="display: flex; gap: 10px; align-items: stretch; margin-bottom: 25px;">

  <div class="user-card" onclick="window.location.href='/profil'" style="cursor:pointer; margin-bottom:0; flex:1; min-width:0;" title="Profil Saya">
    <div class="d-flex align-items-center">
      <img src="{{ asset('assets/images/user/avatar-1.jpg') }}" class="user-avatar" alt="User">
      <div class="ms-3">
        <div class="user-name" id="sidebarUsername">User</div>
        <div class="user-role" id="sidebarRole">Role</div>
      </div>
    </div>
  </div>

  <!-- LOGOUT (DI SAMPING USER CARD, ikon saja) -->
  <div class="logout-box" style="margin: 0;">
    <button type="button" class="logout-btn" onclick="logout()" title="Logout" aria-label="Logout" style="width: auto; height: 100%; padding: 0 16px; text-align: center;">
      <i class="ti ti-logout fs-5"></i>
    </button>
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

    <!-- SUPERADMIN -->
    <li class="menu-superadmin">
      <a href="/ruanganAdmin">
        <i class="ti ti-device-gamepad"></i>
        <span>Ruangan</span>
      </a>
    </li>

    <li class="menu-superadmin">
      <a href="/user">
        <i class="ti ti-users"></i>
        <span>Data User</span>
      </a>
    </li>

    <!-- KASIR -->
    <li class="menu-kasir">
      <a href="/booking">
        <i class="ti ti-calendar-event"></i>
        <span>Booking</span>
      </a>
    </li>

    <li class="menu-kasir">
      <a href="/ruangan" class="active">
        <i class="ti ti-device-gamepad"></i>
        <span>Ruangan</span>
      </a>
    </li>

    <li class="menu-kasir">
      <a href="/tracking">
        <i class="ti ti-receipt"></i>
        <span>Tracking</span>
      </a>
    </li>

    <!-- LAPORAN (SEMUA ROLE) -->
    <li>
      <a href="/laporan">
        <i class="ti ti-report"></i>
        <span>Laporan</span>
      </a>
    </li>

  </ul>

</aside>


<!-- ===================== MAIN ===================== -->
<main class="main-content">

  <!-- HEADER -->
  <header class="top-header">
    <div class="d-flex align-items-center gap-2">
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

    <div class="d-flex flex-wrap justify-content-between align-items-end gap-3 mb-4">
      <div>
        <h4 class="page-title mb-1">Jadwal Ruangan</h4>
        <p class="text-muted mb-0">Informasi jadwal dan ketersediaan ruangan PS Rental.</p>
      </div>
      <div class="summary-chips" id="ringkasanChips"></div>
    </div>

    <div class="schedule-card">

      <div class="schedule-head">
        <div>
          <h5>Jadwal Hari Ini</h5>
          <div class="hint">Klik blok berwarna untuk membatalkan atau menyelesaikan booking.</div>
        </div>
        <span class="date-pill" id="badgeDate">-</span>
      </div>

      <div class="schedule-body">

        <div id="notifRuangan" class="alert d-none py-2 small mt-3" role="alert"></div>

        <div class="timeline-scroll">
          <div class="timeline" id="timeline">
            <div class="text-center text-muted py-5">Memuat jadwal ruangan...</div>
          </div>
        </div>

        <!-- LEGEND -->
        <div class="legend-row">
          <span class="item"><span class="dot is-empty"></span> Kosong</span>
          <span class="item"><span class="dot is-booking"></span> Booking</span>
          <span class="item"><span class="dot is-used"></span> Sedang Digunakan</span>
          <span class="item"><span class="dot is-maint"></span> Maintenance</span>
          <span class="note">Garis merah menandakan waktu sekarang</span>
        </div>

      </div>
    </div>

  </div>


</main>

<!-- ===== DITAMBAHKAN: POPUP KONFIRMASI LOGOUT (TENGAH HALAMAN) ===== -->
<div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content">

      <div class="modal-body pb-0">
        <div class="logout-modal-icon">
          <i class="ti ti-logout"></i>
        </div>

        <p class="logout-modal-text">
          Apakah Anda yakin ingin logout? 
        </p>
      </div>

      <div class="logout-modal-actions">
        <button type="button" class="btn btn-logout-cancel" data-bs-dismiss="modal">Tidak</button>
        <button type="button" class="btn btn-logout-confirm" id="confirmLogoutBtn">Ya</button>
      </div>

    </div>
  </div>
</div>


<!-- BOOTSTRAP JAVASCRIPT -->
<!-- ===================== POPUP AKSI BOOKING ===================== -->
<div class="modal fade" id="modalAksiBooking" tabindex="-1" aria-labelledby="judulAksiBooking" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header border-0 pb-0">
        <h5 class="modal-title" id="judulAksiBooking">Detail Booking</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>

      <div class="modal-body">
        <dl class="mb-0">
          <dt>Ruangan</dt>
          <dd id="aksiRuangan">-</dd>
          <dt>Pelanggan</dt>
          <dd id="aksiNama">-</dd>
          <dt>Jam</dt>
          <dd id="aksiJam">-</dd>
          <dt>Status</dt>
          <dd id="aksiStatus">-</dd>
        </dl>
        <div id="aksiCatatan" class="small text-muted"></div>
      </div>

      <div class="modal-footer border-0 pt-0">
        <button type="button" class="btn btn-outline-danger" id="btnBatalBooking">
          <i class="ti ti-x me-1"></i> Batalkan
        </button>
        <button type="button" class="btn btn-success" id="btnSelesaiBooking">
          <i class="ti ti-check me-1"></i> Selesai
        </button>
      </div>

    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
  /* ===== CEK LOGIN ===== */
  const role = localStorage.getItem("role");
  const username = localStorage.getItem("username");

  if (!role || !username) {
    window.location.href = "/logout";
  }

  /* ===== ROLE ===== */
  let roleName = "";

  if (role === "superadmin") {
    roleName = "Superadmin";
  } else if (role === "kasir") {
    roleName = "Kasir";
  } else {
    localStorage.removeItem("role");
    localStorage.removeItem("username");
    window.location.href = "/logout";
  }

  /* ===== ISI NAMA & ROLE DI SIDEBAR ===== */
  document.getElementById("sidebarUsername").textContent = username;
  document.getElementById("sidebarRole").textContent = roleName;

  /* ===== MENU BERDASARKAN ROLE ===== */
  document.querySelectorAll(".menu-kasir").forEach(function (menu) {
    menu.style.display = (role === "kasir") ? "" : "none";
  });

  document.querySelectorAll(".menu-superadmin").forEach(function (menu) {
    menu.style.display = (role === "superadmin") ? "" : "none";
  });

  /* ===== TANGGAL & JAM ===== */
  function updateDateTime() {
    const now = new Date();

    const dateText = now.toLocaleDateString("id-ID", {
      weekday: "long", year: "numeric", month: "long", day: "numeric"
    });

    const timeText = now.toLocaleTimeString("id-ID", {
      hour: "2-digit", minute: "2-digit", second: "2-digit"
    });

    document.getElementById("currentDate").textContent = dateText;
    document.getElementById("currentTime").textContent = timeText;
    document.getElementById("badgeDate").textContent = dateText;
  }

  updateDateTime();
  setInterval(updateDateTime, 1000);

  /* ===== LOGOUT ===== */
  /* DIUBAH: confirm() bawaan browser diganti popup di tengah halaman.
     Proses logout (hapus role & username, lalu ke /logout) tidak berubah,
     hanya dijalankan saat tombol "Ya, Logout" diklik. */
  function logout() {
    bootstrap.Modal.getOrCreateInstance(
      document.getElementById("logoutModal")
    ).show();
  }

  document.getElementById("confirmLogoutBtn").addEventListener("click", function () {
    localStorage.removeItem("role");
    localStorage.removeItem("username");
    window.location.href = "/logout";
  });

  /*  TOGGLE SIDEBAR (HAMBURGER)  */
  const menuToggle = document.getElementById("menuToggle");

  try {
    if (localStorage.getItem("sidebarCollapsed") === "1") {
      document.body.classList.add("sidebar-collapsed");
    }
  } catch (e) {}

  menuToggle.addEventListener("click", function () {
    const collapsed = document.body.classList.toggle("sidebar-collapsed");
    try {
      localStorage.setItem("sidebarCollapsed", collapsed ? "1" : "0");
    } catch (e) {}
  });

  /* ===== DITAMBAHKAN: DRAWER SIDEBAR DI MOBILE (SAMA SEPERTI BOOKING) ===== */
  const sidebar = document.getElementById("sidebar");

  menuToggle.addEventListener("click", function () {
    if (window.innerWidth < 992) {
      sidebar.classList.toggle("show");
    }
  });

  /* =====================================================
     JADWAL RUANGAN (TIMELINE) DARI DATABASE + AKSI BOOKING
  ===================================================== */
  (function () {

    var JAM_BUKA  = 9;    // awal timeline: 09:00
    var JAM_TUTUP = 24;   // akhir timeline: 24:00
    var JUMLAH    = JAM_TUTUP - JAM_BUKA;
    var TOTAL     = JUMLAH * 60;

    var csrf       = document.querySelector('meta[name="csrf-token"]').content;
    var elTimeline = document.getElementById("timeline");
    var elRingkas  = document.getElementById("ringkasanChips");
    var elNotif    = document.getElementById("notifRuangan");
    var elModal    = document.getElementById("modalAksiBooking");
    var modal      = bootstrap.Modal.getOrCreateInstance(elModal);
    var btnBatal   = document.getElementById("btnBatalBooking");
    var btnSelesai = document.getElementById("btnSelesaiBooking");
    var aktif      = null;      // booking yang sedang dibuka di popup
    var timerNotif = null;

    function pad(n) { return String(n).padStart(2, "0"); }

    function menit(t) {
      var p = String(t).split(":");
      return parseInt(p[0], 10) * 60 + parseInt(p[1], 10);
    }

    // Posisi menit (0-1440) menjadi persen lebar timeline
    function persen(m) {
      var p = (m - JAM_BUKA * 60) / TOTAL * 100;
      return Math.max(0, Math.min(100, p));
    }

    function el(tag, kelas, teks) {
      var e = document.createElement(tag);
      if (kelas) e.className = kelas;
      if (teks !== undefined) e.textContent = teks;
      return e;
    }

    function buatBadge(teks, kelas) {
      var s = el("span", "badge " + kelas, teks);
      return s;
    }

    function infoStatus(r) {
      if (r.status_ruangan === "Maintenance") return { teks: "Maintenance", kelas: "is-maint", kunci: "maint" };
      for (var i = 0; i < r.booking.length; i++) {
        if (r.booking[i].status === "Sedang Main") return { teks: "Sedang Digunakan", kelas: "is-used", kunci: "used" };
      }
      if (r.booking.length) return { teks: "Booking", kelas: "is-booking", kunci: "booking" };
      return { teks: "Kosong", kelas: "is-empty", kunci: "empty" };
    }

    function tampilNotif(teks, sukses) {
      elNotif.className = "alert py-2 small mt-3 " + (sukses ? "alert-success" : "alert-danger");
      elNotif.textContent = teks;
      clearTimeout(timerNotif);
      timerNotif = setTimeout(function () { elNotif.classList.add("d-none"); }, 5000);
    }

    function tampilPesan(teks) {
      elTimeline.innerHTML = "";
      elTimeline.appendChild(el("div", "text-center text-muted py-5", teks));
    }

    function gambarRingkasan(h) {
      elRingkas.innerHTML = "";
      [
        ["is-empty",   "Kosong",    h.empty],
        ["is-booking", "Booking",   h.booking],
        ["is-used",    "Digunakan", h.used],
        ["is-maint",   "Maintenance", h.maint]
      ].forEach(function (x) {
        var chip = el("span", "chip");
        chip.appendChild(el("span", "dot " + x[0]));
        chip.appendChild(document.createTextNode(x[1] + " "));
        chip.appendChild(el("b", "", String(x[2])));
        elRingkas.appendChild(chip);
      });
    }

    /* ---------- GAMBAR TIMELINE ---------- */
    function gambar(data) {

      elTimeline.innerHTML = "";
      elTimeline.style.setProperty("--n", JUMLAH);

      if (!data.ruangan.length) {
        tampilPesan("Belum ada data ruangan.");
        gambarRingkasan({ empty: 0, booking: 0, used: 0, maint: 0 });
        return;
      }

      var sekarang = new Date();
      var menitSekarang = sekarang.getHours() * 60 + sekarang.getMinutes();
      var dalamRentang = menitSekarang >= JAM_BUKA * 60 && menitSekarang <= JAM_TUTUP * 60;
      var pNow = persen(menitSekarang);

      // Baris judul jam
      var head = el("div", "tl-row tl-head");
      head.appendChild(el("div", "tl-label", "Ruangan"));

      var jam = el("div", "tl-hours");
      for (var h = JAM_BUKA; h < JAM_TUTUP; h++) {
        var sel = el("div", "tl-hour" + (dalamRentang && h === sekarang.getHours() ? " is-now" : ""), pad(h) + ":00");
        jam.appendChild(sel);
      }
      head.appendChild(jam);
      elTimeline.appendChild(head);

      var hitung = { empty: 0, booking: 0, used: 0, maint: 0 };

      data.ruangan.forEach(function (r) {

        var st = infoStatus(r);
        hitung[st.kunci]++;

        var row = el("div", "tl-row");

        // Kolom nama ruangan
        var label = el("div", "tl-label");
        label.appendChild(el("div", "tl-name", r.nama_ruangan));

        var meta = el("div", "tl-meta");
        meta.appendChild(el("span", "tl-type", r.jenis_ruangan));
        meta.appendChild(el("span", "tl-status " + st.kelas, st.teks));
        label.appendChild(meta);
        row.appendChild(label);

        // Jalur waktu
        var maint = r.status_ruangan === "Maintenance";
        var track = el("div", "tl-track" + (maint ? " is-maint" : ""));

        if (maint) track.appendChild(el("span", "tl-maint-text", "SEDANG MAINTENANCE"));

        if (dalamRentang) {
          var lewat = el("div", "tl-past");
          lewat.style.width = pNow + "%";
          track.appendChild(lewat);
        }

        r.booking.forEach(function (b) {

          var kiri  = persen(menit(b.mulai));
          var kanan = persen(menit(b.selesai));
          if (kanan <= kiri) return;

          var sedangMain = b.status === "Sedang Main";
          var bar = el("div", "tl-bar " + (sedangMain ? "is-used" : "is-booking"));
          bar.style.left  = "calc(" + kiri + "% + 3px)";
          bar.style.width = "calc(" + (kanan - kiri) + "% - 6px)";
          bar.title = b.nama + " (" + b.mulai + " - " + b.selesai + ")";

          bar.appendChild(el("span", "tl-bar-name", b.nama));
          bar.appendChild(el("span", "tl-bar-time", b.mulai + " - " + b.selesai));

          bar.addEventListener("click", function () { bukaPopup(r, b); });
          track.appendChild(bar);
        });

        if (dalamRentang) {
          var garis = el("div", "tl-now");
          garis.style.left = pNow + "%";
          track.appendChild(garis);
        }

        row.appendChild(track);
        elTimeline.appendChild(row);
      });

      gambarRingkasan(hitung);
    }

    /* ---------- AMBIL DATA ---------- */
    async function muat() {
      try {
        var res = await fetch("/ruangan/jadwal", { headers: { "Accept": "application/json" } });

        if (res.status === 401) { window.location.href = "/logout"; return; }

        if (!res.ok) { tampilPesan("Gagal memuat jadwal ruangan."); return; }

        gambar(await res.json());
      } catch (e) {
        tampilPesan("Tidak dapat terhubung ke server.");
      }
    }

    /* ---------- POPUP ---------- */
    function bukaPopup(r, b) {
      aktif = { ruangan: r, booking: b };

      document.getElementById("aksiRuangan").textContent = r.nama_ruangan;
      document.getElementById("aksiNama").textContent    = b.nama;
      document.getElementById("aksiJam").textContent     = b.mulai + " - " + b.selesai;

      var elStatus = document.getElementById("aksiStatus");
      elStatus.innerHTML = "";
      var sedangMain = b.status === "Sedang Main";
      elStatus.appendChild(buatBadge(sedangMain ? "Sedang Digunakan" : "Booking",
                                     sedangMain ? "text-bg-danger" : "text-bg-warning"));

      btnBatal.disabled   = false;
      btnSelesai.disabled = !sedangMain;

      document.getElementById("aksiCatatan").textContent = sedangMain
        ? "Selesai akan memasukkan booking ini ke laporan. Batalkan tidak akan masuk laporan."
        : "Booking belum dimulai, jadi hanya bisa dibatalkan. Tombol Selesai aktif saat jam mulai tiba.";

      modal.show();
    }

    async function kirimAksi(aksi) {
      if (!aktif) return;

      btnBatal.disabled = true;
      btnSelesai.disabled = true;

      try {
        var res = await fetch("/booking/" + aktif.booking.id_booking + "/" + aksi, {
          method: "POST",
          headers: { "Accept": "application/json", "X-CSRF-TOKEN": csrf }
        });

        if (res.status === 401) { window.location.href = "/logout"; return; }

        var data = {};
        try { data = await res.json(); } catch (e) {}

        modal.hide();

        if (!res.ok) {
          tampilNotif(data.message || "Gagal memproses booking.", false);
        } else {
          tampilNotif(data.message || "Berhasil.", true);
        }

      } catch (e) {
        modal.hide();
        tampilNotif("Tidak dapat terhubung ke server.", false);
      }

      aktif = null;
      muat();
    }

    btnBatal.addEventListener("click",   function () { kirimAksi("batal"); });
    btnSelesai.addEventListener("click", function () { kirimAksi("selesai"); });

    tampilPesan("Memuat jadwal ruangan...");
    muat();
    setInterval(muat, 30000);   // perbarui otomatis tiap 30 detik

  })();
</script>

</body>
</html>