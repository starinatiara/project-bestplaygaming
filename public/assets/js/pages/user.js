/* =========================================================
   PS RENTAL - DATA USER MANAGEMENT JAVASCRIPT
========================================================== */

const STORAGE_KEY_USERS = "ps_rental_users_data";

// Data awal user jika localStorage belum ada
const initialUsers = [
  {
    id: "USR-001",
    name: "Super Admin",
    username: "superadmin",
    role: "superadmin",
    phone: "0812-9999-0001",
    status: "Aktif",
    lastLogin: "Hari ini, 10:45"
  },
  {
    id: "USR-002",
    name: "Rizal Pratama",
    username: "kasir",
    role: "kasir",
    phone: "0812-3456-7890",
    status: "Aktif",
    lastLogin: "Kemarin, 21:00"
  },
  {
    id: "USR-003",
    name: "Siti Nurhaliza",
    username: "kasir2",
    role: "kasir",
    phone: "0856-7890-1234",
    status: "Aktif",
    lastLogin: "06 Okt 2026, 17:30"
  },
  {
    id: "USR-004",
    name: "Bambang Wijaya",
    username: "kasir3",
    role: "kasir",
    phone: "0878-1122-3344",
    status: "Nonaktif",
    lastLogin: "01 Okt 2026, 14:10"
  }
];

function getUsers() {
  const saved = localStorage.getItem(STORAGE_KEY_USERS);
  if (saved) {
    try {
      return JSON.parse(saved);
    } catch (e) {
      return initialUsers;
    }
  }
  localStorage.setItem(STORAGE_KEY_USERS, JSON.stringify(initialUsers));
  return initialUsers;
}

function saveUsers(data) {
  localStorage.setItem(STORAGE_KEY_USERS, JSON.stringify(data));
}

// Render Tabel User & Statistik
function renderUserTable() {
  const users = getUsers();
  const searchInput = document.getElementById("searchUser");
  const filterRole = document.getElementById("filterRoleUser");

  const query = searchInput ? searchInput.value.toLowerCase().trim() : "";
  const selectedRole = filterRole ? filterRole.value : "all";

  const filtered = users.filter(function(u) {
    const matchQuery = u.name.toLowerCase().includes(query) ||
      u.username.toLowerCase().includes(query) ||
      u.id.toLowerCase().includes(query) ||
      u.phone.toLowerCase().includes(query);
    const matchRole = selectedRole === "all" || u.role === selectedRole;
    return matchQuery && matchRole;
  });

  const tbody = document.getElementById("tabelUser");
  if (!tbody) return;
  tbody.innerHTML = "";

  if (filtered.length === 0) {
    tbody.innerHTML = '<tr><td colspan="8" class="text-center py-4 text-muted">' +
      '<i class="ti ti-user-off fs-2 d-block mb-2"></i>' +
      'Tidak ada data pengguna yang sesuai.</td></tr>';
  } else {
    filtered.forEach(function(u, index) {
      const isSuper = u.role === "superadmin";
      const badgeRoleClass = isSuper ? "bg-light-primary text-primary" : "bg-light-success text-success";
      const badgeStatusClass = u.status === "Aktif" ? "bg-light-success text-success" : "bg-light-secondary text-muted";

      const tr = document.createElement("tr");
      tr.innerHTML = '<td>' + (index + 1) + '</td>' +
        '<td><span class="badge bg-light-secondary text-dark fw-bold">' + u.id + '</span></td>' +
        '<td>' +
        '<div class="d-flex align-items-center">' +
        '<div class="rounded-circle bg-light-primary text-primary d-flex align-items-center justify-content-center me-2 fw-bold" style="width: 36px; height: 36px; font-size: 14px;">' +
        u.name.charAt(0) +
        '</div>' +
        '<div><strong>' + u.name + '</strong><br><small class="text-muted">' + u.phone + '</small></div>' +
        '</div>' +
        '</td>' +
        '<td><code>@' + u.username + '</code></td>' +
        '<td><span class="badge ' + badgeRoleClass + '"><i class="ti ' + (isSuper ? 'ti-shield' : 'ti-cash') + ' me-1"></i>' + (isSuper ? 'Superadmin' : 'Kasir') + '</span></td>' +
        '<td><span class="badge ' + badgeStatusClass + '">' + u.status + '</span></td>' +
        '<td><small class="text-muted">' + u.lastLogin + '</small></td>' +
        '<td class="text-center">' +
        '<div class="btn-group btn-group-sm">' +
        '<button class="btn btn-outline-primary" title="Edit" onclick="editUser(\'' + u.id + '\')"><i class="ti ti-edit"></i></button>' +
        (isSuper && users.filter(x => x.role === 'superadmin').length <= 1 ? '' :
          '<button class="btn btn-outline-danger" title="Hapus" onclick="deleteUser(\'' + u.id + '\')"><i class="ti ti-trash"></i></button>') +
        '</div>' +
        '</td>';
      tbody.appendChild(tr);
    });
  }

  // Update Statistik Cards
  const totalUsers = users.length;
  const adminCount = users.filter(u => u.role === "superadmin").length;
  const kasirCount = users.filter(u => u.role === "kasir").length;
  const activeCount = users.filter(u => u.status === "Aktif").length;

  const c1 = document.getElementById("statTotalUser");
  const c2 = document.getElementById("statTotalAdmin");
  const c3 = document.getElementById("statTotalKasir");
  const c4 = document.getElementById("statUserAktif");
  const badgeTotal = document.getElementById("badgeTotalUser");

  if (c1) c1.textContent = totalUsers + " Akun";
  if (c2) c2.textContent = adminCount + " Akun";
  if (c3) c3.textContent = kasirCount + " Akun";
  if (c4) c4.textContent = activeCount + " Aktif";
  if (badgeTotal) badgeTotal.textContent = "Menampilkan " + filtered.length + " User";
}

