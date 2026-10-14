/* =========================================================
   PS RENTAL - MANAJEMEN BOOKING JAVASCRIPT
========================================================== */

const STORAGE_KEY_BOOKINGS = "ps_rental_bookings_data";

// Data tarif ruangan
const roomTariffs = {
  "PS Room 1": { price: 20000, type: "PlayStation 5" },
  "PS Room 2": { price: 20000, type: "PlayStation 5" },
  "PS Room 3": { price: 15000, type: "PlayStation 4" },
  "PS Room 4": { price: 15000, type: "PlayStation 4" },
  "VIP Room 1": { price: 30000, type: "VIP PS5" },
  "VIP Room 2": { price: 30000, type: "VIP PS5" }
};

// Data booking awal jika localStorage masih kosong
const initialBookings = [
  {
    id: "BK-001",
    customer: "Rudi Hermawan",
    phone: "081234567890",
    room: "PS Room 3",
    date: "2026-10-08",
    time: "11:00",
    duration: 2,
    pricePerHour: 15000,
    total: 30000,
    note: "Minta stik warna hitam",
    status: "Booking"
  },
  {
    id: "BK-002",
    customer: "Budi Santoso",
    phone: "082345678901",
    room: "VIP Room 1",
    date: "2026-10-08",
    time: "19:00",
    duration: 3,
    pricePerHour: 30000,
    total: 90000,
    note: "Acara main bareng teman",
    status: "Booking"
  },
  {
    id: "BK-003",
    customer: "Doni Prasetyo",
    phone: "085612345678",
    room: "PS Room 1",
    date: "2026-10-08",
    time: "09:00",
    duration: 2,
    pricePerHour: 20000,
    total: 40000,
    note: "Main game FIFA / FC 26",
    status: "Sedang Main"
  }
];

function getBookings() {
  const saved = localStorage.getItem(STORAGE_KEY_BOOKINGS);
  if (saved) {
    try {
      return JSON.parse(saved);
    } catch (e) {
      return initialBookings;
    }
  }
  localStorage.setItem(STORAGE_KEY_BOOKINGS, JSON.stringify(initialBookings));
  return initialBookings;
}

function saveBookings(data) {
  localStorage.setItem(STORAGE_KEY_BOOKINGS, JSON.stringify(data));
}

function formatRupiah(num) {
  return "Rp " + Number(num).toLocaleString("id-ID");
}

// Hitung estimasi biaya saat input ruangan atau durasi berubah
function updateEstimatedPrice() {
  const roomSelect = document.getElementById("bookingRoom");
  const durationSelect = document.getElementById("bookingDuration");
  const displayEl = document.getElementById("estimatedPriceDisplay");

  if (!roomSelect || !durationSelect || !displayEl) return;

  const selectedRoom = roomSelect.value;
  const duration = parseInt(durationSelect.value, 10) || 1;

  if (roomTariffs[selectedRoom]) {
    const rate = roomTariffs[selectedRoom].price;
    const total = rate * duration;
    displayEl.textContent = formatRupiah(total) + " (" + formatRupiah(rate) + "/jam x " + duration + " jam)";
  } else {
    displayEl.textContent = "Rp 0";
  }
}

