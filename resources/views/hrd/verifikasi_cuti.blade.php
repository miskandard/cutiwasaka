<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Cuti</title>

    <link rel="icon" type="image/png" href="{{ asset('img/logo/wg.png') }}">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <link rel="stylesheet" href="{{ asset('css/hrd.css') }}">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- Google Fonts for Modern Typography -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS CDN for mobile cards and responsiveness -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    }
                }
            }
        }
    </script>

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

.modal-backdrop.show{
    opacity:.5 !important;
}

body:not(.modal-open) .modal-backdrop{
    display:none !important;
}

.modal {
    z-index: 1055 !important;
}

.modal-backdrop {
    z-index: 1050 !important;
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

        /* ==========================================================================
           DESKTOP POLISH (>= 769px)
           ========================================================================== */
        @media (min-width: 769px) {
            .card {
                border-radius: 20px !important;
                box-shadow: 0 4px 20px -2px rgba(0,0,0,0.05), 0 2px 8px -1px rgba(0,0,0,0.03) !important;
                border: 1px solid #e2e8f0 !important;
                padding: 10px !important;
                transition: background 0.3s, border-color 0.3s;
            }
        }

        /* ==========================================================================
           TABLET & MOBILE RESPONSIVE OVERRIDES
           ========================================================================== */
        @media (max-width: 768px) {
            .sidebar {
                position: fixed !important;
                left: 0 !important;
                top: 0 !important;
                bottom: 0 !important;
                width: 270px !important;
                z-index: 1000 !important;
                transform: translateX(0) !important;
                transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
            }
            
            body.sidebar-closed .sidebar {
                transform: translateX(-100%) !important;
                width: 270px !important;
            }

            .main-content {
                margin-left: 0 !important;
                padding: 15px !important;
            }

            body.sidebar-closed .main-content {
                margin-left: 0 !important;
            }

            .sidebar-overlay {
                position: fixed;
                inset: 0;
                background: rgba(15, 23, 42, 0.5);
                backdrop-filter: blur(4px);
                z-index: 998;
                opacity: 0;
                transition: opacity 0.3s ease;
                display: none;
            }

            body:not(.sidebar-closed) .sidebar-overlay {
                display: block !important;
                opacity: 1 !important;
            }

            .logout {
                width: 100% !important;
                left: 0 !important;
                padding: 12px 20px !important;
                box-sizing: border-box !important;
            }

            /* Custom Topbar positioning for Mobile Header */
            .topbar {
                display: flex !important;
                align-items: center !important;
                justify-content: space-between !important;
                position: relative !important;
                padding: 12px 16px !important;
                height: 64px !important;
            }

            .topbar-left {
                display: flex !important;
                align-items: center !important;
                width: auto !important;
            }

            .topbar-left h1 {
                position: absolute !important;
                left: 50% !important;
                transform: translateX(-50%) !important;
                margin: 0 !important;
                font-size: 1.15rem !important;
                font-weight: 700 !important;
                white-space: nowrap !important;
            }

            .user-box {
                display: flex !important;
                align-items: center !important;
                gap: 8px !important;
            }

            .user-box span {
                display: none !important;
            }

            /* Responsive Controls */
            .card-body > .d-flex {
                flex-direction: column !important;
                align-items: stretch !important;
                gap: 16px !important;
            }

            .card-body > .d-flex input {
                width: 100% !important;
                height: 44px !important;
                border-radius: 12px !important;
            }

            .card-body > .d-flex h4 {
                margin: 0 !important;
                font-size: 1.25rem !important;
                font-weight: 700 !important;
                text-align: center !important;
            }
        }

        /* ==========================================================================
           LOGOUT MODAL POLISH
           ========================================================================== */
        .logout-box {
            border-radius: 20px !important;
            padding: 32px !important;
            max-width: 380px !important;
            width: 90% !important;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25) !important;
            border: 1px solid #e2e8f0 !important;
        }

        body.dark-mode .logout-box {
            background: #111827 !important;
            border-color: #374151 !important;
            color: white !important;
        }

        .logout-buttons {
            margin-top: 20px;
            display: flex;
            gap: 12px;
            width: 100%;
        }

        .logout-buttons a, .logout-buttons button {
            flex: 1;
            height: 44px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            border-radius: 12px;
            font-size: 14px;
            transition: all 0.2s;
            border: none;
            cursor: pointer;
        }

        @media (max-width: 768px) {
            .logout-buttons {
                flex-direction: column !important;
                gap: 10px !important;
            }
            .logout-buttons a, .logout-buttons button {
                width: 100% !important;
            }
        }

        .theme-toggle-top button.active {
            background: #1e2a78 !important;
            color: white !important;
        }
        .dark .theme-toggle-top button.active {
            background: #2563eb !important;
            color: white !important;
        }

        .mobile-toggle-btn {
            display: none !important;
        }

        @media (max-width: 768px) {
            .mobile-toggle-btn {
                display: inline-flex !important;
                background: transparent !important;
                border: none !important;
                font-size: 24px !important;
                color: #1e2a78 !important;
                cursor: pointer !important;
                padding: 0 !important;
                align-items: center !important;
                justify-content: center !important;
                margin-right: 12px !important;
            }
            body.dark-mode .mobile-toggle-btn,
            .dark .mobile-toggle-btn {
                color: #ffffff !important;
            }
        }

        /* ==========================================
           SUPER NARROW DEVICES (width < 320px, down to 240px)
           ========================================== */
        @media (max-width: 320px) {
            .sidebar {
                width: 100vw !important;
                max-width: 100% !important;
            }
            body.sidebar-closed .sidebar {
                transform: translateX(-100vw) !important;
            }
            .topbar {
                flex-wrap: wrap !important;
                height: auto !important;
                padding: 10px !important;
                gap: 8px !important;
            }
            .topbar-left {
                width: 100% !important;
                justify-content: center !important;
                position: relative !important;
            }
            .topbar-left h1 {
                position: static !important;
                transform: none !important;
                font-size: 1rem !important;
            }
            .mobile-toggle-btn {
                position: absolute !important;
                left: 0 !important;
                top: 50% !important;
                transform: translateY(-50%) !important;
                margin-right: 0 !important;
            }
            .user-box {
                width: 100% !important;
                justify-content: center !important;
                gap: 10px !important;
            }
            .leave-card {
                padding: 12px !important;
            }
            .modal-content {
                padding: 15px !important;
            }
            .modal-footer {
                flex-direction: column !important;
                align-items: stretch !important;
                gap: 8px !important;
            }
            .modal-footer button {
                width: 100% !important;
                margin: 0 !important;
            }
            .modal-body .d-flex.gap-4 {
                flex-direction: column !important;
                gap: 10px !important;
            }
        }
    </style>