// Buka Modal Tambah User
function openAddUserModal() {
  document.getElementById("modalUserTitle").textContent = "Tambah Akun User Baru";
  document.getElementById("userForm").reset();
  document.getElementById("userEditId").value = "";

  const users = getUsers();
  const nextNum = (users.length + 1).toString().padStart(3, "0");
  document.getElementById("userId").value = "USR-" + nextNum;

  const modal = new bootstrap.Modal(document.getElementById("modalUser"));
  modal.show();
}

// Buka Modal Edit User
function editUser(id) {
  const users = getUsers();
  const u = users.find(x => x.id === id);
  if (!u) return;

  document.getElementById("modalUserTitle").textContent = "Edit Akun Pengguna";
  document.getElementById("userEditId").value = u.id;
  document.getElementById("userId").value = u.id;
  document.getElementById("userName").value = u.name;
  document.getElementById("userUsername").value = u.username;
  document.getElementById("userRole").value = u.role;
  document.getElementById("userPhone").value = u.phone;
  document.getElementById("userStatus").value = u.status;

  const modal = new bootstrap.Modal(document.getElementById("modalUser"));
  modal.show();
}

// Simpan Data User (Tambah / Update)
function handleUserSubmit(e) {
  e.preventDefault();

  const editId = document.getElementById("userEditId").value.trim();
  const id = document.getElementById("userId").value.trim();
  const name = document.getElementById("userName").value.trim();
  const username = document.getElementById("userUsername").value.trim();
  const role = document.getElementById("userRole").value;
  const phone = document.getElementById("userPhone").value.trim() || "-";
  const status = document.getElementById("userStatus").value;

  let users = getUsers();

  if (editId) {
    // Mode Update
    users = users.map(function(u) {
      if (u.id === editId) {
        return { ...u, name, username, role, phone, status };
      }
      return u;
    });
  } else {
    // Cek apakah username sudah dipakai
    const exists = users.some(u => u.username.toLowerCase() === username.toLowerCase());
    if (exists) {
      alert("Username @" + username + " sudah digunakan! Silakan gunakan username lain.");
      return;
    }

    // Mode Tambah
    users.push({
      id,
      name,
      username,
      role,
      phone,
      status,
      lastLogin: "Baru dibuat"
    });
  }

  saveUsers(users);
  renderUserTable();

  const modalEl = document.getElementById("modalUser");
  const modal = bootstrap.Modal.getInstance(modalEl);
  if (modal) modal.hide();
}

// Hapus User
function deleteUser(id) {
  if (confirm("Apakah Anda yakin ingin menghapus akun " + id + "?")) {
    let users = getUsers();
    users = users.filter(u => u.id !== id);
    saveUsers(users);
    renderUserTable();
  }
}

// Auth & Real-Time Clock
document.addEventListener("DOMContentLoaded", function() {
  const role = localStorage.getItem("role");
  const username = localStorage.getItem("username");

  if (!role || !username) {
    window.location.href = "login.html";
    return;
  }

  const displayUsername = username || "Superadmin";
  const displayRole = role === "superadmin" ? "Superadmin" : "Kasir";

  const sbUser = document.getElementById("sidebarUsername");
  const sbRole = document.getElementById("sidebarRole");
  if (sbUser) sbUser.textContent = displayUsername;
  if (sbRole) sbRole.textContent = displayRole;

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

  renderUserTable();
});

function logout() {
  if (confirm("Apakah Anda yakin ingin logout?")) {
    localStorage.removeItem("role");
    localStorage.removeItem("username");
    window.location.href = "login.html";
  }
}
