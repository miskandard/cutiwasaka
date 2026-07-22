<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Riwayat Cuti</title>

    <link rel="icon" type="image/png" href="{{ asset('img/logo/wg.png') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <script>
        tailwind.config = {
            corePlugins: {
                preflight: false
            }
        }
    </script>
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

        .table-box {
            background: white;
            padding: 25px;
            border-radius: 14px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.08);
            margin-top: 25px;
        }

        .table-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .search-box input {
            padding: 10px 14px;
            border: 1px solid #ddd;
            border-radius: 8px;
            width: 230px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #f1f3f6;
            color: #0d1f6b;
            padding: 13px;
            text-align: left;
            white-space: nowrap;
        }

        td {
            padding: 13px;
            border-bottom: 1px solid #e5e7eb;
            white-space: nowrap;
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
            color: #111827;
        }

        .disetujui {
            background: #22c55e;
        }

        .ditolak {
            background: #ef4444;
        }

        .btn-detail {
            background: #1e2a78;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
        }

        .modal-detail {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.45);
            z-index: 9999;
            justify-content: center;
            align-items: center;
        }

        .modal-box {
            background: white;
            width: 900px;
            max-width: 92%;
            border-radius: 20px;
            padding: 35px;
            box-shadow: 0 15px 40px rgba(0,0,0,0.25);
        }

        .timeline-wrapper {
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 25px 0 35px;
        }

        .timeline-step {
            text-align: center;
            color: #aaa;
            font-weight: bold;
            min-width: 90px;
        }

        .circle {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: #d9d9d9;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: auto;
            margin-bottom: 8px;
            color: #111;
            font-weight: bold;
        }

        .timeline-step.active .circle {
            background: #1e2a78 !important;
            color: white !important;
        }

        .timeline-step.active span {
            color: #1e2a78 !important;
        }

        .timeline-step.reject .circle {
            background: #dc2626 !important;
            color: white !important;
        }

        .timeline-step.reject span {
            color: #dc2626 !important;
        }

        .timeline-line {
            width: 90px;
            height: 3px;
            background: #cfcfcf;
            margin-bottom: 28px;
        }

        .timeline-line.active {
            background: #1e2a78 !important;
        }

        .detail-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 22px;
            margin-top: 30px;
        }

        .detail-grid div {
            display: flex;
            flex-direction: column;
        }

        .detail-grid label {
            font-weight: bold;
            color: #1e2a78;
            margin-bottom: 8px;
            font-size: 15px;
        }

        .detail-grid input,
        .detail-grid textarea {
            width: 100%;
            padding: 14px;
            border: 1px solid #d8dbe8;
            border-radius: 12px;
            background: #f5f7ff;
            font-size: 15px;
            box-sizing: border-box;
        }

        .detail-grid textarea {
            height: 110px;
            resize: none;
        }

        .full {
            grid-column: span 2;
        }

        .btn-close-modal {
            margin-top: 25px;
            background: #777;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 10px;
            font-weight: bold;
            cursor: pointer;
        }

        .alasan-ditolak-box {
            display: none;
            margin-top: 20px;
        }

        .alasan-ditolak-box label {
            color: #dc2626;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .alasan-ditolak-box textarea {
            width: 100%;
            min-height: 90px;
            padding: 14px;
            border: 1px solid #fecaca;
            border-radius: 12px;
            background: #fef2f2;
            color: #991b1b;
            resize: none;
            box-sizing: border-box;
            font-size: 14px;
        }

        .logout-modal {
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,.5);
            backdrop-filter: blur(4px);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 999999;
        }

        .logout-box {
            width: 90%;
            max-width: 420px;
            background: #fff;
            border-radius: 12px;
            padding: 35px;
            text-align: center;
            box-shadow: 0 15px 40px rgba(0,0,0,.25);
        }

        .logout-icon {
            width: 70px;
            height: 70px;
            margin: 0 auto 20px;
            border: 3px solid #dbeafe;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
            color: #3b82f6;
        }

        .logout-buttons {
            margin-top: 25px;
            display: flex;
            justify-content: center;
            gap: 12px;
        }

        .btn-logout {
            background: #ef4444;
            color: white;
            text-decoration: none;
            padding: 12px 24px;
            border-radius: 8px;
            font-weight: bold;
        }

        .btn-cancel {
            background: #9ca3af;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 8px;
            cursor: pointer;
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
            box-shadow: 0 2px 8px rgba(0,0,0,0.2);
        }

        body.dark-mode {
            background: #0f172a;
            color: white;
        }

        body.dark-mode .main-content {
            background: #0f172a !important;
        }

        body.dark-mode .topbar,
        body.dark-mode .welcome-bar,
        body.dark-mode .table-box,
        body.dark-mode .notif-dropdown {
            background: #111827;
            color: white;
            border: 1px solid #1f2937;
        }

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

        body.dark-mode table thead th {
            background: #1f2937 !important;
            color: #ffffff !important;
            border-bottom: 1px solid #374151 !important;
        }

        body.dark-mode table tbody td {
            background: #111827 !important;
            color: #ffffff !important;
            border-bottom: 1px solid #374151 !important;
        }

        body.dark-mode .search-box input {
            background: #111827 !important;
            color: #ffffff !important;
            border: 1px solid #374151 !important;
        }

        body.dark-mode .modal-box,
        body.dark-mode .logout-box {
            background: #ffffff !important;
            color: #111827 !important;
        }

        body.dark-mode .modal-box label,
        body.dark-mode .modal-box h2 {
            color: #1e2a78 !important;
        }

        body.dark-mode .modal-box input,
        body.dark-mode .modal-box textarea {
            background: #eef4ff !important;
            color: #111827 !important;
            border: 1px solid #94a3b8 !important;
        }

        body.dark-mode .sidebar{
            background:#0f172a !important;
        }


        .status.diproses {
            background: #e0e0e0;
            color: #333;
            padding: 5px 10px;
            border-radius: 6px;
            font-weight: 600;
            display: inline-block;
        }

        @media (max-width: 1023.98px) {
            .detail-grid {
                grid-template-columns: 1fr !important;
                gap: 15px !important;
            }
            .full {
                grid-column: span 1 !important;
            }
            .timeline-wrapper {
                flex-direction: column !important;
                gap: 5px !important;
            }
            .timeline-line {
                width: 3px !important;
                height: 30px !important;
                margin: 5px auto !important;
            }
            .timeline-step {
                min-width: auto !important;
            }
        }

        @media (max-width: 768px) {
            .table-header {
                flex-direction: column !important;
                align-items: flex-start !important;
                gap: 15px !important;
            }
            .search-box {
                width: 100% !important;
            }
            .search-box input {
                width: 100% !important;
                box-sizing: border-box !important;
            }
            .table-box {
                padding: 10px !important;
                box-shadow: none !important;
                background: transparent !important;
                border: none !important;
            }
            body.dark-mode .table-box {
                background: transparent !important;
                border: none !important;
            }
            .table-header h2 {
                font-size: 20px !important;
                margin-bottom: 5px !important;
            }
            
            /* Mobile Cards Styles */
            .riwayat-card {
                border-radius: 12px;
                box-shadow: 0 4px 12px rgba(0,0,0,0.04);
                border: 1px solid #eef2f6;
                margin-bottom: 15px;
                transition: all 0.25s ease;
                background: white;
            }
            body.dark-mode .riwayat-card {
                background: #111827 !important;
                border-color: #1f2937 !important;
            }
            .riwayat-card:hover {
                transform: translateY(-2px);
                box-shadow: 0 8px 16px rgba(0,0,0,0.08);
            }
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

    <a href="/dashboard-karyawan">
        <i class="fa-solid fa-house"></i> Beranda
    </a>

    <a href="/input-cuti">
        <i class="fa-solid fa-pen-to-square"></i> Input Cuti
    </a>

    <a href="/riwayat-cuti" class="active">
        <i class="fa-solid fa-clipboard-list"></i> Riwayat Cuti
    </a>

    <a href="javascript:void(0)" class="logout" onclick="showLogoutModal(event)">
        <i class="fa-solid fa-right-from-bracket"></i> Keluar
    </a>
</div>

<!-- Sidebar Overlay for mobile -->
<div class="sidebar-overlay" onclick="toggleSidebar()"></div>

<div class="main-content">

    <div class="topbar d-flex justify-content-between align-items-center px-4 py-3">
        <div class="d-flex align-items-center gap-3">
            <button type="button" class="lg:hidden text-2xl text-[#0d1f6b] hover:text-blue-900 border-none bg-transparent cursor-pointer p-0" onclick="toggleSidebar()">
                <i class="fa-solid fa-bars"></i>
            </button>
            <h1 class="fw-bold font-bold text-primary-emphasis mb-0 fs-3">Riwayat Cuti</h1>
        </div>

        <div class="user-box d-flex align-items-center gap-3">
            <div class="theme-toggle-top scale-90 sm:scale-100">
                <button type="button" id="lightBtn" onclick="setLightMode()">
                    <i class="fa-solid fa-sun"></i>
                </button>

                <button type="button" id="darkBtn" onclick="setDarkMode()">
                    <i class="fa-solid fa-moon"></i>
                </button>
            </div>

            <span class="font-semibold hidden sm:inline-block">{{ session('nama') }}</span>
            <i class="fa-solid fa-user"></i>
        </div>
    </div>

    

    <div class="table-box">
        <div class="table-header">
            <h2>Data Riwayat Cuti</h2>

            <div class="search-box">
                <input type="text" id="searchInput" placeholder="Cari riwayat cuti">
            </div>
        </div>

        <div class="overflow-x-auto hidden md:block">
            <table id="riwayatTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Jenis Cuti</th>
                        <th>Tanggal Pengajuan</th>
                        <th>Tanggal Mulai</th>
                        <th>Tanggal Selesai</th>
                        <th>Jumlah Hari</th>
                        <th>Keterangan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($riwayatCuti as $cuti)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $cuti->nama_jenis_cuti ?? 'Cuti' }}</td>
                            <td>{{ $cuti->tanggal_pengajuan }}</td>
                            <td>{{ $cuti->tanggal_mulai }}</td>
                            <td>{{ $cuti->tanggal_selesai }}</td>
                            <td>{{ $cuti->jumlah_hari }}</td>
                            <td>{{ $cuti->alasan_pengajuan }}</td>

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

                            <td>
                                <button
                                    type="button"
                                    class="btn-detail"
                                    data-jenis="{{ $cuti->nama_jenis_cuti ?? 'Cuti' }}"
                                    data-pengajuan="{{ $cuti->tanggal_pengajuan }}"
                                    data-mulai="{{ $cuti->tanggal_mulai }}"
                                    data-selesai="{{ $cuti->tanggal_selesai }}"
                                    data-jumlah="{{ $cuti->jumlah_hari }}"
                                    data-keterangan="{{ $cuti->alasan_pengajuan }}"
                                    data-status="{{ $cuti->status_pengajuan }}"
                                    data-hrd="{{ $cuti->status_hrd ?? (($cuti->status_pengajuan == 'diproses' || $cuti->status_pengajuan == 'disetujui') ? 'disetujui' : 'menunggu') }}"
                                    data-direktur="{{ $cuti->status_direktur ?? ($cuti->status_pengajuan == 'disetujui' ? 'disetujui' : 'menunggu') }}"
                                    data-alasan-ditolak="{{ $cuti->alasan_ditolak ?? '' }}"
                                    onclick="openDetailFromButton(this)"
                                >
                                    Detail
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" style="text-align:center;">
                                Belum ada riwayat cuti
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Card view on mobile screen -->
        <div class="block md:hidden space-y-4 mt-2" id="riwayatCardContainer">
            @forelse($riwayatCuti as $cuti)
                <div class="riwayat-card p-5 transition">
                    <div class="flex justify-between items-start mb-3">
                        <div>
                            <span class="text-xs text-gray-400 font-semibold block mb-1">
                                #{{ $loop->iteration }} - {{ $cuti->tanggal_pengajuan }}
                            </span>
                            <h4 class="font-bold text-lg text-[#0d1f6b] dark:text-white">
                                {{ $cuti->nama_jenis_cuti ?? 'Cuti' }}
                            </h4>
                        </div>
                        <div>
                            @if($cuti->status_pengajuan == 'menunggu')
                                <span class="status menunggu text-xs">Menunggu</span>
                            @elseif($cuti->status_hrd == 'disetujui' && $cuti->status_direktur == 'menunggu')
                                <span class="status diproses text-xs">Diproses</span>
                            @elseif($cuti->status_pengajuan == 'disetujui')
                                <span class="status disetujui text-xs">Disetujui</span>
                            @elseif($cuti->status_pengajuan == 'ditolak')
                                <span class="status ditolak text-xs">Ditolak</span>
                            @endif
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3 text-sm border-t border-b border-gray-100 dark:border-gray-800 py-3 my-3">
                        <div>
                            <span class="text-gray-400 block text-xs">TANGGAL MULAI</span>
                            <span class="font-semibold text-gray-700 dark:text-gray-200">{{ $cuti->tanggal_mulai }}</span>
                        </div>
                        <div>
                            <span class="text-gray-400 block text-xs">TANGGAL SELESAI</span>
                            <span class="font-semibold text-gray-700 dark:text-gray-200">{{ $cuti->tanggal_selesai }}</span>
                        </div>
                        <div class="col-span-2">
                            <span class="text-gray-400 block text-xs">JUMLAH HARI</span>
                            <span class="font-semibold text-gray-700 dark:text-gray-200">{{ $cuti->jumlah_hari }} Hari</span>
                        </div>
                    </div>

                    <div class="mb-4">
                        <span class="text-gray-400 block text-xs mb-1">KETERANGAN</span>
                        <p class="text-gray-700 dark:text-gray-300 text-sm italic">
                            "{{ $cuti->alasan_pengajuan ?? '-' }}"
                        </p>
                    </div>

                    <div class="flex justify-end">
                        <button
                            type="button"
                            class="btn-detail w-full text-center py-2.5 flex items-center justify-center gap-2"
                            data-jenis="{{ $cuti->nama_jenis_cuti ?? 'Cuti' }}"
                            data-pengajuan="{{ $cuti->tanggal_pengajuan }}"
                            data-mulai="{{ $cuti->tanggal_mulai }}"
                            data-selesai="{{ $cuti->tanggal_selesai }}"
                            data-jumlah="{{ $cuti->jumlah_hari }}"
                            data-keterangan="{{ $cuti->alasan_pengajuan }}"
                            data-status="{{ $cuti->status_pengajuan }}"
                            data-hrd="{{ $cuti->status_hrd ?? (($cuti->status_pengajuan == 'diproses' || $cuti->status_pengajuan == 'disetujui') ? 'disetujui' : 'menunggu') }}"
                            data-direktur="{{ $cuti->status_direktur ?? ($cuti->status_pengajuan == 'disetujui' ? 'disetujui' : 'menunggu') }}"
                            data-alasan-ditolak="{{ $cuti->alasan_ditolak ?? '' }}"
                            onclick="openDetailFromButton(this)"
                        >
                            <i class="fa-solid fa-circle-info"></i> Detail Pengajuan
                        </button>
                    </div>
                </div>
            @empty
                <div class="bg-white dark:bg-[#111827] text-center py-8 rounded-xl border border-dashed border-gray-200 dark:border-gray-800">
                    <p class="text-gray-500">Belum ada riwayat cuti</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