</head>

<body>

    <div class="sidebar-overlay" onclick="toggleSidebar()"></div>

    <!-- SIDEBAR -->
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

    <!-- MAIN CONTENT -->
    <div class="main-content">

        <!-- TOPBAR -->
        <div class="topbar d-flex justify-content-between align-items-center">
            <div class="topbar-left">
                <button type="button" class="mobile-toggle-btn" onclick="toggleSidebar()">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <h1 class="fw-bold text-primary-emphasis m-0">Verifikasi Cuti</h1>
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

                <span>{{ session('nama') }}</span>
                <i class="fa-solid fa-user"></i>
            </div>
        </div>

        <div class="card shadow-sm border-0 mt-4">
            <div class="card-body">

                @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="fw-bold text-primary-emphasis m-0">Pengajuan Cuti</h4>

                    <input type="text" id="searchInput" class="form-control w-25" placeholder="Cari nama karyawan">
                </div>

                <!-- TABLE VIEW (Tablet & Desktop: >= 768px) -->
                <div class="hidden md:block table-responsive">
                    <table class="table table-hover align-middle" id="cutiTable">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Jenis Cuti</th>
                                <th>Divisi</th>
                                <th>Tanggal Mulai</th>
                                <th>Tanggal Selesai</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($pengajuanCuti as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->nama ?? '-' }}</td>
                                <td>{{ $item->nama_jenis_cuti ?? 'Cuti' }}</td>
                                <td>{{ $item->divisi ?? '-' }}</td>
                                <td>{{ $item->tanggal_mulai }}</td>
                                <td>{{ $item->tanggal_selesai }}</td>

                                <td>
                                    @if($item->status_hrd == 'menunggu')
                                    <span class="status menunggu">Menunggu</span>

                                    @elseif($item->status_hrd == 'disetujui')
                                    <span class="status disetujui">Disetujui</span>

                                    @elseif($item->status_hrd == 'ditolak')
                                    <span class="status ditolak">Ditolak</span>
                                    @endif
                                </td>

                                <td>
                                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#modalVerifikasi" data-id="{{ $item->id_pengajuan }}"
                                        data-nama="{{ $item->nama ?? '-' }}"
                                        data-jenis="{{ $item->nama_jenis_cuti ?? 'Cuti' }}"
                                        data-jumlah="{{ $item->jumlah_hari ?? 0 }}"
                                        data-sisa="{{ $item->sisa_cuti ?? 0 }}" data-mulai="{{ $item->tanggal_mulai }}"
                                        data-selesai="{{ $item->tanggal_selesai }}"
                                        data-alasan="{{ $item->alasan_pengajuan ?? '-' }}"
                                        data-dokumen="{{ $item->dokumen_pendukung ? asset('storage/' . $item->dokumen_pendukung) : '' }}"
                                        onclick="isiModal(this)">
                                        Lihat
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center">
                                    Belum ada data pengajuan cuti
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- CARD VIEW (Smartphone: < 768px) -->
                <div class="block md:hidden space-y-4" id="leaveCards">
                    @forelse($pengajuanCuti as $item)
                    <div class="leave-card bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-md border border-gray-100 dark:border-gray-700 hover:-translate-y-1 hover:shadow-lg transition-all duration-300 flex flex-col gap-4">
                        <!-- Card Header -->
                        <div class="flex items-center gap-3 border-b border-gray-100 dark:border-gray-700 pb-3">
                            <div class="w-10 h-10 rounded-xl bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 flex items-center justify-center text-lg">
                                <i class="fa-solid fa-user"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="font-bold text-lg text-gray-800 dark:text-white truncate m-0">{{ $item->nama ?? '-' }}</h3>
                                <span class="inline-flex text-[10px] font-bold uppercase tracking-wider text-gray-400">#{{ $loop->iteration }}</span>
                            </div>
                        </div>

                        <!-- Card Fields -->
                        <div class="grid grid-cols-1 gap-2.5 text-sm">
                            <div class="flex justify-between items-center py-0.5">
                                <span class="text-gray-400 flex items-center gap-2">
                                    <i class="fa-solid fa-umbrella-beach text-blue-500 w-5 text-center"></i> Jenis Cuti
                                </span>
                                <span class="font-semibold text-gray-800 dark:text-gray-200 text-right">{{ $item->nama_jenis_cuti ?? 'Cuti' }}</span>
                            </div>
                            <div class="flex justify-between items-center py-0.5 border-t border-gray-50 dark:border-gray-800/40">
                                <span class="text-gray-400 flex items-center gap-2">
                                    <i class="fa-solid fa-building text-blue-500 w-5 text-center"></i> Divisi
                                </span>
                                <span class="font-medium text-gray-800 dark:text-gray-200 text-right">{{ $item->divisi ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between items-center py-0.5 border-t border-gray-50 dark:border-gray-800/40">
                                <span class="text-gray-400 flex items-center gap-2">
                                    <i class="fa-solid fa-calendar-day text-blue-500 w-5 text-center"></i> Mulai
                                </span>
                                <span class="font-medium text-gray-800 dark:text-gray-200 text-right">{{ $item->tanggal_mulai }}</span>
                            </div>
                            <div class="flex justify-between items-center py-0.5 border-t border-gray-50 dark:border-gray-800/40">
                                <span class="text-gray-400 flex items-center gap-2">
                                    <i class="fa-solid fa-calendar-check text-blue-500 w-5 text-center"></i> Selesai
                                </span>
                                <span class="font-medium text-gray-800 dark:text-gray-200 text-right">{{ $item->tanggal_selesai }}</span>
                            </div>
                            <div class="flex justify-between items-center py-0.5 border-t border-gray-50 dark:border-gray-800/40">
                                <span class="text-gray-400 flex items-center gap-2">
                                    <i class="fa-solid fa-circle-info text-blue-500 w-5 text-center"></i> Status
                                </span>
                                <div>
                                    @if($item->status_hrd == 'menunggu')
                                    <span class="status menunggu">Menunggu</span>
                                    @elseif($item->status_hrd == 'disetujui')
                                    <span class="status disetujui">Disetujui</span>
                                    @elseif($item->status_hrd == 'ditolak')
                                    <span class="status ditolak">Ditolak</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Card Action -->
                        <div class="mt-2 pt-3 border-t border-gray-100 dark:border-gray-700">
                            <button type="button" class="btn btn-primary w-full h-11 d-flex align-items-center justify-content-center fw-bold rounded-3 cursor-pointer" data-bs-toggle="modal"
                                data-bs-target="#modalVerifikasi" data-id="{{ $item->id_pengajuan }}"
                                data-nama="{{ $item->nama ?? '-' }}"
                                data-jenis="{{ $item->nama_jenis_cuti ?? 'Cuti' }}"
                                data-jumlah="{{ $item->jumlah_hari ?? 0 }}"
                                data-sisa="{{ $item->sisa_cuti ?? 0 }}" data-mulai="{{ $item->tanggal_mulai }}"
                                data-selesai="{{ $item->tanggal_selesai }}"
                                data-alasan="{{ $item->alasan_pengajuan ?? '-' }}"
                                data-dokumen="{{ $item->dokumen_pendukung ? asset('storage/' . $item->dokumen_pendukung) : '' }}"
                                onclick="isiModal(this)">
                                Lihat
                            </button>
                        </div>
                    </div>
                    @empty
                    <div class="text-center p-6 text-muted border border-dashed rounded-xl">
                        Belum ada data pengajuan cuti
                    </div>
                    @endforelse
                </div>

            </div>
        </div>
    </div>

    <!-- MODAL BOOTSTRAP -->
    <div class="modal fade" id="modalVerifikasi" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 rounded-4 shadow">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold text-primary-emphasis m-0">
                        Verifikasi Pengajuan Cuti
                    </h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form id="formVerifikasi" method="POST" novalidate>
                    @csrf

                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nama Lengkap</label>
                            <input type="text" id="modal_nama" class="form-control" readonly>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Jenis Cuti</label>
                                <input type="text" id="modal_jenis" class="form-control" readonly>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Cuti Diambil</label>
                                <input type="text" id="modal_jumlah" class="form-control" readonly>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Sisa Cuti</label>
                                <input type="text" id="modal_sisa" class="form-control" readonly>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Tanggal Mulai</label>
                                <input type="text" id="modal_mulai" class="form-control" readonly>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Tanggal Selesai</label>
                                <input type="text" id="modal_selesai" class="form-control" readonly>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Keterangan Cuti</label>
                            <input type="text" id="modal_alasan" class="form-control" readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold mb-2">Dokumen Pendukung</label>

                            <div id="modal_dokumen_box">
                                <a href="#" target="_blank" id="modal_dokumen_link"
                                    class="btn btn-outline-primary btn-sm">
                                    <i class="fa-solid fa-file"></i> Lihat Dokumen
                                </a>
                            </div>

                            <div id="modal_dokumen_empty" class="text-muted">
                                Tidak ada dokumen
                            </div>
                        </div>

                       <div class="d-flex gap-4 mb-3">
    <div class="form-check">
        <input
            class="form-check-input"
            type="radio"
            name="status_pengajuan"
            value="disetujui"
            id="status_disetujui"
            required
            onclick="toggleAlasanDitolak()">

        <label class="form-check-label" for="status_disetujui">
            Diterima
        </label>
    </div>

    <div class="form-check">
        <input
            class="form-check-input"
            type="radio"
            name="status_pengajuan"
            value="ditolak"
            id="status_ditolak"
            required
            onclick="toggleAlasanDitolak()">

        <label class="form-check-label" for="status_ditolak">
            Ditolak
        </label>
    </div>
</div>

<!-- Alasan Ditolak (di bawah) -->
<div class="mb-3" id="box_alasan_ditolak" style="display:none;">
    <label class="form-label fw-semibold">Alasan Ditolak</label>
    <input
        type="text"
        id="alasan_ditolak"
        name="alasan_ditolak"
        class="form-control"
        placeholder="Silakan isi alasan penolakan">
</div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Tutup
                        </button>

                        <button type="submit" class="btn btn-primary">
                            Simpan Data
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- LOGOUT MODAL -->
    <div id="logoutModal" class="logout-modal">
        <div class="logout-box">
            <div class="logout-icon" style="background: #fee2e2; color: #ef4444; width: 56px; height: 56px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px; font-size: 24px;">
                <i class="fa-solid fa-question"></i>
            </div>

            <h2 style="font-size: 20px; font-weight: 800; margin-bottom: 12px; text-align: center;">Konfirmasi Keluar</h2>
            <p style="color: #64748b; font-size: 14px; text-align: center; margin-bottom: 24px;">
                Apakah Anda yakin ingin keluar?
            </p>

            <div class="logout-buttons">
                <a href="/logout" class="btn-logout" style="background: #ef4444; color: white;">
                    Ya, Keluar
                </a>

                <button type="button" onclick="closeLogoutModal()" class="btn-cancel" style="background: #e2e8f0; color: #334155;">
                    Batal
                </button>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function isiModal(btn) {
            const form = document.getElementById("formVerifikasi");

            form.action = "/verifikasi-cuti/update/" + btn.dataset.id;

            document.getElementById("modal_nama").value = btn.dataset.nama || "";
            document.getElementById("modal_jenis").value = btn.dataset.jenis || "";
            document.getElementById("modal_jumlah").value = btn.dataset.jumlah || "";
            document.getElementById("modal_sisa").value = btn.dataset.sisa || "";
            document.getElementById("modal_mulai").value = btn.dataset.mulai || "";
            document.getElementById("modal_selesai").value = btn.dataset.selesai || "";
            document.getElementById("modal_alasan").value = btn.dataset.alasan || "";

            const dokumen = btn.dataset.dokumen;
            const dokumenBox = document.getElementById("modal_dokumen_box");
            const dokumenEmpty = document.getElementById("modal_dokumen_empty");
            const dokumenLink = document.getElementById("modal_dokumen_link");

            if (dokumen && dokumen !== "") {
                dokumenLink.href = dokumen;
                dokumenBox.style.display = "block";
                dokumenEmpty.style.display = "none";
            } else {
                dokumenLink.href = "#";
                dokumenBox.style.display = "none";
                dokumenEmpty.style.display = "block";
            }
        }

        const searchInput = document.getElementById("searchInput");

        if (searchInput) {
            searchInput.addEventListener("keyup", function () {
                const filter = this.value.toLowerCase();
                
                // Filter Desktop table rows
                const rows = document.querySelectorAll("#cutiTable tbody tr");
                rows.forEach(row => {
                    const nama = row.cells[1]?.textContent.toLowerCase() || "";
                    row.style.display = nama.includes(filter) ? "" : "none";
                });

                // Filter Mobile cards
                const cards = document.querySelectorAll(".leave-card");
                cards.forEach(card => {
                    const nama = card.querySelector("h3")?.textContent.toLowerCase() || "";
                    card.style.display = nama.includes(filter) ? "" : "none";
                });
            });
        }

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

        function toggleSidebar() {
            document.body.classList.toggle("sidebar-closed");

            localStorage.setItem(
                "sidebar",
                document.body.classList.contains("sidebar-closed") ? "closed" : "open"
            );
        }

        function setDarkMode() {
            document.body.classList.add("dark-mode");
            document.documentElement.classList.add("dark");
            localStorage.setItem("theme", "dark");

            document.getElementById("darkBtn")?.classList.add("active");
            document.getElementById("lightBtn")?.classList.remove("active");
        }

        function setLightMode() {
            document.body.classList.remove("dark-mode");
            document.documentElement.classList.remove("dark");
            localStorage.setItem("theme", "light");

            document.getElementById("lightBtn")?.classList.add("active");
            document.getElementById("darkBtn")?.classList.remove("active");
        }

        document.addEventListener("DOMContentLoaded", function () {
            if (window.innerWidth <= 768) {
                document.body.classList.add("sidebar-closed");
            } else if (localStorage.getItem("sidebar") === "closed") {
                document.body.classList.add("sidebar-closed");
            }

            const theme = localStorage.getItem("theme");
            if (theme === "dark") {
                setDarkMode();
            } else {
                setLightMode();
            }

            const closeWelcome = document.getElementById("closeWelcome");

            if (closeWelcome) {
                closeWelcome.addEventListener("click", function () {
                    const welcomeBar = document.querySelector(".welcome-bar");
                    welcomeBar.style.display = "none";
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

        // VALIDASI FORM VERIFIKASI
        document.getElementById('formVerifikasi').addEventListener('submit', function(e){

            const status = document.querySelector(
                'input[name="status_pengajuan"]:checked'
            );

            const alasan = document.getElementById('alasan_ditolak');

            if(!status){

                e.preventDefault();

                Swal.fire({
                    icon: 'warning',
                    title: 'Peringatan',
                    text: 'Silahkan pilih status pengajuan terlebih dahulu.'
                });

                return false;
            }

            if(
                status.value === 'ditolak' &&
                alasan.value.trim() === ''
            ){

                e.preventDefault();

                Swal.fire({
                    icon: 'warning',
                    title: 'Peringatan',
                    text: 'Silahkan isi alasan cuti ditolak.'
                });

                alasan.focus();

                return false;
            }
        });

        // OPTIONAL: CLEAR ALASAN SAAT DISETUJUI
        const radioDisetujui = document.querySelector(
            'input[name="status_pengajuan"][value="disetujui"]'
        );

        const radioDitolak = document.querySelector(
            'input[name="status_pengajuan"][value="ditolak"]'
        );

        const alasanDitolak = document.getElementById('alasan_ditolak');

        if(radioDisetujui){
            radioDisetujui.addEventListener('change', function(){
                alasanDitolak.value = '';
            });
        }

        function toggleAlasanDitolak() {

    const radioDitolak = document.getElementById("status_ditolak");
    const boxAlasan = document.getElementById("box_alasan_ditolak");
    const inputAlasan = document.getElementById("alasan_ditolak");

    if (radioDitolak.checked) {
        boxAlasan.style.display = "block";
        inputAlasan.required = true;
    } else {
        boxAlasan.style.display = "none";
        inputAlasan.required = false;
        inputAlasan.value = "";
    }

}
    </script>

</body>

</html>