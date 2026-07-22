<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Cuti HRD</title>

    <link rel="icon" type="image/png" href="{{ asset('img/logo/wg.png') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
 

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
        }

        td {
            padding: 13px;
            border-bottom: 1px solid #e5e7eb;
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
            width: 420px;
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

.modal-box h2{
    color:#0d1f6b;
    font-weight:700;
    margin-bottom:20px;
}

.detail-grid input,
.detail-grid textarea{
    background:#f8fafc;
}

.btn-detail{
    background:#1e2a78;
    color:#fff;
    border:none;
    padding:8px 16px;
    border-radius:8px;
    font-weight:600;
}

.btn-detail:hover{
    background:#16205d;
}

.badge-success{
    background:#dcfce7;
    color:#166534;
    padding:8px 14px;
    border-radius:999px;
    font-weight:600;
}

        .table-box {
            overflow-x: auto;
        }

        /* RESPONSIVE DESIGN */
        .topbar-left {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .mobile-toggle-btn {
            display: none;
        }

        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(4px);
            z-index: 998;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        @media (max-width: 768px) {
            .mobile-toggle-btn {
                display: flex;
                align-items: center;
                justify-content: center;
                width: 40px;
                height: 40px;
                border: 1px solid #dfe3f0;
                border-radius: 8px;
                background: #f8f9fc;
                color: #1e2a78;
                cursor: pointer;
                font-size: 18px;
                transition: all 0.3s ease;
            }

            body.dark-mode .mobile-toggle-btn {
                background: #1f2937;
                border-color: #374151;
                color: #ffffff;
            }

            .sidebar {
                left: 0;
                z-index: 1000;
                transform: translateX(0);
                transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1), width 0.3s ease;
            }
            
            body.sidebar-closed .sidebar {
                transform: translateX(-100%);
            }

            body:not(.sidebar-closed) .sidebar-overlay {
                display: block;
                opacity: 1;
            }

            .main-content {
                margin-left: 0 !important;
                padding: 15px !important;
            }

            body.sidebar-closed .main-content {
                margin-left: 0 !important;
            }

            .topbar {
                padding: 15px !important;
                flex-direction: row;
                justify-content: space-between;
                align-items: center;
                gap: 10px;
            }

            .topbar h1 {
                font-size: 20px !important;
            }

            .user-box span {
                display: none !important; /* Hide user name text on small screen */
            }

            .user-box {
                gap: 8px !important;
            }

            .welcome-bar {
                margin: 10px 0 !important;
                padding: 10px 15px !important;
                font-size: 14px !important;
            }

            .table-box {
                margin-top: 15px !important;
                padding: 15px !important;
                overflow-x: visible !important;
            }

            .table-header {
                flex-direction: column;
                align-items: stretch !important;
                gap: 12px;
            }

            .search-box {
                width: 100%;
            }

            .search-box input {
                width: 100% !important;
                box-sizing: border-box;
            }

            /* Responsive Table (Cards Layout) */
            #riwayatTable {
                display: block !important;
                width: 100% !important;
                border: none !important;
            }

            #riwayatTable thead {
                display: none !important; /* Hide headers */
            }

            #riwayatTable tbody {
                display: block !important;
                width: 100% !important;
            }

            #riwayatTable tbody tr {
                display: block;
                background: #ffffff !important;
                border: 1px solid #e2e8f0 !important;
                border-radius: 12px !important;
                padding: 10px 15px !important;
                margin-bottom: 15px !important;
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05) !important;
                box-sizing: border-box !important;
                transition: transform 0.2s ease !important;
            }

            body.dark-mode #riwayatTable tbody tr {
                background: #111827 !important;
                border-color: #374151 !important;
            }

            #riwayatTable tbody td {
                display: flex !important;
                justify-content: space-between !important;
                align-items: center !important;
                padding: 10px 0 !important;
                border-bottom: 1px dashed #e2e8f0 !important;
                text-align: right !important;
                font-size: 14px !important;
                box-sizing: border-box !important;
                background: transparent !important;
            }

            body.dark-mode #riwayatTable tbody td {
                border-bottom-color: #374151 !important;
                background: transparent !important;
                color: #ffffff !important;
            }

            #riwayatTable tbody td:last-child {
                border-bottom: none !important;
            }

            #riwayatTable tbody td::before {
                content: attr(data-label) !important;
                font-weight: 600 !important;
                color: #64748b !important;
                text-align: left !important;
                margin-right: 15px !important;
                display: inline-block !important;
            }

            body.dark-mode #riwayatTable tbody td::before {
                color: #94a3b8 !important;
            }

            /* Empty table formatting */
            #riwayatTable tbody tr td[colspan="9"] {
                display: block !important;
                text-align: center !important;
                border: none !important;
                padding: 20px 0 !important;
            }

            #riwayatTable tbody tr td[colspan="9"]::before {
                display: none !important;
            }

            .btn-detail {
                margin: 0 !important;
                padding: 6px 12px !important;
                font-size: 13px !important;
                display: inline-block !important;
            }

            .badge {
                margin: 0 !important;
                padding: 6px 12px !important;
                font-size: 12px !important;
            }

            /* Detail Modal responsive form grid */
            .detail-grid {
                grid-template-columns: 1fr !important;
                gap: 12px !important;
            }

            .detail-grid .full {
                grid-column: span 1 !important;
            }

            .modal-box {
                padding: 20px 25px !important;
                max-height: 90vh !important;
                overflow-y: auto !important;
            }
        }

        @media (max-width: 576px) {
            /* Timeline scaling for mobile screens */
            .timeline-wrapper {
                margin: 15px 0 25px !important;
                gap: 2px !important;
            }
            .timeline-step {
                min-width: 50px !important;
                font-size: 11px !important;
            }
            .circle {
                width: 32px !important;
                height: 32px !important;
                font-size: 13px !important;
                line-height: 32px !important;
                margin-bottom: 4px !important;
            }
            .timeline-line {
                width: 35px !important;
                margin-bottom: 20px !important;
            }
            .logout-box {
                width: 90% !important;
                padding: 20px !important;
            }
        }
    </style>