<div id="detailModal" class="modal-detail">
    <div class="modal-box">
        <h2>Detail Pengajuan Cuti</h2>

        @php
            $steps = [
                ['id' => 'Pengajuan', 'label' => 'Pengajuan'],
                ['id' => 'Hrd', 'label' => 'HRD'],
                ['id' => 'Direktur', 'label' => 'Direktur'],
                ['id' => 'Selesai', 'label' => 'Selesai'],
            ];

            $lines = ['Hrd', 'Direktur', 'Selesai'];
        @endphp

        <div class="timeline-wrapper">
            @foreach($steps as $i => $step)
                <div class="timeline-step {{ $i == 0 ? 'active' : '' }}" id="step{{ $step['id'] }}">
                    <div class="circle">{{ $i + 1 }}</div>
                    <span>{{ $step['label'] }}</span>
                </div>

                @if($i < count($lines))
                    <div class="timeline-line" id="line{{ $lines[$i] }}"></div>
                @endif
            @endforeach
        </div>

        <div class="detail-grid">
            <div>
                <label>Jenis Cuti</label>
                <input type="text" id="detail_jenis" readonly>
            </div>

            <div>
                <label>Tanggal Pengajuan</label>
                <input type="text" id="detail_pengajuan" readonly>
            </div>

            <div>
                <label>Tanggal Mulai</label>
                <input type="text" id="detail_mulai" readonly>
            </div>

            <div>
                <label>Tanggal Selesai</label>
                <input type="text" id="detail_selesai" readonly>
            </div>

            <div>
                <label>Jumlah Hari</label>
                <input type="text" id="detail_jumlah" readonly>
            </div>

            <div>
                <label>Status</label>
                <input type="text" id="detail_status" readonly>
            </div>

            <div class="full">
                <label>Keterangan</label>
                <textarea id="detail_keterangan" readonly></textarea>
            </div>
        </div>

        <div class="full alasan-ditolak-box" id="box_alasan_ditolak">
            <label>Alasan Ditolak</label>
            <textarea id="detail_alasan_ditolak" readonly></textarea>
        </div>

        <button type="button" class="btn-close-modal" onclick="closeDetailModal()">
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
        <p>Apakah Anda yakin ingin keluar?</p>

        <div class="logout-buttons">
            <a href="/logout" class="btn-logout">
                Ya, Keluar
            </a>

            <button type="button" class="btn-cancel" onclick="closeLogoutModal()">
                Batal
            </button>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    initSearch();
    initTheme();
    initSidebar();
    initWelcomeClose();
});

