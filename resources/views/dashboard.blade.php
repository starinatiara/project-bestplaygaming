<!DOCTYPE html>
<html lang="id">

<head>

  <meta charset="UTF-8">

  <meta name="viewport"
        content="width=device-width, initial-scale=1.0">

  <title>Dashboard | PS Rental</title>


  <!-- =====================================================
       BOOTSTRAP 5
  ====================================================== -->

  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
    rel="stylesheet">


  <!-- =====================================================
       TABLER ICON
  ====================================================== -->

  <link
    rel="stylesheet"
    href="{{ asset('assets/fonts/tabler-icons.min.css') }}">


  <!-- =====================================================
       FONT
  ====================================================== -->

  <link
    rel="stylesheet"
    href="{{ asset('assets/fonts/inter/inter.css') }}">


  <style>

    /* =====================================================
       GLOBAL
    ====================================================== */

    body {
      font-family: 'Inter', sans-serif;
      background-color: #f8f9fa;
      color: #212529;
    }


    /* =====================================================
       SIDEBAR
    ====================================================== */

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

    }


    .brand {

      font-size: 25px;

      font-weight: 700;

      color: #3b82f6;

      text-decoration: none;

      display: block;

      padding: 0 10px 25px;

    }


    /* =====================================================
       USER CARD
    ====================================================== */

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


    /* =====================================================
       SIDEBAR MENU
    ====================================================== */

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


    /* =====================================================
       SIDEBAR BOTTOM
    ====================================================== */

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

      border: none;

      background: #ffffff;

      border: 1px solid #e5e7eb;

      color: #dc3545;

      padding: 14px;

      border-radius: 12px;

      text-align: left;

      font-weight: 400;

    }


    /* =====================================================
       MAIN
    ====================================================== */

    .main-content {

      margin-left: 280px;

      min-height: 100vh;

    }


    /* =====================================================
       HEADER
    ====================================================== */

    .top-header {

      height: 80px;

      background: #ffffff;

      border-bottom: 1px solid #dee2e6;

      display: flex;

      align-items: center;

      justify-content: space-between;

      padding: 0 35px;

    }


    .header-title {

      font-size: 20px;

      font-weight: 600;

      margin: 0;

    }


    .header-date {

      color: #6c757d;

      font-size: 14px;

    }


    /* =====================================================
       CONTENT
    ====================================================== */

    .content {

      padding: 35px;

    }


    .welcome-title {

      font-size: 25px;

      font-weight: 600;

    }


    .welcome-text {

      color: #6c757d;

    }


    /* =====================================================
       STATISTIC CARD
    ====================================================== */

    .stat-card {

      background: #ffffff;

      border: 1px solid #e5e7eb;

      border-radius: 15px;

      padding: 22px;

      height: 100%;

    }


    .stat-label {

      color: #6c757d;

      font-size: 14px;

      margin-bottom: 8px;

    }


    .stat-number {

      font-size: 28px;

      font-weight: 700;

      margin: 0;

    }


    .stat-icon {

      width: 48px;

      height: 48px;

      border-radius: 12px;

      display: flex;

      align-items: center;

      justify-content: center;

      font-size: 23px;

    }


    .icon-blue {

      background: #e8f0ff;

      color: #3b82f6;

    }


    .icon-red {

      background: #fde8e8;

      color: #dc3545;

    }


    .icon-yellow {

      background: #fff4d6;

      color: #d99a00;

    }


    .icon-green {

      background: #e5f7ed;

      color: #198754;

    }


    /* =====================================================
       ROOM CARD
    ====================================================== */

    .room-card {

      border: 1px solid #e5e7eb;

      border-radius: 13px;

      background: #ffffff;

      height: 100%;

      transition: 0.2s;

    }


    .room-card:hover {

      transform: translateY(-2px);

      box-shadow: 0 5px 15px rgba(0,0,0,0.05);

    }


    .room-card-body {

      padding: 20px;

    }


    .room-title {

      font-weight: 600;

      margin: 0;

    }


    .room-icon {

      font-size: 22px;

      margin-right: 7px;

    }


    .room-info {

      color: #6c757d;

      font-size: 13px;

      margin-bottom: 7px;

    }


    .timer-box {

      background: #fff1f1;

      color: #dc3545;

      padding: 10px;

      border-radius: 8px;

      text-align: center;

      margin-top: 15px;

      font-weight: 600;

    }


    /* =====================================================
       BOOKING
    ====================================================== */

    .booking-item {

      display: flex;

      justify-content: space-between;

      align-items: center;

      padding: 15px 0;

      border-bottom: 1px solid #eeeeee;

    }


    .booking-item:last-child {

      border-bottom: none;

    }


    .booking-time {

      font-weight: 600;

      font-size: 15px;

    }


    .booking-customer {

      color: #6c757d;

      font-size: 13px;

    }


    /* =====================================================
       FOOTER
    ====================================================== */

    footer {

      padding: 25px 35px;

      color: #6c757d;

      font-size: 14px;

    }


    /* =====================================================
       RESPONSIVE
    ====================================================== */

    @media (max-width: 991px) {

      .sidebar {

        position: relative;

        width: 100%;

        min-height: auto;

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
       DITAMBAHKAN: HAMBURGER + SIDEBAR TOGGLE
    ====================================================== */

    .sidebar {

      overflow-y: auto;

      transition: transform 0.25s ease;

    }


    .main-content {

      transition: margin-left 0.25s ease;

    }


    .menu-toggle {

      border: none;

      background: transparent;

      font-size: 26px;

      line-height: 1;

      padding: 6px 8px;

      border-radius: 8px;

      color: #495057;

      cursor: pointer;

    }


    .menu-toggle:hover {

      background: #f1f5f9;

      color: #3b82f6;

    }


    /* Desktop: sidebar disembunyikan */

    body.sidebar-hidden .sidebar {

      transform: translateX(-100%);

    }


    body.sidebar-hidden .main-content {

      margin-left: 0;

    }


    /* Mobile / tablet: sidebar menjadi drawer */

    @media (max-width: 991px) {

      .sidebar {

        position: fixed;

        width: 280px;

        min-height: 100vh;

        transform: translateX(-100%);

      }


      .sidebar.show {

        transform: translateX(0);

        box-shadow: 0 0 30px rgba(0, 0, 0, 0.15);

      }

    }


    /* =====================================================
       DITAMBAHKAN: POPUP KONFIRMASI LOGOUT
    ====================================================== */

    #logoutModal .modal-content {

      border: 0;

      border-radius: 22px;

      padding: 12px 8px 8px;

      text-align: center;

      box-shadow: 0 25px 60px rgba(15, 23, 42, 0.25);

    }


    #logoutModal.modal.fade .modal-dialog {

      transform: scale(0.85) translateY(20px);

      transition: transform 0.25s ease, opacity 0.25s ease;

    }


    #logoutModal.modal.show .modal-dialog {

      transform: scale(1) translateY(0);

    }


    .logout-modal-icon {

      width: 76px;

      height: 76px;

      margin: 14px auto 18px;

      border-radius: 50%;

      background: #fde8e8;

      color: #dc3545;

      display: flex;

      align-items: center;

      justify-content: center;

      font-size: 36px;

      box-shadow: 0 0 0 10px #fff4f4;

    }


    .logout-modal-title {

      font-size: 21px;

      font-weight: 700;

      margin-bottom: 8px;

    }


    .logout-modal-text {

      color: #6c757d;

      font-size: 14px;

      margin-bottom: 0;

    }


    .logout-modal-actions {

      display: flex;

      gap: 12px;

      padding: 22px 16px 14px;

    }


    .logout-modal-actions .btn {

      flex: 1;

      padding: 12px;

      border-radius: 12px;

      font-weight: 600;

    }


    .btn-logout-cancel {

      background: #f1f5f9;

      border: 1px solid #e5e7eb;

      color: #475569;

    }


    .btn-logout-cancel:hover {

      background: #e2e8f0;

      color: #1e293b;

    }


    .btn-logout-confirm {

      background: #dc3545;

      border: 1px solid #dc3545;

      color: #ffffff;

    }


    .btn-logout-confirm:hover {

      background: #bb2d3b;

      border-color: #bb2d3b;

      color: #ffffff;

    }


  </style>

