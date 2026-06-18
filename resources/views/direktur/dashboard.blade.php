<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Dashboard Direktur</title>

    <link rel="icon" type="image/png" href="{{ asset('img/logo/wg.png') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <style>
        .status {
            padding: 7px 16px;
            border-radius: 999px;
            font-size: 13px;
            font-weight: 700;
            display: inline-block;
            min-width: 95px;
            text-align: center;
        }

        .menunggu {
            background: #facc15;
            color: #111827
        }

        .disetujui {
            background: #22c55e;
            color: white
        }

        .ditolak {
            background: #ef4444;
            color: white
        }

        .btn-lihat {
            background: #0d6efd;
            color: white;
            border: none;
            border-radius: 6px;
            padding: 7px 14px;
            font-weight: 600;
            text-decoration: none;
        }

        .search-box {
            display: flex;
            align-items: center;
            gap: 10px;
            border: 1px solid #ddd;
            padding: 8px 14px;
            border-radius: 8px;
            background: white;
        }

        .search-box input {
            border: none;
            outline: none;
        }

        .welcome-modal {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, .5);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .welcome-box {
            background: white;
            padding: 30px;
            border-radius: 20px;
            text-align: center;
        }

        .check-icon {
            width: 90px;
            height: 90px;
            margin: 0 auto 25px;

            border: 4px solid #d8f5cf;
            border-radius: 50%;

            color: #7ad65c;

            display: flex;
            align-items: center;
            justify-content: center;

            animation: popCircle .7s ease;
        }

        .check-icon i {
            font-size: 42px;

            animation:
                rotateCheck .8s ease,
                glowCheck 2s infinite;
        }

        .welcome-box h2 {
            font-size: 25px;
            margin-bottom: 15px;
            color: #333;
        }

        .welcome-box p {
            font-size: 16px;
            color: #555;
            margin-bottom: 25px;
        }

        .welcome-box button {
            background: #0d6efd;
            color: white;
            border: none;
            padding: 10px 28px;
            border-radius: 4px;
            font-weight: 600;
        }

        @keyframes modalShow {

            from {
                opacity: 0;
                transform:
                    translateY(-40px) scale(.9);
            }

            to {
                opacity: 1;
                transform:
                    translateY(0) scale(1);
            }
        }

        @keyframes popCircle {

            0% {
                transform: scale(0);
                opacity: 0;
            }

            70% {
                transform: scale(1.1);
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        @keyframes rotateCheck {

            0% {
                opacity: 0;
                transform:
                    rotate(-180deg) scale(0);
            }

            100% {
                opacity: 1;
                transform:
                    rotate(0deg) scale(1);
            }
        }

        @keyframes glowCheck {

            0% {
                text-shadow: 0 0 0 transparent;
            }

            50% {
                text-shadow:
                    0 0 12px #7ad65c,
                    0 0 20px #7ad65c;
            }

            100% {
                text-shadow: 0 0 0 transparent;
            }
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

        .logo {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
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



        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;

            background: #fff;
            padding: 25px 30px;
            border-radius: 12px;
            margin-bottom: 20px;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .user-box {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 600;
        }

        .page-title {
            margin: 0;
            color: #1e2a78;
            font-size: 42px;
            font-weight: 800;
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

        <a href="/dashboard-direktur" class="active">
            <i class="fa-solid fa-house"></i> Beranda
        </a>

        <a href="/verifikasi-cuti-direktur">
            <i class="fa-solid fa-check-circle"></i> Verifikasi Cuti
        </a>

        <a href="/data-cuti-direktur">
            <i class="fa-solid fa-calendar-days"></i> Data Cuti
        </a>

        <a href="#" class="logout" onclick="showLogoutModal(event)">
            <i class="fa-solid fa-right-from-bracket"></i> Keluar
        </a>
    </div>

    <div class="main-content">

        <div class="topbar">

            <h1 class="fw-bold page-title">
                Beranda
            </h1>

            <div class="topbar-right">

                <div class="theme-toggle-top">
                    <button type="button" id="lightBtn" onclick="setLightMode()">
                        <i class="fa-solid fa-sun"></i>
                    </button>

                    <button type="button" id="darkBtn" onclick="setDarkMode()">
                        <i class="fa-solid fa-moon"></i>
                    </button>
                </div>

                <div class="user-box">
                    <strong>{{ session('nama') }}</strong>
                    <i class="fa-solid fa-user"></i>
                </div>

            </div>

        </div>

       <div class="row g-4 mb-4">

    <!-- Menunggu -->
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100 border-start border-4 border-warning">
            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center">

                    <div>
                        <p class="text-muted mb-1">
                            Menunggu
                        </p>

                        <h2 class="fw-bold mb-0 text-dark">
                            {{ $menungguVerifikasi }}
                        </h2>
                    </div>

                    <div class="bg-warning-subtle rounded-3 p-3">
                        <i class="fa-solid fa-clock text-warning fs-3"></i>
                    </div>

                </div>

            </div>
        </div>
    </div>

    <!-- Disetujui -->
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100 border-start border-4 border-success">
            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center">

                    <div>
                        <p class="text-muted mb-1">
                            Disetujui
                        </p>

                        <h2 class="fw-bold mb-0 text-dark">
                            {{ $disetujui }}
                        </h2>
                    </div>

                    <div class="bg-success-subtle rounded-3 p-3">
                        <i class="fa-solid fa-circle-check text-success fs-3"></i>
                    </div>

                </div>

            </div>
        </div>
    </div>

    <!-- Ditolak -->
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100 border-start border-4 border-danger">
            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center">

                    <div>
                        <p class="text-muted mb-1">
                            Ditolak
                        </p>

                        <h2 class="fw-bold mb-0 text-dark">
                            {{ $ditolak }}
                        </h2>
                    </div>

                    <div class="bg-danger-subtle rounded-3 p-3">
                        <i class="fa-solid fa-circle-xmark text-danger fs-3"></i>
                    </div>

                </div>

            </div>
        </div>
    </div>

</div>

        <div class="card border-0 shadow-sm rounded-4 mt-4">
            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="modal-title fw-bold text-primary-emphasis">
                        Pengajuan Cuti Terbaru 
                    </h5>


                </div>

                <div class="table-responsive">
                    <table class="table align-middle" id="dataTable">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Jenis Cuti</th>
                                <th>Divisi</th>
                                <th>Tanggal Mulai</th>
                                <th>Tanggal Selesai</th>
                                <th>Status Direktur</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($pengajuan as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->nama }}</td>
                                <td>{{ $item->nama_jenis_cuti ?? 'Cuti' }}</td>
                                <td>{{ $item->divisi ?? '-' }}</td>
                                <td>{{ $item->tanggal_mulai }}</td>
                                <td>{{ $item->tanggal_selesai }}</td>
                                <td>
                                    @if($item->status_direktur == 'menunggu')
                                    <span class="status menunggu">Menunggu</span>
                                    @elseif($item->status_direktur == 'disetujui')
                                    <span class="status disetujui">Disetujui</span>
                                    @elseif($item->status_direktur == 'ditolak')
                                    <span class="status ditolak">Ditolak</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="/verifikasi-cuti-direktur" class="btn-lihat">
                                        Lihat
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted">
                                    Belum ada pengajuan cuti
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

    </div>

    @if(session('welcome_login_id'))
    <div id="welcomeModal" class="welcome-modal" data-login-id="{{ session('welcome_login_id') }}"
        style="display:none;">

        <div class="welcome-box">
            <div class="check-icon">
                <i class="fa-solid fa-check"></i>
            </div>

            <h2>Berhasil Masuk</h2>
            <p>Selamat Datang Kembali, {{ session('nama') }}!</p>

            <button onclick="closeWelcomeModal()">OK</button>
        </div>
    </div>
    @endif


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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
      
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

        /*
        |--------------------------------------------------------------------------
        | MODAL LOGIN & LOGOUT SUCCESS
        |--------------------------------------------------------------------------
        */

        document.addEventListener("DOMContentLoaded", function () {
            const modal = document.getElementById("welcomeModal");

            if (!modal) return;

            const loginId = modal.dataset.loginId;

            if (!loginId) return;

            const alreadyShown = sessionStorage.getItem("welcome_login_id");

            if (alreadyShown !== loginId) {
                modal.style.display = "flex";
            }
        });

        function closeWelcomeModal() {
            const modal = document.getElementById("welcomeModal");

            if (!modal) return;

            sessionStorage.setItem("welcome_login_id", modal.dataset.loginId);
            modal.style.display = "none";
        }


        function showLogoutModal(event) {
            event.preventDefault();
            event.stopPropagation();

            document.getElementById('logoutModal').style.display = 'flex';
        }

        function closeLogoutModal() {
            document.getElementById('logoutModal').style.display = 'none';
        }

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

        document.addEventListener("DOMContentLoaded", function () {

            const theme = localStorage.getItem("theme");

            if (theme === "dark") {
                document.body.classList.add("dark-mode");

                document.getElementById("darkBtn").classList.add("active");
                document.getElementById("lightBtn").classList.remove("active");
            } else {
                document.body.classList.remove("dark-mode");

                document.getElementById("lightBtn").classList.add("active");
                document.getElementById("darkBtn").classList.remove("active");
            }

        });

        document.addEventListener("DOMContentLoaded", () => {

            const theme = localStorage.getItem("theme");

            console.log("Theme:", theme);

            if (theme === "dark") {
                setDarkMode();
            } else {
                setLightMode();
            }

            console.log(
                "Dark Button Class:",
                document.getElementById("darkBtn").className
            );
        });
        document.addEventListener("DOMContentLoaded", function () {

            const body = document.body;
            const lightBtn = document.getElementById("lightBtn");
            const darkBtn = document.getElementById("darkBtn");

            if (localStorage.getItem("theme") === "dark") {
                body.classList.add("dark-mode");

                darkBtn.classList.add("active");
                lightBtn.classList.remove("active");
            } else {
                body.classList.remove("dark-mode");

                lightBtn.classList.add("active");
                darkBtn.classList.remove("active");
            }

        });
    </script>

</body>

</html>