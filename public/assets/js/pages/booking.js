/* =========================================================
   PS RENTAL - FORM BOOKING (KASIR)
   Ruangan diambil dari ms_ruangan, booking disimpan ke
   tr_booking dan pelanggan ke ms_customer lewat Laravel
========================================================== */

const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

let daftarRuangan = [];

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

function formatRupiah(num) {
  return "Rp " + Number(num).toLocaleString("id-ID");
}

function namaJenis(jenis) {
  return jenis === "PS5" ? "PS5" : "PS4";
}

// Tanggal hari ini menurut jam di komputer pengguna (YYYY-MM-DD)
function tanggalHariIni() {
  const d = new Date();
  const bulan = String(d.getMonth() + 1).padStart(2, "0");
  const hari = String(d.getDate()).padStart(2, "0");
  return d.getFullYear() + "-" + bulan + "-" + hari;
}

// Jam default: waktu sekarang dibulatkan ke atas ke 30 menit berikutnya
function jamDefault() {
  const d = new Date();
  let menit = d.getHours() * 60 + d.getMinutes();
  menit = Math.ceil(menit / 30) * 30;

  // Kalau melewati tengah malam, pakai jam terakhir yang masih valid
  if (menit >= 23 * 60) {
    menit = 22 * 60;
  }

  const jam = String(Math.floor(menit / 60)).padStart(2, "0");
  const mnt = String(menit % 60).padStart(2, "0");
  return jam + ":" + mnt;
}

function tampilkanSukses(pesan) {
  const box = document.getElementById("bookingSuccessAlert");
  const err = document.getElementById("bookingErrorAlert");
  err.classList.add("d-none");

  box.innerHTML = "";
  const ikon = document.createElement("i");
  ikon.className = "ti ti-check me-1";
  box.appendChild(ikon);
  box.appendChild(document.createTextNode(pesan));
  box.classList.remove("d-none");

  window.scrollTo({ top: 0, behavior: "smooth" });
  setTimeout(function () { box.classList.add("d-none"); }, 6000);
}

function tampilkanError(pesan) {
  const box = document.getElementById("bookingErrorAlert");
  const ok = document.getElementById("bookingSuccessAlert");
  ok.classList.add("d-none");

  box.innerHTML = "";
  const ikon = document.createElement("i");
  ikon.className = "ti ti-alert-circle me-1";
  box.appendChild(ikon);
  box.appendChild(document.createTextNode(pesan));
  box.classList.remove("d-none");

  window.scrollTo({ top: 0, behavior: "smooth" });
}

function sembunyikanPesan() {
  document.getElementById("bookingSuccessAlert").classList.add("d-none");
  document.getElementById("bookingErrorAlert").classList.add("d-none");
}

/* ---------------------------------------------------------
   Ruangan dari database
--------------------------------------------------------- */

function ruanganTerpilih() {
  const id = Number(document.getElementById("bookingRoom").value);
  return daftarRuangan.find(function (r) { return Number(r.id_ruangan) === id; });
}

async function loadRuangan() {
  const select = document.getElementById("bookingRoom");
  const tombol = document.getElementById("btnSimpanBooking");

  try {
    const res = await api("/ruangan/data", "GET");

    if (!res.ok) {
      select.innerHTML = '<option value="">Gagal memuat ruangan</option>';
      tombol.disabled = true;
      return;
    }

    // Ruangan yang sedang Maintenance tidak bisa dipesan
    daftarRuangan = res.data.filter(function (r) {
      return r.status_ruangan !== "Maintenance";
    });

    select.innerHTML = "";

    if (daftarRuangan.length === 0) {
      select.innerHTML = '<option value="">Belum ada ruangan yang tersedia</option>';
      tombol.disabled = true;
      updateEstimatedPrice();
      return;
    }

    daftarRuangan.forEach(function (r) {
      const opsi = document.createElement("option");
      opsi.value = r.id_ruangan;
      opsi.textContent = r.nama_ruangan + " (" + namaJenis(r.jenis_ruangan) +
        " - " + formatRupiah(r.tarif_per_jam) + "/jam)" +
        (r.status_ruangan === "Digunakan" ? " - sedang digunakan" : "");
      select.appendChild(opsi);
    });

    tombol.disabled = false;
    updateEstimatedPrice();
    loadJadwal();
  } catch (e) {
    select.innerHTML = '<option value="">Tidak dapat terhubung ke server</option>';
    tombol.disabled = true;
  }
}

