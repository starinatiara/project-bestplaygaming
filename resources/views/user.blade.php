<!DOCTYPE html>
<html lang="id">

<head>
  <title>Data User | PS Rental</title>
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
  </style>
</head>

<body
  data-pc-preset="preset-1"
  data-pc-sidebar-caption="true"
  data-pc-layout="vertical"
  data-pc-direction="ltr"
  data-pc-theme_contrast=""
  data-pc-theme="light">

  <!-- SIDEBAR SUPERADMIN-->
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

        <!-- USER CARD -->
        <div class="card pc-user-card" onclick="window.location.href='/profil'" style="cursor:pointer" title="Profil Saya" >
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

        <!-- MENU -->
        <ul class="pc-navbar">
          <li class="pc-item pc-caption">
            <label>Menu Superadmin</label>
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

          <!-- Ruangan -->
          <li class="pc-item">
            <a href="/ruanganAdmin" class="pc-link">
              <span class="pc-micon">
                <i class="ti ti-device-gamepad"></i>
              </span>
              <span class="pc-mtext">Ruangan</span>
            </a>
          </li>

          <!-- Data User (Active) -->
          <li class="pc-item active">
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

  <!-- HEADER
  ======================================-->
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
              <h4 class="mb-1">Manajemen Data User</h4>
              <p class="text-muted mb-0">Kelola akun pengguna, staf kasir, dan hak akses sistem (2 User: Superadmin & Kasir).</p>
            </div>
            <div>
              <button class="btn btn-primary" onclick="openAddUserModal()">
                <i class="ti ti-user-plus me-1"></i> Tambah User
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- KARTU STATISTIK USER -->
      <div class="row mb-3">
        <!-- Total User -->
        <div class="col-sm-6 col-xl-3 mb-3">
          <div class="card border-0 shadow-sm stat-box mb-0">
            <div class="card-body">
              <div class="d-flex align-items-center">
                <div class="stat-icon bg-light-primary text-primary me-3">
                  <i class="ti ti-users"></i>
                </div>
                <div>
                  <h6 class="text-muted mb-1 fs-6">Total Akun</h6>
                  <h4 class="mb-0 fw-bold" id="statTotalUser">4 Akun</h4>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Superadmin -->
        <div class="col-sm-6 col-xl-3 mb-3">
          <div class="card border-0 shadow-sm stat-box mb-0">
            <div class="card-body">
              <div class="d-flex align-items-center">
                <div class="stat-icon bg-light-info text-info me-3">
                  <i class="ti ti-shield-check"></i>
                </div>
                <div>
                  <h6 class="text-muted mb-1 fs-6">Superadmin</h6>
                  <h4 class="mb-0 fw-bold" id="statTotalAdmin">1 Akun</h4>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Kasir -->
        <div class="col-sm-6 col-xl-3 mb-3">
          <div class="card border-0 shadow-sm stat-box mb-0">
            <div class="card-body">
              <div class="d-flex align-items-center">
                <div class="stat-icon bg-light-success text-success me-3">
                  <i class="ti ti-device-gamepad"></i>
                </div>
                <div>
                  <h6 class="text-muted mb-1 fs-6">Staf Kasir</h6>
                  <h4 class="mb-0 fw-bold" id="statTotalKasir">3 Akun</h4>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- User Aktif -->
        <div class="col-sm-6 col-xl-3 mb-3">
          <div class="card border-0 shadow-sm stat-box mb-0">
            <div class="card-body">
              <div class="d-flex align-items-center">
                <div class="stat-icon bg-light-warning text-warning me-3">
                  <i class="ti ti-activity"></i>
                </div>
                <div>
                  <h6 class="text-muted mb-1 fs-6">Status Aktif</h6>
                  <h4 class="mb-0 fw-bold" id="statUserAktif">3 Aktif</h4>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- TABEL DATA USER -->
      <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
          <h5 class="mb-0">Daftar Akun Pengguna</h5>
          <span class="badge bg-light-primary text-primary px-3 py-2" id="badgeTotalUser">
            Menampilkan 4 User
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
                  id="searchUser"
                  class="form-control border-start-0"
                  placeholder="Cari nama, username, atau nomor HP..."
                  onkeyup="renderUserTable()">
              </div>
            </div>

            <!-- Filter Role -->
            <div class="col-md-4 col-lg-3">
              <select id="filterRoleUser" class="form-select" onchange="renderUserTable()">
                <option value="all">Semua Peran (Role)</option>
                <option value="superadmin">Superadmin</option>
                <option value="kasir">Kasir</option>
              </select>
            </div>
          </div>
        </div>

        <div class="table-responsive">
          <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
              <tr>
                <th style="width: 50px;">No</th>
                <th>ID User</th>
                <th>Nama Lengkap</th>
                <th>Username</th>
                <th>Role / Akses</th>
                <th>Status</th>
                <th>Terakhir Login</th>
                <th class="text-center" style="width: 100px;">Aksi</th>
              </tr>
            </thead>
            <tbody id="tabelUser">
              <!-- Render otomatis via user.js -->
            </tbody>
          </table>
        </div>
      </div>

    </div>
  </div>

  <!-- =========================================================
       MODAL FORM TAMBAH / EDIT USER
  ========================================================== -->
  <div class="modal fade" id="modalUser" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">

        <div class="modal-header">
          <h5 class="modal-title fw-bold" id="modalUserTitle">
            Tambah Akun User Baru
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <form id="userForm">
          <input type="hidden" id="userEditId" value="">

          <div class="modal-body">
            <div class="row g-3">
              <!-- ID User -->
              <div class="col-md-6">
                <label class="form-label small fw-semibold text-secondary">ID Pengguna</label>
                <input type="text" id="userId" class="form-control" required readonly>
              </div>

              <!-- Nama Lengkap -->
              <div class="col-md-6">
                <label class="form-label small fw-semibold text-secondary">Nama Lengkap</label>
                <input type="text" id="userName" class="form-control" placeholder="Contoh: Budi Santoso" required>
              </div>

              <!-- Username -->
              <div class="col-md-6">
                <label class="form-label small fw-semibold text-secondary">Username Login</label>
                <input type="text" id="userUsername" class="form-control" placeholder="Contoh: kasir_budi" required>
              </div>

              <!-- No HP -->
              <div class="col-md-6">
                <label class="form-label small fw-semibold text-secondary">No. Handphone / WA</label>
                <input type="text" id="userPhone" class="form-control" placeholder="08xxxxxxxxxx">
              </div>

              <!-- Role -->
              <div class="col-md-6">
                <label class="form-label small fw-semibold text-secondary">Hak Akses (Role)</label>
                <select id="userRole" class="form-select" required>
                  <option value="kasir">Kasir</option>
                  <option value="superadmin">Superadmin</option>
                </select>
              </div>

              <!-- Status -->
              <div class="col-md-6">
                <label class="form-label small fw-semibold text-secondary">Status Akun</label>
                <select id="userStatus" class="form-select" required>
                  <option value="Aktif">Aktif</option>
                  <option value="Nonaktif">Nonaktif</option>
                </select>
              </div>
            </div>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary">
              <i class="ti ti-device-floppy me-1"></i> Simpan User
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

  <!-- Script Logika Data User -->
  <script src="{{ asset('assets/js/pages/user.js') }}"></script>

</body>

</html>
