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

    <link rel="stylesheet" href="{{ asset('css/hrd.css') }}">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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

    <a href="javascript:void(0)" class="logout" onclick="showLogoutModal(event)">
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
    <input
    type="text"
    id="alasan_ditolak"
    name="alasan_ditolak"
    class="form-control"
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





    </script>

</body>

</html>