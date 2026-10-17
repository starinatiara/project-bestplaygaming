/* =========================================================
   PS RENTAL - LAPORAN TRANSAKSI JAVASCRIPT
========================================================== */

// Data Transaksi
const defaultTransactions = [
  {
    id: "TRX-20261008-001",
    date: "2026-10-08",
    time: "10:00",
    customer: "Rudi Hermawan",
    phone: "081234567890",
    room: "PS Room 1",
    duration: 2,
    rentCost: 30000,
    fnbCost: 10000,
    total: 40000,
    cashier: "Kasir 1",
    status: "Lunas"
  },
  {
    id: "TRX-20261008-002",
    date: "2026-10-08",
    time: "11:30",
    customer: "Budi Santoso",
    phone: "082345678901",
    room: "VIP Room 1",
    duration: 3,
    rentCost: 75000,
    fnbCost: 20000,
    total: 95000,
    cashier: "Kasir 1",
    status: "Lunas"
  },
  {
    id: "TRX-20261008-003",
    date: "2026-10-08",
    time: "13:00",
    customer: "Dimas Pratama",
    phone: "085678901234",
    room: "PS Room 2",
    duration: 4,
    rentCost: 60000,
    fnbCost: 15000,
    total: 75000,
    cashier: "Kasir 1",
    status: "Lunas"
  },
  {
    id: "TRX-20261007-004",
    date: "2026-10-07",
    time: "15:00",
    customer: "Andi Saputra",
    phone: "087812345678",
    room: "PS Room 3",
    duration: 2,
    rentCost: 30000,
    fnbCost: 0,
    total: 30000,
    cashier: "Kasir 1",
    status: "Lunas"
  },
  {
    id: "TRX-20261007-005",
    date: "2026-10-07",
    time: "18:00",
    customer: "Fajar Nugraha",
    phone: "089678123456",
    room: "VIP Room 2",
    duration: 5,
    rentCost: 125000,
    fnbCost: 20000,
    total: 145000,
    cashier: "Kasir 1",
    status: "Lunas"
  },
  {
    id: "TRX-20261006-006",
    date: "2026-10-06",
    time: "20:00",
    customer: "Rizky Ramadhan",
    phone: "081345678912",
    room: "PS Room 1",
    duration: 3,
    rentCost: 45000,
    fnbCost: 0,
    total: 45000,
    cashier: "Kasir 1",
    status: "Lunas"
  }
];

let currentData = [...defaultTransactions];

// Format Rupiah
function formatRupiah(num) {
  return "Rp " + Number(num).toLocaleString("id-ID");
}

// Render Tabel & Kartu
function renderTable(data) {
  const tbody = document.getElementById("reportTableBody");
  if (!tbody) return;

  tbody.innerHTML = "";

  if (data.length === 0) {
    tbody.innerHTML = '<tr><td colspan="11" class="text-center py-4 text-muted">' +
      '<i class="ti ti-database-off fs-2 d-block mb-2"></i>' +
      'Tidak ada data transaksi pada rentang filter ini.</td></tr>';
    updateSummaryCards(0, 0, 0, 0);
    return;
  }

  let totalRent = 0;
  let totalFnb = 0;
  let totalAll = 0;
  let totalHours = 0;

  data.forEach(function(trx, index) {
    totalRent += trx.rentCost;
    totalFnb += trx.fnbCost;
    totalAll += trx.total;
    totalHours += trx.duration;

    const tr = document.createElement("tr");
    tr.innerHTML = '<td>' + (index + 1) + '</td>' +
      '<td><span class="badge bg-light-secondary text-dark">' + trx.id + '</span></td>' +
      '<td>' + trx.date + ' <small class="text-muted">' + trx.time + '</small></td>' +
      '<td><strong>' + trx.customer + '</strong><br><small class="text-muted">' + trx.phone + '</small></td>' +
      '<td><span class="badge bg-light-info text-info">' + trx.room + '</span></td>' +
      '<td>' + trx.duration + ' Jam</td>' +
      '<td>' + formatRupiah(trx.rentCost) + '</td>' +
      '<td>' + formatRupiah(trx.fnbCost) + '</td>' +
      '<td><strong class="text-primary">' + formatRupiah(trx.total) + '</strong></td>' +
      '<td><span class="badge bg-light-success text-success">' + trx.status + '</span></td>' +
      '<td class="no-print text-center">' +
      '<button class="btn btn-sm btn-light-primary" title="Lihat Struk" onclick="viewReceipt(\'' + trx.id + '\')">' +
      '<i class="ti ti-receipt"></i> Struk</button></td>';
    tbody.appendChild(tr);
  });

  const tfootSewa = document.getElementById("tfootSewa");
  const tfootFnb = document.getElementById("tfootFnb");
  const tfootTotal = document.getElementById("tfootTotal");
  if (tfootSewa) tfootSewa.textContent = formatRupiah(totalRent);
  if (tfootFnb) tfootFnb.textContent = formatRupiah(totalFnb);
  if (tfootTotal) tfootTotal.textContent = formatRupiah(totalAll);

  updateSummaryCards(totalAll, data.length, totalHours, totalFnb);

  const badge = document.getElementById("dataCountBadge");
  if (badge) badge.textContent = "Menampilkan " + data.length + " Data";
}