// Render status ketersediaan 6 ruangan secara dinamis
function renderRoomAvailability() {
  const container = document.getElementById("roomAvailabilityList");
  if (!container) return;

  const bookings = getBookings();
  const rooms = [
    { name: "PS Room 1", type: "PS5", subtitle: "Standar 4K UHD" },
    { name: "PS Room 2", type: "PS5", subtitle: "Standar 4K UHD" },
    { name: "PS Room 3", type: "PS4", subtitle: "PS4 Pro 1TB" },
    { name: "PS Room 4", type: "PS4", subtitle: "PS4 Slim 500GB" },
    { name: "VIP Room 1", type: "VIP PS5", subtitle: "Private Room & Sofa" },
    { name: "VIP Room 2", type: "VIP PS5", subtitle: "Private Room & Beanbag" }
  ];

  container.innerHTML = "";

  rooms.forEach(function(room) {
    // Cek apakah ada booking aktif pada ruangan ini
    const activeBooking = bookings.find(function(b) {
      return b.room === room.name && (b.status === "Sedang Main" || b.status === "Booking");
    });

    let statusText = "Tersedia";
    let badgeClass = "bg-light-success text-success";
    let infoText = "Bisa di-booking";

    if (activeBooking) {
      if (activeBooking.status === "Sedang Main") {
        statusText = "Sedang Main";
        badgeClass = "bg-light-danger text-danger";
        infoText = "Hingga selesai (" + activeBooking.customer + ")";
      } else {
        statusText = "Sudah Booking";
        badgeClass = "bg-light-warning text-warning";
        infoText = "Mulai pkl " + activeBooking.time + " (" + activeBooking.customer + ")";
      }
    }

    const col = document.createElement("div");
    col.className = "col-md-6 mb-3";
    col.innerHTML = '<div class="card border booking-card h-100 shadow-sm" style="cursor: pointer;" onclick="quickSelectRoom(\'' + room.name + '\')">' +
      '<div class="card-body p-3">' +
      '<div class="d-flex justify-content-between align-items-center mb-2">' +
      '<h6 class="mb-0 fw-bold"><i class="ti ti-device-gamepad-2 text-primary me-1"></i>' + room.name + '</h6>' +
      '<span class="badge ' + badgeClass + '">' + statusText + '</span>' +
      '</div>' +
      '<div class="d-flex justify-content-between align-items-center small text-muted">' +
      '<span>' + room.subtitle + '</span>' +
      '<strong class="text-secondary">' + formatRupiah(roomTariffs[room.name].price) + '/jam</strong>' +
      '</div>' +
      '<div class="small text-muted mt-2 pt-2 border-top">' +
      '<i class="ti ti-info-circle me-1"></i>' + infoText +
      '</div>' +
      '</div>' +
      '</div>';
    container.appendChild(col);
  });
}

// Klik kartu ruangan langsung otomatis memilih ruangan di form
function quickSelectRoom(roomName) {
  const roomSelect = document.getElementById("bookingRoom");
  if (roomSelect) {
    roomSelect.value = roomName;
    updateEstimatedPrice();
    // Scroll halus ke form
    document.getElementById("formTambahBooking").scrollIntoView({ behavior: "smooth" });
  }
}

// Render tabel daftar booking
function renderBookingsTable() {
  const bookings = getBookings();
  const searchInput = document.getElementById("searchBooking");
  const filterStatus = document.getElementById("filterStatusBooking");

  const query = searchInput ? searchInput.value.toLowerCase().trim() : "";
  const selectedStatus = filterStatus ? filterStatus.value : "all";

  const filtered = bookings.filter(function(b) {
    const matchQuery = b.customer.toLowerCase().includes(query) ||
      b.phone.toLowerCase().includes(query) ||
      b.room.toLowerCase().includes(query) ||
      b.id.toLowerCase().includes(query);
    const matchStatus = selectedStatus === "all" || b.status === selectedStatus;
    return matchQuery && matchStatus;
  });

  const tbody = document.getElementById("tabelBooking");
  if (!tbody) return;
  tbody.innerHTML = "";

  if (filtered.length === 0) {
    tbody.innerHTML = '<tr><td colspan="9" class="text-center py-4 text-muted">' +
      '<i class="ti ti-calendar-off fs-2 d-block mb-2"></i>' +
      'Tidak ada data booking yang sesuai.</td></tr>';
  } else {
    filtered.forEach(function(b, index) {
      let badgeClass = "bg-light-primary text-primary";
      if (b.status === "Sedang Main") badgeClass = "bg-light-danger text-danger";
      if (b.status === "Selesai") badgeClass = "bg-light-success text-success";
      if (b.status === "Dibatalkan") badgeClass = "bg-light-secondary text-muted";

      const tr = document.createElement("tr");
      tr.innerHTML = '<td>' + (index + 1) + '</td>' +
        '<td><span class="badge bg-light-secondary text-dark fw-bold">' + b.id + '</span></td>' +
        '<td><strong>' + b.customer + '</strong><br><small class="text-muted"><i class="ti ti-phone me-1"></i>' + b.phone + '</small></td>' +
        '<td><span class="badge bg-light-info text-info"><i class="ti ti-device-gamepad-2 me-1"></i>' + b.room + '</span></td>' +
        '<td>' + b.date + ' <br><small class="text-muted"><i class="ti ti-clock me-1"></i>Pkl ' + b.time + '</small></td>' +
        '<td>' + b.duration + ' Jam</td>' +
        '<td><strong class="text-primary">' + formatRupiah(b.total) + '</strong></td>' +
        '<td><span class="badge ' + badgeClass + '">' + b.status + '</span></td>' +
        '<td class="text-center">' +
        '<div class="btn-group btn-group-sm">' +
        (b.status === "Booking" ?
          '<button class="btn btn-outline-success" title="Check-in / Mulai Main" onclick="checkInBooking(\'' + b.id + '\')"><i class="ti ti-player-play"></i></button>' : '') +
        (b.status === "Sedang Main" ?
          '<button class="btn btn-outline-info" title="Selesaikan Main" onclick="finishBooking(\'' + b.id + '\')"><i class="ti ti-check"></i></button>' : '') +
        '<button class="btn btn-outline-primary" title="Edit Booking" onclick="openEditBookingModal(\'' + b.id + '\')"><i class="ti ti-edit"></i></button>' +
        '<button class="btn btn-outline-danger" title="Batalkan / Hapus" onclick="deleteBooking(\'' + b.id + '\')"><i class="ti ti-trash"></i></button>' +
        '</div>' +
        '</td>';
      tbody.appendChild(tr);
    });
  }

  // Update badge counter
  const counter = document.getElementById("badgeTotalBooking");
  if (counter) counter.textContent = "Menampilkan " + filtered.length + " Booking";
}

