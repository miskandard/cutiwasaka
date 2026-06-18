<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Data Cuti</title>

    <link rel="icon" type="image/png" href="{{ asset('img/logo/wg.png') }}">
    <link rel="stylesheet" href="{{ asset('css/hrd.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        .sidebar .logo {
            display: flex;
            flex-direction: column;
            align-items: center;
            /* tengah horizontal */
            justify-content: center;
            width: 100%;
            padding: 20px 0 10px;
            text-align: center;
        }

        .modal-backdrop.show {
            opacity: .5 !important;
        }

        body:not(.modal-open) .modal-backdrop {
            display: none !important;
        }

        .modal {
            z-index: 1055 !important;
        }

        .modal-backdrop {
            z-index: 1050 !important;
        }

        /* BACKDROP */
        .modal-detail {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        /* BOX MODAL */
        .modal-box {
            width: 90%;
            max-width: 800px;
            background: #fff;
            border-radius: 12px;
            padding: 20px 25px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            animation: fadeIn 0.2s ease-in-out;
        }

        /* TITLE */
        .modal-box h2 {
            margin-bottom: 20px;
            font-size: 20px;
            font-weight: 600;
            color: #333;
        }

        /* GRID DETAIL (MODEL TABLE CLEAN) */
        .detail-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px 20px;
            margin-bottom: 15px;
        }

        /* ITEM BOX */
        .detail-item {
            background: #f8f9fc;
            padding: 10px 12px;
            border-radius: 8px;
        }

        .detail-item span {
            font-size: 12px;
            color: #888;
        }

        .detail-item strong {
            display: block;
            font-size: 14px;
            margin-top: 3px;
            color: #222;
        }

        /* ALASAN BOX */
        .detail-alasan {
            background: #f8f9fc;
            padding: 12px;
            border-radius: 8px;
            margin-top: 10px;
        }

        .detail-alasan span {
            font-size: 12px;
            color: #888;
        }

        .detail-alasan p {
            margin-top: 5px;
            font-size: 14px;
            color: #333;
        }

        /* BUTTON */
        .btn-close {
            margin-top: 15px;
            padding: 8px 14px;
            border: none;
            background: #e74c3c;
            color: #fff;
            border-radius: 6px;
            cursor: pointer;
        }

        .btn-close:hover {
            background: #c0392b;
        }
        
        
        .menu-section{
    margin-top: 10px;
    margin-bottom: 10px;
}

/* judul section lebih clean */
.menu-title{
    font-size: 11px;
    font-weight: 800;
    letter-spacing: 1.5px;
    color: #fff;
    margin: 18px 16px 8px;
    position: relative;
}

/* garis kecil kiri */
.menu-title::before{
    content:"";
    display:inline-block;
    width: 18px;
    height: 2px;
    background: #3b82f6;
    margin-right: 8px;
    vertical-align: middle;
    border-radius: 10px;
}
body.sidebar-closed .menu-title {
    display: none;
}

.sidebar {
    height: 100vh;
    display: flex;
    flex-direction: column;
}

    </style>
</head>
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

    <!-- SECTION 1 -->
    <div class="menu-section">

        <a href="/dashboard-hrd" class="active">
            <i class="fa-solid fa-house"></i> Beranda
        </a>
    </div>

    <!-- SECTION 2 -->
    <div class="menu-section">
        <p class="menu-title">MANAJEMEN CUTI</p>

        <a href="/hrd/input-cuti">
            <i class="fa-solid fa-pen-to-square"></i> Input Cuti
        </a>

        <a href="/verifikasi-cuti">
            <i class="fa-solid fa-check-circle"></i> Verifikasi Cuti
        </a>

        <a href="/hrd/riwayat-cuti-hrd">
            <i class="fa-solid fa-clipboard-list"></i> Riwayat Cuti
        </a>
    </div>

    <!-- SECTION 3 -->
    <div class="menu-section">
        <p class="menu-title">MONITORING</p>

        <a href="/data-cuti">
            <i class="fa-solid fa-calendar-days"></i> Data Cuti
        </a>

        <a href="/list-karyawan">
            <i class="fa-solid fa-users"></i> List Karyawan
        </a>
    </div>

    <a href="javascript:void(0)" class="logout" onclick="showLogoutModal(event)">
        <i class="fa-solid fa-right-from-bracket"></i> Keluar
    </a>

</div>

    <div class="main-content">

        <div class="topbar">
            <h1>Data Cuti</h1>

            <div class="user-box">

                <div class="theme-toggle-top">
                    <button type="button" id="lightBtn" onclick="setLightMode()">
                        <i class="fa-solid fa-sun"></i>
                    </button>

                    <button type="button" id="darkBtn" onclick="setDarkMode()">
                        <i class="fa-solid fa-moon"></i>
                    </button>
                </div>

                <div class="notif-wrapper">

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
                    <tr data-tahun="{{ date('Y', strtotime($cuti->tanggal_pengajuan)) }}">
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $cuti->nama }}</td>
                        <td>{{ $cuti->nama_jenis_cuti ?? 'Cuti' }}</td>
                        <td>{{ $cuti->divisi ?? '-' }}</td>
                        <td>{{ $cuti->tanggal_pengajuan }}</td>
                        <td>{{ $cuti->tanggal_mulai }}</td>
                        <td>{{ $cuti->tanggal_selesai }}</td>
                        <td>{{ $cuti->jumlah_hari }}</td>

                        <td>
                            @php
                            if ($cuti->status_hrd == 'disetujui' && $cuti->status_direktur == 'menunggu') {
                            $statusTampil = 'disetujui';
                            } else {
                            $statusTampil = $cuti->status_pengajuan;
                            }
                            @endphp

                            <span class="status {{ $statusTampil }}">
                                {{ ucfirst($statusTampil) }}
                            </span>
                        </td>

                        <td>
                          <button type="button" class="btn-detail"
                            onclick="showDetail(
                            '{{ $cuti->nama }}',
                            '{{ $cuti->nama_jenis_cuti ?? 'Cuti' }}',
                            '{{ $cuti->divisi ?? '-' }}',
                            '{{ $cuti->tanggal_pengajuan }}',
'{{ $cuti->tanggal_mulai }}',
'{{ $cuti->tanggal_selesai }}',
'{{ $cuti->jumlah_hari }}',
'{{ $cuti->status_pengajuan }}',
'{{ $cuti->alasan_pengajuan }}',
                            '{{ $cuti->alasan_ditolak ?? '-' }}'
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

            <div class="detail-alasan">
                <span>Alasan Pengajuan</span>
                <p id="d_alasan"></p>
            </div>

            <div class="detail-item" id="box_alasan_hrd">
    <span style="color:red;">Alasan Ditolak HRD</span>
    <strong id="d_alasan_hrd" style="color:red;">-</strong>
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

       function showDetail(nama, jenis, divisi, pengajuan, mulai, selesai, jumlah, status, alasan, alasanDitolak) {
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
    const alasanHRD = document.getElementById("d_alasan_hrd");

    if (status === 'ditolak') {
        alasanHRD.innerText = alasanDitolak ?? '-';
        boxAlasan.style.display = "block";
    } else {
        alasanHRD.innerText = "-";
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
            if (localStorage.getItem("sidebar") === "closed") {
                document.body.classList.add("sidebar-closed");
            }
        });

        function toggleNotif(event) {
            event.stopPropagation();

            const notif = document.getElementById("notifDropdown");

            notif.style.display =
                notif.style.display === "block" ? "none" : "block";
        }

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