function updateSummaryCards(totalUang, totalTrx, totalJam, totalFnb) {
  const c1 = document.getElementById("cardTotalPendapatan");
  const c2 = document.getElementById("cardTotalTransaksi");
  const c3 = document.getElementById("cardTotalJam");
  const c4 = document.getElementById("cardTotalFnb");
  if (c1) c1.textContent = formatRupiah(totalUang);
  if (c2) c2.textContent = totalTrx + " Transaksi";
  if (c3) c3.textContent = totalJam + " Jam";
  if (c4) c4.textContent = formatRupiah(totalFnb);
}

// Filter Logic
function applyFilter() {
  const startEl = document.getElementById("filterStartDate");
  const endEl = document.getElementById("filterEndDate");
  const roomEl = document.getElementById("filterRoom");

  const start = startEl ? startEl.value : "";
  const end = endEl ? endEl.value : "";
  const room = roomEl ? roomEl.value : "all";

  const filtered = defaultTransactions.filter(function(item) {
    const matchStart = !start || item.date >= start;
    const matchEnd = !end || item.date <= end;
    const matchRoom = room === "all" || item.room === room;
    return matchStart && matchEnd && matchRoom;
  });

  currentData = filtered;
  renderTable(filtered);
}

function resetFilter() {
  const startEl = document.getElementById("filterStartDate");
  const endEl = document.getElementById("filterEndDate");
  const roomEl = document.getElementById("filterRoom");
  if (startEl) startEl.value = "2026-10-01";
  if (endEl) endEl.value = "2026-10-08";
  if (roomEl) roomEl.value = "all";

  currentData = [...defaultTransactions];
  renderTable(currentData);
}

// Struk Pembayaran
function viewReceipt(id) {
  const trx = defaultTransactions.find(function(t) { return t.id === id; });
  if (!trx) return;

  const receiptHTML = '<div class="text-center mb-3">' +
    '<h5 class="fw-bold mb-0">PS RENTAL</h5>' +
    '<small>Sistem Informasi Rental PlayStation</small><br>' +
    '<small class="text-muted">Jl. Kampus TI No. 12, Telp: 0812-3456-7890</small>' +
    '</div>' +
    '<hr style="border-top: 1px dashed #000;">' +
    '<div class="small">' +
    '<div class="d-flex justify-content-between"><span>No. Nota:</span><strong>' + trx.id + '</strong></div>' +
    '<div class="d-flex justify-content-between"><span>Tanggal:</span><span>' + trx.date + ' ' + trx.time + '</span></div>' +
    '<div class="d-flex justify-content-between"><span>Kasir:</span><span>' + trx.cashier + '</span></div>' +
    '<div class="d-flex justify-content-between"><span>Pelanggan:</span><span>' + trx.customer + '</span></div>' +
    '</div>' +
    '<hr style="border-top: 1px dashed #000;">' +
    '<div class="small">' +
    '<div class="d-flex justify-content-between"><span>Sewa (' + trx.room + ' - ' + trx.duration + ' Jam):</span><span>' + formatRupiah(trx.rentCost) + '</span></div>' +
    '<div class="d-flex justify-content-between"><span>Makanan / Minuman:</span><span>' + formatRupiah(trx.fnbCost) + '</span></div>' +
    '</div>' +
    '<hr style="border-top: 1px dashed #000;">' +
    '<div class="d-flex justify-content-between fw-bold fs-6"><span>TOTAL:</span><span>' + formatRupiah(trx.total) + '</span></div>' +
    '<div class="d-flex justify-content-between small text-muted"><span>Status Pembayaran:</span><span class="text-success fw-bold">LUNAS</span></div>' +
    '<hr style="border-top: 1px dashed #000;">' +
    '<div class="text-center small text-muted mt-3">' +
    '<p class="mb-0">Terima kasih atas kunjungan Anda!</p>' +
    '<p class="mb-0">Selamat Bermain Kembali di PS Rental.</p>' +
    '</div>';

  document.getElementById("receiptContent").innerHTML = receiptHTML;
  const modal = new bootstrap.Modal(document.getElementById("receiptModal"));
  modal.show();
}

