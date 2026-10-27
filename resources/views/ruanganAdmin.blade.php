<!DOCTYPE html>
<html lang="id">

<head>
  <title>Kelola Ruangan | PS Rental</title>

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
    .stat-box {
      transition: transform 0.2s, box-shadow 0.2s;
    }

    .stat-box:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(0,0,0,0.06);
    }

    .stat-icon {
      width: 48px;
      height: 48px;
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 24px;
    }

    /* =====================================================
       USER CARD + LOGOUT (disamakan dengan dashboard)
    ====================================================== */

    /* Lebar sidebar disamakan dengan dashboard (280px).
       Hapus baris ini jika ingin memakai lebar bawaan template. */
    :root {
      --pc-sidebar-width: 280px;
    }

    .sidebar-user-row {
      display: flex;
      align-items: stretch;
      gap: 10px;
      margin: 0 15px 15px;
    }

    /* Timpa margin & shadow bawaan template */
    .sidebar-user-row .pc-user-card {
      flex: 1 1 auto;
      min-width: 0;
      margin: 0 !important;
      box-shadow: none;
      background: #f8f9fa;
      border: 1px solid #e5e7eb;
      border-radius: 16px;
    }

    .sidebar-user-row .pc-user-card .card-body {
      padding: 16px;
    }

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

    .sidebar-logout-btn:hover {
      background: #fde8e8;
      color: #dc3545;
    }
    /* ================= DITAMBAHKAN: POPUP KONFIRMASI LOGOUT ================= */
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

