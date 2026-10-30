/* =========================================================
   PS RENTAL - DATA USER MANAGEMENT JAVASCRIPT
   Data diambil dan disimpan ke tabel ms_user lewat Laravel
========================================================== */

const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

let allUsers = [];

/* ---------------------------------------------------------
   Helper
--------------------------------------------------------- */

// Kirim permintaan ke server (JSON)
async function api(url, method, body) {
  const options = {
    method: method,
    headers: {
      "Accept": "application/json",
      "X-CSRF-TOKEN": csrfToken
    }
  };

  if (body) {
    options.headers["Content-Type"] = "application/json";
    options.body = JSON.stringify(body);
  }

  const response = await fetch(url, options);

  let data = {};
  try {
    data = await response.json();
  } catch (e) {
    data = {};
  }

  if (response.status === 401) {
    window.location.href = "/logout";
  }

  return { ok: response.ok, status: response.status, data: data };
}

// Ambil pesan error pertama dari respons server
function pesanError(data) {
  if (data && data.errors) {
    return Object.values(data.errors)[0][0];
  }
  return (data && data.message) || "Terjadi kesalahan pada server.";
}

// Cegah teks dari database dibaca sebagai HTML
function esc(teks) {
  const div = document.createElement("div");
  div.textContent = teks == null ? "" : String(teks);
  return div.innerHTML;
}

// 1 -> USR-001
function formatId(id) {
  return "USR-" + String(id).padStart(3, "0");
}

function tampilkanErrorForm(pesan) {
  const box = document.getElementById("userFormAlert");
  box.textContent = pesan;
  box.classList.remove("d-none");
}

function sembunyikanErrorForm() {
  const box = document.getElementById("userFormAlert");
  box.textContent = "";
  box.classList.add("d-none");
}

/* ---------------------------------------------------------
   Ambil data dari database
--------------------------------------------------------- */

async function loadUsers() {
  const tbody = document.getElementById("tabelUser");
  tbody.innerHTML = '<tr><td colspan="7" class="text-center py-4 text-muted">Memuat data...</td></tr>';

  try {
    const res = await api("/user/data", "GET");

    if (!res.ok) {
      tbody.innerHTML = '<tr><td colspan="7" class="text-center py-4 text-danger">' +
        esc(pesanError(res.data)) + '</td></tr>';
      return;
    }

    allUsers = res.data;
    renderUserTable();
  } catch (e) {
    tbody.innerHTML = '<tr><td colspan="7" class="text-center py-4 text-danger">' +
      'Tidak dapat terhubung ke server.</td></tr>';
  }
}

/* ---------------------------------------------------------
   Render tabel dan statistik
--------------------------------------------------------- */

