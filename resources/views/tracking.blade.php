<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Tracking | PS Rental</title>

  <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- BOOTSTRAP 5 -->
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
    rel="stylesheet">

  <!-- TABLER ICON -->
  <link rel="stylesheet" href="{{ asset('assets/fonts/tabler-icons.min.css') }}">

  <!-- FONT -->
  <link rel="stylesheet" href="{{ asset('assets/fonts/inter/inter.css') }}">

  <!-- TEMPLATE CSS (sama seperti halaman Ruangan, supaya font seragam) -->
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/style-preset.css') }}">

  <style>
    /* ================= GLOBAL ================= */
    body {
      background-color: #f8f9fa;
      color: #212529;
    }

    /* ================= SIDEBAR ================= */
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
      overflow-y: auto;
      transition: transform 0.25s ease;
    }

    .brand {
      font-size: 25px;
      font-weight: 700;
      color: #3b82f6;
      text-decoration: none;
      display: block;
      padding: 0 10px 25px;
    }

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
      background: #ffffff;
      border: 1px solid #e5e7eb;
      color: #dc3545;
      padding: 14px;
      border-radius: 12px;
      text-align: left;
    }

    /* ================= MAIN ================= */
    .main-content {
      margin-left: 280px;
      min-height: 100vh;
      transition: margin-left 0.25s ease;
    }

    .top-header {
      height: 80px;
      background: #ffffff;
      border-bottom: 1px solid #dee2e6;
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0 35px;
    }

    .header-date {
      color: #6c757d;
      font-size: 14px;
    }

    .content {
      padding: 35px;
    }

    /* ================= HAMBURGER ================= */
    .menu-toggle {
      border: none;
      background: transparent;
      font-size: 26px;
      line-height: 1;
      padding: 6px 8px;
      border-radius: 8px;
      color: #495057;
    }

    .menu-toggle:hover {
      background: #f1f5f9;
      color: #3b82f6;
    }

    body.sidebar-hidden .sidebar {
      transform: translateX(-100%);
    }

    body.sidebar-hidden .main-content {
      margin-left: 0;
    }


    /* =====================================================
       TRACKING WRAPPER
    ====================================================== */

    .tracking-wrapper {
      width: 100%;
      max-width: 1000px;
      margin: 0 auto;
    }


    /* =====================================================
       TRACKING CARD
    ====================================================== */

    .tracking-card {
      width: 100%;
      background: #ffffff;
      border: 1px solid #e5e7eb;
      border-radius: 10px;
      overflow: hidden;
    }


    /* =====================================================
       CARD HEADER
    ====================================================== */

    .tracking-header {
      padding: 18px 22px;
      border-bottom: 1px solid #eeeeee;
      background: #ffffff;
    }

    .tracking-header-left {
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .tracking-room-icon {
      font-size: 20px;
      color: #374151;
    }

    .tracking-room-title {
      font-size: 18px;
      font-weight: 600;
      color: #1f2937;
    }


    /* =====================================================
       STATUS
    ====================================================== */

    .status-badge {
      display: inline-block;
      padding: 6px 10px;
      border-radius: 5px;
      background: #e1f7ed;
      color: #179b63;
      font-size: 11px;
      font-weight: 500;
      white-space: nowrap;
    }


    /* =====================================================
       TRACKING BODY
    ====================================================== */

    .tracking-body {
      padding: 22px;
    }

    .tracking-main {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 60px;
    }


    /* =====================================================
       DETAIL CUSTOMER
    ====================================================== */

    .tracking-detail {
      flex: 1;
      max-width: 560px;
    }

    .detail-row {
      display: flex;
      align-items: center;
      margin-bottom: 14px;
      font-size: 13px;
    }

    .detail-row:last-child {
      margin-bottom: 0;
    }

    .detail-label {
      width: 70px;
      color: #374151;
    }

    .detail-separator {
      width: 25px;
      color: #9ca3af;
    }

    .detail-value {
      color: #374151;
      font-weight: 500;
    }


    /* =====================================================
       TIMER
    ====================================================== */

    .timer-wrapper {
      width: 150px;
      height: 150px;
      flex-shrink: 0;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .timer-ring {
      width: 145px;
      height: 145px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      position: relative;
      background:
        conic-gradient(
          #36b56f 0deg,
          #36b56f 290deg,
          #e7edf0 290deg,
          #e7edf0 360deg
        );
    }

    .timer-ring::before {
      content: "";
      position: absolute;
      width: 119px;
      height: 119px;
      border-radius: 50%;
      background: #ffffff;
    }

    .timer-content {
      position: relative;
      z-index: 2;
      text-align: center;
    }

    .timer-value {
      font-size: 19px;
      font-weight: 700;
      line-height: 1.2;
      color: #263238;
    }

    .timer-label {
      margin-top: 4px;
      font-size: 9px;
      color: #8b949e;
    }


    /* =====================================================
       DETAIL HARGA
    ====================================================== */

    .price-section {
      margin-top: 24px;
      border: 1px solid #e5e7eb;
      border-radius: 7px;
      overflow: hidden;
    }

    .price-header {
      padding: 12px 14px;
      background: #ffffff;
      border-bottom: 1px solid #eeeeee;
      color: #374151;
      font-size: 13px;
      font-weight: 600;
    }

    .price-row {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 12px 14px;
      border-bottom: 1px solid #f0f0f0;
      color: #374151;
      font-size: 12px;
    }

    .price-row:last-of-type {
      border-bottom: none;
    }

    .price-value {
      font-weight: 500;
    }


    /* =====================================================
       TOTAL
    ====================================================== */

    .total-section {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 13px 14px;
      background: #edf4f9;
      color: #374151;
      font-size: 13px;
      font-weight: 600;
    }

    .total-price {
      font-weight: 700;
    }


    /* =====================================================
       ACTION BUTTON
    ====================================================== */

    .tracking-actions {
      display: flex;
      align-items: center;
      gap: 8px;
      padding: 10px 16px;
      border-top: 1px solid #eeeeee;
      background: #ffffff;
    }

    .tracking-actions .btn {
      padding: 8px 11px;
      font-size: 11px;
      border-radius: 5px;
      cursor: pointer;
    }

    .btn-extend {
      background: #ffffff;
      border: 1px solid #d8dee4;
      color: #6b7280;
    }

    .btn-finish {
      background: #ffffff;
      border: 1px solid #e57373;
      color: #e53935;
    }


    /* =====================================================
       TABLET
    ====================================================== */

    @media (max-width: 991px) {

      .tracking-main {
        gap: 30px;
      }

      .tracking-wrapper {
        max-width: 100%;
      }

      /* Sidebar menjadi drawer */
      .sidebar {
        transform: translateX(-100%);
      }

      .sidebar.show {
        transform: translateX(0);
        box-shadow: 0 0 30px rgba(0, 0, 0, 0.15);
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
       MOBILE
    ====================================================== */

    @media (max-width: 767px) {

      .tracking-main {
        flex-direction: column;
        align-items: flex-start;
      }

      .timer-wrapper {
        align-self: center;
      }

      .tracking-actions {
        flex-wrap: wrap;
      }
    }
    /* ================= DITAMBAHKAN: POPUP KONFIRMASI LOGOUT ================= */
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

    /* =====================================================
       DITAMBAHKAN: KARTU RUANGAN YANG SEDANG DISEWA + POPUP
    ===================================================== */
    .rent-card {
      height: 100%;
      background: #ffffff;
      border: 1px solid #e5e7eb;
      border-radius: 14px;
      padding: 20px;
      cursor: pointer;
      transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
    }

    .rent-card:hover {
      transform: translateY(-3px);
      border-color: #cfe0ff;
      box-shadow: 0 10px 24px rgba(15, 23, 42, 0.08);
    }

    .rent-card:focus-visible { outline: 2px solid #3b82f6; outline-offset: 2px; }

    .rent-head { display: flex; align-items: flex-start; justify-content: space-between; gap: 10px; }
    .rent-title { display: flex; align-items: center; gap: 8px; font-size: 16px; font-weight: 600; color: #1f2937; }
    .rent-title i { font-size: 22px; color: #374151; }
    .rent-type { font-size: 11px; font-weight: 600; padding: 2px 8px; border-radius: 6px; background: #f1f5f9; color: #64748b; margin-left: 4px; }

    .rent-info { margin-top: 16px; font-size: 13px; color: #6b7280; }
    .rent-info div { margin-bottom: 6px; }
    .rent-info b { color: #374151; font-weight: 600; }

    .rent-time {
      margin-top: 14px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      font-size: 12px;
      color: #6b7280;
    }

    .rent-time .sisa { font-size: 15px; font-weight: 700; color: #263238; }

    .rent-bar { height: 6px; border-radius: 999px; background: #e7edf0; overflow: hidden; margin-top: 8px; }
    .rent-bar span { display: block; height: 100%; background: #36b56f; border-radius: 999px; transition: width 1s linear; }

    .rent-hint { margin-top: 14px; font-size: 12px; color: #3b82f6; display: flex; align-items: center; gap: 4px; }

    .rent-empty {
      background: #ffffff;
      border: 1px dashed #d8dee4;
      border-radius: 14px;
      padding: 56px 20px;
      text-align: center;
      color: #9ca3af;
    }

    .rent-empty i { font-size: 44px; display: block; margin-bottom: 10px; color: #cbd5e1; }

    #modalTracking .modal-content { border: 0; border-radius: 12px; overflow: hidden; box-shadow: 0 25px 60px rgba(15, 23, 42, 0.25); }
    #modalTracking .tracking-header { display: flex; align-items: center; justify-content: space-between; gap: 12px; }
    #modalTracking .btn-close { margin-left: 8px; }

    .extend-box {
      display: none;
      align-items: center;
      gap: 8px;
      flex-wrap: wrap;
      padding: 12px 16px;
      border-top: 1px solid #eeeeee;
      background: #f8fafc;
      font-size: 12px;
      color: #475569;
    }

    .extend-box.show { display: flex; }
    .extend-box .form-select { width: auto; font-size: 12px; padding: 5px 30px 5px 10px; }
    .extend-box .btn { font-size: 11px; padding: 7px 12px; border-radius: 5px; }
    .extend-note { width: 100%; color: #94a3b8; font-size: 11px; }

    .tracking-alert { font-size: 12px; padding: 8px 14px; margin: 0 22px 14px; border-radius: 8px; }

    /* =====================================================
       TAMPILAN LEBIH ELEGAN (menimpa gaya sebelumnya)
    ===================================================== */
    .page-title { font-weight: 700; letter-spacing: -0.01em; }

    .chip { display: inline-flex; align-items: center; gap: 8px; background: #ffffff; border: 1px solid #e5e7eb; border-radius: 999px; padding: 7px 16px 7px 12px; font-size: 13px; color: #475569; box-shadow: 0 1px 2px rgba(15, 23, 42, 0.04); }
    .chip b { color: #0f172a; font-weight: 700; }
    .chip .dot { width: 9px; height: 9px; border-radius: 50%; background: #e5484d; }

    /* ---- Status ---- */
    .status-badge { display: inline-flex; align-items: center; gap: 7px; padding: 5px 12px; border-radius: 999px; background: #e6f6ee; color: #177a4f; font-size: 12px; font-weight: 600; white-space: nowrap; }
    .status-badge::before { content: ""; width: 7px; height: 7px; border-radius: 50%; background: #22a06b; animation: denyut 1.6s ease-in-out infinite; }
    @keyframes denyut { 0%, 100% { box-shadow: 0 0 0 0 rgba(34, 160, 107, 0.45); } 50% { box-shadow: 0 0 0 5px rgba(34, 160, 107, 0); } }

    /* ---- Kartu ---- */
    .rent-card { border: 0; border-radius: 18px; padding: 22px; box-shadow: 0 1px 3px rgba(15, 23, 42, 0.06), 0 10px 28px rgba(15, 23, 42, 0.05); position: relative; overflow: hidden; }
    .rent-card::before { content: ""; position: absolute; left: 0; top: 0; bottom: 0; width: 4px; background: linear-gradient(180deg, #36b56f, #7ad8a4); }
    .rent-card:hover { transform: translateY(-4px); box-shadow: 0 2px 6px rgba(15, 23, 42, 0.06), 0 18px 36px rgba(15, 23, 42, 0.1); border-color: transparent; }

    .rent-title { gap: 12px; align-items: center; }
    .rent-icon { width: 44px; height: 44px; border-radius: 12px; background: #eaf1ff; color: #3b82f6; display: inline-flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .rent-icon i { font-size: 24px; color: #3b82f6; }
    .rent-name { font-size: 16px; font-weight: 700; color: #0f172a; line-height: 1.2; }
    .rent-type { margin-left: 0; margin-top: 4px; display: inline-block; }

    .rent-info { margin-top: 20px; padding-top: 18px; border-top: 1px solid #f0f2f5; display: flex; flex-direction: column; gap: 14px; }
    .rent-row { display: flex; align-items: center; gap: 12px; }
    .rent-avatar { width: 34px; height: 34px; border-radius: 50%; background: #3b82f6; color: #ffffff; font-size: 14px; font-weight: 700; display: inline-flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .rent-avatar.is-soft { background: #f1f5f9; color: #64748b; font-size: 17px; }
    .rent-label { font-size: 11.5px; color: #94a3b8; font-weight: 500; }
    .rent-value { font-size: 14px; color: #1f2937; font-weight: 600; }

    .rent-time { margin-top: 20px; padding: 14px 16px; background: #f6fbf8; border-radius: 12px; display: flex; align-items: center; justify-content: space-between; }
    .rent-time .sisa { font-size: 20px; font-weight: 700; color: #0f172a; letter-spacing: 0.02em; font-variant-numeric: tabular-nums; }
    .rent-bar { height: 7px; background: #e4ebe7; margin-top: 12px; }
    .rent-bar span { background: linear-gradient(90deg, #36b56f, #5cd08f); }
    .rent-hint { margin-top: 16px; color: #3b82f6; font-weight: 500; }

    .rent-empty { border-radius: 18px; background: #ffffff; border: 1px dashed #d5dbe3; padding: 64px 20px; }

    /* ---- Popup ---- */
    #modalTracking .modal-dialog { max-width: 720px; }
    #modalTracking .modal-content { border-radius: 20px; box-shadow: 0 30px 70px rgba(15, 23, 42, 0.3); }
    #modalTracking .tracking-header { padding: 20px 26px; background: linear-gradient(180deg, #f8fbff, #ffffff); border-bottom: 1px solid #eef0f3; }
    #modalTracking .tracking-room-icon { width: 38px; height: 38px; border-radius: 11px; background: #eaf1ff; color: #3b82f6; display: inline-flex; align-items: center; justify-content: center; font-size: 22px; }
    #modalTracking .tracking-room-title { font-size: 19px; font-weight: 700; color: #0f172a; }
    #modalTracking .tracking-header-left { gap: 12px; }

    #modalTracking .tracking-body { padding: 26px; }
    #modalTracking .tracking-main { gap: 40px; }
    #modalTracking .detail-row { font-size: 14px; margin-bottom: 16px; }
    #modalTracking .detail-label { width: 84px; color: #94a3b8; font-weight: 500; }
    #modalTracking .detail-separator { width: 22px; color: #cbd5e1; }
    #modalTracking .detail-value { color: #1f2937; font-weight: 600; }

    #modalTracking .timer-wrapper { width: 176px; height: 176px; }
    #modalTracking .timer-ring { width: 168px; height: 168px; box-shadow: 0 8px 22px rgba(54, 181, 111, 0.18); }
    #modalTracking .timer-ring::before { width: 138px; height: 138px; }
    #modalTracking .timer-value { font-size: 23px; letter-spacing: 0.02em; font-variant-numeric: tabular-nums; }
    #modalTracking .timer-label { font-size: 11px; margin-top: 5px; }

    #modalTracking .price-section { margin-top: 26px; border-radius: 14px; border-color: #e8ecf1; }
    #modalTracking .price-header { padding: 14px 18px; font-size: 12px; text-transform: uppercase; letter-spacing: 0.07em; color: #94a3b8; background: #ffffff; }
    #modalTracking .price-row { padding: 14px 18px; font-size: 14px; }
    #modalTracking .total-section { padding: 16px 18px; font-size: 15px; background: #eef4ff; color: #1e3a8a; }
    #modalTracking .total-price { font-size: 18px; }

    #modalTracking .tracking-actions { padding: 16px 26px 22px; gap: 10px; border-top: 1px solid #eef0f3; }
    #modalTracking .tracking-actions .btn { padding: 11px 20px; font-size: 13px; font-weight: 600; border-radius: 11px; transition: 0.2s; }
    #modalTracking .btn-extend { background: #ffffff; border: 1px solid #bcd3ff; color: #2f6fed; }
    #modalTracking .btn-extend:hover:not(:disabled) { background: #eaf1ff; border-color: #3b82f6; }
    #modalTracking .btn-extend:disabled { opacity: 0.45; cursor: not-allowed; }
    #modalTracking .btn-finish { background: #e5484d; border: 1px solid #e5484d; color: #ffffff; }
    #modalTracking .btn-finish:hover:not(:disabled) { background: #c93a3f; border-color: #c93a3f; }
    #modalTracking .btn-finish:disabled { opacity: 0.6; }

    .extend-box { padding: 14px 26px; background: #f5f8ff; border-top: 1px solid #e3ecff; font-size: 13px; }
    .extend-box .form-select { font-size: 13px; padding: 7px 32px 7px 12px; border-radius: 10px; }
    .extend-box .btn { font-size: 12.5px; padding: 8px 16px; border-radius: 10px; }
    .extend-note { font-size: 12px; }
    .tracking-alert { margin: 0 26px 16px; font-size: 13px; border-radius: 10px; }

    @media (max-width: 767px) {
      #modalTracking .timer-wrapper { align-self: center; }
      #modalTracking .tracking-body { padding: 20px; }
      #modalTracking .tracking-header { padding: 16px 20px; }
      #modalTracking .tracking-actions { padding: 14px 20px 20px; }
    }
  </style>
</head>

<body>
  <!-- =========================================================
       POPUP DETAIL SEWA (muncul saat kartu ruangan diklik)
  ========================================================== -->
  <div class="modal fade" id="modalTracking" tabindex="-1" aria-labelledby="trkRuangan" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">

        <!-- HEADER -->
        <div class="tracking-header">
          <div class="tracking-header-left">
            <i class="ti ti-device-gamepad tracking-room-icon"></i>
            <span class="tracking-room-title" id="trkRuangan">-</span>
          </div>
          <div class="d-flex align-items-center">
            <span class="status-badge">Sedang Digunakan</span>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
          </div>
        </div>

        <!-- BODY -->
        <div class="tracking-body">

          <div class="tracking-main">

            <div class="tracking-detail">
              <div class="detail-row">
                <span class="detail-label">Customer</span>
                <span class="detail-separator">:</span>
                <span class="detail-value" id="trkCustomer">-</span>
              </div>
              <div class="detail-row">
                <span class="detail-label">Mulai</span>
                <span class="detail-separator">:</span>
                <span class="detail-value" id="trkMulai">-</span>
              </div>
              <div class="detail-row">
                <span class="detail-label">Selesai</span>
                <span class="detail-separator">:</span>
                <span class="detail-value" id="trkSelesai">-</span>
              </div>
              <div class="detail-row">
                <span class="detail-label">Durasi</span>
                <span class="detail-separator">:</span>
                <span class="detail-value" id="trkDurasi">-</span>
              </div>
            </div>

            <div class="timer-wrapper">
              <div class="timer-ring" id="trkRing">
                <div class="timer-content">
                  <div class="timer-value" id="trkTimer">00:00:00</div>
                  <div class="timer-label">Sisa waktu</div>
                </div>
              </div>
            </div>

          </div>

          <div class="price-section">
            <div class="price-header">Detail Harga</div>

            <div class="price-row">
              <span id="trkLabelSewa">Sewa Ruangan</span>
              <span class="price-value" id="trkHargaSewa">Rp 0</span>
            </div>

            <div class="total-section">
              <span>Total</span>
              <span class="total-price" id="trkTotal">Rp 0</span>
            </div>
          </div>

        </div>

        <div id="trkAlert" class="alert alert-danger tracking-alert d-none" role="alert"></div>

        <!-- PERPANJANG WAKTU -->
        <div class="extend-box" id="extendBox">
          <span>Tambah waktu:</span>
          <select class="form-select" id="trkTambah"></select>
          <button type="button" class="btn btn-primary" id="btnKonfirmasiPerpanjang">Perpanjang</button>
          <button type="button" class="btn btn-light border" id="btnBatalPerpanjang">Batal</button>
          <span class="extend-note" id="extendNote"></span>
        </div>

        <!-- TOMBOL AKSI -->
        <div class="tracking-actions">
          <button type="button" class="btn btn-extend" id="btnPerpanjang">
            <i class="ti ti-clock-plus me-1"></i>
            Perpanjang Waktu
          </button>

          <button type="button" class="btn btn-finish" id="btnSelesaikan">
            <i class="ti ti-circle-check me-1"></i>
            Selesaikan Sewa
          </button>
        </div>

      </div>
    </div>
  </div>


  <!-- =========================================================
       SIDEBAR
  ========================================================== -->
  <aside class="sidebar" id="sidebar">

    <!-- LOGO -->
    <a href="/dashboard" class="brand">PS Rental</a>

    <!-- USER CARD + LOGOUT (satu baris) -->
    <div style="display: flex; gap: 10px; align-items: stretch; margin-bottom: 25px;">

    <div class="user-card" onclick="window.location.href='/profil'" style="cursor:pointer; margin-bottom:0; flex:1; min-width:0;" title="Profil Saya">
      <div class="d-flex align-items-center">
        <img
          src="{{ asset('assets/images/user/avatar-1.jpg') }}"
          class="user-avatar"
          alt="user">

        <div class="ms-3">
          <div class="user-name" id="sidebarUsername">kasir</div>
          <div class="user-role" id="sidebarRole">Kasir</div>
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
    <div class="menu-title">Menu</div>

    <ul class="sidebar-menu">

      <li>
        <a href="/dashboard">
          <i class="ti ti-home"></i>
          <span>Dashboard</span>
        </a>
      </li>

      <li>
        <a href="/booking">
          <i class="ti ti-calendar-event"></i>
          <span>Booking</span>
        </a>
      </li>

      <li>
        <a href="/ruangan">
          <i class="ti ti-device-gamepad"></i>
          <span>Ruangan</span>
        </a>
      </li>

      <li>
        <a href="/tracking" class="active">
          <i class="ti ti-receipt"></i>
          <span>Tracking</span>
        </a>
      </li>

      <li>
        <a href="/laporan">
          <i class="ti ti-report"></i>
          <span>Laporan</span>
        </a>
      </li>

    </ul>

  </aside>


  <!-- =========================================================
       MAIN
  ========================================================== -->
  <main class="main-content">

    <!-- HEADER -->
    <header class="top-header">

      <!-- HAMBURGER -->
      <div>
        <button type="button" class="menu-toggle" id="menuToggle" aria-label="Toggle sidebar">
          <i class="ti ti-menu-2"></i>
        </button>
      </div>

      <div class="header-date d-flex align-items-center gap-3">
        <span>
          <i class="ti ti-calendar me-1"></i>
          <span id="currentDate">-</span>
        </span>
        <span>
          <i class="ti ti-clock me-1"></i>
          <span id="currentTime">-</span>
        </span>
      </div>

    </header>

    <!-- CONTENT -->
    <div class="content">

      <!-- PAGE TITLE -->
      <div class="d-flex flex-wrap justify-content-between align-items-end gap-3 mb-4">
        <div>
          <h4 class="page-title mb-1">Tracking Sewa</h4>
          <p class="text-muted mb-0">Pantau waktu sewa ruangan yang sedang digunakan.</p>
        </div>
        <span class="chip"><span class="dot"></span> Sedang disewa <b id="chipSewa">0</b></span>
      </div>

      <!-- NOTIFIKASI -->
      <div id="notifTracking" class="alert d-none py-2 small" role="alert"></div>

      <!-- DAFTAR RUANGAN YANG SEDANG DISEWA -->
      <div class="row g-3" id="daftarSewa">
        <div class="col-12">
          <div class="rent-empty">
            <i class="ti ti-loader-2"></i>
            Memuat data sewa...
          </div>
        </div>
      </div>

    </div>

  </main>

  <!-- =========================================================
       DITAMBAHKAN: POPUP KONFIRMASI LOGOUT (TENGAH HALAMAN)
  ========================================================== -->
  <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalTitle" aria-hidden="true">
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
          <button type="button" class="btn btn-logout-cancel" data-bs-dismiss="modal">Tidak</button>
          <button type="button" class="btn btn-logout-confirm" id="confirmLogoutBtn">Ya</button>
        </div>

      </div>
    </div>
  </div>


  <!-- =========================================================
       JAVASCRIPT
  ========================================================== -->

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    // Toggle sidebar (desktop & mobile)
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

    // Tanggal & jam
    function updateDateTime() {
      const now = new Date();

      document.getElementById("currentDate").textContent =
        now.toLocaleDateString("id-ID", {
          weekday: "long",
          year: "numeric",
          month: "long",
          day: "numeric"
        });

      document.getElementById("currentTime").textContent =
        now.toLocaleTimeString("id-ID", {
          hour: "2-digit",
          minute: "2-digit",
          second: "2-digit"
        });
    }

    updateDateTime();
    setInterval(updateDateTime, 1000);

    // DIUBAH: confirm() bawaan browser diganti popup di tengah halaman.
    // Proses logout (hapus role & username, lalu ke /logout) tidak berubah,
    // hanya dijalankan saat tombol "Ya, Logout" diklik.
    function logout() {
      bootstrap.Modal.getOrCreateInstance(
        document.getElementById("logoutModal")
      ).show();
    }

    document.getElementById("confirmLogoutBtn").addEventListener("click", function () {
      localStorage.removeItem("role");
      localStorage.removeItem("username");
      window.location.href = "/logout";
    });
  
    /* =====================================================
       DITAMBAHKAN: DAFTAR SEWA, POPUP DETAIL, PERPANJANG, SELESAI
    ===================================================== */
    (function () {

      var csrf       = document.querySelector('meta[name="csrf-token"]').content;
      var elDaftar   = document.getElementById("daftarSewa");
      var elNotif    = document.getElementById("notifTracking");
      var elModal    = document.getElementById("modalTracking");
      var modal      = bootstrap.Modal.getOrCreateInstance(elModal);
      var elAlert    = document.getElementById("trkAlert");
      var elExtend   = document.getElementById("extendBox");
      var elTambah   = document.getElementById("trkTambah");
      var btnPerpanjang = document.getElementById("btnPerpanjang");
      var btnSelesaikan = document.getElementById("btnSelesaikan");
      var btnKonfirmasi = document.getElementById("btnKonfirmasiPerpanjang");

      var daftar     = [];     // data sewa terakhir dari server
      var diambilPada = Date.now();
      var aktifId    = null;   // id_booking yang sedang dibuka di popup
      var timerNotif = null;

      function rupiah(n) { return "Rp " + Number(n).toLocaleString("id-ID"); }
      function pad(n) { return String(n).padStart(2, "0"); }

      function hms(detik) {
        detik = Math.max(0, detik);
        return pad(Math.floor(detik / 3600)) + ":" + pad(Math.floor((detik % 3600) / 60)) + ":" + pad(detik % 60);
      }

      function el(tag, kelas, teks) {
        var e = document.createElement(tag);
        if (kelas) e.className = kelas;
        if (teks !== undefined) e.textContent = teks;
        return e;
      }

      // Sisa detik yang diperbarui terus tanpa menunggu server
      function sisaSekarang(s) {
        return Math.max(0, s.sisa_detik - Math.floor((Date.now() - diambilPada) / 1000));
      }

      function tampilNotif(teks, sukses) {
        elNotif.className = "alert py-2 small " + (sukses ? "alert-success" : "alert-danger");
        elNotif.textContent = teks;
        clearTimeout(timerNotif);
        timerNotif = setTimeout(function () { elNotif.classList.add("d-none"); }, 5000);
      }

      function tampilAlertModal(teks) {
        elAlert.textContent = teks;
        elAlert.classList.remove("d-none");
      }

      function cariAktif() {
        for (var i = 0; i < daftar.length; i++) {
          if (daftar[i].id_booking === aktifId) return daftar[i];
        }
        return null;
      }

      /* ---------- KARTU ---------- */
      function gambarKartu() {

        elDaftar.innerHTML = "";
        document.getElementById("chipSewa").textContent = daftar.length;

        if (!daftar.length) {
          var kosong = el("div", "col-12");
          var box = el("div", "rent-empty");
          box.appendChild(el("i", "ti ti-device-gamepad"));
          box.appendChild(document.createTextNode("Belum ada ruangan yang sedang disewa."));
          kosong.appendChild(box);
          elDaftar.appendChild(kosong);
          return;
        }

        daftar.forEach(function (s) {

          var kol  = el("div", "col-md-6 col-xl-4");
          var kartu = el("div", "rent-card");
          kartu.tabIndex = 0;
          kartu.setAttribute("role", "button");

          var head = el("div", "rent-head");
          var kiri = el("div", "rent-title");

          var ikon = el("span", "rent-icon");
          ikon.appendChild(el("i", "ti ti-device-gamepad"));
          kiri.appendChild(ikon);

          var nm = el("div");
          nm.appendChild(el("div", "rent-name", s.nama_ruangan));
          nm.appendChild(el("span", "rent-type", s.jenis_ruangan));
          kiri.appendChild(nm);

          head.appendChild(kiri);
          head.appendChild(el("span", "status-badge", "Sedang Digunakan"));
          kartu.appendChild(head);

          var info = el("div", "rent-info");

          var barisCust = el("div", "rent-row");
          barisCust.appendChild(el("span", "rent-avatar", (s.customer || "?").trim().charAt(0).toUpperCase()));
          var teksCust = el("div");
          teksCust.appendChild(el("div", "rent-label", "Customer"));
          teksCust.appendChild(el("div", "rent-value", s.customer));
          barisCust.appendChild(teksCust);
          info.appendChild(barisCust);

          var barisJam = el("div", "rent-row");
          var ikonJam = el("span", "rent-avatar is-soft");
          ikonJam.appendChild(el("i", "ti ti-clock"));
          barisJam.appendChild(ikonJam);
          var teksJam = el("div");
          teksJam.appendChild(el("div", "rent-label", "Jam sewa"));
          teksJam.appendChild(el("div", "rent-value", s.mulai + " - " + s.selesai + " (" + s.durasi_jam + " jam)"));
          barisJam.appendChild(teksJam);
          info.appendChild(barisJam);

          kartu.appendChild(info);

          var waktu = el("div", "rent-time");
          waktu.appendChild(el("span", "rent-label", "Sisa waktu"));
          var sisa = el("span", "sisa", "--:--:--");
          sisa.setAttribute("data-sisa", s.id_booking);
          waktu.appendChild(sisa);
          kartu.appendChild(waktu);

          var bar = el("div", "rent-bar");
          var isi = el("span");
          isi.setAttribute("data-bar", s.id_booking);
          bar.appendChild(isi);
          kartu.appendChild(bar);

          var hint = el("div", "rent-hint");
          hint.appendChild(el("i", "ti ti-click"));
          hint.appendChild(document.createTextNode("Klik untuk melihat detail"));
          kartu.appendChild(hint);

          kartu.addEventListener("click", function () { bukaPopup(s.id_booking); });
          kartu.addEventListener("keydown", function (e) {
            if (e.key === "Enter" || e.key === " ") { e.preventDefault(); bukaPopup(s.id_booking); }
          });

          kol.appendChild(kartu);
          elDaftar.appendChild(kol);
        });
      }

      /* ---------- HITUNG MUNDUR (tiap detik) ---------- */
      function detak() {

        var habis = false;

        daftar.forEach(function (s) {
          var sisa = sisaSekarang(s);
          var persen = Math.max(0, Math.min(100, sisa / s.total_detik * 100));

          var elSisa = document.querySelector('[data-sisa="' + s.id_booking + '"]');
          var elBar  = document.querySelector('[data-bar="' + s.id_booking + '"]');
          if (elSisa) elSisa.textContent = hms(sisa);
          if (elBar) elBar.style.width = persen + "%";

          if (sisa === 0) habis = true;
        });

        // Popup: timer dan cincin
        var s = cariAktif();
        if (s && elModal.classList.contains("show")) {
          var sisaModal = sisaSekarang(s);
          var derajat = Math.max(0, Math.min(360, sisaModal / s.total_detik * 360));

          document.getElementById("trkTimer").textContent = hms(sisaModal);
          document.getElementById("trkRing").style.background =
            "conic-gradient(#36b56f 0deg, #36b56f " + derajat + "deg, #e7edf0 " + derajat + "deg, #e7edf0 360deg)";
        }

        // Waktu salah satu sewa habis: muat ulang supaya kartunya hilang sendiri
        if (habis && !detak.sedangMuat) {
          detak.sedangMuat = true;
          muat().then(function () { detak.sedangMuat = false; });
        }
      }

      /* ---------- AMBIL DATA ---------- */
      async function muat() {
        try {
          var res = await fetch("/tracking/data", { headers: { "Accept": "application/json" } });

          if (res.status === 401) { window.location.href = "/logout"; return; }

          if (!res.ok) {
            tampilNotif("Gagal memuat data tracking.", false);
            return;
          }

          daftar = await res.json();
          diambilPada = Date.now();
          gambarKartu();
          detak();

          // Sewa yang sedang dibuka di popup sudah selesai: tutup popup
          if (aktifId !== null && !cariAktif()) {
            modal.hide();
            aktifId = null;
          } else if (aktifId !== null) {
            isiPopup(cariAktif(), false);
          }

        } catch (e) {
          tampilNotif("Tidak dapat terhubung ke server.", false);
        }
      }

      /* ---------- POPUP ---------- */
      function isiPopup(s, resetForm) {
        document.getElementById("trkRuangan").textContent  = s.nama_ruangan;
        document.getElementById("trkCustomer").textContent = s.customer;
        document.getElementById("trkMulai").textContent    = s.mulai;
        document.getElementById("trkSelesai").textContent  = s.selesai;
        document.getElementById("trkDurasi").textContent   = s.durasi_jam + " Jam";

        document.getElementById("trkLabelSewa").textContent = "Sewa Ruangan (" + s.durasi_jam + " Jam)";
        document.getElementById("trkHargaSewa").textContent = rupiah(s.total_sewa);
        document.getElementById("trkTotal").textContent     = rupiah(s.total_sewa);

        if (resetForm) {
          elAlert.classList.add("d-none");
          elExtend.classList.remove("show");
        }

        // Tombol Perpanjang nonaktif kalau tidak ada waktu yang bisa ditambah
        btnPerpanjang.disabled = s.maks_tambah < 1;
        btnPerpanjang.title = s.maks_tambah < 1
          ? "Tidak bisa diperpanjang: ada booking berikutnya atau sudah mendekati pukul 24.00"
          : "";
      }

      function bukaPopup(id) {
        aktifId = id;
        var s = cariAktif();
        if (!s) return;

        btnSelesaikan.disabled = false;
        isiPopup(s, true);
        modal.show();
        detak();
      }

      elModal.addEventListener("hidden.bs.modal", function () { aktifId = null; });

      /* ---------- PERPANJANG WAKTU ---------- */
      btnPerpanjang.addEventListener("click", function () {
        var s = cariAktif();
        if (!s || s.maks_tambah < 1) return;

        elTambah.innerHTML = "";
        for (var n = 1; n <= s.maks_tambah; n++) {
          var o = document.createElement("option");
          o.value = n;
          o.textContent = "+" + n + " jam (" + rupiah(s.tarif_per_jam * n) + ")";
          elTambah.appendChild(o);
        }

        document.getElementById("extendNote").textContent =
          "Maksimal " + s.maks_tambah + " jam karena ada booking berikutnya atau batas pukul 24.00.";

        elAlert.classList.add("d-none");
        elExtend.classList.add("show");
      });

      document.getElementById("btnBatalPerpanjang").addEventListener("click", function () {
        elExtend.classList.remove("show");
      });

      async function kirim(url, body) {
        var opsi = {
          method: "POST",
          headers: { "Accept": "application/json", "X-CSRF-TOKEN": csrf }
        };

        if (body) {
          opsi.headers["Content-Type"] = "application/json";
          opsi.body = JSON.stringify(body);
        }

        var res = await fetch(url, opsi);

        if (res.status === 401) { window.location.href = "/logout"; return null; }

        var data = {};
        try { data = await res.json(); } catch (e) {}

        if (!res.ok && data.errors) {
          data.message = Object.values(data.errors)[0][0];
        }

        return { ok: res.ok, data: data };
      }

      btnKonfirmasi.addEventListener("click", async function () {
        if (aktifId === null) return;

        btnKonfirmasi.disabled = true;
        elAlert.classList.add("d-none");

        try {
          var hasil = await kirim("/booking/" + aktifId + "/perpanjang",
                                  { tambah_jam: parseInt(elTambah.value, 10) });
          if (!hasil) return;

          if (!hasil.ok) {
            tampilAlertModal(hasil.data.message || "Gagal memperpanjang waktu.");
            await muat();
            return;
          }

          elExtend.classList.remove("show");
          tampilNotif(hasil.data.message || "Waktu sewa diperpanjang.", true);
          await muat();

        } catch (e) {
          tampilAlertModal("Tidak dapat terhubung ke server.");
        } finally {
          btnKonfirmasi.disabled = false;
        }
      });

      /* ---------- SELESAIKAN SEWA ---------- */
      btnSelesaikan.addEventListener("click", async function () {
        if (aktifId === null) return;

        btnSelesaikan.disabled = true;
        elAlert.classList.add("d-none");

        try {
          var hasil = await kirim("/booking/" + aktifId + "/selesai");
          if (!hasil) return;

          if (!hasil.ok) {
            tampilAlertModal(hasil.data.message || "Gagal menyelesaikan sewa.");
            await muat();
            return;
          }

          modal.hide();
          aktifId = null;
          tampilNotif("Sewa berhasil diselesaikan dan masuk ke laporan.", true);
          await muat();

        } catch (e) {
          tampilAlertModal("Tidak dapat terhubung ke server.");
        } finally {
          btnSelesaikan.disabled = false;
        }
      });

      muat();
      setInterval(detak, 1000);    // hitung mundur tiap detik
      setInterval(muat, 30000);    // sinkron dengan server tiap 30 detik

    })();
  </script>

</body>

</html>