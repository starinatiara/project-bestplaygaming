<!DOCTYPE html>
<html lang="id">

<head>

  <title>Tracking | PS Rental</title>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- =====================================================
       FONT
  ====================================================== -->
  <link rel="stylesheet" href="{{ asset('assets/fonts/inter/inter.css') }}">

  <!-- =====================================================
       ICON
  ====================================================== -->
  <link rel="stylesheet" href="{{ asset('assets/fonts/tabler-icons.min.css') }}">

  <!-- =====================================================
       TEMPLATE CSS
  ====================================================== -->
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/style-preset.css') }}">


  <style>

    /* =====================================================
       GENERAL
    ====================================================== */

    body {
      background: #f8f9fa;
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
       LOGOUT UI
    ====================================================== */

    .logout-ui {

      pointer-events: none;

      cursor: default;
    }


    /* =====================================================
       DESKTOP
    ====================================================== */

    @media (min-width: 1200px) {

      .tracking-wrapper {

        max-width: 1000px;

      }

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



<body
  data-pc-preset="preset-1"
  data-pc-sidebar-caption="true"
  data-pc-layout="vertical"
  data-pc-direction="ltr"
  data-pc-theme_contrast=""
  data-pc-theme="light">


  <!-- =====================================================
       SIDEBAR
  ====================================================== -->

  <nav class="pc-sidebar">

    <div class="navbar-wrapper">


      <!-- =================================================
           LOGO
      ================================================== -->

      <div class="m-header">

        <a
          href="/dashboard"
          class="b-brand text-primary">

          <span class="fw-bold fs-4">
            PS Rental
          </span>

        </a>

      </div>



      <!-- =================================================
           SIDEBAR CONTENT
      ================================================== -->

      <div class="navbar-content">


        <!-- =================================================
             USER CARD
        ================================================== -->

        <div class="card pc-user-card">

          <div class="card-body">

            <div class="d-flex align-items-center">


              <!-- Avatar -->

              <div class="flex-shrink-0">

                <img
                  src="{{ asset('assets/images/user/avatar-1.jpg') }}"
                  class="user-avtar wid-45 rounded-circle"
                  alt="user">

              </div>


              <!-- User Name -->

              <div class="flex-grow-1 ms-3">

                <h6 class="mb-0">
                  kasir
                </h6>

                <small>
                  Kasir
                </small>

              </div>


            </div>

          </div>

        </div>



        <!-- =================================================
             MENU
        ================================================== -->

        <ul class="pc-navbar">


          <!-- Menu Caption -->

          <li class="pc-item pc-caption">

            <label>
              Menu
            </label>

          </li>



          <!-- =================================================
               DASHBOARD
          ================================================== -->

          <li class="pc-item">

            <a
              href="/dashboard"
              class="pc-link">

              <span class="pc-micon">

                <i class="ti ti-home"></i>

              </span>

              <span class="pc-mtext">

                Dashboard

              </span>

            </a>

          </li>



          <!-- =================================================
               BOOKING
          ================================================== -->

          <li class="pc-item">

            <a
              href="/booking"
              class="pc-link">

              <span class="pc-micon">

                <i class="ti ti-calendar-event"></i>

              </span>

              <span class="pc-mtext">

                Booking

              </span>

            </a>

          </li>



          <!-- =================================================
               RUANGAN
          ================================================== -->

          <li class="pc-item">

            <a
              href="/ruangan"
              class="pc-link">

              <span class="pc-micon">

                <i class="ti ti-device-gamepad"></i>

              </span>

              <span class="pc-mtext">

                Ruangan

              </span>

            </a>

          </li>



          <!-- =================================================
               TRACKING
          ================================================== -->

          <li class="pc-item active">

            <a
              href="/tracking"
              class="pc-link">

              <span class="pc-micon">

                <i class="ti ti-receipt"></i>

              </span>

              <span class="pc-mtext">

                Tracking

              </span>

            </a>

          </li>



          <!-- =================================================
               LAPORAN
          ================================================== -->

          <li class="pc-item">

            <a
              href="/laporan"
              class="pc-link">

              <span class="pc-micon">

                <i class="ti ti-report"></i>

              </span>

              <span class="pc-mtext">

                Laporan

              </span>

            </a>

          </li>


        </ul>



        <!-- =================================================
             USER CARD BAWAH
        ================================================== -->

        <div class="card mt-3">

          <div class="card-body text-center">


            <i class="ti ti-user f-24"></i>


            <h6 class="mt-2 mb-0">

              kasir

            </h6>


            <small class="text-muted">

              Kasir

            </small>


          </div>

        </div>



        <!-- =================================================
             LOGOUT
        ================================================== -->

        <div class="card mt-3">

          <div class="card-body">

            <div
              class="d-flex align-items-center text-danger logout-ui">

              <i class="ti ti-logout me-2"></i>

              <span>

                Logout

              </span>

            </div>

          </div>

        </div>


      </div>

    </div>

  </nav>



  <!-- =====================================================
       HEADER
  ====================================================== -->

  <header class="pc-header">

    <div class="header-wrapper">


      <!-- =================================================
           MOBILE / SIDEBAR BUTTON
      ================================================== -->

      <div class="me-auto pc-mob-drp">

        <ul class="list-unstyled">


          <!-- Sidebar Collapse -->

          <li class="pc-h-item pc-sidebar-collapse">

            <a
              href="#"
              class="pc-head-link ms-0"
              id="sidebar-hide">

              <i class="ti ti-menu-2"></i>

            </a>

          </li>


          <!-- Mobile Sidebar -->

          <li class="pc-h-item pc-sidebar-popup">

            <a
              href="#"
              class="pc-head-link ms-0"
              id="mobile-collapse">

              <i class="ti ti-menu-2"></i>

            </a>

          </li>


        </ul>

      </div>



      <!-- =================================================
           HEADER KANAN
      ================================================== -->

      <div class="ms-auto">

        <ul class="list-unstyled">


          <!-- Date -->

          <li class="pc-h-item">

            <span class="pc-head-link">

              <i class="ti ti-calendar"></i>

              8 Oktober 2026

            </span>

          </li>


          <!-- Time -->

          <li class="pc-h-item">

            <span class="pc-head-link">

              <i class="ti ti-clock"></i>

              19:34

            </span>

          </li>


        </ul>

      </div>


    </div>

  </header>



  <!-- =====================================================
       MAIN CONTENT
  ====================================================== -->

  <div class="pc-container">

    <div class="pc-content">


      <!-- =================================================
           PAGE TITLE
      ================================================== -->

      <div class="row mb-4">

        <div class="col-12">

          <h4 class="mb-1">

            Tracking Sewa

          </h4>


          <p class="text-muted mb-0">

            Pantau waktu sewa ruangan yang sedang digunakan.

          </p>

        </div>

      </div>



      <!-- =================================================
           TRACKING
      ================================================== -->

      <div class="tracking-wrapper">


        <div class="tracking-card">


          <!-- =================================================
               TRACKING HEADER
          ================================================== -->

          <div class="tracking-header">

            <div
              class="d-flex justify-content-between align-items-center">


              <!-- Room -->

              <div class="tracking-header-left">

                <i
                  class="ti ti-device-gamepad-2 tracking-room-icon">

                </i>


                <span class="tracking-room-title">

                  VIP Room 1

                </span>

              </div>



              <!-- Status -->

              <span class="status-badge">

                Sedang Digunakan

              </span>


            </div>

          </div>



          <!-- =================================================
               TRACKING BODY
          ================================================== -->

          <div class="tracking-body">


            <div class="tracking-main">


              <!-- =================================================
                   DETAIL CUSTOMER
              ================================================== -->

              <div class="tracking-detail">


                <!-- Customer -->

                <div class="detail-row">

                  <span class="detail-label">

                    Customer

                  </span>


                  <span class="detail-separator">

                    :

                  </span>


                  <span class="detail-value">

                    Budi

                  </span>

                </div>



                <!-- Mulai -->

                <div class="detail-row">

                  <span class="detail-label">

                    Mulai

                  </span>


                  <span class="detail-separator">

                    :

                  </span>


                  <span class="detail-value">

                    19:00

                  </span>

                </div>



                <!-- Selesai -->

                <div class="detail-row">

                  <span class="detail-label">

                    Selesai

                  </span>


                  <span class="detail-separator">

                    :

                  </span>


                  <span class="detail-value">

                    21:00

                  </span>

                </div>



                <!-- Durasi -->

                <div class="detail-row">

                  <span class="detail-label">

                    Durasi

                  </span>


                  <span class="detail-separator">

                    :

                  </span>


                  <span class="detail-value">

                    2 Jam

                  </span>

                </div>


              </div>



              <!-- =================================================
                   TIMER
              ================================================== -->

              <div class="timer-wrapper">


                <div class="timer-ring">


                  <div class="timer-content">


                    <!-- TIDAK BERJALAN -->

                    <div class="timer-value">

                      00:00:00

                    </div>


                    <div class="timer-label">

                      Sisa waktu

                    </div>


                  </div>


                </div>


              </div>


            </div>



            <!-- =================================================
                 DETAIL HARGA
            ================================================== -->

            <div class="price-section">


              <!-- Header -->

              <div class="price-header">

                Detail Harga

              </div>



              <!-- Sewa Ruangan -->

              <div class="price-row">

                <span>

                  Sewa Ruangan (2 Jam)

                </span>


                <span class="price-value">

                  Rp 30.000

                </span>

              </div>



              <!-- Makanan -->

              <div class="price-row">

                <span>

                  Makanan/Minuman

                </span>


                <span class="price-value">

                  Rp 0

                </span>

              </div>



              <!-- Total -->

              <div class="total-section">

                <span>

                  Total

                </span>


                <span class="total-price">

                  Rp 30.000

                </span>

              </div>


            </div>


          </div>



          <!-- =================================================
               ACTION BUTTON
          ================================================== -->

          <div class="tracking-actions">


            <!-- Perpanjang Waktu -->

            <button
              type="button"
              class="btn btn-extend">

              <i class="ti ti-clock-plus me-1"></i>

              Perpanjang Waktu

            </button>



            <!-- Selesaikan Sewa -->

            <button
              type="button"
              class="btn btn-finish">

              <i class="ti ti-circle-check me-1"></i>

              Selesaikan Sewa

            </button>


          </div>


        </div>

      </div>


    </div>

  </div>


  <!-- =====================================================
       JAVASCRIPT TEMPLATE
       
       Tidak ada JavaScript timer.
       Tidak ada fungsi tombol.
       Halaman hanya UI/prototype.
  ====================================================== -->

  <script src="{{ asset('assets/js/plugins/popper.min.js') }}"></script>

  <script src="{{ asset('assets/js/plugins/simplebar.min.js') }}"></script>

  <script src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script>

  <script src="{{ asset('assets/js/script.js') }}"></script>

  <script src="{{ asset('assets/js/theme.js') }}"></script>

  <script src="{{ asset('assets/js/plugins/feather.min.js') }}"></script>


</body>

</html>