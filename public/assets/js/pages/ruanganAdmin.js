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
   Pop up (desain sama dengan pop up logout)
   Dibuat langsung di sini, tidak bergantung file lain
--------------------------------------------------------- */

function pasangStylePopup() {
  if (document.getElementById("popupStyleRuangan")) return;

  const style = document.createElement("style");
  style.id = "popupStyleRuangan";
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

// Proses hapus ke server
async function hapusRoom(id) {
  try {
    const res = await api("/ruangan/" + id, "DELETE");

    if (!res.ok) {
      tampilPopup({
        ikon: "ti-alert-circle",
        judul: "Gagal Menghapus",
        pesan: pesanError(res.data) + " (kode " + res.status + ")",
        teksYa: "Oke"
      });
      return;
    }

    await loadRooms();
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
function deleteRoom(id) {
  const r = allRooms.find(function (x) { return Number(x.id_ruangan) === Number(id); });
  if (!r) return;

  tampilPopup({
    ikon: "ti-trash",
    pesan: "Apakah Anda yakin ingin menghapus ruangan " + r.nama_ruangan + "?",
    teksYa: "Ya, Hapus",
    teksTidak: "Tidak",
    onYa: function () { hapusRoom(id); }
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