function printReceipt() {
  const content = document.getElementById("receiptContent").innerHTML;
  const printFrame = document.createElement("iframe");
  printFrame.style.position = "absolute";
  printFrame.style.width = "0px";
  printFrame.style.height = "0px";
  printFrame.style.border = "none";
  document.body.appendChild(printFrame);

  const frameDoc = printFrame.contentWindow || printFrame.contentDocument.document || printFrame.contentDocument;
  frameDoc.document.open();
  frameDoc.document.write(
    '<html><head><title>Struk Pembayaran</title>' +
    '<style>' +
    'body { font-family: monospace; padding: 20px; font-size: 13px; color: #111; }' +
    'hr { border: none; border-top: 1px dashed #444; margin: 12px 0; }' +
    '.text-center { text-align: center; }' +
    '.d-flex { display: flex; }' +
    '.justify-content-between { justify-content: space-between; }' +
    '.fw-bold { font-weight: bold; }' +
    '.small { font-size: 12px; }' +
    '.mt-3 { margin-top: 15px; }' +
    '.mb-0 { margin-bottom: 0; }' +
    '</style></head><body>' +
    content +
    '</body></html>'
  );
  frameDoc.document.close();

  setTimeout(function() {
    printFrame.contentWindow.focus();
    printFrame.contentWindow.print();
    setTimeout(function() {
      document.body.removeChild(printFrame);
    }, 1000);
  }, 250);
}

// Print & Export
function printLaporan() {
  const now = new Date();
  const printTs = document.getElementById("printTimestamp");
  if (printTs) {
    printTs.textContent = now.toLocaleDateString("id-ID", {
      weekday: "long", year: "numeric", month: "long", day: "numeric", hour: "2-digit", minute: "2-digit"
    });
  }
  window.print();
}

function exportCSV() {
  let csv = "No,No Nota,Tanggal,Jam,Pelanggan,No HP,Ruangan,Durasi (Jam),Biaya Sewa,F&B,Total,Kasir,Status\n";
  currentData.forEach(function(row, i) {
    csv += '"' + (i+1) + '","' + row.id + '","' + row.date + '","' + row.time + '","' + row.customer + '","' + row.phone + '","' + row.room + '","' + row.duration + '","' + row.rentCost + '","' + row.fnbCost + '","' + row.total + '","' + row.cashier + '","' + row.status + '"\n';
  });

  const blob = new Blob([csv], { type: "text/csv;charset=utf-8;" });
  const link = document.createElement("a");
  const url = URL.createObjectURL(blob);
  link.setAttribute("href", url);
  link.setAttribute("download", "Laporan_Rental_PS_" + new Date().toISOString().slice(0,10) + ".csv");
  link.style.visibility = "hidden";
  document.body.appendChild(link);
  link.click();
  document.body.removeChild(link);
}

// Auth & Real-Time Clock
document.addEventListener("DOMContentLoaded", function() {
  const role = localStorage.getItem("role");
  const username = localStorage.getItem("username");

  if (!role || !username) {
    window.location.href ="/logout";
    return;
  }

  const displayUsername = username || "Kasir";
  const displayRole = role === "superadmin" ? "Superadmin" : "Kasir";

  const sbUser = document.getElementById("sidebarUsername");
  const sbRole = document.getElementById("sidebarRole");
  const prCashier = document.getElementById("printCashier");
  if (sbUser) sbUser.textContent = displayUsername;
  if (sbRole) sbRole.textContent = displayRole;
  if (prCashier) prCashier.textContent = displayUsername;

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

  // Render tabel
  renderTable(currentData);
});

function logout() {
  if (confirm("Apakah Anda yakin ingin logout?")) {
    localStorage.removeItem("role");
    localStorage.removeItem("username");
    window.location.href ="/logout";
  }
}
