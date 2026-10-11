/* =========================================================
   PS RENTAL - MANAJEMEN RUANGAN ADMIN JAVASCRIPT
========================================================== */

const STORAGE_KEY_ROOMS = "ps_rental_rooms_data";

// Data default ruangan awal jika localStorage belum ada
const initialRooms = [
  {
    id: "ROOM-01",
    name: "PS Room 1",
    type: "PlayStation 5",
    consoleDetail: "PS5 Disc Edition",
    price: 20000,
    desc: "TV 43\" 4K UHD, 2 Stick DualSense, AC, Sofa L-Shape",
    status: "Digunakan"
  },
  {
    id: "ROOM-02",
    name: "PS Room 2",
    type: "PlayStation 5",
    consoleDetail: "PS5 Digital Edition",
    price: 20000,
    desc: "TV 43\" 4K UHD, 2 Stick DualSense, AC, Sofa 2 Seater",
    status: "Tersedia"
  },
  {
    id: "ROOM-03",
    name: "PS Room 3",
    type: "PlayStation 4",
    consoleDetail: "PS4 Pro 1TB",
    price: 15000,
    desc: "TV 40\" FHD, 2 Stick DualShock 4, AC, Sofa Bed",
    status: "Tersedia"
  },
  {
    id: "ROOM-04",
    name: "PS Room 4",
    type: "PlayStation 4",
    consoleDetail: "PS4 Slim 500GB",
    price: 15000,
    desc: "TV 40\" FHD, 2 Stick DualShock 4, AC, Sofa Minimalis",
    status: "Tersedia"
  },
  {
    id: "ROOM-05",
    name: "VIP Room 1",
    type: "PlayStation 5",
    consoleDetail: "PS5 Disc Edition (Private)",
    price: 30000,
    desc: "Ruangan Privat Kedap Suara, Smart TV 55\" 4K, 4 Stick DualSense, AC, Recliner Sofa, Soundbar Dolby",
    status: "Digunakan"
  },
  {
    id: "ROOM-06",
    name: "VIP Room 2",
    type: "PlayStation 5",
    consoleDetail: "PS5 Disc Edition (Private)",
    price: 30000,
    desc: "Ruangan Privat Kedap Suara, Smart TV 55\" 4K, 4 Stick DualSense, AC, Beanbags, Soundbar",
    status: "Maintenance"
  }
];

// Ambil data dari localStorage atau inisialisasi awal
function getRooms() {
  const saved = localStorage.getItem(STORAGE_KEY_ROOMS);
  if (saved) {
    try {
      return JSON.parse(saved);
    } catch (e) {
      return initialRooms;
    }
  }
  localStorage.setItem(STORAGE_KEY_ROOMS, JSON.stringify(initialRooms));
  return initialRooms;
}

function saveRooms(data) {
  localStorage.setItem(STORAGE_KEY_ROOMS, JSON.stringify(data));
}

function formatRupiah(num) {
  return "Rp " + Number(num).toLocaleString("id-ID");
}

// Render Tabel & Kartu Statistik
function renderRoomsTable() {
  const rooms = getRooms();
  const searchInput = document.getElementById("searchRuangan");
  const filterType = document.getElementById("filterTypeRuangan");

  const query = searchInput ? searchInput.value.toLowerCase().trim() : "";
  const selectedType = filterType ? filterType.value : "all";

  const filtered = rooms.filter(function(room) {
    const matchQuery = room.name.toLowerCase().includes(query) ||
      room.id.toLowerCase().includes(query) ||
      room.type.toLowerCase().includes(query) ||
      room.desc.toLowerCase().includes(query);
    const matchType = selectedType === "all" || room.type === selectedType;
    return matchQuery && matchType;
  });

  const tbody = document.getElementById("tabelRuangan");
  if (!tbody) return;
  tbody.innerHTML = "";

  if (filtered.length === 0) {
    tbody.innerHTML = '<tr><td colspan="8" class="text-center py-4 text-muted">' +
      '<i class="ti ti-device-gamepad-off fs-2 d-block mb-2"></i>' +
      'Tidak ada data ruangan yang cocok.</td></tr>';
  } else {
    filtered.forEach(function(r, index) {
      let badgeStatusClass = "bg-light-success text-success";
      if (r.status === "Digunakan") badgeStatusClass = "bg-light-danger text-danger";
      if (r.status === "Maintenance") badgeStatusClass = "bg-light-warning text-warning";

      let badgeTypeClass = r.type.includes("5") ? "bg-light-primary text-primary" : "bg-light-info text-info";

      const tr = document.createElement("tr");
      tr.innerHTML = '<td>' + (index + 1) + '</td>' +
        '<td><span class="badge bg-light-secondary text-dark fw-bold">' + r.id + '</span></td>' +
        '<td><strong>' + r.name + '</strong><br><small class="text-muted">' + r.consoleDetail + '</small></td>' +
        '<td><span class="badge ' + badgeTypeClass + '">' + r.type + '</span></td>' +
        '<td><strong class="text-primary">' + formatRupiah(r.price) + '</strong> <small class="text-muted">/ jam</small></td>' +
        '<td style="max-width: 250px;"><small class="text-secondary">' + r.desc + '</small></td>' +
        '<td><span class="badge ' + badgeStatusClass + '">' + r.status + '</span></td>' +
        '<td class="text-center">' +
        '<div class="btn-group btn-group-sm">' +
        '<button class="btn btn-outline-primary" title="Edit" onclick="editRoom(\'' + r.id + '\')"><i class="ti ti-edit"></i></button>' +
        '<button class="btn btn-outline-danger" title="Hapus" onclick="deleteRoom(\'' + r.id + '\')"><i class="ti ti-trash"></i></button>' +
        '</div></td>';
      tbody.appendChild(tr);
    });
  }

  // Update Statistik Cards
  const totalRooms = rooms.length;
  const ps5Count = rooms.filter(r => r.type.includes("5")).length;
  const ps4Count = rooms.filter(r => r.type.includes("4")).length;
  const activeCount = rooms.filter(r => r.status === "Digunakan").length;

  const c1 = document.getElementById("statTotalRuangan");
  const c2 = document.getElementById("statPS5");
  const c3 = document.getElementById("statPS4");
  const c4 = document.getElementById("statRuanganAktif");
  const badgeTotal = document.getElementById("badgeTotalRuangan");

  if (c1) c1.textContent = totalRooms + " Unit";
  if (c2) c2.textContent = ps5Count + " Unit";
  if (c3) c3.textContent = ps4Count + " Unit";
  if (c4) c4.textContent = activeCount + " Ruangan";
  if (badgeTotal) badgeTotal.textContent = "Menampilkan " + filtered.length + " Ruangan";
}