</head>


<body>


<!-- =====================================================
     SIDEBAR
====================================================== -->

<!-- DITAMBAHKAN: id="sidebar" -->
<aside class="sidebar" id="sidebar">


  <!-- LOGO -->

  <a href="/dashboard"
     class="brand">

    PS Rental

  </a>


  <!-- USER CARD + LOGOUT (satu baris) -->
  <div style="display: flex; gap: 10px; align-items: stretch; margin-bottom: 25px;">


  <div class="user-card" onclick="window.location.href='/profil'" style="cursor:pointer; margin-bottom:0; flex:1; min-width:0;" title="Profil Saya">

    <div class="d-flex align-items-center">

      <img
        src="{{ asset('assets/images/user/avatar-1.jpg') }}"
        class="user-avatar"
        alt="User">


      <div class="ms-3">

        <div
          class="user-name"
          id="sidebarUsername">

          User

        </div>


        <div
          class="user-role"
          id="sidebarRole">

          Role

        </div>

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

  <div class="menu-title">

    Menu

  </div>


  <ul class="sidebar-menu">


    <!-- DASHBOARD -->

    <li>

      <a
        href="/dashboard"
        class="active">

        <i class="ti ti-home"></i>

        <span>
          Dashboard
        </span>

      </a>

    </li>


    <!-- =================================================
         SUPERADMIN
    ================================================== -->


    <li class="menu-superadmin">

      <a href="/ruanganAdmin">

        <i class="ti ti-device-gamepad"></i>

        <span>
          Ruangan
        </span>

      </a>

    </li>


    <li class="menu-superadmin">

      <a href="/user">

        <i class="ti ti-users"></i>

        <span>
          Data User
        </span>

      </a>

    </li>


    <!-- =================================================
         KASIR
    ================================================== -->


    <li class="menu-kasir">

      <a href="/booking">

        <i class="ti ti-calendar-event"></i>

        <span>
          Booking
        </span>

      </a>

    </li>


    <li class="menu-kasir">

      <a href="/ruangan">

        <i class="ti ti-device-gamepad"></i>

        <span>
          Ruangan
        </span>

      </a>

    </li>


    <li class="menu-kasir">

      <a href="/tracking">

        <i class="ti ti-receipt"></i>

        <span>
          Tracking
        </span>

      </a>

    </li>


    <!-- =================================================
         LAPORAN
         AKSES SEMUA ROLE
    ================================================== -->

    <li>

      <a href="/laporan">

        <i class="ti ti-report"></i>

        <span>
          Laporan
        </span>

      </a>

    </li>


  </ul>


