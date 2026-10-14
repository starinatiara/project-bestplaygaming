<!DOCTYPE html>
<html lang="id">

<head>
  <title>Laporan Transaksi | PS Rental</title>

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
    .report-stat-card {
      transition: transform 0.2s, box-shadow 0.2s;
    }

    .report-stat-card:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(0,0,0,0.06);
    }

    .stat-icon-wrapper {
      width: 48px;
      height: 48px;
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 24px;
    }

    .receipt-box {
      font-family: 'Courier New', Courier, monospace;
      background: #fafafa;
      border: 1px dashed #cbd5e1;
      padding: 20px;
      border-radius: 8px;
      color: #1e293b;
    }

    @media print {
      body * {
        visibility: hidden;
      }
      #printArea, #printArea * {
        visibility: visible;
      }
      #printArea {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
      }
      .no-print {
        display: none !important;
      }
      .pc-sidebar, .pc-header, .pc-footer {
        display: none !important;
      }
      .pc-container {
        margin-left: 0 !important;
        padding: 0 !important;
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

  <!-- =========================================================
       SIDEBAR
  ========================================================== -->
  <nav class="pc-sidebar no-print">
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
            <label>Menu</label>
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

          <!-- Booking -->
          <li class="pc-item">
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

          <!-- Laporan (Active) -->
          <li class="pc-item active">
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
  <header class="pc-header no-print">
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
      <div class="row mb-3 no-print">
        <div class="col-12">
          <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div>
              <h4 class="mb-1">Laporan Transaksi Kasir</h4>
              <p class="text-muted mb-0">Rekapitulasi riwayat penyewaan, transaksi kasir, dan pendapatan rental PlayStation.</p>
            </div>
            <div class="d-flex gap-2">
              <button class="btn btn-outline-secondary" onclick="exportCSV()">
                <i class="ti ti-file-spreadsheet me-1"></i> Export Excel (CSV)
              </button>
              <button class="btn btn-primary" onclick="printLaporan()">
                <i class="ti ti-printer me-1"></i> Cetak Laporan
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- KARTU STATISTIK RINGKASAN -->
      <div class="row mb-3 no-print">
        <!-- Total Pendapatan -->
        <div class="col-sm-6 col-xl-3 mb-3">
          <div class="card border-0 shadow-sm report-stat-card mb-0">
            <div class="card-body">
              <div class="d-flex align-items-center">
                <div class="stat-icon-wrapper bg-light-primary text-primary me-3">
                  <i class="ti ti-wallet"></i>
                </div>
                <div>
                  <h6 class="text-muted mb-1 fs-6">Total Pendapatan</h6>
                  <h4 class="mb-0 fw-bold" id="cardTotalPendapatan">Rp 0</h4>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Total Transaksi Selesai -->
        <div class="col-sm-6 col-xl-3 mb-3">
          <div class="card border-0 shadow-sm report-stat-card mb-0">
            <div class="card-body">
              <div class="d-flex align-items-center">
                <div class="stat-icon-wrapper bg-light-success text-success me-3">
                  <i class="ti ti-circle-check"></i>
                </div>
                <div>
                  <h6 class="text-muted mb-1 fs-6">Transaksi Selesai</h6>
                  <h4 class="mb-0 fw-bold" id="cardTotalTransaksi">0 Transaksi</h4>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Total Jam Sewa -->
        <div class="col-sm-6 col-xl-3 mb-3">
          <div class="card border-0 shadow-sm report-stat-card mb-0">
            <div class="card-body">
              <div class="d-flex align-items-center">
                <div class="stat-icon-wrapper bg-light-warning text-warning me-3">
                  <i class="ti ti-clock-hour-4"></i>
                </div>
                <div>
                  <h6 class="text-muted mb-1 fs-6">Total Jam Sewa</h6>
                  <h4 class="mb-0 fw-bold" id="cardTotalJam">0 Jam</h4>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- F&B Tambahan -->
        <div class="col-sm-6 col-xl-3 mb-3">
          <div class="card border-0 shadow-sm report-stat-card mb-0">
            <div class="card-body">
              <div class="d-flex align-items-center">
                <div class="stat-icon-wrapper bg-light-info text-info me-3">
                  <i class="ti ti-cup"></i>
                </div>
                <div>
                  <h6 class="text-muted mb-1 fs-6">Total Makanan / Minuman</h6>
                  <h4 class="mb-0 fw-bold" id="cardTotalFnb">Rp 0</h4>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- FILTER BOX -->
      <div class="card mb-4 no-print">
        <div class="card-header py-3">
          <h5 class="mb-0 fs-6 fw-semibold">
            <i class="ti ti-filter me-1 text-primary"></i> Filter Periode & Ruangan
          </h5>
        </div>
        <div class="card-body">
          <div class="row g-3">
            <div class="col-md-3">
              <label class="form-label small text-muted">Tanggal Mulai</label>
              <input type="date" id="filterStartDate" class="form-control" value="2026-10-01">
            </div>
            <div class="col-md-3">
              <label class="form-label small text-muted">Tanggal Akhir</label>
              <input type="date" id="filterEndDate" class="form-control" value="2026-10-08">
            </div>
            <div class="col-md-3">
              <label class="form-label small text-muted">Pilih Ruangan</label>
              <select id="filterRoom" class="form-select">
                <option value="all">Semua Ruangan</option>
                <option value="PS Room 1">PS Room 1</option>
                <option value="PS Room 2">PS Room 2</option>
                <option value="PS Room 3">PS Room 3</option>
                <option value="VIP Room 1">VIP Room 1</option>
                <option value="VIP Room 2">VIP Room 2</option>
              </select>
            </div>
            <div class="col-md-3 d-flex align-items-end gap-2">
              <button class="btn btn-primary flex-fill" onclick="applyFilter()">
                <i class="ti ti-search me-1"></i> Terapkan
              </button>
              <button class="btn btn-light" onclick="resetFilter()" title="Reset Filter">
                <i class="ti ti-rotate-clockwise"></i>
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- TABEL LAPORAN (AREA PRINT) -->
      <div class="card" id="printArea">
        <div class="card-header d-flex justify-content-between align-items-center">
          <div>
            <h5 class="mb-0">Data Rekap Transaksi Rental</h5>
            <small class="text-muted d-none d-print-block">Dicetak pada: <span id="printTimestamp"></span> | Operator: <span id="printCashier">Kasir</span></small>
          </div>
          <span class="badge bg-light-primary text-primary px-3 py-2 no-print" id="dataCountBadge">
            Memuat data...
          </span>
        </div>

        <div class="table-responsive">
          <table class="table table-hover align-middle mb-0" id="reportTable">
            <thead class="table-light">
              <tr>
                <th style="width: 50px;">No</th>
                <th>No. Nota</th>
                <th>Tanggal & Jam</th>
                <th>Pelanggan</th>
                <th>Ruangan</th>
                <th>Durasi</th>
                <th>Biaya Sewa</th>
                <th>F & B</th>
                <th>Total Bayar</th>
                <th>Status</th>
                <th class="no-print text-center">Aksi</th>
              </tr>
            </thead>
            <tbody id="reportTableBody">
              <!-- Render otomatis via laporan.js -->
            </tbody>
            <tfoot class="table-light fw-bold">
              <tr>
                <td colspan="6" class="text-end">Grand Total Pendapatan:</td>
                <td id="tfootSewa">Rp 0</td>
                <td id="tfootFnb">Rp 0</td>
                <td id="tfootTotal" class="text-primary fs-6">Rp 0</td>
                <td colspan="2"></td>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>

    </div>
  </div>

  <!-- =========================================================
       MODAL STRUK / NOTA PEMBAYARAN
  ========================================================== -->
  <div class="modal fade" id="receiptModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h6 class="modal-title fw-bold">
            <i class="ti ti-receipt me-1"></i> Struk Transaksi PS Rental
          </h6>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="receipt-box" id="receiptContent">
            <!-- Isi struk di-generate via laporan.js -->
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
          <button type="button" class="btn btn-primary btn-sm" onclick="printReceipt()">
            <i class="ti ti-printer me-1"></i> Cetak Struk
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- =========================================================
       FOOTER
  ========================================================== -->
  <footer class="pc-footer no-print">
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

  <!-- Script Logika Laporan (File Eksternal) -->
  <script src="{{ asset('assets/js/pages/laporan.js') }}"></script>

</body>

</html>
