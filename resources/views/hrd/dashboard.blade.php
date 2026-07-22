<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard HRD</title>

    <link rel="icon" type="image/png" href="{{ asset('img/logo/wg.png') }}">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- CSS Kamu -->
    <link rel="stylesheet" href="{{ asset('css/hrd.css') }}">
   

    <style>
       .sidebar .logo {
    display: flex;
    flex-direction: column;
    align-items: center;   /* tengah horizontal */
    justify-content: center;
    width: 100%;
    padding: 20px 0 10px;
    text-align: center;
}

.sidebar {
    height: 100vh;
    display: flex;
    flex-direction: column;
}

.sidebar .logout {
    margin-top: 20px;
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

        /* Mobile and Tablet Responsiveness overrides */
        @media (max-width: 991.98px) {
            .sidebar {
                position: fixed !important;
                left: 0;
                top: 0;
                bottom: 0;
                width: 250px !important;
                z-index: 1050;
                transform: translateX(-100%);
                transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            }

            body:not(.sidebar-closed) .sidebar {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0 !important;
                padding: 15px !important;
                min-height: auto !important;
            }

            body.sidebar-closed .main-content {
                margin-left: 0 !important;
            }

            .sidebar-overlay {
                position: fixed;
                inset: 0;
                background: rgba(0, 0, 0, 0.4);
                z-index: 1040;
                opacity: 0;
                pointer-events: none;
                transition: opacity 0.3s ease;
                backdrop-filter: blur(4px);
            }

            body:not(.sidebar-closed) .sidebar-overlay {
                opacity: 1;
                pointer-events: auto;
            }

            .sidebar .logo img.logo-full {
                display: inline-block !important;
                width: 150px;
            }

            .sidebar .logo img.logo-mini {
                display: none !important;
            }
        }

        @media (max-width: 767.98px) {
            .main-content {
                padding: 12px !important;
            }
            .topbar {
                padding: 15px !important;
            }
            .welcome-bar {
                padding: 10px 15px !important;
                font-size: 14px;
            }
        }

        @media (max-width: 575.98px) {
            .topbar h1 {
                font-size: 24px !important;
            }
        }

        .sidebar-mobile-toggle {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background: #e8ecff;
            color: #1e2a78;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .sidebar-mobile-toggle:hover {
            background: #1e2a78;
            color: white;
        }

        body.dark-mode .sidebar-mobile-toggle {
            background: #1f2937;
            color: white;
        }

        body.dark-mode .sidebar-mobile-toggle:hover {
            background: #374151;
        }

        /* Responsive Modal Fixes */
        .welcome-box, .logout-box {
            width: 90% !important;
            max-width: 420px !important;
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


    <!-- SECTION 4 -->
    <div class="menu-section">
        <p class="menu-title">PENGATURAN</p>

        <a href="/pengaturan-cuti">
            <i class="fa-solid fa-gear"></i> Pengaturan Cuti
        </a>
    </div>
    <a href="javascript:void(0)" class="logout" onclick="showLogoutModal(event)">
        <i class="fa-solid fa-right-from-bracket"></i> Keluar
    </a>

</div>

<div class="sidebar-overlay" onclick="toggleSidebar()"></div>

<div class="main-content">

    <div class="topbar d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center gap-3">
            <button type="button" class="sidebar-mobile-toggle d-lg-none" onclick="toggleSidebar()">
                <i class="fa-solid fa-bars"></i>
            </button>
            <h1 class="fw-bold text-primary-emphasis page-title mb-0">Beranda</h1>
        </div>

        <div class="user-box d-flex align-items-center gap-3">
            <div class="theme-toggle-top">
                <button type="button" id="lightBtn" onclick="setLightMode()">
                    <i class="fa-solid fa-sun"></i>
                </button>

                <button type="button" id="darkBtn" onclick="setDarkMode()">
                    <i class="fa-solid fa-moon"></i>
                </button>
            </div>

            <span class="d-none d-sm-inline">{{ session('nama') }}</span>
            <i class="fa-solid fa-user"></i>
        </div>
    </div>
    <div class="welcome-bar alert alert-light d-flex justify-content-between align-items-center mt-3 shadow-sm">
        <span>Selamat Datang, {{ session('nama') }}</span>
        <i class="fa-solid fa-xmark" id="closeWelcome" style="cursor:pointer;"></i>
    </div>


<!-- STATS -->
<div class="row g-4 mb-4">

    <!-- Total Karyawan -->
    <div class="col-12 col-sm-6 col-xl">
        <div class="card border-0 shadow-sm h-100 text-white bg-primary">
            <div class="card-body d-flex justify-content-between align-items-center">

                <div>
                    <small class="opacity-75">
                        Total Karyawan
                    </small>

                    <h2 class="fw-bold mt-2 mb-0">
                        {{ $jumlahKaryawan }}
                    </h2>
                </div>

                <div class="bg-white bg-opacity-25 rounded-3 p-3">
                    <i class="fa-solid fa-users fs-3"></i>
                </div>

            </div>
        </div>
    </div>

    <!-- Menunggu -->
    <div class="col-12 col-sm-6 col-xl">
        <div class="card border-0 shadow-sm h-100 text-white bg-warning">
            <div class="card-body d-flex justify-content-between align-items-center">

                <div>
                    <small class="opacity-75">
                        Menunggu
                    </small>

                    <h2 class="fw-bold mt-2 mb-0">
                        {{ $menungguVerifikasi }}
                    </h2>
                </div>

                <div class="bg-white bg-opacity-25 rounded-3 p-3">
                    <i class="fa-solid fa-clock fs-3"></i>
                </div>

            </div>
        </div>
    </div>

    <!-- Diproses -->
    <div class="col-12 col-sm-6 col-xl">
        <div class="card border-0 shadow-sm h-100 text-white bg-info">
            <div class="card-body d-flex justify-content-between align-items-center">

                <div>
                    <small class="opacity-75">
                        Diproses
                    </small>

                    <h2 class="fw-bold mt-2 mb-0">
                        {{ $diproses }}
                    </h2>
                </div>

                <div class="bg-white bg-opacity-25 rounded-3 p-3">
                    <i class="fa-solid fa-spinner fs-3"></i>
                </div>

            </div>
        </div>
    </div>

    <!-- Disetujui -->
    <div class="col-12 col-sm-6 col-xl">
        <div class="card border-0 shadow-sm h-100 text-white bg-success">
            <div class="card-body d-flex justify-content-between align-items-center">

                <div>
                    <small class="opacity-75">
                        Disetujui
                    </small>

                    <h2 class="fw-bold mt-2 mb-0">
                        {{ $disetujui }}
                    </h2>
                </div>

                <div class="bg-white bg-opacity-25 rounded-3 p-3">
                    <i class="fa-solid fa-circle-check fs-3"></i>
                </div>

            </div>
        </div>
    </div>

    <!-- Ditolak -->
    <div class="col-12 col-sm-6 col-xl">
        <div class="card border-0 shadow-sm h-100 text-white bg-danger">
            <div class="card-body d-flex justify-content-between align-items-center">

                <div>
                    <small class="opacity-75">
                        Ditolak
                    </small>

                    <h2 class="fw-bold mt-2 mb-0">
                        {{ $ditolak }}
                    </h2>
                </div>

                <div class="bg-white bg-opacity-25 rounded-3 p-3">
                    <i class="fa-solid fa-circle-xmark fs-3"></i>
                </div>

            </div>
        </div>
    </div>

</div>

    <div class="card border-0 shadow-sm rounded-4 mt-4">
        <div class="card-body">
            <h4 class="fw-bold text-primary-emphasis mb-4">
                Pengajuan Cuti Terbaru
            </h4>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Nama</th>
                            <th>Jenis Cuti</th>
                            <th>Tanggal Mulai</th>
                            <th>Tanggal Selesai</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($pengajuanTerbaru as $cuti)
                            <tr>
                                <td>{{ $cuti->nama }}</td>
                                <td>{{ $cuti->nama_jenis_cuti ?? 'Cuti' }}</td>
                                <td>{{ $cuti->tanggal_mulai }}</td>
                                <td>{{ $cuti->tanggal_selesai }}</td>
                                <td>
@if($cuti->status_hrd == 'menunggu')
    <span class="status menunggu">Menunggu</span>

@elseif($cuti->status_hrd == 'disetujui')
    <span class="status disetujui">Disetujui</span>

@elseif($cuti->status_hrd == 'ditolak')
    <span class="status ditolak">Ditolak</span>
@endif
</td>
                                <td>
                                    <a href="/verifikasi-cuti" class="btn btn-sm btn-primary">
                                        Lihat
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">
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
<div id="welcomeModal"
     class="welcome-modal"
     data-login-id="{{ session('welcome_login_id') ?? '' }}"
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



<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>

/*
|--------------------------------------------------------------------------
| DARKMODE & SIDEBAR TOGGLE
|--------------------------------------------------------------------------
*/
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

function toggleSidebar() {
    document.body.classList.toggle("sidebar-closed");

    localStorage.setItem(
        "sidebar",
        document.body.classList.contains("sidebar-closed") ? "closed" : "open"
    );
}



document.addEventListener("DOMContentLoaded", function () {
    const theme = localStorage.getItem("theme");
    const sidebarState = localStorage.getItem("sidebar");
    const isMobile = window.innerWidth < 992;

    if (theme === "dark") {
        setDarkMode();
    } else {
        setLightMode();
    }

    if (sidebarState === "closed" || (isMobile && sidebarState === null)) {
        document.body.classList.add("sidebar-closed");
    } else if (sidebarState === "open") {
        document.body.classList.remove("sidebar-closed");
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

if(localStorage.getItem('theme') === 'dark'){
    document.documentElement.classList.add('dark-init');
}
</script>

</body>
</html>