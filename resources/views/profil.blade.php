<!DOCTYPE html>
<html lang="id">

<head>

  <meta charset="UTF-8">

  <meta name="viewport"
        content="width=device-width, initial-scale=1.0">

  <title>Profil | PS Rental</title>

  <meta name="csrf-token" content="{{ csrf_token() }}">


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
       PROFIL: link user card & sidebar bisa disembunyikan
    ====================================================== */

    .user-card-link .user-card {
      transition: background 0.2s;
    }

    .user-card-link:hover .user-card {
      background: #eef2f7;
    }

    body.sidebar-collapsed .sidebar {
      display: none;
    }

    body.sidebar-collapsed .main-content {
      margin-left: 0;
    }

  </style>

</head>


<body>


<!-- =====================================================
     SIDEBAR
====================================================== -->

<aside class="sidebar">


  <!-- LOGO -->

  <a href="/dashboard"
     class="brand">

    PS Rental

  </a>


  <!-- USER CARD -->

  <a href="/profil" class="user-card-link d-block text-decoration-none text-reset" title="Profil Saya">

  <div class="user-card">

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

  </a>


  <!-- MENU -->

  <div class="menu-title">

    Menu

  </div>


  <ul class="sidebar-menu">


    <!-- DASHBOARD -->

    <li>

      <a
        href="/dashboard">

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


  <!-- PROFILE -->

  <div class="sidebar-bottom">


    <!-- LOGOUT -->

    <div class="logout-box">

      <button
        type="button"
        class="logout-btn"
        onclick="logout()">

        <i class="ti ti-logout me-2"></i>

        Logout

      </button>

    </div>


  </div>


</aside>

<!-- =====================================================
     MAIN CONTENT
====================================================== -->

<main class="main-content">

  <header class="top-header">
    <div>
      <button type="button" class="btn btn-light border-0 fs-4 px-2 py-1" id="btnToggleSidebar" aria-label="Buka atau tutup menu">
        <i class="ti ti-menu-2"></i>
      </button>
    </div>
    <div class="header-date">
      <i class="ti ti-calendar me-1"></i>
      <span id="currentDate">-</span>
      <span class="mx-2">|</span>
      <i class="ti ti-clock me-1"></i>
      <span id="currentTime">-</span>
    </div>
  </header>

  <div class="content">

    <div class="mb-4">
      <h4 class="welcome-title">Profil Saya</h4>
      <p class="welcome-text mb-0">Ubah nama, username, dan password akun yang sedang login.</p>
    </div>

    <div class="row">
      <div class="col-lg-7">

        <div id="alertBox"></div>

        <div class="card border-0 shadow-sm">
          <div class="card-body p-4">

            <div class="d-flex align-items-center mb-4">
              <div class="rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center"
                   style="width:64px;height:64px;">
                <i class="ti ti-user fs-2 text-primary"></i>
              </div>
              <div class="ms-3">
                <h5 class="mb-1" id="profilNama">-</h5>
                <span class="badge bg-primary" id="profilRole">-</span>
              </div>
            </div>

            <form id="profilForm" novalidate>

              <div class="mb-3">
                <label class="form-label" for="inputNama">Nama Lengkap</label>
                <input type="text" id="inputNama" class="form-control" maxlength="50" required>
              </div>

              <div class="mb-3">
                <label class="form-label" for="inputUsername">Username</label>
                <input type="text" id="inputUsername" class="form-control" maxlength="50" required>
              </div>

              <div class="mb-3">
                <label class="form-label" for="inputRole">Role</label>
                <input type="text" id="inputRole" class="form-control" readonly>
                <div class="form-text">Role tidak dapat diubah dari halaman ini.</div>
              </div>

              <hr class="my-4">

              <h6 class="mb-1">Ubah Password</h6>
              <p class="text-muted small mb-3">Kosongkan bagian ini jika tidak ingin mengubah password.</p>

              <div class="mb-3">
                <label class="form-label" for="inputPasswordLama">Password Lama</label>
                <input type="password" id="inputPasswordLama" class="form-control" autocomplete="current-password">
              </div>

              <div class="mb-3">
                <label class="form-label" for="inputPasswordBaru">Password Baru</label>
                <input type="password" id="inputPasswordBaru" class="form-control" autocomplete="new-password">
                <div class="form-text">Minimal 6 karakter.</div>
              </div>

              <div class="mb-4">
                <label class="form-label" for="inputPasswordKonfirmasi">Konfirmasi Password Baru</label>
                <input type="password" id="inputPasswordKonfirmasi" class="form-control" autocomplete="new-password">
              </div>

              <button type="submit" class="btn btn-primary" id="btnSimpan">
                <i class="ti ti-device-floppy me-1"></i> Simpan Perubahan
              </button>

            </form>

          </div>
        </div>

      </div>
    </div>

  </div>

