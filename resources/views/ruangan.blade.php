<!DOCTYPE html>
<html lang="id">

<head>
  <title>Jadwal Ruangan | PS Rental</title>

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
    .schedule-slot {
      height: 28px;
      border-radius: 5px;
      width: 100%;
    }

    .slot-empty {
      background: #dff4e7;
    }

    .slot-booking {
      background: #ffedc2;
    }

    .slot-used {
      background: #f6d5d9;
    }

    .room-name {
      font-weight: 600;
      margin-bottom: 6px;
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

  <!-- ================= SIDEBAR ================= -->

  <nav class="pc-sidebar">

    <div class="navbar-wrapper">

      <!-- Logo -->
      <div class="m-header">

        <a href="/dashboard" class="b-brand text-primary">

          <span class="fw-bold fs-4">
            PS Rental
          </span>

        </a>

      </div>


      <!-- User -->
      <div class="navbar-content">

        <div class="card pc-user-card">

          <div class="card-body">

            <div class="d-flex align-items-center">

              <div class="flex-shrink-0">

                <img
                  src="{{ asset('assets/images/user/avatar-1.jpg') }}"
                  class="user-avtar wid-45 rounded-circle"
                  alt="user">

              </div>

              <div class="flex-grow-1 ms-3">

                <h6 class="mb-0">
                  Kasir
                </h6>

                <small>
                  Administrator
                </small>

              </div>

            </div>

          </div>

        </div>


        <!-- MENU -->
        <ul class="pc-navbar">

          <li class="pc-item pc-caption">
            <label>Menu</label>
          </li>


          <!-- Dashboard -->
          <li class="pc-item">

            <a href="/dashboard" class="pc-link">

              <span class="pc-micon">
                <i class="ti ti-home"></i>
              </span>

              <span class="pc-mtext">
                Dashboard
              </span>

            </a>

          </li>


          <!-- Booking -->
          <li class="pc-item">

            <a href="/booking" class="pc-link">

              <span class="pc-micon">
                <i class="ti ti-calendar-event"></i>
              </span>

              <span class="pc-mtext">
                Booking
              </span>

            </a>

          </li>


          <!-- Ruangan -->
          <li class="pc-item active">

            <a href="/ruangan" class="pc-link">

              <span class="pc-micon">
                <i class="ti ti-device-gamepad-2"></i>
              </span>

              <span class="pc-mtext">
                Ruangan
              </span>

            </a>

          </li>


          <!-- Tracking -->
          <li class="pc-item">

            <a href="/tracking" class="pc-link">

              <span class="pc-micon">
                <i class="ti ti-receipt"></i>
              </span>

              <span class="pc-mtext">
                Tracking
              </span>

            </a>

          </li>


          <!-- Laporan -->
          <li class="pc-item">

            <a href="/laporan" class="pc-link">

              <span class="pc-micon">
                <i class="ti ti-report"></i>
              </span>

              <span class="pc-mtext">
                Laporan
              </span>

            </a>

          </li>

        </ul>


        <!-- User bawah -->
        <div class="card mt-3">

          <div class="card-body text-center">

            <i class="ti ti-user f-24"></i>

            <h6 class="mt-2 mb-0">
              Kasir
            </h6>

            <small class="text-muted">
              Sistem PS Rental
            </small>

          </div>

        </div>

      </div>

    </div>

  </nav>


  <!-- ================= HEADER ================= -->

  <header class="pc-header">

    <div class="header-wrapper">

      <!-- Mobile menu -->
      <div class="me-auto pc-mob-drp">

        <ul class="list-unstyled">

          <li class="pc-h-item pc-sidebar-collapse">

            <a
              href="#"
              class="pc-head-link ms-0"
              id="sidebar-hide">

              <i class="ti ti-menu-2"></i>

            </a>

          </li>


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


      <!-- Header -->
      <div class="ms-auto">

        <ul class="list-unstyled">

          <li class="pc-h-item">

            <span class="pc-head-link">

              <i class="ti ti-calendar"></i>

              23 September 2026

            </span>

          </li>


          <li class="pc-h-item">

            <span class="pc-head-link">

              <i class="ti ti-clock"></i>

              10:24

            </span>

          </li>

        </ul>

      </div>

    </div>

  </header>


  <!-- ================= MAIN ================= -->

  <div class="pc-container">

    <div class="pc-content">


      <!-- Judul -->
      <div class="row mb-3">

        <div class="col-12">

          <h4 class="mb-1">
            Jadwal Ruangan
          </h4>

          <p class="text-muted">
            Informasi jadwal dan ketersediaan ruangan PS Rental.
          </p>

        </div>

      </div>


      <!-- ================= JADWAL RUANGAN ================= -->

      <div class="card">

        <div class="card-header d-flex justify-content-between align-items-center">

          <h5 class="mb-0">
            Jadwal Ruangan
          </h5>

          <span class="badge bg-light-primary text-primary">
            23 September 2026
          </span>

        </div>


        <div class="card-body">

          <div class="table-responsive">

            <table class="table table-bordered align-middle">

              <thead>

                <tr>

                  <th style="min-width: 170px;">
                    Ruangan
                  </th>

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

                    <div class="room-name">
                      PS Room 1
                    </div>

                    <span class="badge bg-light-danger text-danger">
                      Sedang Digunakan
                    </span>

                  </td>

                  <td>
                    <div class="schedule-slot slot-used"></div>
                  </td>

                  <td>
                    <div class="schedule-slot slot-used"></div>
                  </td>

                  <td>
                    <div class="schedule-slot slot-used"></div>
                  </td>

                  <td>
                    <div class="schedule-slot slot-used"></div>
                  </td>

                  <td>
                    <div class="schedule-slot slot-empty"></div>
                  </td>

                  <td>
                    <div class="schedule-slot slot-empty"></div>
                  </td>

                  <td>
                    <div class="schedule-slot slot-empty"></div>
                  </td>

                </tr>


                <!-- PS ROOM 2 -->

                <tr>

                  <td>

                    <div class="room-name">
                      PS Room 2
                    </div>

                    <span class="badge bg-light-warning text-warning">
                      Booking
                    </span>

                  </td>

                  <td>
                    <div class="schedule-slot slot-empty"></div>
                  </td>

                  <td>
                    <div class="schedule-slot slot-booking"></div>
                  </td>

                  <td>
                    <div class="schedule-slot slot-booking"></div>
                  </td>

                  <td>
                    <div class="schedule-slot slot-booking"></div>
                  </td>

                  <td>
                    <div class="schedule-slot slot-empty"></div>
                  </td>

                  <td>
                    <div class="schedule-slot slot-empty"></div>
                  </td>

                  <td>
                    <div class="schedule-slot slot-empty"></div>
                  </td>

                </tr>


                <!-- PS ROOM 3 -->

                <tr>

                  <td>

                    <div class="room-name">
                      PS Room 3
                    </div>

                    <span class="badge bg-light-success text-success">
                      Kosong
                    </span>

                  </td>

                  <td>
                    <div class="schedule-slot slot-empty"></div>
                  </td>

                  <td>
                    <div class="schedule-slot slot-empty"></div>
                  </td>

                  <td>
                    <div class="schedule-slot slot-empty"></div>
                  </td>

                  <td>
                    <div class="schedule-slot slot-empty"></div>
                  </td>

                  <td>
                    <div class="schedule-slot slot-empty"></div>
                  </td>

                  <td>
                    <div class="schedule-slot slot-empty"></div>
                  </td>

                  <td>
                    <div class="schedule-slot slot-empty"></div>
                  </td>

                </tr>


                <!-- VIP ROOM 1 -->

                <tr>

                  <td>

                    <div class="room-name">
                      VIP Room 1
                    </div>

                    <span class="badge bg-light-warning text-warning">
                      Booking
                    </span>

                  </td>

                  <td>
                    <div class="schedule-slot slot-empty"></div>
                  </td>

                  <td>
                    <div class="schedule-slot slot-booking"></div>
                  </td>

                  <td>
                    <div class="schedule-slot slot-booking"></div>
                  </td>

                  <td>
                    <div class="schedule-slot slot-booking"></div>
                  </td>

                  <td>
                    <div class="schedule-slot slot-booking"></div>
                  </td>

                  <td>
                    <div class="schedule-slot slot-empty"></div>
                  </td>

                  <td>
                    <div class="schedule-slot slot-empty"></div>
                  </td>

                </tr>


                <!-- VIP ROOM 2 -->

                <tr>

                  <td>

                    <div class="room-name">
                      VIP Room 2
                    </div>

                    <span class="badge bg-light-success text-success">
                      Kosong
                    </span>

                  </td>

                  <td>
                    <div class="schedule-slot slot-empty"></div>
                  </td>

                  <td>
                    <div class="schedule-slot slot-empty"></div>
                  </td>

                  <td>
                    <div class="schedule-slot slot-empty"></div>
                  </td>

                  <td>
                    <div class="schedule-slot slot-empty"></div>
                  </td>

                  <td>
                    <div class="schedule-slot slot-empty"></div>
                  </td>

                  <td>
                    <div class="schedule-slot slot-empty"></div>
                  </td>

                  <td>
                    <div class="schedule-slot slot-empty"></div>
                  </td>

                </tr>

              </tbody>

            </table>

          </div>


          <!-- LEGEND -->

          <div class="mt-3 d-flex gap-4">

            <span class="text-muted">
              <span class="badge rounded-circle bg-success">&nbsp;</span>
              Kosong
            </span>

            <span class="text-muted">
              <span class="badge rounded-circle bg-warning">&nbsp;</span>
              Booking
            </span>

            <span class="text-muted">
              <span class="badge rounded-circle bg-danger">&nbsp;</span>
              Sedang Digunakan
            </span>

          </div>

        </div>

      </div>

    </div>

  </div>


  <!-- ================= FOOTER ================= -->

  <footer class="pc-footer">

    <div class="footer-wrapper container-fluid">

      <div class="row">

        <div class="col-sm my-1">

          <p class="m-0">
            PS Rental © 2026
          </p>

        </div>

        <div class="col-auto my-1">

          <p class="m-0 text-muted">
            Sistem Informasi Rental PS
          </p>

        </div>

      </div>

    </div>

  </footer>


  <!-- ================= JAVASCRIPT ================= -->

  <script src="{{ asset('assets/js/plugins/popper.min.js') }}"></script>
  <script src="{{ asset('assets/js/plugins/simplebar.min.js') }}"></script>
  <script src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script>
  <script src="{{ asset('assets/js/script.js') }}"></script>
  <script src="{{ asset('assets/js/theme.js') }}"></script>
  <script src="{{ asset('assets/js/plugins/feather.min.js') }}"></script>

</body>

</html>