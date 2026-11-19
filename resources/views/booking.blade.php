<!DOCTYPE html>
<html lang="id">

<head>
  <title>Booking Ruangan | PS Rental</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">

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
    /* =====================================================
       USER CARD + LOGOUT (sama dengan Dashboard)
    ====================================================== */

    :root {
      --pc-sidebar-width: 280px;
    }

    .sidebar-user-row {
      display: flex;
      align-items: stretch;
      gap: 10px;
      margin: 0 15px 15px;
    }

    .sidebar-user-row .pc-user-card {
      flex: 1 1 auto;
      min-width: 0;
      margin: 0 !important;
      box-shadow: none;
      background: #f8f9fa;
      border: 1px solid #e5e7eb;
      border-radius: 16px;
    }

    .sidebar-user-row .pc-user-card .card-body { padding: 16px; }

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

    .sidebar-logout-btn:hover { background: #fde8e8; color: #dc3545; }

    /* =====================================================
       BOOKING
    ====================================================== */

    .price-box {
      background: #f8fafc;
      border: 1px dashed #cbd5e1;
      border-radius: 10px;
    }

    /* =====================================================
       POPUP KONFIRMASI LOGOUT
    ====================================================== */

    .lg-overlay {
      position: fixed;
      top: 0; right: 0; bottom: 0; left: 0;
      z-index: 2000;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 16px;
      background: rgba(0, 0, 0, 0.5);
      opacity: 0;
      visibility: hidden;
      transition: opacity 0.25s ease, visibility 0.25s ease;
    }

    .lg-overlay.show { opacity: 1; visibility: visible; }

    .lg-box {
      width: 100%;
      max-width: 300px;
      background: #ffffff;
      border-radius: 22px;
      padding: 12px 8px 8px;
      text-align: center;
      box-shadow: 0 25px 60px rgba(15, 23, 42, 0.25);
      transform: scale(0.85) translateY(20px);
      transition: transform 0.25s ease;
    }

    .lg-overlay.show .lg-box { transform: scale(1) translateY(0); }

    .lg-icon {
      width: 76px;
      height: 76px;
      margin: 18px auto 18px;
      border-radius: 50%;
      background: #fde8e8;
      color: #dc3545;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 36px;
      box-shadow: 0 0 0 10px #fff4f4;
    }

    .lg-text { color: #6c757d; font-size: 14px; margin: 0; padding: 0 16px; }

    .lg-actions { display: flex; gap: 12px; padding: 22px 16px 14px; }

    .lg-actions .btn { flex: 1; padding: 12px; border-radius: 12px; font-weight: 600; }

    .btn-logout-cancel { background: #f1f5f9; border: 1px solid #e5e7eb; color: #475569; }
    .btn-logout-cancel:hover { background: #e2e8f0; color: #1e293b; }
    .btn-logout-confirm { background: #dc3545; border: 1px solid #dc3545; color: #ffffff; }
    .btn-logout-confirm:hover { background: #bb2d3b; border-color: #bb2d3b; color: #ffffff; }
    
    #jadwalTerisi,
    #jadwalTerisi * {
      color: #dc3545 !important;
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
       SIDEBAR KASIR
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
                  <h6 class="mb-0" id="sidebarUsername">Kasir</h6>
                  <small class="text-muted" id="sidebarRole">Kasir</small>
                </div>
              </div>
            </div>
          </div>

          <!-- LOGOUT (ikon) -->
          <a href="#" class="sidebar-logout-btn" title="Logout" onclick="logout(); return false;">
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
              <span class="pc-micon"><i class="ti ti-home"></i></span>
              <span class="pc-mtext">Dashboard</span>
            </a>
          </li>

          <!-- Booking (Active) -->
          <li class="pc-item active">
            <a href="/booking" class="pc-link">
              <span class="pc-micon"><i class="ti ti-calendar-event"></i></span>
              <span class="pc-mtext">Booking</span>
            </a>
          </li>

          <!-- Ruangan -->
          <li class="pc-item">
            <a href="/ruangan" class="pc-link">
              <span class="pc-micon"><i class="ti ti-device-gamepad"></i></span>
              <span class="pc-mtext">Ruangan</span>
            </a>
          </li>

          <!-- Tracking -->
          <li class="pc-item">
            <a href="/tracking" class="pc-link">
              <span class="pc-micon"><i class="ti ti-receipt"></i></span>
              <span class="pc-mtext">Tracking</span>
            </a>
          </li>

          <!-- Laporan -->
          <li class="pc-item">
            <a href="/laporan" class="pc-link">
              <span class="pc-micon"><i class="ti ti-report"></i></span>
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
          <li class="pc-h-item text-muted">
            <i class="ti ti-calendar me-1"></i>
            <span id="currentDate">-</span>
          </li>
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

      <!-- JUDUL HALAMAN + TOMBOL TAMBAH BOOKING -->
      <div class="row mb-3">
        <div class="col-12">
          <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div>
              <h4 class="mb-1">Kelola Booking PlayStation</h4>
              <p class="text-muted mb-0">Input reservasi sewa ruangan PS, cek ketersediaan konsol, dan kelola jadwal pelanggan kasir.</p>
            </div>
            <div>
              <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalBooking">
                <i class="ti ti-plus me-1"></i> Tambah Booking
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- NOTIFIKASI SUKSES -->
      <div id="bookingSuccessAlert" class="alert alert-success d-none py-2 px-3 small rounded-3 mb-3 shadow-sm" role="alert"></div>

      <!-- RIWAYAT BOOKING + FILTER TANGGAL -->
      <div class="row">
        <div class="col-12">

          <div class="card border-0 shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
              <h5 class="mb-0">
                <i class="ti ti-list me-1 text-primary"></i> Riwayat Booking
              </h5>
              <span class="badge bg-light-primary text-primary px-3 py-2" id="badgeTotalRiwayat">0 Booking</span>
            </div>

            <!-- Filter tanggal -->
            <div class="card-body border-bottom py-3">
              <div class="row g-2 align-items-end">
                <div class="col-sm-6 col-md-4 col-lg-3">
                  <label class="form-label small fw-semibold text-secondary">Dari Tanggal</label>
                  <input type="date" id="filterTanggalDari" class="form-control">
                </div>
                <div class="col-sm-6 col-md-4 col-lg-3">
                  <label class="form-label small fw-semibold text-secondary">Sampai Tanggal</label>
                  <input type="date" id="filterTanggalSampai" class="form-control">
                </div>
                <div class="col-sm-12 col-md-4 col-lg-3">
                  <button type="button" class="btn btn-light" id="btnResetFilterTanggal">
                    <i class="ti ti-refresh me-1"></i> Reset Filter
                  </button>
                </div>
              </div>
            </div>

            <!-- Tabel riwayat -->
            <div class="table-responsive">
              <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                  <tr>
                    <th style="width: 50px;">No</th>
                    <th>Tanggal</th>
                    <th>Jam</th>
                    <th>Pelanggan</th>
                    <th>Ruangan</th>
                    <th>Durasi</th>
                    <th>Total</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody id="tabelRiwayatBooking">
                  <!-- Diisi lewat window.setRiwayatBooking(data) -->
                </tbody>
              </table>
            </div>
          </div>

        </div>
      </div>

    </div>
  </div>

  <!-- =========================================================
       MODAL TAMBAH BOOKING (isi form tidak berubah, hanya dipindah ke modal)
  ========================================================== -->
  <div class="modal fade" id="modalBooking" tabindex="-1" aria-labelledby="modalBookingTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content">

        <div class="modal-header">
          <h5 class="modal-title fw-bold" id="modalBookingTitle">
            <i class="ti ti-calendar-plus me-1 text-primary"></i> Tambah Booking Baru
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <form id="formTambahBooking">

          <div class="modal-body">

            <!-- NOTIFIKASI ERROR (dipindah ke dalam modal agar terlihat) -->
            <div id="bookingErrorAlert" class="alert alert-danger d-none py-2 px-3 small rounded-3 mb-3 shadow-sm" role="alert"></div>


                <!-- Nama Pelanggan -->
                <div class="mb-3">
                  <label class="form-label small fw-semibold text-secondary">Nama Pelanggan <span class="text-danger">*</span></label>
                  <input
                    type="text"
                    id="customerName"
                    class="form-control"
                    placeholder="Masukkan nama pelanggan"
                    required>
                </div>

                <!-- No HP -->
                <div class="mb-3">
                  <label class="form-label small fw-semibold text-secondary">Nomor WhatsApp / HP <span class="text-danger">*</span></label>
                  <input
                    type="text"
                    id="customerPhone"
                    class="form-control"
                    placeholder="08xxxxxxxxxx"
                    required>
                </div>

                <!-- Pilihan Ruangan -->
                <div class="mb-3">
                  <label class="form-label small fw-semibold text-secondary">Pilih Ruangan PS <span class="text-danger">*</span></label>
                  <select id="bookingRoom" class="form-select" required>
                    <option value="">Memuat ruangan...</option>
                  </select>
                </div>

                <!-- Tanggal & Jam -->
                <div class="row g-2 mb-3">
                  <div class="col-6">
                    <label class="form-label small fw-semibold text-secondary">Tanggal <span class="text-danger">*</span></label>
                    <input type="date" id="bookingDate" class="form-control" required>
                  </div>
                  <div class="col-6">
                    <label class="form-label small fw-semibold text-secondary">Jam Mulai <span class="text-danger">*</span></label>
                    <input type="time" id="bookingTime" class="form-control" value="13:00" required>
                  </div>
                </div>

                <div id="jadwalTerisi" class="small text-muted mb-3"></div>

                <!-- Durasi Sewa -->
                <div class="mb-3">
                  <label class="form-label small fw-semibold text-secondary">Durasi Sewa <span class="text-danger">*</span></label>
                  <select id="bookingDuration" class="form-select" required>
                    <option value="1">1 Jam</option>
                    <option value="2" selected>2 Jam</option>
                    <option value="3">3 Jam</option>
                    <option value="4">4 Jam</option>
                    <option value="5">5 Jam</option>
                  </select>
                </div>

                <!-- Estimasi Biaya -->
                <div class="price-box p-3 mb-3">
                  <div class="d-flex justify-content-between align-items-center">
                    <span class="small text-muted fw-semibold">Estimasi Total Biaya:</span>
                    <strong class="text-primary fs-6" id="estimatedPriceDisplay">Rp 0</strong>
                  </div>
                </div>

          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="reset" class="btn btn-light" onclick="setTimeout(resetFormBooking, 100)">
              Reset
            </button>
            <button type="submit" class="btn btn-primary" id="btnSimpanBooking">
              <i class="ti ti-calendar-plus me-1"></i> Simpan Booking
            </button>
          </div>

        </form>

      </div>
    </div>
  </div>

  <!-- =========================================================
       POPUP KONFIRMASI LOGOUT
  ========================================================== -->
  <div class="lg-overlay" id="logoutModal" aria-hidden="true">
    <div class="lg-box" role="dialog" aria-modal="true">

      <div class="lg-icon"><i class="ti ti-logout"></i></div>

      <p class="lg-text">Apakah Anda yakin ingin logout?</p>

      <div class="lg-actions">
        <button type="button" class="btn btn-logout-cancel" id="cancelLogoutBtn">Tidak</button>
        <button type="button" class="btn btn-logout-confirm" id="confirmLogoutBtn">Ya</button>
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

  <!-- Script Logika Booking -->
  <script src="{{ asset('assets/js/pages/booking.js') }}"></script>

  <!-- Script layout: tanggal & jam, logout -->
  <script>
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

    // Popup logout di tengah halaman
    const logoutModal = document.getElementById("logoutModal");

    window.logout = function () {
      logoutModal.classList.add("show");
      logoutModal.setAttribute("aria-hidden", "false");
    };

    function tutupModalLogout() {
      logoutModal.classList.remove("show");
      logoutModal.setAttribute("aria-hidden", "true");
    }

    document.getElementById("cancelLogoutBtn").addEventListener("click", tutupModalLogout);

    logoutModal.addEventListener("click", function (e) {
      if (e.target === logoutModal) tutupModalLogout();
    });

    document.addEventListener("keydown", function (e) {
      if (e.key === "Escape") tutupModalLogout();
    });

    document.getElementById("confirmLogoutBtn").addEventListener("click", function () {
      localStorage.removeItem("role");
      localStorage.removeItem("username");
      window.location.href = "/logout";
    });
  </script>

  <!-- =========================================================
       DITAMBAHKAN: RIWAYAT BOOKING, FILTER TANGGAL, TUTUP MODAL OTOMATIS
       booking.js TIDAK diubah.
  ========================================================== -->
  <script>
    (function () {

      var semuaRiwayat = [];

      var tbody   = document.getElementById("tabelRiwayatBooking");
      var badge   = document.getElementById("badgeTotalRiwayat");
      var elDari  = document.getElementById("filterTanggalDari");
      var elSampai = document.getElementById("filterTanggalSampai");

      function formatRupiah(angka) {
        return "Rp " + Number(angka || 0).toLocaleString("id-ID");
      }

      function formatTanggal(iso) {
        if (!iso) return "-";
        var p = String(iso).substring(0, 10).split("-");
        return p.length === 3 ? p[2] + "/" + p[1] + "/" + p[0] : iso;
      }

      function kelasStatus(status) {
        switch (status) {
          case "Booking":     return "bg-warning";
          case "Sedang Main": return "bg-primary";
          case "Selesai":     return "bg-success";
          case "Dibatalkan":  return "bg-secondary";
          default:            return "bg-light text-dark";
        }
      }

      function sel(teks, kelas) {
        var td = document.createElement("td");
        if (kelas) td.className = kelas;
        td.textContent = teks;
        return td;
      }

      function render() {

        var dari   = elDari.value;
        var sampai = elSampai.value;

        var hasil = semuaRiwayat.filter(function (b) {
          var t = String(b.tanggal || "").substring(0, 10);
          if (dari && t < dari) return false;
          if (sampai && t > sampai) return false;
          return true;
        });

        tbody.innerHTML = "";

        if (hasil.length === 0) {
          var tr = document.createElement("tr");
          var td = document.createElement("td");
          td.colSpan = 8;
          td.className = "text-center text-muted py-4";
          td.textContent = (dari || sampai)
            ? "Tidak ada riwayat booking pada rentang tanggal ini."
            : "Belum ada riwayat booking.";
          tr.appendChild(td);
          tbody.appendChild(tr);
        }

        hasil.forEach(function (b, i) {
          var tr = document.createElement("tr");

          tr.appendChild(sel(i + 1));
          tr.appendChild(sel(formatTanggal(b.tanggal)));
          tr.appendChild(sel(String(b.jam_mulai || b.jam || "-").substring(0, 5)));
          tr.appendChild(sel(b.nama_pelanggan || b.pelanggan || "-"));
          tr.appendChild(sel(b.ruangan || b.nama_ruangan || "-"));
          tr.appendChild(sel((b.durasi || "-") + " Jam"));
          tr.appendChild(sel(formatRupiah(b.total || b.total_biaya)));

          var tdStatus = document.createElement("td");
          var span = document.createElement("span");
          span.className = "badge " + kelasStatus(b.status);
          span.textContent = b.status || "-";
          tdStatus.appendChild(span);
          tr.appendChild(tdStatus);

          tbody.appendChild(tr);
        });

        badge.textContent = hasil.length + " Booking";
      }

      // Menerima array data riwayat lalu menampilkannya di tabel
      window.setRiwayatBooking = function (data) {
        semuaRiwayat = Array.isArray(data) ? data : [];
        render();
      };

      // Tampilkan pesan satu baris di tabel (memuat / gagal)
      function tampilPesan(teks) {
        tbody.innerHTML = "";
        var tr = document.createElement("tr");
        var td = document.createElement("td");
        td.colSpan = 8;
        td.className = "text-center text-muted py-4";
        td.textContent = teks;
        tr.appendChild(td);
        tbody.appendChild(tr);
      }

      // Ambil riwayat dari server (GET /booking/data), dengan filter tanggal bila diisi
      async function muatRiwayat() {

        var params = new URLSearchParams();

        if (elDari.value)   params.set("dari", elDari.value);
        if (elSampai.value) params.set("sampai", elSampai.value);

        var url = "/booking/data" + (params.toString() ? "?" + params.toString() : "");

        try {

          var res = await fetch(url, { headers: { "Accept": "application/json" } });

          if (res.status === 401) {
            window.location.href = "/logout";
            return;
          }

          if (!res.ok) {
            tampilPesan("Gagal memuat riwayat booking.");
            return;
          }

          window.setRiwayatBooking(await res.json());

        } catch (e) {
          tampilPesan("Tidak dapat terhubung ke server.");
        }
      }

      elDari.addEventListener("change", muatRiwayat);
      elSampai.addEventListener("change", muatRiwayat);

      document.getElementById("btnResetFilterTanggal").addEventListener("click", function () {
        elDari.value = "";
        elSampai.value = "";
        muatRiwayat();
      });

      tampilPesan("Memuat riwayat booking...");
      muatRiwayat();


      // Tutup modal otomatis saat notifikasi sukses muncul
      var alertSukses = document.getElementById("bookingSuccessAlert");

      if (alertSukses) {
        new MutationObserver(function () {
          if (!alertSukses.classList.contains("d-none")) {
            var tombolTutup = document.querySelector('#modalBooking [data-bs-dismiss="modal"]');
            if (tombolTutup) tombolTutup.click();
            muatRiwayat();
          }
        }).observe(alertSukses, { attributes: true, attributeFilter: ["class"] });
      }

    })();
  </script>

</body>

</html>