function renderUserTable() {
  const searchInput = document.getElementById("searchUser");
  const filterRole = document.getElementById("filterRoleUser");
  const tbody = document.getElementById("tabelUser");

  const query = searchInput ? searchInput.value.toLowerCase().trim() : "";
  const selectedRole = filterRole ? filterRole.value : "all";
  const usernameLogin = localStorage.getItem("username");
  const jumlahSuperadmin = allUsers.filter(function (u) { return u.role === "superadmin"; }).length;

  const filtered = allUsers.filter(function (u) {
    const cocokCari = u.nama.toLowerCase().includes(query) ||
      u.username.toLowerCase().includes(query) ||
      formatId(u.id_user).toLowerCase().includes(query);
    const cocokRole = selectedRole === "all" || u.role === selectedRole;
    return cocokCari && cocokRole;
  });

  tbody.innerHTML = "";

  if (filtered.length === 0) {
    tbody.innerHTML = '<tr><td colspan="7" class="text-center py-4 text-muted">' +
      '<i class="ti ti-user-off fs-2 d-block mb-2"></i>' +
      'Tidak ada data pengguna yang sesuai.</td></tr>';
  } else {
    filtered.forEach(function (u, index) {
      const isSuper = u.role === "superadmin";
      const badgeRoleClass = isSuper ? "bg-light-primary text-primary" : "bg-light-success text-success";

      const aktif = u.status === "Aktif";
      const badgeStatusClass = aktif ? "bg-light-success text-success" : "bg-light-secondary text-muted";

      // Akun yang sedang dipakai dan superadmin terakhir tidak boleh dihapus
      const boleHapus = u.username !== usernameLogin && !(isSuper && jumlahSuperadmin <= 1);

      const tr = document.createElement("tr");
      tr.innerHTML = '<td>' + (index + 1) + '</td>' +
        '<td><span class="badge bg-light-secondary text-dark fw-bold">' + formatId(u.id_user) + '</span></td>' +
        '<td>' +
        '<div class="d-flex align-items-center">' +
        '<div class="rounded-circle bg-light-primary text-primary d-flex align-items-center justify-content-center me-2 fw-bold" style="width: 36px; height: 36px; font-size: 14px;">' +
        esc(u.nama.charAt(0).toUpperCase()) +
        '</div>' +
        '<div><strong>' + esc(u.nama) + '</strong></div>' +
        '</div>' +
        '</td>' +
        '<td><code>@' + esc(u.username) + '</code></td>' +
        '<td><span class="badge ' + badgeRoleClass + '"><i class="ti ' + (isSuper ? "ti-shield" : "ti-cash") + ' me-1"></i>' + (isSuper ? "Superadmin" : "Kasir") + '</span></td>' +
        '<td><span class="badge ' + badgeStatusClass + '">' + (aktif ? "Aktif" : "Nonaktif") + '</span></td>' +
        '<td class="text-center">' +
        '<div class="btn-group btn-group-sm">' +
        '<button class="btn btn-outline-primary" title="Edit" onclick="editUser(' + u.id_user + ')"><i class="ti ti-edit"></i></button>' +
        (boleHapus
          ? '<button class="btn btn-outline-danger" title="Hapus" onclick="deleteUser(' + u.id_user + ')"><i class="ti ti-trash"></i></button>'
          : '') +
        '</div>' +
        '</td>';
      tbody.appendChild(tr);
    });
  }

  // Statistik
  const totalKasir = allUsers.filter(function (u) { return u.role === "kasir"; }).length;

  const c1 = document.getElementById("statTotalUser");
  const c2 = document.getElementById("statTotalAdmin");
  const c3 = document.getElementById("statTotalKasir");
  const c4 = document.getElementById("statUserAktif");
  const badgeTotal = document.getElementById("badgeTotalUser");

  if (c1) c1.textContent = allUsers.length + " Akun";
  if (c2) c2.textContent = jumlahSuperadmin + " Akun";
  if (c3) c3.textContent = totalKasir + " Akun";
  if (c4) c4.textContent = allUsers.filter(function (u) { return u.status === "Aktif"; }).length + " Aktif";
  if (badgeTotal) badgeTotal.textContent = "Menampilkan " + filtered.length + " User";
}

/* ---------------------------------------------------------
   Modal tambah / edit
--------------------------------------------------------- */

function bukaModal() {
  const modal = bootstrap.Modal.getOrCreateInstance(document.getElementById("modalUser"));
  modal.show();
}

function openAddUserModal() {
  document.getElementById("modalUserTitle").textContent = "Tambah Akun User Baru";
  document.getElementById("userForm").reset();
  document.getElementById("userEditId").value = "";
  document.getElementById("userRole").disabled = false;
  document.getElementById("userStatus").value = "Aktif";
  document.getElementById("userStatus").disabled = false;
  document.getElementById("passwordHint").textContent = "Wajib diisi untuk akun baru.";
  sembunyikanErrorForm();
  bukaModal();
}

function editUser(id) {
  const u = allUsers.find(function (x) { return Number(x.id_user) === Number(id); });
  if (!u) return;

  document.getElementById("modalUserTitle").textContent = "Edit Akun Pengguna";
  document.getElementById("userForm").reset();
  document.getElementById("userEditId").value = u.id_user;
  document.getElementById("userName").value = u.nama;
  document.getElementById("userUsername").value = u.username;
  document.getElementById("userRole").value = u.role;
  document.getElementById("userStatus").value = u.status || "Aktif";
  document.getElementById("userPassword").value = "";
  document.getElementById("passwordHint").textContent = "Kosongkan jika tidak ingin mengubah password.";

  // Role akun yang sedang dipakai tidak boleh diubah
  const akunSendiri = (u.username === localStorage.getItem("username"));
  document.getElementById("userRole").disabled = akunSendiri;
  document.getElementById("userStatus").disabled = akunSendiri;

  sembunyikanErrorForm();
  bukaModal();
}

