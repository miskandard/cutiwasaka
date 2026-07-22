<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pengaturan Cuti</title>

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

        /* Custom Premium Styles for Settings Page */
        .settings-card {
            border: 1px solid rgba(226, 232, 240, 0.8) !important;
            background: #ffffff;
            box-shadow: 0 20px 40px rgba(30, 42, 120, 0.04) !important;
            transition: all 0.3s ease;
        }
        body.dark-mode .settings-card {
            background: #111827 !important;
            border-color: rgba(55, 65, 81, 0.5) !important;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3) !important;
        }
        .settings-header {
            background: linear-gradient(135deg, #1e2a78 0%, #3b82f6 100%) !important;
            padding: 24px 30px !important;
            border-bottom: none !important;
        }
        .settings-header h4 {
            font-size: 20px;
            font-weight: 700;
            letter-spacing: 0.5px;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .setting-item-box {
            background: #f8fafc;
            border: 1px solid #f1f5f9;
            border-radius: 16px;
            padding: 24px;
            margin-bottom: 24px;
            transition: all 0.3s ease;
            display: flex;
            align-items: flex-start;
            gap: 20px;
        }
        body.dark-mode .setting-item-box {
            background: #1f2937 !important;
            border-color: #374151 !important;
        }
        .setting-item-box:hover {
            border-color: #cbd5e1;
            box-shadow: 0 4px 20px rgba(30, 42, 120, 0.03);
            transform: translateY(-2px);
        }
        body.dark-mode .setting-item-box:hover {
            border-color: #4b5563 !important;
        }
        .setting-icon-circle {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            flex-shrink: 0;
        }
        .icon-blue {
            background: #eff6ff;
            color: #3b82f6;
        }
        body.dark-mode .icon-blue {
            background: rgba(59, 130, 246, 0.15) !important;
        }
        .icon-purple {
            background: #f5f3ff;
            color: #8b5cf6;
        }
        body.dark-mode .icon-purple {
            background: rgba(139, 92, 246, 0.15) !important;
        }
        .setting-content-area {
            flex-grow: 1;
        }
        .setting-content-area label {
            color: #1e293b !important;
        }
        body.dark-mode .setting-content-area label {
            color: #ffffff !important;
        }
        .settings-input-group .form-control {
            border-radius: 10px 0 0 10px !important;
            border: 1px solid #cbd5e1;
            padding: 12px 16px;
            font-weight: 500;
            background: #ffffff;
            transition: all 0.2s ease;
        }
        body.dark-mode .settings-input-group .form-control {
            background: #111827 !important;
            border-color: #4b5563 !important;
            color: #ffffff !important;
        }
        .settings-input-group .form-control:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
        }
        .settings-input-group .input-group-text {
            border-radius: 0 10px 10px 0 !important;
            background: #e2e8f0;
            border: 1px solid #cbd5e1;
            border-left: none;
            font-weight: 600;
            color: #475569;
            padding: 0 20px;
        }
        body.dark-mode .settings-input-group .input-group-text {
            background: #374151 !important;
            border-color: #4b5563 !important;
            color: #94a3b8 !important;
        }
        /* Custom Toggle Switch */
        .custom-switch-box {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 18px 24px;
            background: #f8fafc;
            border-radius: 12px;
            border: 1px dashed #cbd5e1;
            margin-bottom: 24px;
        }
        body.dark-mode .custom-switch-box {
            background: #1f2937 !important;
            border-color: #4b5563 !important;
        }
        .custom-switch-box label {
            color: #1e293b !important;
        }
        body.dark-mode .custom-switch-box label {
            color: #ffffff !important;
        }
        .form-check-input {
            width: 44px !important;
            height: 22px !important;
            border-radius: 50px !important;
            margin-top: 0 !important;
            cursor: pointer;
        }
        /* Save Button */
        .btn-save-settings {
            background: linear-gradient(135deg, #1e2a78 0%, #3b82f6 100%) !important;
            border: none !important;
            border-radius: 12px !important;
            padding: 14px 28px !important;
            font-weight: 600 !important;
            letter-spacing: 0.5px !important;
            box-shadow: 0 4px 15px rgba(30, 42, 120, 0.2) !important;
            transition: all 0.3s ease !important;
        }
        .btn-save-settings:hover {
            box-shadow: 0 6px 20px rgba(30, 42, 120, 0.3) !important;
            transform: translateY(-2px);
        }
        .btn-save-settings:active {
            transform: translateY(0);
        }
        /* Page Title Gradient */
        .page-title {
            background: linear-gradient(135deg, #1e2a78 0%, #3b82f6 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
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

        <a href="/dashboard-hrd">
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

        <a href="/pengaturan-cuti" class="active">
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
            <h1 class="fw-bold text-primary-emphasis page-title mb-0">Pengaturan Cuti</h1>
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
<div class="container-fluid mt-4">

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow border-0 rounded-4">

        <div class="card-header bg-primary text-white py-3">
            <h4 class="mb-0">
                <i class="fa-solid fa-gear"></i>
                Pengaturan Cuti
            </h4>
        </div>

        <div class="card-body">

            <form action="{{ url('/pengaturan-cuti/update') }}" method="POST">

                @csrf

                <!-- Hak Cuti -->
                <div class="mb-4">
                    <label class="form-label fw-semibold">
                        Hak Cuti Tahunan
                    </label>

                    <div class="input-group">

                        <input
                            type="number"
                            name="hak_cuti_tahunan"
                            class="form-control"
                            value="{{ $pengaturan->hak_cuti_tahunan }}"
                            min="1"
                            required>

                        <span class="input-group-text">
                            Hari
                        </span>

                    </div>

                    <small class="text-muted">
                        Hak cuti tahunan yang berlaku untuk seluruh karyawan.
                    </small>
                </div>

                <!-- Minimal Pengajuan -->
                <div class="mb-4">

                    <label class="form-label fw-semibold">
                        Minimal Pengajuan Cuti
                    </label>

                    <div class="input-group">

                        <input
                            type="number"
                            name="minimal_pengajuan_hari"
                            class="form-control"
                            value="{{ $pengaturan->minimal_pengajuan_hari }}"
                            min="1"
                            required>

                        <span class="input-group-text">
                            Hari Sebelum Cuti
                        </span>

                    </div>

                    <small class="text-muted">
                        Contoh: isi 7 berarti karyawan wajib mengajukan cuti minimal 7 hari sebelum tanggal mulai cuti.
                    </small>

                </div>

                <!-- Checkbox -->
                <div class="form-check mb-4">

                    <input
                        class="form-check-input"
                        type="checkbox"
                        name="terapkan_semua"
                        value="1"
                        id="terapkanSemua">

                    <label class="form-check-label" for="terapkanSemua">

                        Terapkan hak cuti ke seluruh karyawan yang sudah terdaftar

                    </label>

                </div>

                <button class="btn btn-primary px-4">

                    <i class="fa-solid fa-floppy-disk"></i>

                    Simpan Pengaturan

                </button>

            </form>

        </div>

    </div>

</div>

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
</body>
</html>