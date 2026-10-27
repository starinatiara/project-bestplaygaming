/* =========================================================
   PS RENTAL - MANAJEMEN RUANGAN ADMIN JAVASCRIPT
   Data diambil dan disimpan ke tabel ms_ruangan lewat Laravel
========================================================== */

const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

let allRooms = [];

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

function formatRupiah(num) {
  return "Rp " + Number(num).toLocaleString("id-ID");
}

// 1 -> ROOM-01
function formatKode(id) {
  return "ROOM-" + String(id).padStart(2, "0");
}

// PS5 -> PlayStation 5
function namaJenis(jenis) {
  return jenis === "PS5" ? "PlayStation 5" : "PlayStation 4";
}

function tampilkanErrorForm(pesan) {
  const box = document.getElementById("roomFormAlert");
  box.textContent = pesan;
  box.classList.remove("d-none");
}

function sembunyikanErrorForm() {
  const box = document.getElementById("roomFormAlert");
  box.textContent = "";
  box.classList.add("d-none");
}

/* ---------------------------------------------------------
   Ambil data dari database
--------------------------------------------------------- */

async function loadRooms() {
  const tbody = document.getElementById("tabelRuangan");
  tbody.innerHTML = '<tr><td colspan="7" class="text-center py-4 text-muted">Memuat data...</td></tr>';

  try {
    const res = await api("/ruangan/data", "GET");

    if (!res.ok) {
      tbody.innerHTML = '<tr><td colspan="7" class="text-center py-4 text-danger">' +
        esc(pesanError(res.data)) + '</td></tr>';
      return;
    }

    allRooms = res.data;
    renderRoomsTable();
  } catch (e) {
    tbody.innerHTML = '<tr><td colspan="7" class="text-center py-4 text-danger">' +
      'Tidak dapat terhubung ke server.</td></tr>';
  }
}

/* ---------------------------------------------------------
   Render tabel dan statistik
--------------------------------------------------------- */

function renderRoomsTable() {
  const searchInput = document.getElementById("searchRuangan");
  const filterType = document.getElementById("filterTypeRuangan");
  const tbody = document.getElementById("tabelRuangan");

  const query = searchInput ? searchInput.value.toLowerCase().trim() : "";
  const selectedType = filterType ? filterType.value : "all";

  const filtered = allRooms.filter(function (r) {
    const cocokCari = r.nama_ruangan.toLowerCase().includes(query) ||
      formatKode(r.id_ruangan).toLowerCase().includes(query) ||
      namaJenis(r.jenis_ruangan).toLowerCase().includes(query);
    const cocokJenis = selectedType === "all" || r.jenis_ruangan === selectedType;
    return cocokCari && cocokJenis;
  });

  tbody.innerHTML = "";

  if (filtered.length === 0) {
    tbody.innerHTML = '<tr><td colspan="7" class="text-center py-4 text-muted">' +
      '<i class="ti ti-device-gamepad-off fs-2 d-block mb-2"></i>' +
      'Tidak ada data ruangan yang cocok.</td></tr>';
  } else {
    filtered.forEach(function (r, index) {
      let badgeStatusClass = "bg-light-success text-success";
      if (r.status_ruangan === "Digunakan") badgeStatusClass = "bg-light-danger text-danger";
      if (r.status_ruangan === "Maintenance") badgeStatusClass = "bg-light-warning text-warning";

      const badgeTypeClass = r.jenis_ruangan === "PS5" ? "bg-light-primary text-primary" : "bg-light-info text-info";

      const tr = document.createElement("tr");
      tr.innerHTML = '<td>' + (index + 1) + '</td>' +
        '<td><span class="badge bg-light-secondary text-dark fw-bold">' + formatKode(r.id_ruangan) + '</span></td>' +
        '<td><strong>' + esc(r.nama_ruangan) + '</strong></td>' +
        '<td><span class="badge ' + badgeTypeClass + '">' + namaJenis(r.jenis_ruangan) + '</span></td>' +
        '<td><strong class="text-primary">' + formatRupiah(r.tarif_per_jam) + '</strong> <small class="text-muted">/ jam</small></td>' +
        '<td><span class="badge ' + badgeStatusClass + '">' + esc(r.status_ruangan) + '</span></td>' +
        '<td class="text-center">' +
        '<div class="btn-group btn-group-sm">' +
        '<button class="btn btn-outline-primary" title="Edit" onclick="editRoom(' + r.id_ruangan + ')"><i class="ti ti-edit"></i></button>' +
        '<button class="btn btn-outline-danger" title="Hapus" onclick="deleteRoom(' + r.id_ruangan + ')"><i class="ti ti-trash"></i></button>' +
        '</div></td>';
      tbody.appendChild(tr);
    });
  }

  // Statistik
  const ps5 = allRooms.filter(function (r) { return r.jenis_ruangan === "PS5"; }).length;
  const ps4 = allRooms.filter(function (r) { return r.jenis_ruangan === "PS4"; }).length;
  const dipakai = allRooms.filter(function (r) { return r.status_ruangan === "Digunakan"; }).length;

  const c1 = document.getElementById("statTotalRuangan");
  const c2 = document.getElementById("statPS5");
  const c3 = document.getElementById("statPS4");
  const c4 = document.getElementById("statRuanganAktif");
  const badgeTotal = document.getElementById("badgeTotalRuangan");

  if (c1) c1.textContent = allRooms.length + " Unit";
  if (c2) c2.textContent = ps5 + " Unit";
  if (c3) c3.textContent = ps4 + " Unit";
  if (c4) c4.textContent = dipakai + " Ruangan";
  if (badgeTotal) badgeTotal.textContent = "Menampilkan " + filtered.length + " Ruangan";
}