</aside>



<!-- =====================================================
     MAIN CONTENT
====================================================== -->

<main class="main-content">


  <!-- ===================================================
       HEADER
  ==================================================== -->

  <header class="top-header">


    <!-- DITAMBAHKAN: tombol hamburger di sebelah judul -->
    <div class="d-flex align-items-center gap-2">

      <button
        type="button"
        class="menu-toggle"
        id="menuToggle"
        aria-label="Toggle sidebar">

        <i class="ti ti-menu-2"></i>

      </button>

    </div>


    <div class="header-date">

      <i class="ti ti-calendar me-1"></i>

      <span id="currentDate">
        -
      </span>

      <span class="mx-2">
        |
      </span>

      <i class="ti ti-clock me-1"></i>

      <span id="currentTime">
        -
      </span>

    </div>


  </header>



  <!-- ===================================================
       CONTENT
  ==================================================== -->

  <div class="content">


    <!-- WELCOME -->

    <div class="mb-4">

      <h4
        class="welcome-title"
        id="welcomeTitle">

        Selamat Datang!

      </h4>


      <p class="welcome-text mb-0">

        Berikut adalah kondisi ruangan PS Rental hari ini.

      </p>

    </div>



    <!-- =================================================
         STATISTIK
    ================================================== -->

    <div class="row g-3 mb-4">


      <!-- TOTAL -->

      <div class="col-md-6 col-xl-3">

        <div class="stat-card">

          <div
            class="d-flex justify-content-between align-items-center">

            <div>

              <div class="stat-label">
                Total Ruangan
              </div>

              <h3 class="stat-number">
                5
              </h3>

            </div>


            <div class="stat-icon icon-blue">

              <i class="ti ti-device-gamepad"></i>

            </div>

          </div>

        </div>

      </div>



      <!-- DIGUNAKAN -->

      <div class="col-md-6 col-xl-3">

        <div class="stat-card">

          <div
            class="d-flex justify-content-between align-items-center">

            <div>

              <div class="stat-label">
                Sedang Digunakan
              </div>

              <h3 class="stat-number text-danger">
                2
              </h3>

            </div>


            <div class="stat-icon icon-red">

              <i class="ti ti-player-play"></i>

            </div>

          </div>

        </div>

      </div>



      <!-- BOOKING -->

      <div class="col-md-6 col-xl-3">

        <div class="stat-card">

          <div
            class="d-flex justify-content-between align-items-center">

            <div>

              <div class="stat-label">
                Booking
              </div>

              <h3 class="stat-number text-warning">
                1
              </h3>

            </div>


            <div class="stat-icon icon-yellow">

              <i class="ti ti-calendar-event"></i>

            </div>

          </div>

        </div>

      </div>



      <!-- KOSONG -->

      <div class="col-md-6 col-xl-3">

        <div class="stat-card">

          <div
            class="d-flex justify-content-between align-items-center">

            <div>

              <div class="stat-label">
                Kosong
              </div>

              <h3 class="stat-number text-success">
                2
              </h3>

            </div>


            <div class="stat-icon icon-green">

              <i class="ti ti-circle-check"></i>

            </div>

          </div>

        </div>

      </div>


    </div>



    <!-- =================================================
         STATUS RUANGAN + BOOKING
    ================================================== -->

    <div class="row g-4">


      <!-- =================================================
           STATUS RUANGAN
      ================================================== -->

      <div class="col-xl-9">


        <div class="card border-0 shadow-sm">

          <div class="card-header bg-white py-3">

            <h5 class="mb-0">

              Status Ruangan

            </h5>

          </div>


          <div class="card-body">


            <div class="row g-3">


              <!-- PS ROOM 1 -->

              <div class="col-md-6 col-xl-4">

                <div class="room-card">

                  <div class="room-card-body">


                    <div
                      class="d-flex justify-content-between align-items-start">


                      <h6 class="room-title">

                        <i
                          class="ti ti-device-gamepad-2 room-icon">
                        </i>

                        PS Room 1

                      </h6>


                      <span
                        class="badge text-bg-danger">

                        Digunakan

                      </span>


                    </div>


                    <div class="room-info mt-3">

                      Customer : Andi

                    </div>


                    <div class="room-info">

                      Mulai : 09:00

                    </div>


                    <div class="room-info">

                      Selesai : 11:00

                    </div>


                    <div class="timer-box">

                      <i class="ti ti-clock me-1"></i>

                      00:36:12

                    </div>


                  </div>

                </div>

              </div>



              <!-- PS ROOM 2 -->

              <div class="col-md-6 col-xl-4">

                <div class="room-card">

                  <div class="room-card-body">


                    <div
                      class="d-flex justify-content-between align-items-start">


                      <h6 class="room-title">

                        <i
                          class="ti ti-device-gamepad-2 room-icon">
                        </i>

                        PS Room 2

                      </h6>


                      <span
                        class="badge text-bg-success">

                        Kosong

                      </span>


                    </div>


                    <div class="room-info mt-3">

                      Jadwal berikutnya : 13:00

                    </div>


                    <div
                      class="text-center text-muted py-3">

                      <i
                        class="ti ti-device-gamepad-2 fs-2">
                      </i>

                    </div>


                  </div>

                </div>

              </div>



              <!-- PS ROOM 3 -->

              <div class="col-md-6 col-xl-4">

                <div class="room-card">

                  <div class="room-card-body">


                    <div
                      class="d-flex justify-content-between align-items-start">


                      <h6 class="room-title">

                        <i
                          class="ti ti-device-gamepad-2 room-icon">
                        </i>

                        PS Room 3

                      </h6>


                      <span
                        class="badge text-bg-success">

                        Kosong

                      </span>


                    </div>


                    <div class="room-info mt-3">

                      Jadwal berikutnya : -

                    </div>


                    <div
                      class="text-center text-muted py-3">

                      <i
                        class="ti ti-device-gamepad-2 fs-2">
                      </i>

                    </div>


                  </div>

                </div>

              </div>



              <!-- VIP ROOM 1 -->

              <div class="col-md-6 col-xl-4">

                <div class="room-card">

                  <div class="room-card-body">


                    <div
                      class="d-flex justify-content-between align-items-start">


                      <h6 class="room-title">

                        <i
                          class="ti ti-device-gamepad-2 room-icon">
                        </i>

                        VIP Room 1

                      </h6>


                      <span
                        class="badge text-bg-warning">

                        Booking

                      </span>


                    </div>


                    <div class="room-info mt-3">

                      Customer : Budi

                    </div>


                    <div class="room-info">

                      Jam : 19:00 - 22:00

                    </div>


                    <div
                      class="text-center text-warning py-3">

                      <i
                        class="ti ti-calendar-event fs-2">
                      </i>

                    </div>


                  </div>

                </div>

              </div>



              <!-- VIP ROOM 2 -->

              <div class="col-md-6 col-xl-4">

                <div class="room-card">

                  <div class="room-card-body">


                    <div
                      class="d-flex justify-content-between align-items-start">


                      <h6 class="room-title">

                        <i
                          class="ti ti-device-gamepad-2 room-icon">
                        </i>

                        VIP Room 2

                      </h6>


                      <span
                        class="badge text-bg-success">

                        Kosong

                      </span>


                    </div>


                    <div class="room-info mt-3">

                      Jadwal berikutnya : -

                    </div>


                    <div
                      class="text-center text-muted py-3">

                      <i
                        class="ti ti-device-gamepad-2 fs-2">
                      </i>

                    </div>


                  </div>

                </div>

              </div>


            </div>

          </div>

        </div>

      </div>



      <!-- =================================================
           BOOKING HARI INI
      ================================================== -->

      <div class="col-xl-3">


        <div class="card border-0 shadow-sm">

          <div class="card-header bg-white py-3">

            <h5 class="mb-0">

              Booking Hari Ini

            </h5>

          </div>


          <div class="card-body">


            <!-- BOOKING 1 -->

            <div class="booking-item">


              <div>

                <div class="booking-time">

                  11:00

                </div>


                <div class="booking-customer">

                  Rudi

                </div>

              </div>


              <span
                class="badge text-bg-primary">

                PS Room 3

              </span>


            </div>



            <!-- BOOKING 2 -->

            <div class="booking-item">


              <div>

                <div class="booking-time">

                  19:00

                </div>


                <div class="booking-customer">

                  Budi

                </div>

              </div>


              <span
                class="badge text-bg-warning">

                VIP Room 1

              </span>


            </div>


          </div>

        </div>


      </div>


    </div>


  </div>

