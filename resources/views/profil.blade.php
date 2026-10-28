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


</aside>

<!-- =====================================================
     MAIN CONTENT
====================================================== -->

<main class="main-content">

  <header class="top-header">
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

  const sidebar = document.getElementById("sidebar");
  const menuToggle = document.getElementById("menuToggle");

  if (menuToggle) {
    menuToggle.addEventListener("click", function () {
      if (window.innerWidth >= 992) {
        // Desktop: sembunyikan / tampilkan sidebar
        document.body.classList.toggle("sidebar-hidden");
      } else {
        // Mobile: buka / tutup sidebar
        sidebar.classList.toggle("show");
      }
    });
  }


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
    bootstrap.Modal
      .getOrCreateInstance(document.getElementById("logoutModal"))
      .show();
  }

  document.getElementById("confirmLogoutBtn").addEventListener("click", function () {
    localStorage.removeItem("role");
    localStorage.removeItem("username");
    window.location.href = "/logout";
  });

</script>

</body>

</html>