/* ---------------------------------------------------------
   Simpan (tambah / ubah)
--------------------------------------------------------- */

async function handleUserSubmit(e) {
  e.preventDefault();
  sembunyikanErrorForm();

  const editId = document.getElementById("userEditId").value.trim();
  const nama = document.getElementById("userName").value.trim();
  const username = document.getElementById("userUsername").value.trim();
  const role = document.getElementById("userRole").value;
  const status = document.getElementById("userStatus").value;
  const password = document.getElementById("userPassword").value;

  if (!editId && password === "") {
    tampilkanErrorForm("Password wajib diisi untuk akun baru.");
    return;
  }

  const payload = { nama: nama, username: username, role: role, status: status };
  if (password !== "") {
    payload.password = password;
  }

  const tombol = document.getElementById("btnSimpanUser");
  tombol.disabled = true;

  try {
    const url = editId ? "/user/" + editId : "/user";
    const method = editId ? "PUT" : "POST";
    const res = await api(url, method, payload);

    if (!res.ok) {
      tampilkanErrorForm(pesanError(res.data));
      return;
    }

    // Kalau yang diubah akun sendiri, perbarui nama pengguna di sidebar
    const usernameLama = localStorage.getItem("username");
    const akunLama = allUsers.find(function (x) { return Number(x.id_user) === Number(editId); });
    if (editId && akunLama && akunLama.username === usernameLama) {
      localStorage.setItem("username", username);
      document.getElementById("sidebarUsername").textContent = username;
    }

    const modalEl = document.getElementById("modalUser");
    const modal = bootstrap.Modal.getInstance(modalEl);
    if (modal) modal.hide();

    await loadUsers();
  } catch (err) {
    tampilkanErrorForm("Tidak dapat terhubung ke server.");
  } finally {
    tombol.disabled = false;
  }
}

/* ---------------------------------------------------------
   Pop up (desain sama dengan pop up logout)
   Dibuat langsung di sini, tidak bergantung file lain
--------------------------------------------------------- */

function pasangStylePopup() {
  if (document.getElementById("popupStyleUser")) return;

  const style = document.createElement("style");
  style.id = "popupStyleUser";
  style.textContent =
    ".up-overlay{position:fixed;top:0;right:0;bottom:0;left:0;z-index:2000;display:flex;align-items:center;justify-content:center;padding:16px;background:rgba(0,0,0,.5);opacity:0;visibility:hidden;transition:opacity .25s ease,visibility .25s ease}" +
    ".up-overlay.show{opacity:1;visibility:visible}" +
    ".up-box{width:100%;max-width:320px;background:#fff;border-radius:22px;padding:12px 8px 8px;text-align:center;box-shadow:0 25px 60px rgba(15,23,42,.25);transform:scale(.85) translateY(20px);transition:transform .25s ease}" +
    ".up-overlay.show .up-box{transform:scale(1) translateY(0)}" +
    ".up-icon{width:76px;height:76px;margin:18px auto;border-radius:50%;background:#fde8e8;color:#dc3545;display:flex;align-items:center;justify-content:center;font-size:36px;box-shadow:0 0 0 10px #fff4f4}" +
    ".up-title{font-size:17px;font-weight:700;color:#212529;margin:0 16px 8px}" +
    ".up-text{color:#6c757d;font-size:14px;margin:0;padding:0 16px}" +
    ".up-actions{display:flex;gap:12px;padding:22px 16px 14px}" +
    ".up-btn{flex:1;padding:12px;border-radius:12px;font-weight:600;font-size:14px;cursor:pointer;font-family:inherit}" +
    ".up-btn-cancel{background:#f1f5f9;border:1px solid #e5e7eb;color:#475569}" +
    ".up-btn-cancel:hover{background:#e2e8f0;color:#1e293b}" +
    ".up-btn-ok{background:#dc3545;border:1px solid #dc3545;color:#fff}" +
    ".up-btn-ok:hover{background:#bb2d3b;border-color:#bb2d3b}";
  document.head.appendChild(style);
}