</main>



<!-- =====================================================
     DITAMBAHKAN: POPUP KONFIRMASI LOGOUT (TENGAH HALAMAN)
====================================================== -->

<div
  class="modal fade"
  id="logoutModal"
  tabindex="-1"
  aria-labelledby="logoutModalTitle"
  aria-hidden="true">

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

        <button
          type="button"
          class="btn btn-logout-cancel"
          data-bs-dismiss="modal">

          Tidak

        </button>

        <button
          type="button"
          class="btn btn-logout-confirm"
          id="confirmLogoutBtn">

          Ya

        </button>

      </div>

    </div>

  </div>

</div>



<!-- =====================================================
     BOOTSTRAP JAVASCRIPT
====================================================== -->

<script
  src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
</script>



<!-- =====================================================
     PS RENTAL JAVASCRIPT
====================================================== -->

<script>


  /* =====================================================
     CEK LOGIN
  ====================================================== */

  const role =
    localStorage.getItem("role");

  const username =
    localStorage.getItem("username");


  /*
   * Jika belum login,
   * kembali ke halaman login.
   */

  if (!role || !username) {

    window.location.href =
      "/logout";

  }


  /* =====================================================
     ELEMENT
  ====================================================== */

  const sidebarUsername =
    document.getElementById(
      "sidebarUsername"
    );


  const sidebarRole =
    document.getElementById(
      "sidebarRole"
    );


  const welcomeTitle =
    document.getElementById(
      "welcomeTitle"
    );


  /* =====================================================
     ROLE
  ====================================================== */

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

    window.location.href =
      "/logout";

  }


  /* =====================================================
     USERNAME
  ====================================================== */

  sidebarUsername.textContent =
    username;


  sidebarRole.textContent =
    roleName;


  /* =====================================================
     WELCOME
  ====================================================== */

  welcomeTitle.textContent =
    "Selamat Datang, " +
    roleName +
    "!";


  /* =====================================================
     ROLE MENU
  ====================================================== */

  const menuKasir =
    document.querySelectorAll(
      ".menu-kasir"
    );


  const menuSuperadmin =
    document.querySelectorAll(
      ".menu-superadmin"
    );


  if (role === "kasir") {


    menuKasir.forEach(function(menu) {

      menu.style.display = "";

    });


    menuSuperadmin.forEach(function(menu) {

      menu.style.display = "none";

    });


  }


  else if (role === "superadmin") {


    menuSuperadmin.forEach(function(menu) {

      menu.style.display = "";

    });


    menuKasir.forEach(function(menu) {

      menu.style.display = "none";

    });


  }


  /* =====================================================
     TANGGAL
  ====================================================== */

  function updateDateTime() {


    const now =
      new Date();


    const dateText =
      now.toLocaleDateString(
        "id-ID",
        {
          weekday: "long",
          year: "numeric",
          month: "long",
          day: "numeric"
        }
      );


    document.getElementById(
      "currentDate"
    ).textContent =
      dateText;


    const timeText =
      now.toLocaleTimeString(
        "id-ID",
        {
          hour: "2-digit",
          minute: "2-digit",
          second: "2-digit"
        }
      );


    document.getElementById(
      "currentTime"
    ).textContent =
      timeText;

  }


  updateDateTime();


  setInterval(
    updateDateTime,
    1000
  );


  /* =====================================================
     LOGOUT
  ====================================================== */

  /*
   * DIUBAH: confirm() bawaan browser diganti popup di tengah halaman.
   * Isi proses logout (hapus role & username, lalu ke /logout) TIDAK berubah,
   * hanya dipindah ke tombol "Ya, Logout" pada popup.
   */

  function logout() {


    const logoutModalElement =
      document.getElementById(
        "logoutModal"
      );


    const logoutModal =
      bootstrap.Modal.getOrCreateInstance(
        logoutModalElement
      );


    logoutModal.show();

  }


  document.getElementById(
    "confirmLogoutBtn"
  ).addEventListener(
    "click",
    function () {


      localStorage.removeItem(
        "role"
      );


      localStorage.removeItem(
        "username"
      );


      window.location.href =
        "/logout";

    }
  );


  /* =====================================================
     DITAMBAHKAN: TOGGLE SIDEBAR (HAMBURGER)
  ====================================================== */

  const sidebar =
    document.getElementById(
      "sidebar"
    );


  const menuToggle =
    document.getElementById(
      "menuToggle"
    );


  if (menuToggle) {

    menuToggle.addEventListener(
      "click",
      function () {

        if (window.innerWidth >= 992) {

          // Desktop: sembunyikan / tampilkan sidebar
          document.body.classList.toggle(
            "sidebar-hidden"
          );

        }

        else {

          // Mobile: buka / tutup sidebar
          sidebar.classList.toggle(
            "show"
          );

        }

      }
    );

  }


</script>


</body>

</html>