function initSearch() {
    const searchInput = document.getElementById("searchInput");

    if (!searchInput) return;

    searchInput.addEventListener("keyup", function () {
        const filter = this.value.toLowerCase();
        
        // Filter table rows
        const rows = document.querySelectorAll("#riwayatTable tbody tr");
        rows.forEach(function (row) {
            row.style.display = row.textContent.toLowerCase().includes(filter) ? "" : "none";
        });

        // Filter mobile cards
        const cards = document.querySelectorAll("#riwayatCardContainer .riwayat-card");
        cards.forEach(function (card) {
            card.style.display = card.textContent.toLowerCase().includes(filter) ? "" : "none";
        });
    });
}

function initTheme() {
    const theme = localStorage.getItem("theme");

    if (theme === "dark") {
        setDarkMode();
    } else {
        setLightMode();
    }
}

function initSidebar() {
    const savedSidebarState = localStorage.getItem("sidebar");
    if (savedSidebarState === "closed" || (!savedSidebarState && window.innerWidth < 1024)) {
        document.body.classList.add("sidebar-closed");
    }
}

function initWelcomeClose() {
    const closeWelcome = document.getElementById("closeWelcome");

    if (!closeWelcome) return;

    closeWelcome.addEventListener("click", function () {
        const welcomeBar = document.querySelector(".welcome-bar");

        if (!welcomeBar) return;

        welcomeBar.style.opacity = "0";
        welcomeBar.style.transform = "translateY(-10px)";

        setTimeout(function () {
            welcomeBar.style.display = "none";
        }, 300);
    });
}

