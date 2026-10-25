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
   Hapus
--------------------------------------------------------- */

async function deleteUser(id) {
  const u = allUsers.find(function (x) { return Number(x.id_user) === Number(id); });
  if (!u) return;

  if (!confirm("Hapus akun " + u.username + "?\n\nAkun yang sudah punya data booking tidak bisa dihapus. Untuk kasir yang sudah tidak bekerja, sebaiknya ubah statusnya menjadi Nonaktif.")) {
    return;
  }

  try {
    const res = await api("/user/" + id, "DELETE");

    if (!res.ok) {
      alert(pesanError(res.data));
      return;
    }

    await loadUsers();
  } catch (err) {
    alert("Tidak dapat terhubung ke server.");
  }
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