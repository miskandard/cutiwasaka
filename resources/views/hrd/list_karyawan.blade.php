<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Karyawan</title>
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

        .menu-section {
            margin-top: 10px;
            margin-bottom: 10px;
        }

        /* judul section lebih clean */
        .menu-title {
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 1.5px;
            color: #fff;
            margin: 18px 16px 8px;
            position: relative;
        }

        /* garis kecil kiri */
        .menu-title::before {
            content: "";
            display: inline-block;
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

        .alert {
            padding: 12px 16px;
            margin: 15px 0;
            border-radius: 8px;
            font-weight: 500;
        }

        .alert-success {
            background: #d1fae5;
            color: #065f46;
            border-left: 5px solid #10b981;
        }

        .alert-danger {
            background: #fee2e2;
            color: #991b1b;
            border-left: 5px solid #ef4444;
        }

        .toast {
            position: fixed;
            top: 20px;
            right: 20px;
            min-width: 250px;
            padding: 12px 16px;
            border-radius: 8px;
            color: white;
            font-weight: 500;
            z-index: 9999;
            opacity: 0;
            transform: translateY(-20px);
            transition: 0.3s ease;
        }

        .toast.show {
            opacity: 1;
            transform: translateY(0);
        }

        .toast.success {
            background: #10b981;
        }

        .toast.error {
            background: #ef4444;
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
                display: none;
                /* Hide user name text on small screen */
            }

            .user-box {
                gap: 8px !important;
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

            .table-header>div {
                display: flex;
                flex-wrap: wrap;
                gap: 8px;
            }

            .table-header .btn-add {
                flex: 1 1 auto;
                justify-content: center;
                font-size: 13px;
                padding: 8px 12px;
            }

            .search-box {
                width: 100%;
            }

            .search-box input {
                width: 100% !important;
                box-sizing: border-box;
            }

            /* Modals Form Grid mobile responsiveness */
            .form-grid {
                grid-template-columns: 1fr !important;
                gap: 12px !important;
            }

            .form-grid>div[style*="grid-column: span 2"] {
                grid-column: span 1 !important;
            }

            .modal-content {
                padding: 20px !important;
                margin-top: 20px !important;
                max-height: 90vh !important;
                overflow-y: auto !important;
            }

            /* Responsive Table (Cards Layout) */
            table {
                display: block !important;
                width: 100% !important;
                border: none !important;
            }

            thead {
                display: none !important;
                /* Hide headers */
            }

            tbody {
                display: block !important;
                width: 100% !important;
            }

            tbody tr {
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

            body.dark-mode tbody tr {
                background: #111827 !important;
                border-color: #374151 !important;
            }

            tbody td {
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

            body.dark-mode tbody td {
                border-bottom-color: #374151 !important;
                background: transparent !important;
                color: #ffffff !important;
            }

            tbody td:last-child {
                border-bottom: none !important;
            }

            tbody td::before {
                content: attr(data-label) !important;
                font-weight: 600 !important;
                color: #64748b !important;
                text-align: left !important;
                margin-right: 15px !important;
                display: inline-block !important;
            }

            body.dark-mode tbody td::before {
                color: #94a3b8 !important;
            }

            .btn-edit,
            .btn-delete {
                margin: 0 !important;
                padding: 6px 12px !important;
                font-size: 13px !important;
                display: inline-block !important;
            }
        }

        @media (max-width: 576px) {
            .modal-content {
                width: 95% !important;
            }

            .modal-content h2 {
                font-size: 20px !important;
                margin-bottom: 15px !important;
            }

            .logout-box {
                width: 90% !important;
                padding: 20px !important;
            }
        }
    </style>
</head>
</head>

<body>

    <div id="toast" class="toast"></div>

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
                <h1 class="fw-bold text-primary-emphasis m-0">List Karyawan</h1>
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




        <div class="table-box">
            <div class="table-header">
                <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                    <button type="button" class="btn-add" onclick="openModal()">
                        <i class="fa-solid fa-user-plus"></i> Tambah Karyawan
                    </button>

                    <button type="button" class="btn-add" onclick="openImportModal()" style="background-color: #10b981;">
                        <i class="fa-solid fa-file-excel"></i> Import Karyawan
                    </button>

                    <button type="button" class="btn-add" onclick="openCutiBersamaModal()">
                        <i class="fa-solid fa-calendar-minus"></i> Cuti Bersama
                    </button>
                </div>

                <div class="search-box">
                    <input type="text" id="searchInput" placeholder="Search">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </div>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Username</th>
                        <th>Jabatan</th>
                        <th>Divisi</th>
                        <th>Tipe Kerja</th>
                        <th>No HP</th>
                        <th>Sisa Cuti</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td data-label="No">{{ $loop->iteration }}</td>
                        <td data-label="Nama">{{ $user->nama }}</td>
                        <td data-label="Email">
                            <div>{{ $user->email ?? '-' }}</div>
                            @if(is_null($user->email_verified_at))
                                <span style="display: inline-block; padding: 2px 6px; font-size: 10px; font-weight: 600; border-radius: 4px; background: #fef3c7; color: #d97706; border: 1px solid #fde68a; margin-top: 4px;">
                                    Belum Verifikasi
                                </span>
                                <a href="/karyawan/resend-verification/{{ $user->id_user }}" style="display: block; font-size: 10px; color: #3b82f6; text-decoration: underline; margin-top: 4px; text-align: left;" onclick="return confirm('Kirim ulang email verifikasi ke karyawan ini?')">
                                    <i class="fa-solid fa-paper-plane"></i> Kirim Ulang Email
                                </a>
                            @else
                                <span style="display: inline-block; padding: 2px 6px; font-size: 10px; font-weight: 600; border-radius: 4px; background: #d1fae5; color: #059669; border: 1px solid #a7f3d0; margin-top: 4px;">
                                    Aktif
                                </span>
                            @endif
                        </td>
                        <td data-label="Username">{{ $user->username }}</td>
                        <td data-label="Jabatan">{{ ucfirst($user->jabatan) }}</td>
                        <td data-label="Divisi">
                            {{ strtolower($user->jabatan) == 'direktur' ? '-' : $user->divisi }}
                        </td>
                        <td data-label="Tipe Kerja">
                            {{ strtolower($user->jabatan) == 'direktur' ? '-' : ucfirst(str_replace('_', ' ', $user->tipe_kerja)) }}
                        </td>
                        <td data-label="No HP">{{ $user->no_hp }}</td>

                        <td data-label="Sisa Cuti">
                            {{ strtolower($user->jabatan) == 'direktur' ? '-' : $user->sisa_cuti }}
                        </td>
                        <td data-label="Aksi">
                            <button type="button" class="btn-edit" onclick="openEditModal(
                            '{{ $user->id_user }}',
                            '{{ $user->nama }}',
                            '{{ $user->email }}',
                            '{{ $user->username }}',
                            '{{ $user->jabatan }}',
                            '{{ $user->divisi }}',
                            '{{ $user->tipe_kerja }}',
                            '{{ $user->alamat }}',
                            '{{ $user->no_hp }}'
                        )">
                                <i class="fa-solid fa-pen"></i> Edit
                            </button>

                            <a href="/karyawan/delete/{{ $user->id_user }}" class="btn-delete"
                                onclick="return confirm('Yakin ingin hapus data ini?')">
                                <i class="fa-solid fa-trash"></i> Hapus
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- MODAL TAMBAH -->
    <div id="modalTambah" class="modal">
        <div class="modal-content">
            <h2>Tambah Karyawan</h2>

            <form action="/karyawan/store" method="POST">
                @csrf

                <div class="form-grid">
                    <div>
                        <label>Nama lengkap :</label>
                        <input type="text" name="nama" required>
                    </div>

                    <div>
                        <label>Email :</label>
                        <input type="email" name="email" required>
                    </div>

                    <div>
                        <label>No Hp :</label>
                        <input type="text" name="no_hp" required>
                    </div>

                    <div>
                        <label>Jabatan :</label>
                        <select name="jabatan" id="jabatan" required onchange="toggleDivisi()">
                            <option value="" selected disabled>Pilih jabatan</option>
                            <option value="direktur">Direktur</option>
                            <option value="hrd">HRD</option>
                            <option value="karyawan">Karyawan</option>
                        </select>
                    </div>

                    <div>
                        <label>Username :</label>
                        <input type="text" name="username" id="username" required autocomplete="off">
                    </div>

                    <div id="divisiBox">
                        <label>Divisi :</label>
                        <select name="divisi" id="divisi" required>
                            <option value="" selected disabled>Pilih Divisi</option>
                            <option value="WGS">WGS</option>
                            <option value="WSL">WSL</option>
                            <option value="WTG">WTG</option>
                            <option value="WMS">WMS</option>
                        </select>
                    </div>

                    <div>
                        <label>Password :</label>
                        <input type="password" name="password" id="password" required>
                    </div>

                    <div id="tipeKerjaBox">
                        <label>Tipe Kerja :</label>

                        <select name="tipe_kerja" id="tipe_kerja" required>
                            <option value="" selected disabled>Pilih Tipe Kerja</option>

                            <option value="back_office">
                                Back Office
                            </option>

                            <option value="operasional">
                                Operasional / Lapangan
                            </option>

                        </select>
                    </div>
                    <div>
                        <label>Alamat :</label>
                        <input type="text" name="alamat" required>
                    </div>

                    <div>
                        <label>Tulis ulang password :</label>
                        <input type="password" name="password_confirmation" id="confirmPassword" required>
                    </div>
                </div>

                <div class="modal-buttons">
                    <button type="submit" class="btn-save">Simpan Data</button>
                    <button type="button" class="btn-close" onclick="closeModal()">Tutup</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL IMPORT -->
    <div id="modalImport" class="modal">
        <div class="modal-content">
            <h2>Import Karyawan</h2>
            
            <div style="background-color: #f3f4f6; padding: 15px; border-radius: 8px; margin-bottom: 20px; font-size: 13px; border-left: 4px solid #10b981;">
                <p style="margin-top: 0; font-weight: bold; color: #1f2937;">Panduan Import Data:</p>
                <ul style="padding-left: 20px; margin-bottom: 10px; color: #4b5563; line-height: 1.5; text-align: left;">
                    <li>Unduh file template CSV di bawah ini sebagai acuan pengisian.</li>
                    <li>Kolom <b>Nama, Email, Username, Password</b>, dan <b>Jabatan</b> wajib diisi.</li>
                    <li>Pilihan <b>Jabatan</b>: <code>direktur</code>, <code>hrd</code>, <code>karyawan</code></li>
                    <li>Pilihan <b>Divisi</b>: <code>WGS</code>, <code>WSL</code>, <code>WTG</code>, <code>WMS</code> (isi <code>-</code> jika Jabatan adalah <code>direktur</code>)</li>
                    <li>Pilihan <b>Tipe Kerja</b>: <code>back_office</code>, <code>operasional</code> (isi <code>-</code> jika Jabatan adalah <code>direktur</code>)</li>
                </ul>
                <button type="button" onclick="downloadTemplate()" class="btn-edit" style="background: #10b981; border-color: #10b981; color: white; display: inline-flex; align-items: center; gap: 6px;">
                    <i class="fa-solid fa-download"></i> Unduh Template CSV
                </button>
            </div>

            <form action="/karyawan/import" method="POST" id="formImport" onsubmit="return processExcel(event)">
                @csrf
                <input type="hidden" name="karyawan_data" id="karyawan_data">

                <div class="form-grid" style="grid-template-columns: 1fr;">
                    <div>
                        <label>Pilih File Excel / CSV :</label>
                        <input type="file" id="import_file" accept=".xlsx, .xls, .csv" required style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 6px; box-sizing: border-box; background: white; margin-top: 5px;">
                    </div>
                </div>

                <div id="importPreview" style="margin-top: 15px; max-height: 200px; overflow-y: auto; border: 1px solid #e5e7eb; border-radius: 6px; display: none;">
                    <table style="width: 100%; border-collapse: collapse; font-size: 12px;">
                        <thead style="background: #f9fafb; position: sticky; top: 0; z-index: 1;">
                            <tr>
                                <th style="padding: 8px; border-bottom: 1px solid #e5e7eb; text-align: left;">Nama</th>
                                <th style="padding: 8px; border-bottom: 1px solid #e5e7eb; text-align: left;">Email</th>
                                <th style="padding: 8px; border-bottom: 1px solid #e5e7eb; text-align: left;">Username</th>
                                <th style="padding: 8px; border-bottom: 1px solid #e5e7eb; text-align: left;">Jabatan</th>
                                <th style="padding: 8px; border-bottom: 1px solid #e5e7eb; text-align: left;">Divisi</th>
                            </tr>
                        </thead>
                        <tbody id="previewBody"></tbody>
                    </table>
                </div>

                <div class="modal-buttons" style="margin-top: 20px;">
                    <button type="submit" class="btn-save" id="btnSubmitImport" disabled style="background-color: #10b981; border-color: #10b981; opacity: 0.6; cursor: not-allowed;">
                        <i class="fa-solid fa-file-import"></i> Mulai Import
                    </button>
                    <button type="button" class="btn-close" onclick="closeImportModal()">Tutup</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL EDIT -->
    <div id="modalEdit" class="modal">
        <div class="modal-content">
            <h2>Edit Karyawan</h2>

            <form id="formEdit" method="POST">
                @csrf

                <div class="form-grid">
                    <div>
                        <label>Nama lengkap :</label>
                        <input type="text" name="nama" id="edit_nama" required>
                    </div>

                    <div>
                        <label>Email :</label>
                        <input type="email" name="email" id="edit_email" required>
                    </div>

                    <div>
                        <label>No Hp :</label>
                        <input type="text" name="no_hp" id="edit_nohp" required>
                    </div>

                    <div>
                        <label>Jabatan :</label>
                        <select name="jabatan" id="edit_jabatan" required>
                            <option value="direktur">Direktur</option>
                            <option value="hrd">HRD</option>
                            <option value="karyawan">Karyawan</option>
                        </select>
                    </div>

                    <div>
                        <label>Username :</label>
                        <input type="text" name="username" id="edit_username" required>
                    </div>

                    <div>
                        <label>Divisi :</label>
                        <select name="divisi" id="edit_divisi" required>
                            <option value="WGS">WGS</option>
                            <option value="WSL">WSL</option>
                            <option value="WTG">WTG</option>
                            <option value="WMS">WMS</option>
                        </select>
                    </div>

                    <div>
                        <label>Alamat :</label>
                        <input type="text" name="alamat" id="edit_alamat" required>
                    </div>

                    <div>
                        <label>Tipe Kerja :</label>
                        <select name="tipe_kerja" id="edit_tipe_kerja" required>
                            <option value="back_office">Back Office</option>
                            <option value="operasional">Operasional / Lapangan</option>
                        </select>
                    </div>

                    <div>
                        <label>Aksi Sisa Cuti :</label>
                        <select name="aksi_cuti" required>
                            <option value="tambah">Tambah</option>
                            <option value="kurang">Kurangi</option>
                        </select>
                    </div>

                    <div>
                        <label>Jumlah Hari :</label>
                        <input type="number" name="jumlah_cuti" min="0" value="0">
                    </div>
                </div>

                <div class="modal-buttons">
                    <button type="submit" class="btn-save">Update Data</button>
                    <button type="button" class="btn-close" onclick="closeEditModal()">Tutup</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL CUTI BERSAMA -->
    <div id="modalCutiBersama" class="modal">
        <div class="modal-content">
            <h2>Cuti Bersama</h2>

            <form action="/cuti-bersama/store" method="POST">
                @csrf

                <div class="form-grid">
                    <div>
                        <label>Nama Cuti Bersama :</label>
                        <input type="text" name="nama_cuti" placeholder="Contoh: Cuti Bersama Idul Fitri" required>
                    </div>

                    <div>
                        <label>Jumlah Hari :</label>
                        <input type="number" name="jumlah_hari" min="1" placeholder="Contoh: 2" required>
                    </div>

                    <div style="grid-column: span 2;">
                        <label>Keterangan :</label>
                        <input type="text" name="keterangan" placeholder="Keterangan cuti bersama">
                    </div>
                </div>

                <div class="modal-buttons">
                    <button type="submit" class="btn-save">
                        Simpan & Kurangi Semua Sisa Cuti
                    </button>

                    <button type="button" class="btn-close" onclick="closeCutiBersamaModal()">
                        Tutup
                    </button>
                </div>
            </form>
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


    @if(session('success'))
    <script>
        showToast("{{ session('success') }}", "success");
    </script>
    @endif

    @if(session('error'))
    <script>
        showToast("{{ session('error') }}", "error");
    </script>
    @endif

    <script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script>
</body>
<script>
    function openImportModal() {
        showModal("modalImport", "600px");
    }

    function closeImportModal() {
        hideModal("modalImport");
        document.getElementById("import_file").value = "";
        document.getElementById("importPreview").style.display = "none";
        document.getElementById("previewBody").innerHTML = "";
        const submitBtn = document.getElementById("btnSubmitImport");
        submitBtn.disabled = true;
        submitBtn.style.opacity = "0.6";
        submitBtn.style.cursor = "not-allowed";
    }

    let parsedKaryawanData = null;

    function downloadTemplate() {
        const csvRows = [];
        const headers = ["Nama", "Email", "No HP", "Jabatan", "Username", "Divisi", "Password", "Tipe Kerja", "Alamat"];
        csvRows.push(headers.join(","));
        const sampleRow = ["Budi Santoso", "budi@example.com", "'081234567890", "karyawan", "budi12", "WGS", "Budi123!", "back_office", "Bandung"];
        csvRows.push(sampleRow.map(val => `"${val.replace(/"/g, '""')}"`).join(","));
        
        const csvContent = "\uFEFF" + csvRows.join("\n");
        const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
        const url = URL.createObjectURL(blob);
        const link = document.createElement("a");
        link.setAttribute("href", url);
        link.setAttribute("download", "template_import_karyawan.csv");
        link.style.visibility = 'hidden';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }

    function handleImportFile(e) {
        const file = e.target.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = function(e) {
            try {
                const data = new Uint8Array(e.target.result);
                const workbook = XLSX.read(data, {type: 'array'});
                const firstSheetName = workbook.SheetNames[0];
                const worksheet = workbook.Sheets[firstSheetName];
                
                const jsonData = XLSX.utils.sheet_to_json(worksheet, {defval: "", raw: false});
                
                if (jsonData.length === 0) {
                    showToast("File Excel / CSV kosong.", "error");
                    return;
                }

                const previewBody = document.getElementById("previewBody");
                previewBody.innerHTML = "";
                
                jsonData.forEach((row) => {
                    const name = row['Nama'] || row['nama'] || '';
                    const email = row['Email'] || row['email'] || '';
                    const username = row['Username'] || row['username'] || '';
                    const jabatan = row['Jabatan'] || row['jabatan'] || '';
                    const divisi = row['Divisi'] || row['divisi'] || '';

                    const tr = document.createElement("tr");
                    tr.innerHTML = `
                        <td style="padding: 8px; border-bottom: 1px solid #e5e7eb; text-align: left;">${name}</td>
                        <td style="padding: 8px; border-bottom: 1px solid #e5e7eb; text-align: left;">${email}</td>
                        <td style="padding: 8px; border-bottom: 1px solid #e5e7eb; text-align: left;">${username}</td>
                        <td style="padding: 8px; border-bottom: 1px solid #e5e7eb; text-align: left;">${jabatan}</td>
                        <td style="padding: 8px; border-bottom: 1px solid #e5e7eb; text-align: left;">${divisi}</td>
                    `;
                    previewBody.appendChild(tr);
                });

                document.getElementById("importPreview").style.display = "block";
                parsedKaryawanData = jsonData;

                const submitBtn = document.getElementById("btnSubmitImport");
                submitBtn.disabled = false;
                submitBtn.style.opacity = "1";
                submitBtn.style.cursor = "pointer";
            } catch (error) {
                showToast("Gagal membaca file: " + error.message, "error");
            }
        };
        reader.readAsArrayBuffer(file);
    }

    function processExcel(event) {
        if (!parsedKaryawanData || parsedKaryawanData.length === 0) {
            showToast("Tidak ada data untuk diimport.", "error");
            event.preventDefault();
            return false;
        }

        document.getElementById("karyawan_data").value = JSON.stringify(parsedKaryawanData);
        showToast("Sedang memproses import data...", "success");
        return true;
    }

    function setDarkMode() {
        document.body.classList.add("dark-mode");
        localStorage.setItem("theme", "dark");

        document.getElementById("darkBtn") ?.classList.add("active");
        document.getElementById("lightBtn") ?.classList.remove("active");
    }

    function setLightMode() {
        document.body.classList.remove("dark-mode");
        localStorage.setItem("theme", "light");

        document.getElementById("lightBtn") ?.classList.add("active");
        document.getElementById("darkBtn") ?.classList.remove("active");
    }

    function showModal(id, width = "700px") {
        const modal = document.getElementById(id);
        if (!modal) return;

        modal.style.display = "flex";
        modal.style.justifyContent = "center";
        modal.style.alignItems = "flex-start";

        const content = modal.querySelector(".modal-content");

        if (content) {
            content.style.width = width;
            content.style.maxWidth = "90%";
            content.style.marginTop = "40px";
        }
    }

    function hideModal(id) {
        const modal = document.getElementById(id);
        if (modal) modal.style.display = "none";
    }

    function openModal() {
        showModal("modalTambah", "650px");
    }

    function closeModal() {
        hideModal("modalTambah");
    }

    function openEditModal(
        id,
        nama,
        email,
        username,
        jabatan,
        divisi,
        tipeKerja,
        alamat,
        nohp
    ) {
        document.getElementById("formEdit").action = "/karyawan/update/" + id;

        document.getElementById("edit_nama").value = nama || "";
        document.getElementById("edit_email").value = email || "";
        document.getElementById("edit_username").value = username || "";
        document.getElementById("edit_jabatan").value = jabatan || "";
        document.getElementById("edit_divisi").value = divisi || "";
        document.getElementById("edit_tipe_kerja").value = tipeKerja;
        document.getElementById("edit_alamat").value = alamat || "";
        document.getElementById("edit_nohp").value = nohp || "";

        showModal("modalEdit", "650px");
    }

    function closeEditModal() {
        hideModal("modalEdit");
    }

    function openCutiBersamaModal() {
        showModal("modalCutiBersama", "500px");
    }

    function closeCutiBersamaModal() {
        hideModal("modalCutiBersama");
    }

    function toggleSidebar() {
        document.body.classList.toggle("sidebar-closed");

        localStorage.setItem(
            "sidebar",
            document.body.classList.contains("sidebar-closed") ? "closed" : "open"
        );
    }

    document.addEventListener("DOMContentLoaded", function () {
        if (window.innerWidth <= 768) {
            document.body.classList.add("sidebar-closed");
        } else if (localStorage.getItem("sidebar") === "closed") {
            document.body.classList.add("sidebar-closed");
        }

        if (localStorage.getItem("theme") === "dark") {
            setDarkMode();
        } else {
            setLightMode();
        }

        const searchInput = document.getElementById("searchInput");

        if (searchInput) {
            searchInput.addEventListener("keyup", function () {
                const keyword = this.value.toLowerCase();
                const rows = document.querySelectorAll("tbody tr");

                rows.forEach(function (row) {
                    row.style.display = row.textContent.toLowerCase().includes(keyword) ?
                        "" :
                        "none";
                });
            });
        }

        const fileInput = document.getElementById("import_file");
        if (fileInput) {
            fileInput.addEventListener("change", handleImportFile);
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

    function showToast(message, type = "success") {
        const toast = document.getElementById("toast");

        toast.className = "toast " + type;
        toast.innerText = message;

        toast.classList.add("show");

        setTimeout(() => {
            toast.classList.remove("show");
        }, 3000);
    }

    document.addEventListener("DOMContentLoaded", function () {

        @if(session('success'))
        showToast(@json(session('success')), "success");
        @endif

        @if(session('error'))
        showToast(@json(session('error')), "error");
        @endif

    });

    function toggleDivisi() {
        const jabatan = document.getElementById("jabatan").value;

        const divisiBox = document.getElementById("divisiBox");
        const tipeKerjaBox = document.getElementById("tipeKerjaBox");

        if (jabatan === "direktur") {
            divisiBox.style.display = "none";
            tipeKerjaBox.style.display = "none";

            document.getElementById("divisi").required = false;
            document.getElementById("tipe_kerja").required = false;
        } else {
            divisiBox.style.display = "block";
            tipeKerjaBox.style.display = "block";

            document.getElementById("divisi").required = true;
            document.getElementById("tipe_kerja").required = true;
        }
    }
</script>

</html>