/* ---------------------------------------------------------
   Estimasi biaya
--------------------------------------------------------- */

function updateEstimatedPrice() {
  const display = document.getElementById("estimatedPriceDisplay");
  const durasi = parseInt(document.getElementById("bookingDuration").value, 10) || 1;
  const ruangan = ruanganTerpilih();

  if (!ruangan) {
    display.textContent = "Rp 0";
    return;
  }

  const tarif = Number(ruangan.tarif_per_jam);
  display.textContent = formatRupiah(tarif * durasi) +
    " (" + formatRupiah(tarif) + "/jam x " + durasi + " jam)";
}

/* ---------------------------------------------------------
   Jadwal yang sudah terisi (membantu menghindari bentrok)
--------------------------------------------------------- */

async function loadJadwal() {
  const box = document.getElementById("jadwalTerisi");
  const ruangan = ruanganTerpilih();
  const tanggal = document.getElementById("bookingDate").value;

  if (!ruangan || !tanggal) {
    box.textContent = "";
    return;
  }

  try {
    const url = "/booking/jadwal?id_ruangan=" + encodeURIComponent(ruangan.id_ruangan) +
      "&tanggal=" + encodeURIComponent(tanggal);
    const res = await api(url, "GET");

    if (!res.ok) {
      box.textContent = "";
      return;
    }

    if (res.data.length === 0) {
      box.textContent = "Belum ada booking untuk " + ruangan.nama_ruangan + " pada tanggal ini.";
      return;
    }

    const daftar = res.data.map(function (j) {
      return j.mulai + " - " + j.selesai + " (" + j.nama + ")";
    });
    box.textContent = "Jadwal terisi " + ruangan.nama_ruangan + ": " + daftar.join(", ");
  } catch (e) {
    box.textContent = "";
  }
}

/* ---------------------------------------------------------
   Form
--------------------------------------------------------- */

function isiNilaiAwal() {
  document.getElementById("bookingDate").value = tanggalHariIni();
  document.getElementById("bookingDate").min = tanggalHariIni();
  document.getElementById("bookingTime").value = jamDefault();
  document.getElementById("bookingDuration").value = "2";
}

// Dipanggil tombol Reset
function resetFormBooking() {
  sembunyikanPesan();
  isiNilaiAwal();
  updateEstimatedPrice();
  loadJadwal();
}

async function handleBookingSubmit(e) {
  e.preventDefault();
  sembunyikanPesan();

  const ruangan = ruanganTerpilih();

  if (!ruangan) {
    tampilkanError("Pilih ruangan terlebih dahulu.");
    return;
  }

  const payload = {
    nama_customer: document.getElementById("customerName").value.trim(),
    no_telepon: document.getElementById("customerPhone").value.trim(),
    id_ruangan: ruangan.id_ruangan,
    tanggal: document.getElementById("bookingDate").value,
    jam_mulai: document.getElementById("bookingTime").value,
    durasi: parseInt(document.getElementById("bookingDuration").value, 10)
  };

  const tombol = document.getElementById("btnSimpanBooking");
  tombol.disabled = true;

  try {
    const res = await api("/booking", "POST", payload);

    if (!res.ok) {
      tampilkanError(pesanError(res.data));
      return;
    }

    tampilkanSukses(res.data.message);

    document.getElementById("customerName").value = "";
    document.getElementById("customerPhone").value = "";
    isiNilaiAwal();
    updateEstimatedPrice();
    loadJadwal();
  } catch (err) {
    tampilkanError("Tidak dapat terhubung ke server.");
  } finally {
    tombol.disabled = daftarRuangan.length === 0;
  }
}

/* ---------------------------------------------------------
   Inisialisasi
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

  isiNilaiAwal();

  document.getElementById("bookingRoom").addEventListener("change", function () {
    updateEstimatedPrice();
    loadJadwal();
  });
  document.getElementById("bookingDuration").addEventListener("change", updateEstimatedPrice);
  document.getElementById("bookingDate").addEventListener("change", loadJadwal);

  document.getElementById("formTambahBooking").addEventListener("submit", handleBookingSubmit);

  loadRuangan();
});