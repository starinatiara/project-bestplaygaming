<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Laporan Transaksi | PS Rental</title>

  <script>
    (function () {
      var role = (localStorage.getItem("role") || "").toLowerCase();
      var user = (localStorage.getItem("username") || "").toLowerCase();

      if ((role.includes("admin") && !role.includes("kasir")) || user === "superadmin") {
        window.location.replace("/superadmin/laporan");
      }
    })();
  </script>

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
      transition: transform 0.25s;
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

    .logout-box {
      margin-top: 20px;
    }

    .logout-btn {
      width: 100%;
      background: #ffffff;
      border: 1px solid #e5e7eb;
      color: #dc3545;
      padding: 14px;
      border-radius: 12px;
      text-align: left;
      font-weight: 400;
    }

    /* ================= MAIN ================= */
    .main-content {
      margin-left: 280px;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
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

    .content {
      padding: 35px;
      flex: 1;
    }

    /* ================= CARD ================= */
    .card {
      border: 0;
      border-radius: 12px;
      box-shadow: 0 .125rem .25rem rgba(0, 0, 0, .075);
    }

    .card-header {
      background: #ffffff;
      border-bottom: 1px solid #eeeeee;
    }

    .bg-light-primary {
      background-color: #e8f0ff !important;
    }

    /* ================= LAPORAN ================= */
    .stat-icon {
      width: 48px;
      height: 48px;
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 24px;
      flex-shrink: 0;
    }

    .stat-card {
      transition: transform 0.2s, box-shadow 0.2s;
    }

    .stat-card:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
    }

    /* ================= SIDEBAR TOGGLE (DESKTOP) ================= */
    body.sidebar-hidden .sidebar {
      transform: translateX(-100%);
    }

    body.sidebar-hidden .main-content {
      margin-left: 0;
    }

    /* ================= RESPONSIVE ================= */
    @media (max-width: 991px) {
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
  </style>
</head>

<body>

  <!-- =========================================================
       SIDEBAR KASIR
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
          <div class="user-name" id="sidebarUsername">Kasir</div>
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
        <a href="/tracking">
          <i class="ti ti-receipt"></i>
          <span>Tracking</span>
        </a>
      </li>

      <li>
        <a href="/laporan" class="active">
          <i class="ti ti-report"></i>
          <span>Laporan</span>
        </a>
      </li>

    </ul>

    <!-- LOGOUT -->
    <div class="logout-box">
      <button type="button" class="logout-btn" onclick="logout()">
        <i class="ti ti-logout me-2"></i>
        Logout
      </button>
    </div>

  </aside>

  <!-- =========================================================
       MAIN
  ========================================================== -->
  <main class="main-content">

    <!-- HEADER -->
    <header class="top-header">

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

      <!-- JUDUL HALAMAN -->
      <div class="row mb-3">
        <div class="col-12">
          <h4 class="mb-1">Laporan Transaksi Kasir</h4>
          <p class="text-muted mb-0">Rekapitulasi riwayat penyewaan, transaksi kasir, dan pendapatan rental PlayStation.</p>
        </div>
      </div>

      <!-- RINGKASAN -->
      <div class="row g-3 mb-3">

        <div class="col-md-4">
          <div class="card shadow-sm stat-card h-100">
            <div class="card-body d-flex align-items-center gap-3">
              <div class="stat-icon bg-light-primary text-primary">
                <i class="ti ti-wallet"></i>
              </div>
              <div>
                <div class="small text-muted fw-semibold">Total Pendapatan</div>
                <h5 class="mb-0 fw-bold" id="totalPendapatan">Rp 0</h5>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-4">
          <div class="card shadow-sm stat-card h-100">
            <div class="card-body d-flex align-items-center gap-3">
              <div class="stat-icon bg-success-subtle text-success">
                <i class="ti ti-circle-check"></i>
              </div>
              <div>
                <div class="small text-muted fw-semibold">Transaksi Selesai</div>
                <h5 class="mb-0 fw-bold" id="totalTransaksi">0 Transaksi</h5>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-4">
          <div class="card shadow-sm stat-card h-100">
            <div class="card-body d-flex align-items-center gap-3">
              <div class="stat-icon bg-warning-subtle text-warning">
                <i class="ti ti-clock"></i>
              </div>
              <div>
                <div class="small text-muted fw-semibold">Total Jam Sewa</div>
                <h5 class="mb-0 fw-bold" id="totalJam">0 Jam</h5>
              </div>
            </div>
          </div>
        </div>

      </div>

      <!-- FILTER PERIODE & RUANGAN -->
      <div class="card shadow-sm mb-3">
        <div class="card-header py-3">
          <h5 class="mb-0 fs-6 fw-semibold">
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
      <div class="card shadow-sm">
        <div class="card-header py-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
          <h5 class="mb-0 fs-6 fw-semibold">
            <i class="ti ti-list me-1 text-primary"></i> Data Rekap Transaksi Rental
          </h5>
          <span class="badge bg-light-primary text-primary px-3 py-2" id="badgeTotalData">
            Memuat data...
          </span>
        </div>

        <div class="table-responsive">
          <table class="table table-hover align-middle mb-0 small">
            <thead class="table-light">
              <tr>
                <th style="width: 40px;">No</th>
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

  </main>

  <!-- =========================================================
       JAVASCRIPT
  ========================================================== -->

  <!-- Bootstrap JS (sudah termasuk Popper) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Script Logika Laporan -->
  <script>
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
            <td><span class="badge bg-info-subtle text-info">${d.ruangan}</span></td>
            <td>${d.durasi} Jam</td>
            <td>${rupiah(d.biayaSewa)}</td>
            <td class="fw-semibold text-primary">${rupiah(d.totalBayar)}</td>
            <td><span class="badge bg-success-subtle text-success">${d.status}</span></td>
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

    // ================= INIT =================
    document.addEventListener("DOMContentLoaded", function () {
      // Nama user di sidebar (kalau tersimpan saat login)
      const username = localStorage.getItem("username");
      if (username) {
        document.getElementById("sidebarUsername").textContent = username;
      }

      document.getElementById("btnTerapkan").addEventListener("click", renderLaporan);
      document.getElementById("btnResetFilter").addEventListener("click", resetFilter);

      renderLaporan();
    });
  </script>

  <!-- Script layout: toggle sidebar, tanggal & jam -->
  <script>
    // Toggle sidebar (desktop & mobile)
    const sidebar = document.getElementById("sidebar");
    const menuToggle = document.getElementById("menuToggle");

    if (menuToggle) {
      menuToggle.addEventListener("click", function () {
        if (window.innerWidth >= 992) {
          document.body.classList.toggle("sidebar-hidden");
        } else {
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

    // Logout (fallback)
    if (typeof window.logout !== "function") {
      window.logout = function () {
        if (confirm("Apakah Anda yakin ingin logout?")) {
          localStorage.removeItem("role");
          localStorage.removeItem("username");
          window.location.href = "/logout";
        }
      };
    }
  </script>

</body>

</html>