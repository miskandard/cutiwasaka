<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Data Cuti</title>

    <link rel="icon" type="image/png" href="{{ asset('img/logo/wg.png') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        .table-box {
            background: white;
            padding: 20px;
            border-radius: 12px;
            margin-top: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        }

        .table-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .filter-box {
            display: flex;
            gap: 12px;
            align-items: center;
        }

        .filter-box select,
        .filter-box input {
            padding: 10px 14px;
            border: 1px solid #dcdcdc;
            border-radius: 8px;
            outline: none;
            background: #fff;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th {
            background: #f1f3f6;
            padding: 14px;
            text-align: left;
            color: #0d1f6b;
        }

        table td {
            padding: 14px;
            border-bottom: 1px solid #eee;
        }

        .status {
            display: inline-block;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 700;
        }

        .status.menunggu {
            background: #fef3c7;
            color: #b45309;
        }

        .status.disetujui {
            background: #dcfce7;
            color: #166534;
        }

        .status.ditolak {
            background: #fee2e2;
            color: #dc2626;
        }

        .btn-detail {
            background: #1e2a78;
            color: white;
            border: none;
            padding: 7px 14px;
            border-radius: 7px;
            cursor: pointer;
            font-weight: 600;
        }

        .modal-detail {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.45);
            z-index: 999;
            justify-content: center;
            align-items: center;
        }

        .modal-box {
            background: white;
            width: 700px;
            max-width: 90%;
            border-radius: 18px;
            padding: 30px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.18);
        }

        .modal-box h2 {
            color: #1e2a78;
            margin-bottom: 20px;
        }

        .detail-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .detail-item {
            background: #f7f9ff;
            padding: 14px;
            border-radius: 12px;
        }

        .detail-item span {
            display: block;
            font-size: 13px;
            color: #777;
            margin-bottom: 6px;
        }

        .detail-item strong {
            color: #1e2a78;
        }

        .detail-alasan {
            background: #f7f9ff;
            padding: 14px;
            border-radius: 12px;
            margin-top: 16px;
        }

        .btn-close {
            margin-top: 18px;
            background: #777;
            color: white;
            border: none;
            padding: 10px 18px;
            border-radius: 8px;
            cursor: pointer;
        }

        .theme-toggle-top {
            background: #eef2ff;
            padding: 4px;
            border-radius: 30px;
            display: flex;
            gap: 4px;
            align-items: center;
        }

        .theme-toggle-top button {
            width: 30px;
            height: 30px;
            border: none;
            border-radius: 50%;
            cursor: pointer;
            background: transparent;
            color: #1e2a78;
        }

        .theme-toggle-top button.active {
            background: #1e2a78;
            color: white;
        }

        .status {
            padding: 6px 14px;
            border-radius: 20px;
            color: white;
            font-size: 13px;
            font-weight: bold;
            display: inline-block;
        }

        .menunggu {
            background: #facc15;
        }

        .disetujui {
            background: #22c55e;
        }

        .ditolak {
            background: #ef4444;
        }

        .status.diproses {
            background: #06b6d4;
            color: white !important;
        }

        .notif-wrapper {
            position: relative;
        }

        .notif-btn {
            position: relative;
            width: 42px;
            height: 42px;
            border: none;
            border-radius: 50%;
            background: #f1f4ff;
            color: #1e2a78;
            cursor: pointer;
            font-size: 18px;
        }

        .notif-badge {
            position: absolute;
            top: -6px;
            right: -6px;
            background: #e11d48;
            color: white;
            font-size: 11px;
            font-weight: 700;
            padding: 3px 6px;
            border-radius: 999px;
        }

        .notif-dropdown {
            display: none;
            position: absolute;
            top: 52px;
            right: 0;
            width: 340px;
            max-height: 420px;
            overflow-y: auto;
            background: white;
            border-radius: 16px;
            box-shadow: 0 12px 35px rgba(0, 0, 0, 0.15);
            z-index: 999;
        }

        .notif-header {
            padding: 16px 18px;
            border-bottom: 1px solid #eee;
        }

        .notif-header h4 {
            margin: 0;
            color: #1e2a78;
        }

        .notif-item {
            padding: 14px 18px;
            border-bottom: 1px solid #f1f1f1;
        }

        .notif-item:hover {
            background: #f8faff;
        }

        .notif-unread {
            background: #eef3ff;
        }

        .notif-title {
            font-size: 14px;
            font-weight: 600;
            color: #1e2a78;
            line-height: 1.5;
        }

        .notif-time {
            font-size: 12px;
            color: #888;
            margin-top: 4px;
        }

        .notif-empty {
            padding: 20px;
            text-align: center;
            color: #777;
        }

        .sidebar a {
            display: flex !important;
            align-items: center !important;
            gap: 8px !important;

            height: 44px !important;
            padding: 0 22px !important;
            margin: 8px 0 !important;

            line-height: 44px !important;
        }

        .sidebar a i {
            width: 18px !important;
            text-align: center !important;
        }

        /* =========================
   DARK MODE
========================= */

        body.dark-mode {
            background: #0f172a;
            color: white;
        }

        /* MAIN CONTENT */

        body.dark-mode .main-content {
            background: #0f172a;
        }

        /* CARD & BOX */

        body.dark-mode .topbar,
        body.dark-mode .welcome-bar,
        body.dark-mode .card,
        body.dark-mode .table-box,
        body.dark-mode .notif-dropdown {
            background: #111827;
            color: white;
            border: 1px solid #1f2937;
        }

        /* TEXT */

        body.dark-mode td,
        body.dark-mode th,
        body.dark-mode p,
        body.dark-mode h1,
        body.dark-mode h2,
        body.dark-mode h3,
        body.dark-mode span,
        body.dark-mode label {
            color: white;
        }

        /* TABLE */

        body.dark-mode table {
            width: 100%;
            border-collapse: collapse;
            color: white;
        }

        /* HEADER TABLE */

        body.dark-mode table thead {
            background: linear-gradient(90deg,
                    #172033,
                    #1e293b) !important;
        }

        body.dark-mode table thead th {
            color: #000 !important;
            font-weight: 700;
            font-size: 14px;
            padding: 18px 14px;
            border-bottom: 1px solid #374151;
        }

        /* BODY TABLE */

        body.dark-mode table tbody tr {
            background: transparent;
            transition: 0.2s;
        }

        body.dark-mode table tbody tr:hover {
            background: #1e293b;
        }

        body.dark-mode table tbody td {
            color: white !important;
            padding: 16px 14px;
            border-bottom: 1px solid #374151;
        }

        /* NOTIF */

        body.dark-mode .notif-title {
            color: white;
        }

        body.dark-mode .notif-time {
            color: #cbd5e1;
        }

        body.dark-mode .notif-item {
            border-bottom: 1px solid #374151;
        }

        body.dark-mode .notif-item:hover {
            background: #1e293b;
        }

        body.dark-mode .notif-unread {
            background: #172033;
        }

        /* THEME TOGGLE */

        body.dark-mode .theme-toggle-top {
            background: #1e293b;
        }

        body.dark-mode .theme-toggle-top button {
            color: white;
        }

        body.dark-mode .theme-toggle-top button.active {
            background: #2563eb;
            color: white;
        }

        /* INPUT */

        body.dark-mode input,
        body.dark-mode select,
        body.dark-mode textarea {
            background: #1e293b;
            color: white;
            border: 1px solid #374151;
        }

        body.dark-mode input::placeholder {
            color: #94a3b8;
        }

        /* SIDEBAR */

        body.dark-mode .sidebar {
            background: linear-gradient(180deg,
                    #111827,
                    #0f172a);
        }

        /* BUTTON */

        body.dark-mode .btn-detail {
            background: #1d4ed8;
            color: white;
        }

        body.dark-mode .btn-detail:hover {
            background: #2563eb;
        }

        /* STATUS */

        body.dark-mode .status.menunggu {
            background: #eab308;
            color: #111827;
        }

        body.dark-mode .status.disetujui {
            background: #22c55e;
            color: white;
        }

        body.dark-mode .status.ditolak {
            background: #ef4444;
            color: white;
        }

        .welcome-bar {
            transition: 0.3s ease;
        }

        /* PERBAIKAN TABEL DARK MODE */
        body.dark-mode .table-box,
        body.dark-mode .card,
        body.dark-mode .card-body {
            background: #111827 !important;
            color: #ffffff !important;
            box-shadow: none !important;
        }

        body.dark-mode .table-header h3 {
            color: #ffffff !important;
        }

        body.dark-mode table,
        body.dark-mode .table {
            background: #111827 !important;
            color: #ffffff !important;
        }

        body.dark-mode table thead tr,
        body.dark-mode .table thead tr {
            background: #1f2937 !important;
        }

        body.dark-mode table thead th,
        body.dark-mode .table thead th {
            background: #1f2937 !important;
            color: #ffffff !important;
            border-bottom: 1px solid #374151 !important;
        }

        body.dark-mode table tbody tr,
        body.dark-mode .table tbody tr {
            background: #111827 !important;
        }

        body.dark-mode table tbody td,
        body.dark-mode .table tbody td {
            background: #111827 !important;
            color: #ffffff !important;
            border-bottom: 1px solid #374151 !important;
        }

        body.dark-mode .filter-box input,
        body.dark-mode .filter-box select,
        body.dark-mode .search-box input {
            background: #111827 !important;
            color: #ffffff !important;
            border: 1px solid #374151 !important;
        }

        body.dark-mode .filter-box input::placeholder,
        body.dark-mode .search-box input::placeholder {
            color: #cbd5e1 !important;
        }



        body.dark-mode .main-content {
            background: #0f172a !important;
        }


        .theme-toggle-top {
            display: flex;
            align-items: center;
            background: #eef2ff;
            border-radius: 999px;
            padding: 4px;
            gap: 4px;
            width: max-content;
        }

        .theme-toggle-top button {
            width: 36px;
            height: 36px;
            border: none;
            border-radius: 50%;
            background: transparent;
            cursor: pointer;
            transition: 0.3s;
            color: #1e2a78;
            font-size: 15px;
        }

        .theme-toggle-top button.active {
            background: #1e2a78;
            color: white;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        }

        .logout-modal {
            position: fixed;
            inset: 0;

            background: rgba(0, 0, 0, .45);
            backdrop-filter: blur(4px);

            display: none;
            justify-content: center;
            align-items: center;

            z-index: 999999;
        }

        .logout-box {
            width: 430px;
            background: #fff;

            border-radius: 12px;

            padding: 35px;

            text-align: center;

            animation: logoutShow .3s ease;
        }

        .logout-icon {
            width: 70px;
            height: 70px;

            margin: auto;

            border: 3px solid #cfe6ef;
            border-radius: 50%;

            display: flex;
            justify-content: center;
            align-items: center;

            color: #7ca0af;
            font-size: 32px;
        }

        .logout-box h2 {
            margin-top: 20px;
            margin-bottom: 10px;
            color: #444;
        }

        .logout-box p {
            color: #666;
            margin-bottom: 25px;
        }

        .logout-buttons {
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        .btn-logout {
            background: #e76f51;
            color: #fff;

            padding: 12px 25px;

            border-radius: 6px;

            text-decoration: none;
            font-weight: 600;
        }

        .btn-cancel {
            background: #9e9e9e;
            color: white;

            border: none;

            padding: 12px 25px;

            border-radius: 6px;

            cursor: pointer;
        }

        @keyframes logoutShow {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 1023.98px) {
            .topbar h1 {
                font-size: 20px !important;
            }
        }

        @media (max-width: 768px) {
            .table-header {
                flex-direction: column;
                align-items: stretch !important;
                gap: 15px;
            }

            .filter-box {
                flex-direction: column;
                align-items: stretch !important;
                gap: 10px;
            }

            .filter-box select,
            .filter-box input {
                width: 100% !important;
            }

            .topbar {
                padding: 15px 15px !important;
            }

            .table-box {
                padding: 15px !important;
            }
        }

        /* Table container styling to enable responsive horizontal scrolling */
        .table-responsive {
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
    </style>
</head>

<body>

    <div class="sidebar">
        <div class="logo">
            <img src="{{ asset('img/logo/wg.png') }}" class="logo-full">
            <img src="{{ asset('img/logo/wg1.png') }}" class="logo-mini">
        </div>

        <button type="button" class="sidebar-toggle" onclick="toggleSidebar()">
            <i class="fa-solid fa-table-columns"></i>
        </button>

        <a href="/dashboard-direktur">
            <i class="fa-solid fa-house"></i> Beranda
        </a>

        <a href="/verifikasi-cuti-direktur">
            <i class="fa-solid fa-check-circle"></i> Verifikasi Cuti
        </a>

        <a href="/data-cuti-direktur" class="active">
            <i class="fa-solid fa-calendar-days"></i> Data Cuti
        </a>

        <a href="#" class="logout" onclick="showLogoutModal(event)">
            <i class="fa-solid fa-right-from-bracket"></i> Keluar
        </a>
    </div>

    <!-- Sidebar Overlay for mobile -->
    <div class="sidebar-overlay" onclick="toggleSidebar()"></div>

    <div class="main-content">

        <div class="topbar">
            <div class="d-flex align-items-center gap-3">
                <button type="button" class="hamburger-btn" onclick="toggleSidebar()">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <h1 style="margin: 0; color: #1e2a78;">Data Cuti Karyawan</h1>
            </div>

            <div class="user-box">

                <div class="theme-toggle-top">
                    <button type="button" id="lightBtn" onclick="setLightMode()">
                        <i class="fa-solid fa-sun"></i>
                    </button>

                    <button type="button" id="darkBtn" onclick="setDarkMode()">
                        <i class="fa-solid fa-moon"></i>
                    </button>
                </div>

                <span>{{ session('nama') }}</span>
                <i class="fa-solid fa-user"></i>
            </div>
        </div>



        <div class="table-box">

            <div class="table-header">
                <h3>Daftar Data Cuti</h3>

                <div class="filter-box">

                    <input type="month" id="filterPeriode" value="{{ date('Y-m') }}">

                    <input type="text" id="searchInput" placeholder="Cari nama karyawan...">

                </div>
            </div>

            <div class="table-responsive">
                <table id="dataCutiTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Jenis Cuti</th>
                            <th>Divisi</th>
                            <th>Tanggal Pengajuan</th>
                            <th>Tanggal Mulai</th>
                            <th>Tanggal Selesai</th>
                            <th>Jumlah Hari</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($dataCuti as $cuti)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $cuti->nama ?? '-' }}</td>
                            <td>{{ $cuti->nama_jenis_cuti ?? 'Cuti' }}</td>
                            <td>{{ $cuti->divisi ?? '-' }}</td>
                            <td>{{ $cuti->tanggal_pengajuan }}</td>
                            <td>{{ $cuti->tanggal_mulai }}</td>
                            <td>{{ $cuti->tanggal_selesai }}</td>
                            <td>{{ $cuti->jumlah_hari }} Hari</td>

                            <td>
                                @if($cuti->status_pengajuan == 'menunggu')
                                <span class="status menunggu">Menunggu</span>
                                @elseif($cuti->status_pengajuan == 'disetujui')
                                <span class="status disetujui">Disetujui</span>
                                @elseif($cuti->status_pengajuan == 'ditolak')
                                <span class="status ditolak">Ditolak</span>
                                @endif
                            </td>

                            <td>
                                <button type="button" class="btn-detail" onclick="showDetail(
                                    '{{ $cuti->nama }}',
                                    '{{ $cuti->nama_jenis_cuti }}',
                                    '{{ $cuti->divisi }}',
                                    '{{ $cuti->tanggal_pengajuan }}',
                                    '{{ $cuti->tanggal_mulai }}',
                                    '{{ $cuti->tanggal_selesai }}',
                                    '{{ $cuti->jumlah_hari }}',
                                    '{{ $cuti->status_pengajuan }}',
                                    '{{ $cuti->alasan_pengajuan }}',
                                    '{{ $cuti->alasan_ditolak }}'
                                    )">
                                    Detail
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" style="text-align:center;">
                                Tidak ada data cuti
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    <div id="modalDetail" class="modal-detail">
        <div class="modal-box">
            <h2>Detail Pengajuan Cuti</h2>

            <div class="detail-grid">
                <div class="detail-item">
                    <span>Nama</span>
                    <strong id="d_nama"></strong>
                </div>

                <div class="detail-item">
                    <span>Jenis Cuti</span>
                    <strong id="d_jenis"></strong>
                </div>

                <div class="detail-item">
                    <span>Divisi</span>
                    <strong id="d_divisi"></strong>
                </div>

                <div class="detail-item">
                    <span>Tanggal Pengajuan</span>
                    <strong id="d_pengajuan"></strong>
                </div>

                <div class="detail-item">
                    <span>Tanggal Mulai</span>
                    <strong id="d_mulai"></strong>
                </div>

                <div class="detail-item">
                    <span>Tanggal Selesai</span>
                    <strong id="d_selesai"></strong>
                </div>

                <div class="detail-item">
                    <span>Jumlah Hari</span>
                    <strong id="d_jumlah"></strong>
                </div>

                <div class="detail-item">
                    <span>Status</span>
                    <strong id="d_status"></strong>
                </div>
            </div>

            <div class="detail-item" style="margin-top:16px;">
                <span>Alasan Pengajuan</span>
                <strong id="d_alasan" style="display:block; margin-top:8px;"></strong>
            </div>

            <div class="detail-item" id="box_alasan_hrd" style="margin-top:16px; display:none;">
                <span style="color:#ef4444;">Alasan Ditolak</span>
                <strong id="d_alasan_direktur" style="display:block; margin-top:8px; color:#ef4444;">
                    -
                </strong>
            </div>


            <button class="btn-close" onclick="closeDetail()">
                Tutup
            </button>
        </div>
    </div>


    <div id="logoutModal" class="logout-modal">
        <div class="logout-box">

            <div class="logout-icon">
                <i class="fa-solid fa-question"></i>
            </div>

            <h2>Konfirmasi Keluar</h2>

            <p>
                Apakah Anda yakin ingin keluar?
            </p>

            <div class="logout-buttons">
                <a href="/logout" class="btn-logout">
                    Ya, Keluar
                </a>

                <button type="button" onclick="closeLogoutModal()" class="btn-cancel">
                    Batal
                </button>
            </div>

        </div>
    </div>

    <script>
        const searchInput = document.getElementById('searchInput');
        const filterPeriode = document.getElementById('filterPeriode');

        function filterTable() {
            const keyword = searchInput.value.toLowerCase();
            const periode = filterPeriode.value;

            document.querySelectorAll("tbody tr").forEach(row => {
                const nama = row.cells[1].textContent.toLowerCase();
                const tanggalPengajuan = row.cells[4].textContent.trim();

                let tampil = true;

                if (keyword && !nama.includes(keyword)) {
                    tampil = false;
                }

                if (periode) {
                    const periodeData = tanggalPengajuan.substring(0, 7);

                    if (periodeData !== periode) {
                        tampil = false;
                    }
                }

                row.style.display = tampil ? '' : 'none';
            });
        }

        searchInput.addEventListener('keyup', filterTable);
        filterPeriode.addEventListener('change', filterTable);

        function showDetail(
            nama,
            jenis,
            divisi,
            pengajuan,
            mulai,
            selesai,
            jumlah,
            status,
            alasan,
            alasanDitolak
        ) {

            document.getElementById("d_nama").innerText = nama;
            document.getElementById("d_jenis").innerText = jenis;
            document.getElementById("d_divisi").innerText = divisi;
            document.getElementById("d_pengajuan").innerText = pengajuan;
            document.getElementById("d_mulai").innerText = mulai;
            document.getElementById("d_selesai").innerText = selesai;
            document.getElementById("d_jumlah").innerText = jumlah + " hari";
            document.getElementById("d_status").innerText = status;
            document.getElementById("d_alasan").innerText = alasan;

            const boxAlasan = document.getElementById("box_alasan_hrd");
            const alasanEl = document.getElementById("d_alasan_direktur");

            if (status.toLowerCase() === "ditolak") {
                alasanEl.innerText = alasanDitolak || "-";
                boxAlasan.style.display = "block";
            } else {
                alasanEl.innerText = "-";
                boxAlasan.style.display = "none";
            }

            document.getElementById("modalDetail").style.display = "flex";
        }

        function closeDetail() {
            document.getElementById("modalDetail").style.display = "none";
        }

        function toggleSidebar() {
            document.body.classList.toggle("sidebar-closed");

            localStorage.setItem(
                "sidebar",
                document.body.classList.contains("sidebar-closed") ? "closed" : "open"
            );
        }

        document.addEventListener("DOMContentLoaded", function () {
            const savedSidebarState = localStorage.getItem("sidebar");
            if (savedSidebarState === "closed" || (!savedSidebarState && window.innerWidth < 1024)) {
                document.body.classList.add("sidebar-closed");
            }
        });

        document.addEventListener("click", function (event) {
            const wrapper = document.querySelector(".notif-wrapper");
            const notif = document.getElementById("notifDropdown");

            if (wrapper && notif && !wrapper.contains(event.target)) {
                notif.style.display = "none";
            }
        });

        function setDarkMode() {
            document.body.classList.add("dark-mode");
            localStorage.setItem("theme", "dark");

            document.getElementById("darkBtn").classList.add("active");
            document.getElementById("lightBtn").classList.remove("active");
        }

        function setLightMode() {
            document.body.classList.remove("dark-mode");
            localStorage.setItem("theme", "light");

            document.getElementById("lightBtn").classList.add("active");
            document.getElementById("darkBtn").classList.remove("active");
        }

        const closeWelcome = document.getElementById("closeWelcome");

        if (closeWelcome) {

            closeWelcome.addEventListener("click", function () {

                const welcomeBar = document.querySelector(".welcome-bar");

                welcomeBar.style.opacity = "0";
                welcomeBar.style.transform = "translateY(-10px)";

                setTimeout(() => {
                    welcomeBar.style.display = "none";
                }, 300);

            });

        }

        const body = document.body;

        const lightBtn = document.getElementById("lightBtn");
        const darkBtn = document.getElementById("darkBtn");

        if (localStorage.getItem("theme") === "dark") {
            body.classList.add("dark-mode");

            darkBtn.classList.add("active");
            lightBtn.classList.remove("active");
        } else {
            lightBtn.classList.add("active");
            darkBtn.classList.remove("active");
        }

        lightBtn.addEventListener("click", () => {
            body.classList.remove("dark-mode");

            lightBtn.classList.add("active");
            darkBtn.classList.remove("active");

            localStorage.setItem("theme", "light");
        });

        darkBtn.addEventListener("click", () => {
            body.classList.add("dark-mode");

            darkBtn.classList.add("active");
            lightBtn.classList.remove("active");

            localStorage.setItem("theme", "dark");
        });

        function showLogoutModal(event) {
            event.preventDefault();
            event.stopPropagation();

            const modal = document.getElementById('logoutModal');
            if (modal) {
                modal.style.display = 'flex';
            }
        }

        function closeLogoutModal() {
            const modal = document.getElementById('logoutModal');
            if (modal) {
                modal.style.display = 'none';
            }
        }
    </script>

</body>

</html>