// Buka Modal Tambah Ruangan
function openAddRoomModal() {
  document.getElementById("modalRoomTitle").textContent = "Tambah Ruangan Baru";
  document.getElementById("roomForm").reset();
  document.getElementById("roomEditId").value = "";

  // Otomatis generate kode ruangan berikutnya
  const rooms = getRooms();
  const nextNum = (rooms.length + 1).toString().padStart(2, "0");
  document.getElementById("roomId").value = "ROOM-" + nextNum;

  const modal = new bootstrap.Modal(document.getElementById("modalRuangan"));
  modal.show();
}

// Buka Modal Edit Ruangan
function editRoom(id) {
  const rooms = getRooms();
  const room = rooms.find(r => r.id === id);
  if (!room) return;

  document.getElementById("modalRoomTitle").textContent = "Edit Data Ruangan";
  document.getElementById("roomEditId").value = room.id;
  document.getElementById("roomId").value = room.id;
  document.getElementById("roomName").value = room.name;
  document.getElementById("roomType").value = room.type;
  document.getElementById("roomConsoleDetail").value = room.consoleDetail;
  document.getElementById("roomPrice").value = room.price;
  document.getElementById("roomStatus").value = room.status;
  document.getElementById("roomDesc").value = room.desc;

  const modal = new bootstrap.Modal(document.getElementById("modalRuangan"));
  modal.show();
}

// Simpan Data Ruangan (Tambah / Update)
function handleRoomSubmit(e) {
  e.preventDefault();

  const editId = document.getElementById("roomEditId").value.trim();
  const id = document.getElementById("roomId").value.trim();
  const name = document.getElementById("roomName").value.trim();
  const type = document.getElementById("roomType").value;
  const consoleDetail = document.getElementById("roomConsoleDetail").value.trim();
  const price = parseInt(document.getElementById("roomPrice").value, 10) || 15000;
  const status = document.getElementById("roomStatus").value;
  const desc = document.getElementById("roomDesc").value.trim();

  let rooms = getRooms();

  if (editId) {
    // Mode Update
    rooms = rooms.map(function(r) {
      if (r.id === editId) {
        return { id: editId, name, type, consoleDetail, price, desc, status };
      }
      return r;
    });
  } else {
    // Mode Tambah
    rooms.push({ id, name, type, consoleDetail, price, desc, status });
  }

  saveRooms(rooms);
  renderRoomsTable();

  // Tutup Modal
  const modalEl = document.getElementById("modalRuangan");
  const modal = bootstrap.Modal.getInstance(modalEl);
  if (modal) modal.hide();
}

// Hapus Ruangan
function deleteRoom(id) {
  if (confirm("Apakah Anda yakin ingin menghapus ruangan " + id + "?")) {
    let rooms = getRooms();
    rooms = rooms.filter(r => r.id !== id);
    saveRooms(rooms);
    renderRoomsTable();
  }
}

// Auth & Real-Time Clock
document.addEventListener("DOMContentLoaded", function() {
  const role = localStorage.getItem("role");
  const username = localStorage.getItem("username");

  // Halaman Superadmin: jika belum login, kembalikan ke login
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

  // Form submit listener
  const form = document.getElementById("roomForm");
  if (form) form.addEventListener("submit", handleRoomSubmit);

  // Render tabel awal
  renderRoomsTable();
});

function logout() {
  if (confirm("Apakah Anda yakin ingin logout?")) {
    localStorage.removeItem("role");
    localStorage.removeItem("username");
    window.location.href = "login.html";
  }
}