// opsi: { ikon, judul, pesan, teksYa, teksTidak, onYa }
// Kalau teksTidak dikosongkan, hanya ada satu tombol (untuk pemberitahuan)
function tampilPopup(opsi) {
  pasangStylePopup();

  const overlay = document.createElement("div");
  overlay.className = "up-overlay";

  overlay.innerHTML =
    '<div class="up-box" role="dialog" aria-modal="true">' +
      '<div class="up-icon"><i class="ti ' + (opsi.ikon || "ti-alert-circle") + '"></i></div>' +
      (opsi.judul ? '<p class="up-title">' + esc(opsi.judul) + '</p>' : '') +
      '<p class="up-text">' + esc(opsi.pesan) + '</p>' +
      '<div class="up-actions">' +
        (opsi.teksTidak ? '<button type="button" class="up-btn up-btn-cancel" data-aksi="tidak">' + esc(opsi.teksTidak) + '</button>' : '') +
        '<button type="button" class="up-btn up-btn-ok" data-aksi="ya">' + esc(opsi.teksYa || "Oke") + '</button>' +
      '</div>' +
    '</div>';

  document.body.appendChild(overlay);

  function tutup() {
    document.removeEventListener("keydown", saatTekan);
    overlay.classList.remove("show");
    setTimeout(function () { overlay.remove(); }, 250);
  }

  function saatTekan(e) {
    if (e.key === "Escape") tutup();
  }

  overlay.addEventListener("click", function (e) {
    if (e.target === overlay) tutup();
  });

  overlay.querySelector('[data-aksi="ya"]').addEventListener("click", function () {
    tutup();
    if (typeof opsi.onYa === "function") opsi.onYa();
  });

  const tombolTidak = overlay.querySelector('[data-aksi="tidak"]');
  if (tombolTidak) tombolTidak.addEventListener("click", tutup);

  document.addEventListener("keydown", saatTekan);

  // jalankan animasi masuk
  requestAnimationFrame(function () {
    requestAnimationFrame(function () { overlay.classList.add("show"); });
  });
}

/* ---------------------------------------------------------
   Hapus
--------------------------------------------------------- */

// Proses hapus ke server
async function hapusUser(id) {
  try {
    const res = await api("/user/" + id, "DELETE");

    if (!res.ok) {
      tampilPopup({
        ikon: "ti-alert-circle",
        judul: "Gagal Menghapus",
        pesan: pesanError(res.data),
        teksYa: "Oke"
      });
      return;
    }

    await loadUsers();
  } catch (err) {
    tampilPopup({
      ikon: "ti-wifi-off",
      judul: "Gagal Terhubung",
      pesan: "Tidak dapat terhubung ke server.",
      teksYa: "Oke"
    });
  }
}

// Konfirmasi hapus
function deleteUser(id) {
  const u = allUsers.find(function (x) { return Number(x.id_user) === Number(id); });
  if (!u) return;

  tampilPopup({
    ikon: "ti-trash",
    pesan: "Apakah Anda yakin ingin menghapus akun " + u.username + "?",
    teksYa: "Ya ",
    teksTidak: "Tidak",
    onYa: function () { hapusUser(id); }
  });
}

/* ---------------------------------------------------------
   Auth & jam real-time
--------------------------------------------------------- */

document.addEventListener("DOMContentLoaded", function () {
  const role = localStorage.getItem("role");
  const username = localStorage.getItem("username");

  if (!role || !username) {
    window.location.href = "/logout";
    return;
  }

  const sbUser = document.getElementById("sidebarUsername");
  const sbRole = document.getElementById("sidebarRole");
  if (sbUser) sbUser.textContent = username;
  if (sbRole) sbRole.textContent = role === "superadmin" ? "Superadmin" : "Kasir";

  function updateDateTime() {
    const now = new Date();
    const dateOptions = { weekday: "long", year: "numeric", month: "long", day: "numeric" };
    const curDate = document.getElementById("currentDate");
    const curTime = document.getElementById("currentTime");
    if (curDate) curDate.textContent = now.toLocaleDateString("id-ID", dateOptions);
    if (curTime) curTime.textContent = now.toLocaleTimeString("id-ID", {
      hour: "2-digit", minute: "2-digit", second: "2-digit"
    });
  }

  updateDateTime();
  setInterval(updateDateTime, 1000);

  const form = document.getElementById("userForm");
  if (form) form.addEventListener("submit", handleUserSubmit);

  loadUsers();
});

function logout() {
  if (confirm("Apakah Anda yakin ingin logout?")) {
    localStorage.removeItem("role");
    localStorage.removeItem("username");
    window.location.href = "/logout";
  }
}