function toggleSidebar() {
    document.body.classList.toggle("sidebar-closed");

    localStorage.setItem(
        "sidebar",
        document.body.classList.contains("sidebar-closed") ? "closed" : "open"
    );
}

function formatStatus(status) {
    status = (status || "").toLowerCase();

    const labels = {
        menunggu: "Menunggu",
        diproses: "Diproses",
        disetujui: "Disetujui",
        ditolak: "Ditolak"
    };

    return labels[status] || status || "-";
}

function openDetailFromButton(button) {
    openDetailModal({
        jenis: button.dataset.jenis,
        pengajuan: button.dataset.pengajuan,
        mulai: button.dataset.mulai,
        selesai: button.dataset.selesai,
        jumlah: button.dataset.jumlah,
        keterangan: button.dataset.keterangan,
        status: button.dataset.status,
        hrd: button.dataset.hrd,
        direktur: button.dataset.direktur,
        alasanDitolak: button.dataset.alasanDitolak
    });
}

function openDetailModal(data) {
    const status = normalizeStatus(data.status);
    const statusHrd = normalizeStatus(data.hrd);
    const statusDirektur = normalizeStatus(data.direktur);

    setValue("detail_jenis", data.jenis || "-");
    setValue("detail_pengajuan", data.pengajuan || "-");
    setValue("detail_mulai", data.mulai || "-");
    setValue("detail_selesai", data.selesai || "-");
    setValue("detail_jumlah", data.jumlah || "0");
    setValue("detail_keterangan", data.keterangan || "-");
    setValue("detail_status", formatStatus(status));

    handleAlasanDitolak(status, data.alasanDitolak);
    resetTimeline();

    activateStep("Pengajuan");

    if (statusHrd === "ditolak") {
        activateLine("Hrd");
        rejectStep("Hrd");
        showDetailModal();
        return;
    }

    if (statusHrd === "disetujui" || status === "diproses" || status === "disetujui") {
        activateLine("Hrd");
        activateStep("Hrd");
    }

    if (statusDirektur === "ditolak") {
        activateLine("Direktur");
        rejectStep("Direktur");
        showDetailModal();
        return;
    }

    if (statusDirektur === "disetujui" || status === "disetujui") {
        activateLine("Direktur");
        activateStep("Direktur");
    }

    if (status === "disetujui") {
        activateLine("Selesai");
        activateStep("Selesai");
    }

    showDetailModal();
}