</main>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>

  /* ================= CEK LOGIN ================= */

  const role = localStorage.getItem("role");
  const username = localStorage.getItem("username");

  if (!role || !username) {
    window.location.href = "/logout";
  }

  const roleName = role === "superadmin" ? "Superadmin" : "Kasir";
  const csrfToken = document.querySelector('meta[name="csrf-token"]').content;


  /* ================= SIDEBAR ================= */

  function isiSidebar(namaUser) {
    document.getElementById("sidebarUsername").textContent = namaUser;
    document.getElementById("sidebarRole").textContent = roleName;
  }

  isiSidebar(username);

  document.querySelectorAll(".menu-kasir").forEach(function (menu) {
    menu.style.display = role === "kasir" ? "" : "none";
  });
  document.querySelectorAll(".menu-superadmin").forEach(function (menu) {
    menu.style.display = role === "superadmin" ? "" : "none";
  });


  /* ================= HAMBURGER ================= */

  document.getElementById("btnToggleSidebar").addEventListener("click", function () {
    document.body.classList.toggle("sidebar-collapsed");
  });


  /* ================= TANGGAL & JAM ================= */

  function updateDateTime() {
    const now = new Date();
    document.getElementById("currentDate").textContent =
      now.toLocaleDateString("id-ID", { weekday: "long", year: "numeric", month: "long", day: "numeric" });
    document.getElementById("currentTime").textContent =
      now.toLocaleTimeString("id-ID", { hour: "2-digit", minute: "2-digit", second: "2-digit" });
  }

  updateDateTime();
  setInterval(updateDateTime, 1000);


  /* ================= ALERT ================= */

  function tampilAlert(tipe, pesan) {
    const box = document.getElementById("alertBox");
    box.innerHTML = "";
    const div = document.createElement("div");
    div.className = "alert alert-" + tipe;
    div.textContent = pesan;
    box.appendChild(div);
    window.scrollTo({ top: 0, behavior: "smooth" });
  }


  /* ================= DATA PROFIL ================= */

  function isiForm(data) {
    document.getElementById("profilNama").textContent = data.nama;
    document.getElementById("profilRole").textContent = roleName;
    document.getElementById("inputNama").value = data.nama;
    document.getElementById("inputUsername").value = data.username;
    document.getElementById("inputRole").value = roleName;
  }

  async function muatProfil() {
    try {
      const response = await fetch("/profil/data", {
        headers: { "Accept": "application/json" }
      });

      if (response.status === 401) {
        localStorage.removeItem("role");
        localStorage.removeItem("username");
        window.location.href = "/logout";
        return;
      }

      if (!response.ok) {
        throw new Error("gagal");
      }

      isiForm(await response.json());
    } catch (err) {
      tampilAlert("danger", "Gagal memuat data profil.");
    }
  }

  muatProfil();


  /* ================= SIMPAN PROFIL ================= */

  document.getElementById("profilForm").addEventListener("submit", async function (e) {
    e.preventDefault();

    const passwordLama = document.getElementById("inputPasswordLama").value;
    const passwordBaru = document.getElementById("inputPasswordBaru").value;
    const passwordKonfirmasi = document.getElementById("inputPasswordKonfirmasi").value;

    if (passwordBaru !== "" && passwordBaru !== passwordKonfirmasi) {
      tampilAlert("danger", "Konfirmasi password baru tidak sama.");
      return;
    }

    const tombol = document.getElementById("btnSimpan");
    tombol.disabled = true;

    try {
      const response = await fetch("/profil", {
        method: "PUT",
        headers: {
          "Content-Type": "application/json",
          "Accept": "application/json",
          "X-CSRF-TOKEN": csrfToken
        },
        body: JSON.stringify({
          nama: document.getElementById("inputNama").value.trim(),
          username: document.getElementById("inputUsername").value.trim(),
          password_lama: passwordLama,
          password_baru: passwordBaru,
          password_baru_confirmation: passwordKonfirmasi
        })
      });

      const data = await response.json();

      if (!response.ok) {
        let pesan = data.message || "Gagal menyimpan profil.";
        if (data.errors) {
          pesan = Object.values(data.errors)[0][0];
        }
        tampilAlert("danger", pesan);
        return;
      }

      localStorage.setItem("username", data.username);
      isiSidebar(data.username);
      isiForm(data);

      document.getElementById("inputPasswordLama").value = "";
      document.getElementById("inputPasswordBaru").value = "";
      document.getElementById("inputPasswordKonfirmasi").value = "";

      tampilAlert("success", "Profil berhasil diperbarui.");
    } catch (err) {
      tampilAlert("danger", "Tidak dapat terhubung ke server.");
    } finally {
      tombol.disabled = false;
    }
  });


  /* ================= LOGOUT ================= */

  function logout() {
    if (confirm("Apakah Anda yakin ingin logout?")) {
      localStorage.removeItem("role");
      localStorage.removeItem("username");
      window.location.href = "/logout";
    }
  }

</script>

</body>

</html>