</head>

<body>

    <div class="sidebar-overlay" onclick="toggleSidebar()"></div>

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

<div class="main-content">

    <div class="topbar d-flex justify-content-between align-items-center">
        <div class="topbar-left">
            <button type="button" class="mobile-toggle-btn" onclick="toggleSidebar()">
                <i class="fa-solid fa-bars"></i>
            </button>
            <h1 class="fw-bold text-primary-emphasis m-0">Riwayat Cuti</h1>
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

            <span class="fw-semibold">{{ session('nama') }}</span>
            <i class="fa-solid fa-user"></i>
        </div>
    </div>

    

    <div class="table-box">
        <div class="table-header">
           <h5 class="fw-bold text-primary-emphasis">Data Riwayat Cuti</h5>

            <div class="search-box">
    <input
        type="text"
        id="searchInput"
        class="form-control"
        placeholder="Cari riwayat cuti">
</div>
        </div>

        <div class="table-responsive">
    <table class="table table-hover align-middle" id="riwayatTable">
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
                        <td data-label="No">{{ $loop->iteration }}</td>
                        <td data-label="Jenis Cuti">{{ $cuti->nama_jenis_cuti ?? 'Cuti' }}</td>
                        <td data-label="Tgl Pengajuan">{{ $cuti->tanggal_pengajuan }}</td>
                        <td data-label="Tgl Mulai">{{ $cuti->tanggal_mulai }}</td>
                        <td data-label="Tgl Selesai">{{ $cuti->tanggal_selesai }}</td>
                        <td data-label="Jumlah Hari">{{ $cuti->jumlah_hari }} hari</td>
                        <td data-label="Keterangan">{{ $cuti->alasan_pengajuan }}</td>

                        <td data-label="Status">
    @if($cuti->status_pengajuan == 'menunggu')
    <span class="badge bg-warning text-dark">Menunggu</span>

@elseif($cuti->status_pengajuan == 'diproses')
    <span class="badge bg-secondary">Diproses</span>

@elseif($cuti->status_pengajuan == 'disetujui')
    <span class="badge bg-success">Disetujui</span>

@elseif($cuti->status_pengajuan == 'ditolak')
    <span class="badge bg-danger">Ditolak</span>
@endif
</td>

                        <td data-label="Aksi">
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
        const rows = document.querySelectorAll("#riwayatTable tbody tr");

        rows.forEach(function (row) {
            row.style.display = row.textContent.toLowerCase().includes(filter) ? "" : "none";
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
    if (window.innerWidth <= 768) {
        document.body.classList.add("sidebar-closed");
    } else if (localStorage.getItem("sidebar") === "closed") {
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