/* ---------------------------------------------------------
   Modal tambah / edit
--------------------------------------------------------- */

function bukaModal() {
  const modal = bootstrap.Modal.getOrCreateInstance(document.getElementById("modalRuangan"));
  modal.show();
}

function openAddRoomModal() {
  document.getElementById("modalRoomTitle").textContent = "Tambah Ruangan Baru";
  document.getElementById("roomForm").reset();
  document.getElementById("roomEditId").value = "";
  document.getElementById("roomId").value = "";
  sembunyikanErrorForm();
  bukaModal();
}

function editRoom(id) {
  const r = allRooms.find(function (x) { return Number(x.id_ruangan) === Number(id); });
  if (!r) return;

  document.getElementById("modalRoomTitle").textContent = "Edit Data Ruangan";
  document.getElementById("roomForm").reset();
  document.getElementById("roomEditId").value = r.id_ruangan;
  document.getElementById("roomId").value = formatKode(r.id_ruangan);
  document.getElementById("roomName").value = r.nama_ruangan;
  document.getElementById("roomType").value = r.jenis_ruangan;
  document.getElementById("roomPrice").value = r.tarif_per_jam;
  document.getElementById("roomStatus").value = r.status_ruangan;

  sembunyikanErrorForm();
  bukaModal();
}

/* ---------------------------------------------------------
   Simpan (tambah / ubah)
--------------------------------------------------------- */

async function handleRoomSubmit(e) {
  e.preventDefault();
  sembunyikanErrorForm();

  const editId = document.getElementById("roomEditId").value.trim();

  const payload = {
    nama_ruangan: document.getElementById("roomName").value.trim(),
    jenis_ruangan: document.getElementById("roomType").value,
    tarif_per_jam: parseInt(document.getElementById("roomPrice").value, 10),
    status_ruangan: document.getElementById("roomStatus").value
  };

  const tombol = document.getElementById("btnSimpanRoom");
  tombol.disabled = true;

  try {
    const url = editId ? "/ruangan/" + editId : "/ruangan";
    const method = editId ? "PUT" : "POST";
    const res = await api(url, method, payload);

    if (!res.ok) {
      tampilkanErrorForm(pesanError(res.data));
      return;
    }

    const modal = bootstrap.Modal.getInstance(document.getElementById("modalRuangan"));
    if (modal) modal.hide();

    await loadRooms();
  } catch (err) {
    tampilkanErrorForm("Tidak dapat terhubung ke server.");
  } finally {
    tombol.disabled = false;
  }
}

/* ---------------------------------------------------------
   Hapus
--------------------------------------------------------- */

async function hapusRoom(id) {
  try {
    const res = await api("/ruangan/" + id, "DELETE");

    if (!res.ok) {
      alert(pesanError(res.data));
      return;
    }

    await loadRooms();
  } catch (err) {
    alert("Tidak dapat terhubung ke server.");
  }
}

function deleteRoom(id) {
  const r = allRooms.find(function (x) { return Number(x.id_ruangan) === Number(id); });
  if (!r) return;

  const pesan = "Apakah Anda yakin ingin menghapus ruangan " + r.nama_ruangan + "?";

  // Memakai pop up bersama (logout-modal.js) kalau tersedia
  if (window.tampilKonfirmasi) {
    window.tampilKonfirmasi({
      judul: "Hapus Ruangan",
      pesan: pesan,
      teksYa: "Ya, Hapus",
      teksTidak: "Tidak",
      ikon: "ti-trash",
      tipe: "danger",
      onYa: function () { hapusRoom(id); }
    });
    return;
  }

  if (confirm(pesan)) {
    hapusRoom(id);
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

  const form = document.getElementById("roomForm");
  if (form) form.addEventListener("submit", handleRoomSubmit);

  loadRooms();
});

function logout() {
  if (confirm("Apakah Anda yakin ingin logout?")) {
    localStorage.removeItem("role");
    localStorage.removeItem("username");
    window.location.href = "/logout";
  }
}