function normalizeStatus(value) {
    return (value || "menunggu").toString().trim().toLowerCase();
}

function setValue(id, value) {
    const element = document.getElementById(id);

    if (element) {
        element.value = value;
    }
}

function handleAlasanDitolak(status, alasanDitolak) {
    const boxAlasan = document.getElementById("box_alasan_ditolak");
    const inputAlasan = document.getElementById("detail_alasan_ditolak");

    if (!boxAlasan || !inputAlasan) return;

    if (status === "ditolak") {
        boxAlasan.style.display = "block";
        inputAlasan.value = alasanDitolak || "Tidak ada alasan penolakan";
    } else {
        boxAlasan.style.display = "none";
        inputAlasan.value = "";
    }
}

function resetTimeline() {
    const steps = {
        Pengajuan: "1",
        Hrd: "2",
        Direktur: "3",
        Selesai: "4"
    };

    Object.keys(steps).forEach(function (key) {
        const step = document.getElementById("step" + key);

        if (!step) return;

        step.classList.remove("active", "reject");

        const circle = step.querySelector(".circle");
        const text = step.querySelector("span");

        if (circle) {
            circle.innerHTML = steps[key];
            circle.removeAttribute("style");
        }

        if (text) {
            text.removeAttribute("style");
        }
    });

    ["Hrd", "Direktur", "Selesai"].forEach(function (key) {
        const line = document.getElementById("line" + key);

        if (!line) return;

        line.classList.remove("active");
        line.removeAttribute("style");
    });
}