// Tambah booking baru
function handleBookingSubmit(e) {
  e.preventDefault();

  const customer = document.getElementById("customerName").value.trim();
  const phone = document.getElementById("customerPhone").value.trim();
  const room = document.getElementById("bookingRoom").value;
  const date = document.getElementById("bookingDate").value;
  const time = document.getElementById("bookingTime").value;
  const duration = parseInt(document.getElementById("bookingDuration").value, 10);
  const note = document.getElementById("bookingNote").value.trim() || "-";

  if (!customer || !phone || !room || !date || !time || !duration) {
    alert("Harap lengkapi semua kolom yang wajib diisi!");
    return;
  }

  const rate = roomTariffs[room] ? roomTariffs[room].price : 20000;
  const total = rate * duration;

  let bookings = getBookings();
  const nextNum = (bookings.length + 1).toString().padStart(3, "0");
  const newBooking = {
    id: "BK-" + nextNum,
    customer,
    phone,
    room,
    date,
    time,
    duration,
    pricePerHour: rate,
    total,
    note,
    status: "Booking"
  };

  bookings.unshift(newBooking);
  saveBookings(bookings);

  // Reset form
  document.getElementById("formTambahBooking").reset();
  // Set default tanggal hari ini
  document.getElementById("bookingDate").value = new Date().toISOString().slice(0, 10);
  document.getElementById("bookingTime").value = "13:00";
  updateEstimatedPrice();

  // Re-render
  renderBookingsTable();
  renderRoomAvailability();

  // Tampilkan notifikasi
  const alertBox = document.getElementById("bookingSuccessAlert");
  if (alertBox) {
    alertBox.innerHTML = '<i class="ti ti-check me-1"></i> Booking untuk <strong>' + customer + '</strong> di ' + room + ' berhasil disimpan!';
    alertBox.classList.remove("d-none");
    setTimeout(function() {
      alertBox.classList.add("d-none");
    }, 4000);
  }
}

// Check-in (Mulai Main)
function checkInBooking(id) {
  let bookings = getBookings();
  bookings = bookings.map(function(b) {
    if (b.id === id) {
      return { ...b, status: "Sedang Main" };
    }
    return b;
  });
  saveBookings(bookings);
  renderBookingsTable();
  renderRoomAvailability();
}

// Selesaikan Main
function finishBooking(id) {
  let bookings = getBookings();
  bookings = bookings.map(function(b) {
    if (b.id === id) {
      return { ...b, status: "Selesai" };
    }
    return b;
  });
  saveBookings(bookings);
  renderBookingsTable();
  renderRoomAvailability();
}