<body
  data-pc-preset="preset-1"
  data-pc-sidebar-caption="true"
  data-pc-layout="vertical"
  data-pc-direction="ltr"
  data-pc-theme_contrast=""
  data-pc-theme="light">

  <!-- =========================================================
       SIDEBAR SUPERADMIN
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
                  <h6 class="mb-0" id="sidebarUsername">Superadmin</h6>
                  <small class="text-muted" id="sidebarRole">Superadmin</small>
                </div>
              </div>
            </div>
          </div>

          <!-- LOGOUT (ikon) -->
          <a href="#"
             class="sidebar-logout-btn"
             title="Logout"
             onclick="logout(); return false;">
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
              <span class="pc-micon">
                <i class="ti ti-home"></i>
              </span>
              <span class="pc-mtext">Dashboard</span>
            </a>
          </li>

          <!-- Ruangan (Active) -->
          <li class="pc-item active">
            <a href="/ruanganAdmin" class="pc-link">
              <span class="pc-micon">
                <i class="ti ti-device-gamepad"></i>
              </span>
              <span class="pc-mtext">Ruangan</span>
            </a>
          </li>

          <!-- Data User -->
          <li class="pc-item">
            <a href="/user" class="pc-link">
              <span class="pc-micon">
                <i class="ti ti-users"></i>
              </span>
              <span class="pc-mtext">Data User</span>
            </a>
          </li>

          <!-- Laporan -->
          <li class="pc-item">
            <a href="/laporan" class="pc-link">
              <span class="pc-micon">
                <i class="ti ti-report"></i>
              </span>
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
      <div class="row mb-3">
        <div class="col-12">
          <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div>
              <h4 class="mb-1">Kelola Data Ruangan</h4>
              <p class="text-muted mb-0">Manajemen daftar ruangan PlayStation, spesifikasi konsol, dan pengaturan tarif rental.</p>
            </div>
            <div>
              <button class="btn btn-primary" onclick="openAddRoomModal()">
                <i class="ti ti-plus me-1"></i> Tambah Ruangan
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- KARTU STATISTIK RUANGAN -->
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
                  <h4 class="mb-0 fw-bold" id="statTotalRuangan">6 Unit</h4>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- PS5 -->
        <div class="col-sm-6 col-xl-3 mb-3">
          <div class="card border-0 shadow-sm stat-box mb-0">
            <div class="card-body">
              <div class="d-flex align-items-center">
                <div class="stat-icon bg-light-info text-info me-3">
                  <i class="ti ti-device-tv"></i>
                </div>
                <div>
                  <h6 class="text-muted mb-1 fs-6">Unit PS5</h6>
                  <h4 class="mb-0 fw-bold" id="statPS5">4 Unit</h4>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- PS4 -->
        <div class="col-sm-6 col-xl-3 mb-3">
          <div class="card border-0 shadow-sm stat-box mb-0">
            <div class="card-body">
              <div class="d-flex align-items-center">
                <div class="stat-icon bg-light-secondary text-secondary me-3">
                  <i class="ti ti-device-gamepad"></i>
                </div>
                <div>
                  <h6 class="text-muted mb-1 fs-6">Unit PS4</h6>
                  <h4 class="mb-0 fw-bold" id="statPS4">2 Unit</h4>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Ruangan Aktif -->
        <div class="col-sm-6 col-xl-3 mb-3">
          <div class="card border-0 shadow-sm stat-box mb-0">
            <div class="card-body">
              <div class="d-flex align-items-center">
                <div class="stat-icon bg-light-danger text-danger me-3">
                  <i class="ti ti-flame"></i>
                </div>
                <div>
                  <h6 class="text-muted mb-1 fs-6">Sedang Digunakan</h6>
                  <h4 class="mb-0 fw-bold" id="statRuanganAktif">2 Ruangan</h4>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- TABEL DATA RUANGAN -->
      <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
          <h5 class="mb-0">Daftar Ruangan PlayStation</h5>
          <span class="badge bg-light-primary text-primary px-3 py-2" id="badgeTotalRuangan">
            Menampilkan 6 Ruangan
          </span>
        </div>

        <div class="card-body border-bottom py-3">
          <div class="row g-2 align-items-center">
            <!-- Pencarian -->
            <div class="col-md-6 col-lg-5">
              <div class="input-group">
                <span class="input-group-text bg-light border-end-0">
                  <i class="ti ti-search text-muted"></i>
                </span>
                <input
                  type="text"
                  id="searchRuangan"
                  class="form-control border-start-0"
                  placeholder="Cari nama, kode, atau spesifikasi ruangan..."
                  onkeyup="renderRoomsTable()">
              </div>
            </div>

            <!-- Filter Tipe Konsol -->
            <div class="col-md-4 col-lg-3">
              <select id="filterTypeRuangan" class="form-select" onchange="renderRoomsTable()">
                <option value="all">Semua Jenis Konsol</option>
                <option value="PlayStation 5">PlayStation 5</option>
                <option value="PlayStation 4">PlayStation 4</option>
              </select>
            </div>
          </div>
        </div>

        <div class="table-responsive">
          <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
              <tr>
                <th style="width: 50px;">No</th>
                <th>Kode</th>
                <th>Nama Ruangan</th>
                <th>Jenis Konsol</th>
                <th>Tarif Sewa</th>
                <th>Fasilitas & Deskripsi</th>
                <th>Status</th>
                <th class="text-center" style="width: 100px;">Aksi</th>
              </tr>
            </thead>
            <tbody id="tabelRuangan">
              <!-- Render otomatis via ruanganAdmin.js -->
            </tbody>
          </table>
        </div>
      </div>

    </div>
  </div>

  <!-- =========================================================
       MODAL FORM TAMBAH / EDIT RUANGAN
  ========================================================== -->
  <div class="modal fade" id="modalRuangan" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">

        <div class="modal-header">
          <h5 class="modal-title fw-bold" id="modalRoomTitle">
            Tambah Ruangan Baru
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <form id="roomForm">
          <input type="hidden" id="roomEditId" value="">

          <div class="modal-body">
            <div class="row g-3">
              <!-- Kode Ruangan -->
              <div class="col-md-6">
                <label class="form-label small fw-semibold text-secondary">Kode Ruangan</label>
                <input type="text" id="roomId" class="form-control" required readonly>
              </div>

              <!-- Nama Ruangan -->
              <div class="col-md-6">
                <label class="form-label small fw-semibold text-secondary">Nama Ruangan</label>
                <input type="text" id="roomName" class="form-control" placeholder="Contoh: PS Room 5" required>
              </div>

              <!-- Tipe Konsol -->
              <div class="col-md-6">
                <label class="form-label small fw-semibold text-secondary">Kategori Konsol</label>
                <select id="roomType" class="form-select" required>
                  <option value="PlayStation 5">PlayStation 5</option>
                  <option value="PlayStation 4">PlayStation 4</option>
                </select>
              </div>

              <!-- Detail Konsol -->
              <div class="col-md-6">
                <label class="form-label small fw-semibold text-secondary">Tipe Unit / Varian</label>
                <input type="text" id="roomConsoleDetail" class="form-control" placeholder="Contoh: PS5 Disc Edition" required>
              </div>

              <!-- Tarif Sewa -->
              <div class="col-md-6">
                <label class="form-label small fw-semibold text-secondary">Tarif / Jam (Rp)</label>
                <input type="number" id="roomPrice" class="form-control" placeholder="20000" min="5000" step="1000" required>
              </div>

              <!-- Status -->
              <div class="col-md-6">
                <label class="form-label small fw-semibold text-secondary">Status Awal</label>
                <select id="roomStatus" class="form-select" required>
                  <option value="Tersedia">Tersedia</option>
                  <option value="Digunakan">Digunakan</option>
                  <option value="Maintenance">Maintenance</option>
                </select>
              </div>

              <!-- Fasilitas / Deskripsi -->
              <div class="col-12">
                <label class="form-label small fw-semibold text-secondary">Fasilitas / Deskripsi Ruangan</label>
                <textarea id="roomDesc" class="form-control" rows="3" placeholder="TV 43 inch, 2 Stik, AC, Sofa..." required></textarea>
              </div>
            </div>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary">
              <i class="ti ti-device-floppy me-1"></i> Simpan Ruangan
            </button>
          </div>
        </form>

      </div>
    </div>
  </div>

  <!-- =========================================================
       DITAMBAHKAN: POPUP KONFIRMASI LOGOUT (TENGAH HALAMAN)
  ========================================================== -->
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

  <!-- =========================================================
       JAVASCRIPT
  ========================================================== -->
  <script src="{{ asset('assets/js/plugins/popper.min.js') }}"></script>
  <script src="{{ asset('assets/js/plugins/simplebar.min.js') }}"></script>
  <script src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script>
  <script src="{{ asset('assets/js/script.js') }}"></script>
  <script src="{{ asset('assets/js/theme.js') }}"></script>
  <script src="{{ asset('assets/js/plugins/feather.min.js') }}"></script>

  <!-- Script Logika Ruangan Admin -->
  <script src="{{ asset('assets/js/pages/ruanganAdmin.js') }}"></script>

  <!-- =========================================================
       DITAMBAHKAN: POPUP KONFIRMASI LOGOUT
       Kode logout bawaan (di ruanganAdmin.js / script.js) TIDAK diubah.
       Klik ikon logout dicegat, popup ditampilkan, lalu saat "Ya, Logout"
       diklik fungsi logout() bawaan dijalankan seperti biasa.
  ========================================================== -->
  <script>
    (function () {

      // Cegat klik ikon logout sebelum onclick bawaan berjalan
      document.addEventListener("click", function (e) {

        var tombol = e.target.closest(".sidebar-logout-btn");

        if (!tombol) return;

        e.preventDefault();
        e.stopPropagation();

        bootstrap.Modal.getOrCreateInstance(
          document.getElementById("logoutModal")
        ).show();

      }, true);


      // Tombol "Ya, Logout": jalankan logout() bawaan tanpa confirm bawaan browser
      document.getElementById("confirmLogoutBtn").addEventListener("click", function () {

        var confirmAsli = window.confirm;

        window.confirm = function () { return true; };

        try {

          if (typeof logout === "function") {

            logout();

          } else {

            localStorage.removeItem("role");
            localStorage.removeItem("username");
            window.location.href = "/logout";

          }

        } finally {

          window.confirm = confirmAsli;

        }

      });

    })();
  </script>

</body>

</html>