function activateStep(key) {
    const step = document.getElementById("step" + key);

    if (!step) return;

    step.classList.add("active");

    const circle = step.querySelector(".circle");
    const text = step.querySelector("span");

    if (circle) {
        circle.style.background = "#1e2a78";
        circle.style.color = "#ffffff";
    }

    if (text) {
        text.style.color = "#1e2a78";
    }
}

function activateLine(key) {
    const line = document.getElementById("line" + key);

    if (!line) return;

    line.classList.add("active");
    line.style.background = "#1e2a78";
}

function rejectStep(key) {
    const step = document.getElementById("step" + key);

    if (!step) return;

    step.classList.add("reject");

    const circle = step.querySelector(".circle");
    const text = step.querySelector("span");

    if (circle) {
        circle.innerHTML = "✕";
        circle.style.background = "#dc2626";
        circle.style.color = "#ffffff";
    }

    if (text) {
        text.style.color = "#dc2626";
    }
}

function showDetailModal() {
    const modal = document.getElementById("detailModal");

    if (modal) {
        modal.style.display = "flex";
    }
}

function closeDetailModal() {
    const modal = document.getElementById("detailModal");

    if (modal) {
        modal.style.display = "none";
    }
}

function showLogoutModal(event) {
    event.preventDefault();
    event.stopPropagation();

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

function setDarkMode() {
    document.body.classList.add("dark-mode");
    localStorage.setItem("theme", "dark");

    const darkBtn = document.getElementById("darkBtn");
    const lightBtn = document.getElementById("lightBtn");

    if (darkBtn) darkBtn.classList.add("active");
    if (lightBtn) lightBtn.classList.remove("active");
}

function setLightMode() {
    document.body.classList.remove("dark-mode");
    localStorage.setItem("theme", "light");

    const lightBtn = document.getElementById("lightBtn");
    const darkBtn = document.getElementById("darkBtn");

    if (lightBtn) lightBtn.classList.add("active");
    if (darkBtn) darkBtn.classList.remove("active");
}
</script>

</body>
</html>