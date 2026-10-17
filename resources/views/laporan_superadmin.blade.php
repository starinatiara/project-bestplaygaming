<!DOCTYPE html>
<html lang="id">

<head>
  <title>Laporan | PS Rental</title>
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

          <!-- Ruangan -->
          <li class="pc-item">
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

          <!-- Laporan (Active) -->
          <li class="pc-item active">
            <a href="/superadmin/laporan" class="pc-link">
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
          <h4 class="mb-1">Laporan Transaksi</h4>
          <p class="text-muted mb-0">Rekapitulasi seluruh riwayat penyewaan, transaksi, dan pendapatan rental PlayStation.</p>
        </div>
      </div>

      <!-- KARTU RINGKASAN -->
      <div class="row mb-3">

        <!-- Total Pendapatan -->
        <div class="col-sm-6 col-xl-4 mb-3">
          <div class="card border-0 shadow-sm stat-box mb-0">
            <div class="card-body">
              <div class="d-flex align-items-center">
                <div class="stat-icon bg-light-primary text-primary me-3">
                  <i class="ti ti-wallet"></i>
                </div>
                <div>
                  <h6 class="text-muted mb-1 fs-6">Total Pendapatan</h6>
                  <h4 class="mb-0 fw-bold" id="totalPendapatan">Rp 0</h4>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Transaksi Selesai -->
        <div class="col-sm-6 col-xl-4 mb-3">
          <div class="card border-0 shadow-sm stat-box mb-0">
            <div class="card-body">
              <div class="d-flex align-items-center">
                <div class="stat-icon bg-light-success text-success me-3">
                  <i class="ti ti-circle-check"></i>
                </div>
                <div>
                  <h6 class="text-muted mb-1 fs-6">Transaksi Selesai</h6>
                  <h4 class="mb-0 fw-bold" id="totalTransaksi">0 Transaksi</h4>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Total Jam Sewa -->
        <div class="col-sm-6 col-xl-4 mb-3">
          <div class="card border-0 shadow-sm stat-box mb-0">
            <div class="card-body">
              <div class="d-flex align-items-center">
                <div class="stat-icon bg-light-warning text-warning me-3">
                  <i class="ti ti-clock"></i>
                </div>
                <div>
                  <h6 class="text-muted mb-1 fs-6">Total Jam Sewa</h6>
                  <h4 class="mb-0 fw-bold" id="totalJam">0 Jam</h4>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

      <!-- FILTER PERIODE & RUANGAN -->
      <div class="card">
        <div class="card-header">
          <h5 class="mb-0">
            <i class="ti ti-filter me-1 text-primary"></i> Filter Periode &amp; Ruangan
          </h5>
        </div>

        <div class="card-body">
          <div class="row g-3 align-items-end">

            <div class="col-md-3">
              <label class="form-label small fw-semibold text-secondary">Tanggal Mulai</label>
              <input type="date" id="filterTanggalMulai" class="form-control">
            </div>

            <div class="col-md-3">
              <label class="form-label small fw-semibold text-secondary">Tanggal Akhir</label>
              <input type="date" id="filterTanggalAkhir" class="form-control">
            </div>

            <div class="col-md-3">
              <label class="form-label small fw-semibold text-secondary">Pilih Ruangan</label>
              <select id="filterRuangan" class="form-select">
                <option value="all" selected>Semua Ruangan</option>
                <option value="PS Room 1">PS Room 1</option>
                <option value="PS Room 2">PS Room 2</option>
                <option value="PS Room 3">PS Room 3</option>
                <option value="PS Room 4">PS Room 4</option>
                <option value="VIP Room 1">VIP Room 1</option>
                <option value="VIP Room 2">VIP Room 2</option>
              </select>
            </div>

            <div class="col-md-3">
              <div class="d-flex gap-2">
                <button type="button" class="btn btn-primary flex-fill" id="btnTerapkan">
                  <i class="ti ti-search me-1"></i> Terapkan
                </button>
                <button type="button" class="btn btn-light" id="btnResetFilter" title="Reset filter">
                  <i class="ti ti-refresh"></i>
                </button>
              </div>
            </div>

          </div>
        </div>
      </div>

      <!-- TABEL REKAP TRANSAKSI -->
      <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
          <h5 class="mb-0">Data Rekap Transaksi Rental</h5>
          <span class="badge bg-light-primary text-primary px-3 py-2" id="badgeTotalData">
            Memuat data...
          </span>
        </div>

        <div class="table-responsive">
          <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
              <tr>
                <th style="width: 50px;">No</th>
                <th>Tanggal &amp; Jam</th>
                <th>Pelanggan</th>
                <th>Ruangan</th>
                <th>Durasi</th>
                <th>Biaya Sewa</th>
                <th>Total Bayar</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody id="tabelLaporan">
              <!-- Diisi otomatis oleh script di bawah -->
            </tbody>
          </table>
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

  <!-- Script Logika Laporan -->
  <script>
    (function () {

      // ================= DATA DUMMY =================
      const dataLaporan = [
        {
          id: 1,
          tanggal: "2026-10-08",
          jam: "10:00",
          pelanggan: "Rudi Hermawan",
          telepon: "081234567890",
          ruangan: "PS Room 1",
          durasi: 2,
          biayaSewa: 30000,
          totalBayar: 30000,
          status: "Lunas"
        }
      ];

      // ================= HELPER =================
      const rupiah = (angka) => "Rp " + Number(angka).toLocaleString("id-ID");

      // ================= FILTER =================
      function ambilDataTerfilter() {
        const mulai = document.getElementById("filterTanggalMulai").value;
        const akhir = document.getElementById("filterTanggalAkhir").value;
        const ruangan = document.getElementById("filterRuangan").value;

        return dataLaporan.filter((d) => {
          const cocokMulai = !mulai || d.tanggal >= mulai;
          const cocokAkhir = !akhir || d.tanggal <= akhir;
          const cocokRuangan = ruangan === "all" || d.ruangan === ruangan;
          return cocokMulai && cocokAkhir && cocokRuangan;
        });
      }

      // ================= RENDER =================
      function renderLaporan() {
        const data = ambilDataTerfilter();
        const tbody = document.getElementById("tabelLaporan");

        if (data.length === 0) {
          tbody.innerHTML = `
            <tr>
              <td colspan="8" class="text-center text-muted py-4">
                Tidak ada transaksi pada filter yang dipilih.
              </td>
            </tr>`;
        } else {
          tbody.innerHTML = data.map((d, i) => `
            <tr>
              <td>${i + 1}</td>
              <td>${d.tanggal} <span class="text-muted small">${d.jam}</span></td>
              <td>
                <div class="fw-semibold">${d.pelanggan}</div>
                <div class="text-muted small">${d.telepon}</div>
              </td>
              <td><span class="badge bg-light-info text-info">${d.ruangan}</span></td>
              <td>${d.durasi} Jam</td>
              <td>${rupiah(d.biayaSewa)}</td>
              <td class="fw-semibold text-primary">${rupiah(d.totalBayar)}</td>
              <td><span class="badge bg-light-success text-success">${d.status}</span></td>
            </tr>
          `).join("");
        }

        // Kartu ringkasan
        const totalPendapatan = data.reduce((sum, d) => sum + d.totalBayar, 0);
        const totalJam = data.reduce((sum, d) => sum + d.durasi, 0);

        document.getElementById("totalPendapatan").textContent = rupiah(totalPendapatan);
        document.getElementById("totalTransaksi").textContent = data.length + " Transaksi";
        document.getElementById("totalJam").textContent = totalJam + " Jam";
        document.getElementById("badgeTotalData").textContent = "Menampilkan " + data.length + " Data";
      }

      function resetFilter() {
        document.getElementById("filterTanggalMulai").value = "";
        document.getElementById("filterTanggalAkhir").value = "";
        document.getElementById("filterRuangan").value = "all";
        renderLaporan();
      }

      // ================= TANGGAL & JAM =================
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

      // ================= LOGOUT (fallback) =================
      if (typeof window.logout !== "function") {
        window.logout = function () {
          if (confirm("Apakah Anda yakin ingin logout?")) {
            localStorage.removeItem("role");
            localStorage.removeItem("username");
            window.location.href = "/logout";
          }
        };
      }

      // ================= INIT =================
      document.addEventListener("DOMContentLoaded", function () {
        const username = localStorage.getItem("username");
        if (username) {
          document.getElementById("sidebarUsername").textContent = username;
        }

        document.getElementById("btnTerapkan").addEventListener("click", renderLaporan);
        document.getElementById("btnResetFilter").addEventListener("click", resetFilter);

        renderLaporan();
        updateDateTime();
        setInterval(updateDateTime, 1000);
      });

    })();
  </script>

</body>

</html>