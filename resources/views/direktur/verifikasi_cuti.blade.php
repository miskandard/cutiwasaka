<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Verifikasi Cuti</title>

    <link rel="icon" type="image/png" href="{{ asset('img/logo/wg.png') }}">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        .modal-content {
            width: 850px;
            height: 880px;
            background: #fff;
            margin: 40px auto;
            border-radius: 20px;
            padding: 35px;
            box-shadow: 0 10px 35px rgba(0, 0, 0, 0.12);
            animation: modalFadeDown 0.3s ease forwards;
        }

        m-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        /* STATUS BADGE */

        .status {
            display: inline-block;
            padding: 7px 16px;
            border-radius: 999px;
            font-size: 13px;
            font-weight: 700;
            min-width: 95px;
            text-align: center;
            border: none;
        }

        /* MENUNGGU */

        .status.menunggu {
            background: #facc15;
            color: #111827 !important;
        }

        /* DISETUJUI */

        .status.disetujui {
            background: #22c55e;
            color: white !important;
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

        /* DITOLAK */

        .status.ditolak {
            background: #ef4444;
            color: white !important;
        }

        .menunggu {
            background: #fef3c7;
            color: #b45309;
        }

        .disetujui {
            background: #dcfce7;
            color: #166534;
        }

        .ditolak {
            background: #fee2e2;
            color: #dc2626;
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
            box-shadow: 0 12px 35px rgba(0, 0, 0, .15);
            z-index: 999;
        }

        .notif-item {
            padding: 14px 18px;
            border-bottom: 1px solid #eee;
        }

        .notif-title {
            font-weight: 600;
            color: #1e2a78;
        }

        .notif-time {
            font-size: 12px;
            color: #888;
        }

        .theme-toggle-top {
            display: flex;
            align-items: center;
            background: #eef2ff;
            border-radius: 999px;
            padding: 4px;
            gap: 4px;
        }

        .theme-toggle-top button {
            width: 34px;
            height: 34px;
            border: none;
            border-radius: 50%;
            background: transparent;
            color: #1e2a78;
        }

        .theme-toggle-top button.active {
            background: #1e2a78;
            color: white;
        }


        /* =========================
   DARK MODE
========================= */

        body.dark-mode {
            background: #0f172a;
            color: #f8fafc;
        }

        /* MAIN */
        body.dark-mode .main-content {
            background: #0f172a;
        }

        /* CARD */
        body.dark-mode .card {
            background: #111827 !important;
            border: 1px solid #1f2937 !important;
            color: white !important;
        }

        /* TOPBAR */
        body.dark-mode .topbar {
            background: #111827 !important;
            border: 1px solid #1f2937 !important;
        }

        /* WELCOME */
        body.dark-mode .welcome-bar {
            background: #111827 !important;
            border: 1px solid #1f2937 !important;
            color: white !important;
        }

        /* TEXT */
        body.dark-mode h1,
        body.dark-mode h2,
        body.dark-mode h3,
        body.dark-mode h4,
        body.dark-mode h5,
        body.dark-mode h6,
        body.dark-mode p,
        body.dark-mode span,
        body.dark-mode td,
        body.dark-mode th {
            color: #f8fafc !important;
        }

        /* TABLE */
        body.dark-mode .table {
            color: white !important;
            border-color: #374151 !important;
        }

        /* THEAD */
        body.dark-mode .table thead {
            background: #1e293b !important;
        }

        body.dark-mode .table thead th {
            background: #1e293b !important;
            color: #f8fafc !important;
            border-bottom: 1px solid #374151 !important;
        }

        /* TBODY */
        body.dark-mode .table tbody tr {
            background: #111827 !important;
        }

        body.dark-mode .table tbody td {
            background: #111827 !important;
            color: #f8fafc !important;
            border-bottom: 1px solid #374151 !important;
        }

        /* HOVER */
        body.dark-mode .table-hover tbody tr:hover {
            background: #1e293b !important;
        }

        /* DROPDOWN NOTIF */
        body.dark-mode .notif-dropdown {
            background: #111827 !important;
            border: 1px solid #1f2937 !important;
        }

        body.dark-mode .notif-item {
            border-bottom: 1px solid #374151 !important;
        }

        body.dark-mode .notif-item:hover {
            background: #1e293b !important;
        }

        body.dark-mode .notif-title {
            color: white !important;
        }

        body.dark-mode .notif-time {
            color: #cbd5e1 !important;
        }

        /* THEME BUTTON */
        body.dark-mode .theme-toggle-top {
            background: #1e293b !important;
        }

        body.dark-mode .theme-toggle-top button {
            color: white !important;
        }

        body.dark-mode .theme-toggle-top button.active {
            background: #2563eb !important;
            color: white !important;
        }

        /* INPUT */
        body.dark-mode input,
        body.dark-mode select,
        body.dark-mode textarea {
            background: #111827 !important;
            border: 1px solid #374151 !important;
            color: white !important;
        }

        body.dark-mode input::placeholder {
            color: #9ca3af !important;
        }

        /* MODAL */
        body.dark-mode .modal-content {
            background: #111827 !important;
            color: white !important;
        }

        /* BOOTSTRAP TABLE LIGHT */
        body.dark-mode .table-light,
        body.dark-mode .table-light>th,
        body.dark-mode .table-light>td {
            background: #1e293b !important;
            color: white !important;
        }


        body.dark-mode .sidebar {
            background: linear-gradient(180deg,
                    #0f172a 0%,
                    #111827 100%) !important;
        }

        .theme-toggle-top {
            display: flex;
            align-items: center;
            gap: 0;
            background: #eef2ff;
            padding: 4px;
            border-radius: 999px;
        }

        .theme-toggle-top button {
            width: 36px;
            height: 36px;
            border: none;
            background: transparent;
            color: #1e2a78;
            border-radius: 50%;
            cursor: pointer;
        }

        .theme-toggle-top button.active{
    background:#1e2a78;
    color:white;
    box-shadow:0 2px 8px rgba(0,0,0,0.2);
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

        <div div class="topbar d-flex justify-content-between align-items-center">
            <h1 class="fw-bold text-primary-emphasis">Verifikasi Cuti</h1>

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
                    <h4 class="fw-bold text-primary-emphasis">Pengajuan Cuti</h4>

                    <input type="text" id="searchInput" class="form-control w-25" placeholder="Cari nama karyawan">
                </div>

                <div class="table-responsive">
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
                                    @if($item->status_direktur == 'menunggu')
                                    <span class="status menunggu">Menunggu</span>
                                    @elseif($item->status_direktur == 'disetujui')
                                    <span class="status disetujui">Disetujui</span>
                                    @elseif($item->status_direktur == 'ditolak')
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
                                        data-dokumen="{{ $item->dokumen_pendukung ? asset('storage/'.$item->dokumen_pendukung) : '' }}"
                                        onclick="isiModal(this)">
                                        <i class="fa-solid fa-eye"></i> Lihat
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center">
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

    <!-- MODAL BOOTSTRAP -->
    <div class="modal fade" id="modalVerifikasi" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 rounded-4 shadow">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold text-primary-emphasis">
                        Verifikasi Pengajuan Cuti
                    </h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form id="formVerifikasi" action="#" method="POST" novalidate>
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
                            <label class="form-label fw-semibold">Dokumen Pendukung</label>

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

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Alasan Ditolak</label>
                            <input type="text" id="alasan_ditolak" name="alasan_ditolak" class="form-control"
                                placeholder="Silahkan isi alasan jika cuti ditolak">
                        </div>

                        <div class="d-flex gap-4">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status_pengajuan" value="disetujui"
                                    required>
                                <label class="form-check-label">Diterima</label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status_pengajuan" value="ditolak"
                                    required>
                                <label class="form-check-label">Ditolak</label>
                            </div>
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
        function isiModal(btn) {
            const form = document.getElementById("formVerifikasi");

            form.action =
"/verifikasi-cuti-direktur/update/" + btn.dataset.id;

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
                const rows = document.querySelectorAll("#cutiTable tbody tr");

                rows.forEach(row => {
    const nama = row.cells[1]?.textContent.toLowerCase() || "";
    row.style.display = nama.includes(filter) ? "" : "none";
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

        document.addEventListener("DOMContentLoaded", function () {
            if (localStorage.getItem("sidebar") === "closed") {
                document.body.classList.add("sidebar-closed");
            }

            const theme = localStorage.getItem("theme");
            const lightBtn = document.getElementById("lightBtn");
            const darkBtn = document.getElementById("darkBtn");

            if (theme === "dark") {
                document.body.classList.add("dark-mode");
                darkBtn.classList.add("active");
            } else {
                lightBtn.classList.add("active");
            }

            lightBtn.addEventListener("click", function () {
                document.body.classList.remove("dark-mode");
                lightBtn.classList.add("active");
                darkBtn.classList.remove("active");
                localStorage.setItem("theme", "light");
            });

            darkBtn.addEventListener("click", function () {
                document.body.classList.add("dark-mode");
                darkBtn.classList.add("active");
                lightBtn.classList.remove("active");
                localStorage.setItem("theme", "dark");
            });

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
        document.getElementById('formVerifikasi').addEventListener('submit', function (e) {

            const status = document.querySelector(
                'input[name="status_pengajuan"]:checked'
            );

            const alasan = document.getElementById('alasan_ditolak');

            if (!status) {

                e.preventDefault();

                Swal.fire({
                    icon: 'warning',
                    title: 'Peringatan',
                    text: 'Silahkan pilih status pengajuan terlebih dahulu.'
                });

                return false;
            }

            if (
                status.value === 'ditolak' &&
                alasan.value.trim() === ''
            ) {

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

        if (radioDisetujui) {
            radioDisetujui.addEventListener('change', function () {
                alasanDitolak.value = '';
            });
        }
    </script>

</body>

</html>