// Hapus Booking
function deleteBooking(id) {
  if (confirm("Apakah Anda yakin ingin membatalkan/menghapus booking " + id + "?")) {
    let bookings = getBookings();
    bookings = bookings.filter(function(b) { return b.id !== id; });
    saveBookings(bookings);
    renderBookingsTable();
    renderRoomAvailability();
  }
}

// Buka Modal Edit Booking
function openEditBookingModal(id) {
  const bookings = getBookings();
  const b = bookings.find(function(x) { return x.id === id; });
  if (!b) return;

  document.getElementById("editBookingId").value = b.id;
  document.getElementById("editCustomerName").value = b.customer;
  document.getElementById("editCustomerPhone").value = b.phone;
  document.getElementById("editBookingRoom").value = b.room;
  document.getElementById("editBookingDate").value = b.date;
  document.getElementById("editBookingTime").value = b.time;
  document.getElementById("editBookingDuration").value = b.duration;
  document.getElementById("editBookingStatus").value = b.status;
  document.getElementById("editBookingNote").value = b.note;

  const modal = new bootstrap.Modal(document.getElementById("modalEditBooking"));
  modal.show();
}

// Simpan Perubahan Edit Booking
function handleEditBookingSubmit(e) {
  e.preventDefault();

  const id = document.getElementById("editBookingId").value;
  const customer = document.getElementById("editCustomerName").value.trim();
  const phone = document.getElementById("editCustomerPhone").value.trim();
  const room = document.getElementById("editBookingRoom").value;
  const date = document.getElementById("editBookingDate").value;
  const time = document.getElementById("editBookingTime").value;
  const duration = parseInt(document.getElementById("editBookingDuration").value, 10);
  const status = document.getElementById("editBookingStatus").value;
  const note = document.getElementById("editBookingNote").value.trim();

  const rate = roomTariffs[room] ? roomTariffs[room].price : 20000;
  const total = rate * duration;

  let bookings = getBookings();
  bookings = bookings.map(function(b) {
    if (b.id === id) {
      return {
        ...b,
        customer,
        phone,
        room,
        date,
        time,
        duration,
        pricePerHour: rate,
        total,
        status,
        note
      };
    }
    return b;
  });

  saveBookings(bookings);
  renderBookingsTable();
  renderRoomAvailability();

  const modalEl = document.getElementById("modalEditBooking");
  const modal = bootstrap.Modal.getInstance(modalEl);
  if (modal) modal.hide();
}

// Auth & Real-Time Clock
document.addEventListener("DOMContentLoaded", function() {
  const role = localStorage.getItem("role");
  const username = localStorage.getItem("username");

  if (!role || !username) {
    window.location.href ="/login";
    return;
  }

  const displayUsername = username || "Kasir";
  const displayRole = role === "superadmin" ? "Superadmin" : "Kasir";

  const sbUser = document.getElementById("sidebarUsername");
  const sbRole = document.getElementById("sidebarRole");
  if (sbUser) sbUser.textContent = displayUsername;
  if (sbRole) sbRole.textContent = displayRole;

  // Tanggal & Jam
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

  // Set default date hari ini pada form booking
  const bookingDateInput = document.getElementById("bookingDate");
  if (bookingDateInput && !bookingDateInput.value) {
    bookingDateInput.value = new Date().toISOString().slice(0, 10);
  }

  // Event listener kalkulasi harga otomatis
  const roomSelect = document.getElementById("bookingRoom");
  const durationSelect = document.getElementById("bookingDuration");
  if (roomSelect) roomSelect.addEventListener("change", updateEstimatedPrice);
  if (durationSelect) durationSelect.addEventListener("change", updateEstimatedPrice);

  updateEstimatedPrice();

  // Event listener form tambah booking
  const addForm = document.getElementById("formTambahBooking");
  if (addForm) addForm.addEventListener("submit", handleBookingSubmit);

  // Event listener form edit booking
  const editForm = document.getElementById("formEditBooking");
  if (editForm) editForm.addEventListener("submit", handleEditBookingSubmit);

  // Inisialisasi render
  renderRoomAvailability();
  renderBookingsTable();
});

function logout() {
  if (confirm("Apakah Anda yakin ingin logout?")) {
    localStorage.removeItem("role");
    localStorage.removeItem("username");
    window.location.href ="/login";
  }
}
