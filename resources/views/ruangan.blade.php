<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Jadwal Ruangan | PS Rental</title>

  <!-- BOOTSTRAP 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- TABLER ICON -->
  <link rel="stylesheet" href="{{ asset('assets/fonts/tabler-icons.min.css') }}">

  <!-- FONT -->
  <link rel="stylesheet" href="{{ asset('assets/fonts/inter/inter.css') }}">

  <style>
    /* ===== GLOBAL ===== */
    body { font-family: 'Inter', sans-serif; background-color: #f8f9fa; color: #212529; }

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

    <div class="mb-4">
      <h4 class="mb-1">Jadwal Ruangan</h4>
      <p class="text-muted mb-0">Informasi jadwal dan ketersediaan ruangan PS Rental.</p>
    </div>

    <div class="card border-0 shadow-sm">

      <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Jadwal Ruangan</h5>
        <span class="badge text-bg-primary" id="badgeDate">-</span>
      </div>

      <div class="card-body">

        <div class="table-responsive">
          <table class="table table-bordered align-middle">

            <thead>
              <tr>
                <th style="min-width: 170px;">Ruangan</th>
                <th class="text-center">09:00</th>
                <th class="text-center">10:00</th>
                <th class="text-center">11:00</th>
                <th class="text-center">12:00</th>
                <th class="text-center">13:00</th>
                <th class="text-center">14:00</th>
                <th class="text-center">15:00</th>
              </tr>
            </thead>

            <tbody>

              <!-- PS ROOM 1 -->
              <tr>
                <td>
                  <div class="room-name">PS Room 1</div>
                  <span class="badge text-bg-danger">Sedang Digunakan</span>
                </td>
                <td><div class="schedule-slot slot-used"></div></td>
                <td><div class="schedule-slot slot-used"></div></td>
                <td><div class="schedule-slot slot-used"></div></td>
                <td><div class="schedule-slot slot-used"></div></td>
                <td><div class="schedule-slot slot-empty"></div></td>
                <td><div class="schedule-slot slot-empty"></div></td>
                <td><div class="schedule-slot slot-empty"></div></td>
              </tr>

              <!-- PS ROOM 2 -->
              <tr>
                <td>
                  <div class="room-name">PS Room 2</div>
                  <span class="badge text-bg-warning">Booking</span>
                </td>
                <td><div class="schedule-slot slot-empty"></div></td>
                <td><div class="schedule-slot slot-booking"></div></td>
                <td><div class="schedule-slot slot-booking"></div></td>
                <td><div class="schedule-slot slot-booking"></div></td>
                <td><div class="schedule-slot slot-empty"></div></td>
                <td><div class="schedule-slot slot-empty"></div></td>
                <td><div class="schedule-slot slot-empty"></div></td>
              </tr>

              <!-- PS ROOM 3 -->
              <tr>
                <td>
                  <div class="room-name">PS Room 3</div>
                  <span class="badge text-bg-success">Kosong</span>
                </td>
                <td><div class="schedule-slot slot-empty"></div></td>
                <td><div class="schedule-slot slot-empty"></div></td>
                <td><div class="schedule-slot slot-empty"></div></td>
                <td><div class="schedule-slot slot-empty"></div></td>
                <td><div class="schedule-slot slot-empty"></div></td>
                <td><div class="schedule-slot slot-empty"></div></td>
                <td><div class="schedule-slot slot-empty"></div></td>
              </tr>

              <!-- VIP ROOM 1 -->
              <tr>
                <td>
                  <div class="room-name">VIP Room 1</div>
                  <span class="badge text-bg-warning">Booking</span>
                </td>
                <td><div class="schedule-slot slot-empty"></div></td>
                <td><div class="schedule-slot slot-booking"></div></td>
                <td><div class="schedule-slot slot-booking"></div></td>
                <td><div class="schedule-slot slot-booking"></div></td>
                <td><div class="schedule-slot slot-booking"></div></td>
                <td><div class="schedule-slot slot-empty"></div></td>
                <td><div class="schedule-slot slot-empty"></div></td>
              </tr>

              <!-- VIP ROOM 2 -->
              <tr>
                <td>
                  <div class="room-name">VIP Room 2</div>
                  <span class="badge text-bg-success">Kosong</span>
                </td>
                <td><div class="schedule-slot slot-empty"></div></td>
                <td><div class="schedule-slot slot-empty"></div></td>
                <td><div class="schedule-slot slot-empty"></div></td>
                <td><div class="schedule-slot slot-empty"></div></td>
                <td><div class="schedule-slot slot-empty"></div></td>
                <td><div class="schedule-slot slot-empty"></div></td>
                <td><div class="schedule-slot slot-empty"></div></td>
              </tr>

            </tbody>
          </table>
        </div>

        <!-- LEGEND -->
        <div class="mt-3 d-flex gap-4">
          <span class="text-muted"><span class="badge rounded-circle bg-success">&nbsp;</span> Kosong</span>
          <span class="text-muted"><span class="badge rounded-circle bg-warning">&nbsp;</span> Booking</span>
          <span class="text-muted"><span class="badge rounded-circle bg-danger">&nbsp;</span> Sedang Digunakan</span>
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
</script>

</body>
</html>