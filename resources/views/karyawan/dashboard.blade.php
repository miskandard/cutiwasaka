    <!DOCTYPE html>
    <html lang="id">
    <head>
        <meta charset="UTF-8">
        <title>Dashboard Karyawan</title>

        <link rel="icon" type="image/png" href="{{ asset('img/logo/wg.png') }}">
        <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

        <script src="https://cdn.tailwindcss.com"></script>

        <style>

            .logo {
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 20px 10px;
    }

    .logo img {
        max-width: 200px;
        width: 100%;
        height: auto;
        object-fit: contain;
    }
            body { background:#f4f6f9; }

            .theme-toggle-top{
                display:flex;
                align-items:center;
                background:#e8ecff;
                border-radius:999px;
                padding:4px;
                width:78px;
                height:40px;
            }

            .theme-toggle-top button{
                width:32px;
                height:32px;
                border:none;
                border-radius:50%;
                background:transparent;
                color:#1e2a78;
                cursor:pointer;
                transition:.3s;
            }

            .theme-toggle-top button.active{
                background:#1e2a78;
                color:#fff;
            }

            body.dark-mode{
                background:#0f172a;
                color:white;
            }

            body.dark-mode .main-content{
                background:#0f172a !important;
            }

            body.dark-mode .sidebar{
                background:#0f172a !important;
            }

            body.dark-mode .top-card,
            body.dark-mode .welcome-bar,
            body.dark-mode .dashboard-card,
            body.dark-mode .table-box{
                background:#111827 !important;
                color:white !important;
                border:1px solid #1f2937 !important;
            }

            body.dark-mode .dashboard-card h3,
            body.dark-mode .dashboard-card p,
            body.dark-mode .table-box h2,
            body.dark-mode .table-box th,
            body.dark-mode .table-box td{
                color:white !important;
            }

            body.dark-mode .table-head{
                background:#1f2937 !important;
            }

            body.dark-mode .theme-toggle-top{
                background:#1e293b;
            }

            body.dark-mode table thead th {
                background: #1f2937 !important;
                color: #ffffff !important;
                border-bottom: 1px solid #374151 !important;
            }

            .welcome-modal,
            .logout-modal{
                position:fixed;
                inset:0;
                background:rgba(0,0,0,.45);
                backdrop-filter:blur(4px);
                display:flex;
                justify-content:center;
                align-items:center;
                z-index:99999;
            }

            .logout-modal{
                display:none;
            }

            .welcome-box,
            .logout-box{
                width:420px;
                background:white;
                border-radius:18px;
                padding:38px;
                text-align:center;
                box-shadow:0 20px 45px rgba(0,0,0,.25);
                animation:modalShow .4s ease;
            }

            .check-icon,
            .logout-icon{
                width:82px;
                height:82px;
                margin:0 auto 22px;
                border-radius:50%;
                display:flex;
                align-items:center;
                justify-content:center;
                font-size:38px;
            }

            .check-icon{
                border:4px solid #d8f5cf;
                color:#22c55e;
            }

            .logout-icon{
                border:4px solid #dbeafe;
                color:#2563eb;
            }

            @keyframes modalShow{
                from{opacity:0; transform:translateY(-25px) scale(.95);}
                to{opacity:1; transform:translateY(0) scale(1);}
            }

            .status.diproses {
    background: #e0e0e0;
    color: #333;
    padding: 5px 10px;
    border-radius: 6px;
    font-weight: 600;
    display: inline-block;
}

.status {
    padding: 4px 10px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 600;
    display: inline-block;
}

/* MENUNGGU */
.status.menunggu {
    background: #f3f4f6;
    color: #6b7280;
}

/* DIPROSES */
.status.diproses {
    background: #e0f2fe;
    color: #0284c7;
}

/* DISETUJUI */
.status.disetujui {
    background: #dcfce7;
    color: #16a34a;
}

/* DITOLAK */
.status.ditolak {
    background: #ef4444;
    color:#ffff;
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

        <a href="/dashboard-karyawan" class="active">
            <i class="fa-solid fa-house"></i> Beranda
        </a>

        <a href="/input-cuti">
            <i class="fa-solid fa-pen-to-square"></i> Input Cuti
        </a>

        <a href="/riwayat-cuti">
            <i class="fa-solid fa-clipboard-list"></i> Riwayat Cuti
        </a>

        

        <a href="javascript:void(0)" class="logout" onclick="showLogoutModal(event)">
            <i class="fa-solid fa-right-from-bracket"></i> Keluar
        </a>
    </div>

    <div class="main-content min-h-screen p-6">

        <div class="top-card bg-white rounded-xl px-8 py-6 flex justify-between items-center shadow-sm">
            <h1 class="text-3xl font-bold text-[#0d1f6b]">Dashboard Karyawan</h1>

            <div class="flex items-center gap-4">
                <div class="theme-toggle-top">
                    <button type="button" id="lightBtn" onclick="setLightMode()">
                        <i class="fa-solid fa-sun"></i>
                    </button>

                    <button type="button" id="darkBtn" onclick="setDarkMode()">
                        <i class="fa-solid fa-moon"></i>
                    </button>
                </div>

                <span class="font-semibold">{{ session('nama') }}</span>
                <i class="fa-solid fa-user"></i>
            </div>
        </div>

        <div class="welcome-bar bg-white mt-4 px-5 py-4 rounded-xl flex justify-between items-center font-bold text-[#0d1f6b] shadow-sm">
            <span>Selamat Datang, {{ session('nama') }}</span>
            <button class="close-welcome text-xl">×</button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">

            <div class="dashboard-card bg-white rounded-2xl shadow-md p-8 flex justify-between items-center hover:-translate-y-1 hover:shadow-xl transition-all">
                <div>
                    <h3 class="text-gray-500 text-base font-semibold mb-2">Sisa Cuti</h3>
                    <p class="text-4xl font-extrabold text-gray-900">{{ $user->sisa_cuti ?? 12 }}</p>
                </div>
                <i class="fa-solid fa-users text-5xl text-blue-500"></i>
            </div>

            <div class="dashboard-card bg-white rounded-2xl shadow-md p-8 flex justify-between items-center hover:-translate-y-1 hover:shadow-xl transition-all">
                <div>
                    <h3 class="text-gray-500 text-base font-semibold mb-2">Status Cuti</h3>
                    <p class="text-3xl font-extrabold text-gray-900">{{ ucfirst($statusCuti ?? 'Belum Ada') }}</p>
                </div>
                <i class="fa-solid fa-clipboard-check text-5xl text-green-500"></i>
            </div>

        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">

            <div class="dashboard-card bg-white rounded-2xl shadow-md p-8 flex justify-between items-center hover:-translate-y-1 hover:shadow-xl transition-all">
                <div>
                    <h3 class="text-gray-500 text-base font-semibold mb-2">Total Cuti Dipakai</h3>
                    <p class="text-4xl font-extrabold text-gray-900">{{ $totalDipakai ?? 0 }}</p>
                </div>
                <i class="fa-solid fa-calendar-check text-5xl text-cyan-400"></i>
            </div>

            <div class="dashboard-card bg-white rounded-2xl shadow-md p-8 flex justify-between items-center hover:-translate-y-1 hover:shadow-xl transition-all">
                <div>
                    <h3 class="text-gray-500 text-base font-semibold mb-2">Pengajuan Pending</h3>
                    <p class="text-4xl font-extrabold text-gray-900">{{ $pending ?? 0 }}</p>
                </div>
                <i class="fa-solid fa-clock text-5xl text-yellow-400"></i>
            </div>

            <div class="dashboard-card bg-white rounded-2xl shadow-md p-8 flex justify-between items-center hover:-translate-y-1 hover:shadow-xl transition-all">
                <div>
                    <h3 class="text-gray-500 text-base font-semibold mb-2">Divisi</h3>
                    <p class="text-3xl font-extrabold text-gray-900">{{ $user->divisi ?? '-' }}</p>
                </div>
                <i class="fa-solid fa-building text-5xl text-red-400"></i>
            </div>

        </div>

        <div class="table-box bg-white rounded-2xl shadow-md p-6 mt-8">
            <h2 class="text-3xl font-bold text-[#0d1f6b] mb-5">
                Riwayat Pengajuan Cuti
            </h2>

            <div class="overflow-x-auto">
                <table class="w-full border-collapse">
                    <thead class="table-head bg-gray-100">
                        <tr>
                            <th class="px-4 py-4 text-left">Jenis Cuti</th>
                            <th class="px-4 py-4 text-left">Tanggal Mulai</th>
                            <th class="px-4 py-4 text-left">Tanggal Selesai</th>
                            <th class="px-4 py-4 text-left">Jumlah Hari</th>
                            <th class="px-4 py-4 text-left">Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($riwayatCuti as $cuti)
                            <tr class="border-b border-gray-200">
                                <td class="px-4 py-4">{{ $cuti->nama_jenis_cuti ?? 'Cuti' }}</td>
                                <td class="px-4 py-4">{{ $cuti->tanggal_mulai }}</td>
                                <td class="px-4 py-4">{{ $cuti->tanggal_selesai }}</td>
                                <td class="px-4 py-4">{{ $cuti->jumlah_hari }}</td>
                                <td>
    @if($cuti->status_pengajuan == 'menunggu')
        <span class="status menunggu">Menunggu</span>

    @elseif($cuti->status_hrd == 'disetujui' && $cuti->status_direktur == 'menunggu')
        <span class="status diproses">Diproses</span>

    @elseif($cuti->status_pengajuan == 'disetujui')
        <span class="status disetujui">Disetujui</span>

    @elseif($cuti->status_pengajuan == 'ditolak')
        <span class="status ditolak">Ditolak</span>
    @endif
</td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-6">
                                    Belum ada riwayat cuti
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-6 flex gap-3">
            <a href="/input-cuti" class="bg-[#1e2a78] hover:bg-blue-900 text-white px-5 py-3 rounded-lg font-bold transition">
                <i class="fa-solid fa-plus"></i> Ajukan Cuti
            </a>

            <a href="/riwayat-cuti" class="bg-[#1e2a78] hover:bg-blue-900 text-white px-5 py-3 rounded-lg font-bold transition">
                <i class="fa-solid fa-clock-rotate-left"></i> Riwayat Cuti
            </a>
        </div>

    </div>

    @if(session('welcome_login_id'))
    <div id="welcomeModal" class="welcome-modal" data-login-id="{{ session('welcome_login_id') }}">
        <div class="welcome-box">
            <div class="check-icon">
                <i class="fa-solid fa-check"></i>
            </div>

            <h2 class="text-2xl font-bold text-gray-800 mb-3">Login berhasil</h2>
            <p class="text-gray-600 mb-6">Selamat Datang Kembali, {{ session('nama') }}!</p>

            <button onclick="closeWelcomeModal()" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg font-bold transition">
                OK
            </button>
        </div>
    </div>
    @endif

    <div id="logoutModal" class="logout-modal">
        <div class="logout-box">
            <div class="logout-icon">
                <i class="fa-solid fa-question"></i>
            </div>

            <h2 class="text-2xl font-bold text-gray-800 mb-2">Konfrimasi Keluar</h2>
            <p class="text-gray-600 mb-6">Apakah Anda yakin ingin keluar?</p>

            <div class="flex justify-center gap-3">
                <a href="/logout" class="bg-red-500 hover:bg-red-600 text-white px-6 py-3 rounded-lg font-bold transition">
                    Ya, Keluar
                </a>

                <button type="button" onclick="closeLogoutModal()" class="bg-gray-400 hover:bg-gray-500 text-white px-6 py-3 rounded-lg font-bold transition">
                    Batal
                </button>
            </div>
        </div>
    </div>

    <script>
    function toggleSidebar() {
        document.body.classList.toggle("sidebar-closed");

        localStorage.setItem(
            "sidebar",
            document.body.classList.contains("sidebar-closed") ? "closed" : "open"
        );
    }

    function setDarkMode() {
        document.body.classList.add("dark-mode");
        localStorage.setItem("theme", "dark");

        document.getElementById("darkBtn")?.classList.add("active");
        document.getElementById("lightBtn")?.classList.remove("active");
    }

    function setLightMode() {
        document.body.classList.remove("dark-mode");
        localStorage.setItem("theme", "light");

        document.getElementById("lightBtn")?.classList.add("active");
        document.getElementById("darkBtn")?.classList.remove("active");
    }

    document.addEventListener("DOMContentLoaded", function () {
        if (localStorage.getItem("sidebar") === "closed") {
            document.body.classList.add("sidebar-closed");
        }

        if (localStorage.getItem("theme") === "dark") {
            setDarkMode();
        } else {
            setLightMode();
        }

        const closeWelcome = document.querySelector(".close-welcome");

        if (closeWelcome) {
            closeWelcome.addEventListener("click", function () {
                document.querySelector(".welcome-bar").style.display = "none";
            });
        }

        const modal = document.getElementById("welcomeModal");

        if (modal) {
            const loginId = modal.dataset.loginId;
            const sudahMuncul = sessionStorage.getItem("welcome_login_id");

            modal.style.display = sudahMuncul === loginId ? "none" : "flex";
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

        const modal = document.getElementById("logoutModal");

        if (modal) {
            modal.style.display = "flex";
        }
    }

    function closeLogoutModal() {
        const modal = document.getElementById("logoutModal");

        if (modal) {
            modal.style.display = "none";
        }
    }
    </script>

    </body>
    </html>