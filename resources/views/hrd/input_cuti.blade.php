<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Input Cuti HRD</title>

    <link rel="icon" type="image/png" href="{{ asset('img/logo/wg.png') }}">
    <link rel="stylesheet" href="{{ asset('css/hrd.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
        body {
            background: #f4f6f9;
        }

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
            color:white;
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
        body.dark-mode .form-card{
            background:#111827 !important;
            color:white !important;
            border:1px solid #1f2937 !important;
        }

        body.dark-mode label,
        body.dark-mode h1,
        body.dark-mode h2{
            color:white !important;
        }

        body.dark-mode input,
        body.dark-mode select,
        body.dark-mode textarea{
            background:#1f2937 !important;
            color:white !important;
            border-color:#374151 !important;
        }

        body.dark-mode input::placeholder,
        body.dark-mode textarea::placeholder{
            color:#94a3b8 !important;
        }

        .logout-modal{
            position:fixed;
            inset:0;
            background:rgba(0,0,0,.5);
            backdrop-filter:blur(4px);
            display:none;
            justify-content:center;
            align-items:center;
            z-index:999999;
        }

        .logout-box{
            width:420px;
            background:white;
            border-radius:16px;
            padding:35px;
            text-align:center;
            box-shadow:0 20px 45px rgba(0,0,0,.25);
        }

        .logout-icon{
            width:75px;
            height:75px;
            margin:0 auto 20px;
            border:4px solid #dbeafe;
            border-radius:50%;
            display:flex;
            align-items:center;
            justify-content:center;
            font-size:32px;
            color:#2563eb;
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
            .top-card, .form-card {
                padding: 16px !important;
            }
        }

        @media (max-width: 575.98px) {
            .top-card h1 {
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
        .logout-box {
            width: 90% !important;
            max-width: 420px;
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

<div class="main-content p-4">

    <div class="top-card bg-white rounded-4 shadow-sm p-4 d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center gap-3">
            <button type="button" class="sidebar-mobile-toggle d-lg-none" onclick="toggleSidebar()">
                <i class="fa-solid fa-bars"></i>
            </button>
            <h1 class="fw-bold mb-0 page-title" style="color:#0d1f6b;font-size:32px;">
                Input Cuti
            </h1>
        </div>

        <div class="d-flex align-items-center gap-3">
            <div class="theme-toggle-top">
                <button type="button" id="lightBtn" onclick="setLightMode()">
                    <i class="fa-solid fa-sun"></i>
                </button>

                <button type="button" id="darkBtn" onclick="setDarkMode()">
                    <i class="fa-solid fa-moon"></i>
                </button>
            </div>

            <span class="fw-semibold d-none d-sm-inline">{{ session('nama') }}</span>
            <i class="fa-solid fa-user"></i>
        </div>
    </div>

    <div class="form-card bg-white rounded-4 shadow-sm mt-4 p-4">
        <div class="mb-4">
            <h2 class="fw-bold" style="color:#0d1f6b;">
                Form Pengajuan Cuti
            </h2>
            <p class="text-muted mb-0">
                Silakan lengkapi data pengajuan cuti dengan benar.
            </p>
            <div class="alert alert-info border-0 shadow-sm rounded-3 d-flex align-items-center gap-2 mt-3 mb-0">
                <i class="fa-solid fa-calendar-days"></i>
                <span id="infoCuti"></span>
            </div>
        </div>

       <form action="/hrd/input-cuti/store" method="POST" enctype="multipart/form-data" onsubmit="return validateCuti()">
    @csrf

    <!-- ID KARYAWAN (WAJIB) -->
    

   <div class="row g-3">

    <div class="col-md-6">
        <label class="form-label fw-semibold">Nama Karyawan</label>
        <input type="text"
               value="{{ $user->nama }}"
               readonly
               class="form-control bg-light">
    </div>

    <div class="col-md-6">
        <label class="form-label fw-semibold">Tanggal Pengajuan</label>
        <input type="date"
               name="tanggal_pengajuan"
               value="{{ date('Y-m-d') }}"
               readonly
               class="form-control bg-light">
    </div>

    <div class="col-md-6">
        <label class="form-label fw-semibold">Jabatan</label>
        <input type="text"
               value="{{ ucfirst($user->jabatan) }}"
               readonly
               class="form-control bg-light">
    </div>

    <div class="col-md-6">
        <label class="form-label fw-semibold">Divisi</label>
        <input type="text"
               value="{{ $user->divisi }}"
               readonly
               class="form-control bg-light">
    </div>

    <div class="col-md-6">
        <label class="form-label fw-semibold">Jenis Cuti</label>
        <select name="id_jenis_cuti"
                id="id_jenis_cuti"
                onchange="resetInputsAndHitung()"
                required
                class="form-select">

            <option value="" selected disabled>
                Pilih Jenis Cuti
            </option>

            @foreach($jenisCuti as $jenis)
                <option value="{{ $jenis->id_jenis_cuti }}">
                    {{ $jenis->nama_jenis_cuti }}
                </option>
            @endforeach

        </select>
    </div>

    <div class="col-md-6">
        <label class="form-label fw-semibold">Sisa Cuti</label>
        <input type="number"
               id="sisa_awal"
               value="{{ $user->sisa_cuti }}"
               readonly
               class="form-control bg-light">
    </div>

    <div class="col-md-6">
        <label class="form-label fw-semibold">Tanggal Mulai</label>
        <input type="date"
               name="tanggal_mulai"
               id="tanggal_mulai"
               onchange="hitungCuti()"
               required
               class="form-control">
    </div>

    <div class="col-md-6">
        <label class="form-label fw-semibold">Tanggal Selesai</label>
        <input type="date"
               name="tanggal_selesai"
               id="tanggal_selesai"
               onchange="hitungHari()"
               required
               class="form-control">
    </div>

    <div class="col-md-6">
        <label class="form-label fw-semibold">Jumlah Hari</label>
        <input type="number"
               name="jumlah_hari"
               id="jumlah_hari"
               oninput="hitungSisaCuti()"
               required
               class="form-control">
    </div>

    <div class="col-md-6">
        <label class="form-label fw-semibold">Sisa Setelah Cuti</label>
        <input type="number"
               id="sisa_sekarang"
               name="sisa_sekarang"
               value="{{ $user->sisa_cuti }}"
               readonly
               class="form-control bg-light">
    </div>

    <div class="col-12">
        <label class="form-label fw-semibold">Keterangan</label>
        <textarea name="alasan_pengajuan"
                  rows="4"
                  required
                  class="form-control"></textarea>
    </div>

    <div class="col-12 d-none" id="file_mc_box">
        <label class="form-label fw-semibold">
            Upload Surat Dokter / MC
        </label>
        <input type="file"
               name="dokumen_pendukung"
               id="dokumen_pendukung"
               class="form-control">
    </div>

</div>

    <div class="mt-4 d-flex justify-content-end gap-2">
        <button type="button" onclick="history.back()"
            class="btn btn-secondary">
            Tutup
        </button>

        <button type="submit"
            class="btn text-white fw-bold"
style="background:#1e2a78;">
            Simpan Data
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

        <h2 class="fs-4 fw-bold text-dark mb-2">
            Konfirmasi Keluar
        </h2>

        <p class="text-muted mb-4">
            Apakah Anda yakin ingin keluar?
        </p>

        <div class="d-flex justify-content-center gap-3">
            <a href="/logout"
               class="btn btn-danger px-4 py-2 fw-bold rounded-3">
                Ya, Keluar
            </a>

            <button type="button" onclick="closeLogoutModal()"
                class="btn btn-secondary px-4 py-2 fw-bold rounded-3">
                Batal
            </button>
        </div>
    </div>
</div>

@if(session('error'))
<script>
document.addEventListener("DOMContentLoaded", function () {
    Swal.fire({
        icon: 'warning',
        title: 'Pengajuan Cuti Ditolak',
        html: `{!! session('error') !!}`,
        confirmButtonText: 'Mengerti',
        confirmButtonColor: '#1e2a78'
    });
});
</script>
@endif

@if(session('success'))
<script>
document.addEventListener("DOMContentLoaded", function () {
    Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: "{{ session('success') }}",
        confirmButtonColor: '#1e2a78'
    });
});
</script>
@endif

@if(isset($cutiBelumAcc) && $cutiBelumAcc)
<script>
document.addEventListener("DOMContentLoaded", function () {
    Swal.fire({
        icon: 'warning',
        title: 'Pengajuan Masih Aktif',
        text: 'Anda masih memiliki pengajuan cuti yang belum disetujui atau masih diproses.',
        confirmButtonText: 'OK',
        allowOutsideClick: false
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "{{ url('/dashboard-hrd') }}";
        }
    });
});
</script>
@endif

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
    const isMobile = window.innerWidth < 992;
    const sidebarState = localStorage.getItem("sidebar");
    
    if (sidebarState === "closed" || (isMobile && sidebarState === null)) {
        document.body.classList.add("sidebar-closed");
    } else if (sidebarState === "open") {
        document.body.classList.remove("sidebar-closed");
    }

    if (localStorage.getItem("theme") === "dark") {
        setDarkMode();
    } else {
        setLightMode();
    }

    // Validasi batas tanggal minimal pengajuan
    setTanggalMinimalCuti();
});

function resetInputsAndHitung() {
    const sisaAwal = parseInt(document.getElementById("sisa_awal").value) || 0;
    document.getElementById("tanggal_mulai").value = "";
    document.getElementById("tanggal_selesai").value = "";
    document.getElementById("jumlah_hari").value = "";
    document.getElementById("sisa_sekarang").value = sisaAwal;
    hitungCuti();
}

function hitungCuti() {
    const jenis = document.getElementById("id_jenis_cuti");
    const selected = jenis.options[jenis.selectedIndex];

    if (!selected || selected.value === "") return;

    const jenisText = selected.text.toLowerCase();

    const sisaAwal = parseInt(document.getElementById("sisa_awal").value) || 0;
    const jumlahInput = document.getElementById("jumlah_hari");
    const sisaSekarang = document.getElementById("sisa_sekarang");
    const tanggalMulai = document.getElementById("tanggal_mulai");
    const tanggalSelesai = document.getElementById("tanggal_selesai");
    const fileMc = document.getElementById("file_mc_box");

    if (tanggalMulai.value) {
        tanggalSelesai.min = tanggalMulai.value;
    } else {
        tanggalSelesai.min = tanggalMulai.min || "";
    }

    // Batas minimal pengajuan cuti tahunan
    if (jenisText.includes("tahunan")) {
        setTanggalMinimalCuti();
    } else {
        tanggalMulai.removeAttribute("min");
        const info = document.getElementById("infoCuti");
        if (info) {
            info.innerHTML = "Pengajuan cuti ini tidak memiliki batas minimal hari pengajuan.";
        }
    }

    let jumlahHari = 0;

    if (jenisText.includes("melahirkan") && jenisText.includes("istri")) {
        jumlahHari = 90;
        jumlahInput.value = jumlahHari;
        jumlahInput.readOnly = true;
        sisaSekarang.value = sisaAwal;
        if (tanggalMulai.value) {
            tanggalSelesai.value = hitungTanggalSelesai(tanggalMulai.value, jumlahHari);
        }
        fileMc.classList.add("d-none");
    }

    else if (jenisText.includes("melahirkan") && jenisText.includes("suami")) {
        jumlahHari = 2;
        jumlahInput.value = jumlahHari;
        jumlahInput.readOnly = true;
        sisaSekarang.value = sisaAwal;
        if (tanggalMulai.value) {
            tanggalSelesai.value = hitungTanggalSelesai(tanggalMulai.value, jumlahHari);
        }
        fileMc.classList.add("d-none");
    }

    else if (jenisText.includes("sakit")) {
        jumlahInput.readOnly = false;
        fileMc.classList.remove("d-none");
        if (tanggalMulai.value && tanggalSelesai.value) {
            hitungHari();
        } else {
            jumlahInput.value = "";
            sisaSekarang.value = sisaAwal;
        }
    }

    else {
        jumlahInput.readOnly = false;
        fileMc.classList.add("d-none");
        if (tanggalMulai.value && tanggalSelesai.value) {
            hitungHari();
        } else {
            jumlahInput.value = "";
            sisaSekarang.value = sisaAwal;
        }
    }
}

function hitungTanggalSelesai(tanggalMulai, jumlahHari) {
    if (!tanggalMulai) return "";

    let mulai = new Date(tanggalMulai);
    mulai.setDate(mulai.getDate() + (jumlahHari - 1));

    let tahun = mulai.getFullYear();
    let bulan = String(mulai.getMonth() + 1).padStart(2, "0");
    let hari = String(mulai.getDate()).padStart(2, "0");

    return `${tahun}-${bulan}-${hari}`;
}

function hitungHari() {
    const mulai = document.getElementById("tanggal_mulai").value;
    const selesai = document.getElementById("tanggal_selesai").value;
    const sisaAwal = parseInt(document.getElementById("sisa_awal").value) || 0;
    const tipeKerja = "{{ $user->tipe_kerja ?? '' }}";

    const jenis = document.getElementById("id_jenis_cuti");
    const jenisText = jenis.options[jenis.selectedIndex]?.text.toLowerCase() || "";

    if (jenisText.includes("melahirkan")) {
        return;
    }

    if (mulai && selesai) {
        const start = new Date(mulai);
        const end = new Date(selesai);

        if (end < start) {
            alert("Tanggal selesai tidak boleh sebelum tanggal mulai");
            document.getElementById("jumlah_hari").value = "";
            document.getElementById("sisa_sekarang").value = sisaAwal;
            return;
        }

        const hariLibur = [
            '2026-01-01',
            '2026-03-19',
            '2026-03-20',
            '2026-04-03',
            '2026-04-06',
            '2026-05-01',
            '2026-05-14',
            '2026-05-27',
            '2026-06-17',
            '2026-08-17',
            '2026-12-25'
        ];

        let hari = 0;
        let loopDate = new Date(start);

        while (loopDate <= end) {
            const dayOfWeek = loopDate.getDay(); // 0 is Sunday, 6 is Saturday
            
            // Format to YYYY-MM-DD
            const yyyy = loopDate.getFullYear();
            const mm = String(loopDate.getMonth() + 1).padStart(2, '0');
            const dd = String(loopDate.getDate()).padStart(2, '0');
            const dateString = `${yyyy}-${mm}-${dd}`;

            let isHoliday = false;

            // 1. Sunday is always holiday for all
            if (dayOfWeek === 0) {
                isHoliday = true;
            }
            // 2. Saturday is holiday for back office only
            else if (tipeKerja === 'back_office' && dayOfWeek === 6) {
                isHoliday = true;
            }
            // 3. National Holiday
            else if (hariLibur.includes(dateString)) {
                isHoliday = true;
            }

            if (!isHoliday) {
                hari++;
            }

            loopDate.setDate(loopDate.getDate() + 1);
        }

        document.getElementById("jumlah_hari").value = hari;

        if (jenisText.includes("tahunan")) {
            document.getElementById("sisa_sekarang").value = Math.max(0, sisaAwal - hari);
        } else {
            document.getElementById("sisa_sekarang").value = sisaAwal;
        }
    }
}

function hitungSisaCuti() {
    const sisaAwal = parseInt(document.getElementById("sisa_awal").value) || 0;
    const jumlah = parseInt(document.getElementById("jumlah_hari").value) || 0;
    const jenis = document.getElementById("id_jenis_cuti");
    const jenisText = jenis.options[jenis.selectedIndex]?.text.toLowerCase() || "";

    if (jenisText.includes("tahunan")) {
        document.getElementById("sisa_sekarang").value = Math.max(0, sisaAwal - jumlah);
    } else {
        document.getElementById("sisa_sekarang").value = sisaAwal;
    }
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

function alertCutiBelumAcc() {
    Swal.fire({
        icon: 'warning',
        title: 'Pengajuan Belum Selesai',
        html: `
            <div style="font-size:15px">
                Anda masih memiliki pengajuan cuti yang:
                <br><br>
                <b>• Menunggu Verifikasi</b><br>
                <b>• Sedang Diproses</b>
                <br><br>
                Silakan tunggu hingga pengajuan sebelumnya
                disetujui atau ditolak terlebih dahulu.
            </div>
        `,
        confirmButtonText: 'Mengerti',
        confirmButtonColor: '#1e2a78'
    });
}

function validateCuti() {
    const jenis = document.getElementById("id_jenis_cuti");
    const jenisText = jenis.options[jenis.selectedIndex]?.text.toLowerCase() || "";

    const fileInput = document.getElementById("dokumen_pendukung");

    // cek jika cuti sakit
    if (jenisText.includes("sakit")) {
        if (!fileInput.value) {
            Swal.fire({
                icon: 'error',
                title: 'File Wajib Diupload',
                text: 'Silakan upload surat MC untuk cuti sakit',
                confirmButtonColor: '#1e2a78'
            });
            return false; // STOP submit
        }
    }

    return true; // lanjut submit
}

function setTanggalMinimalCuti(){
    const inputTanggal = document.getElementById("tanggal_mulai");
    const info = document.getElementById("infoCuti");
    if (!inputTanggal || !info) return;

    let sekarang = new Date();
    let minimalHari = {{ $pengaturan->minimal_pengajuan_hari ?? 7 }};
    sekarang.setDate(sekarang.getDate() + minimalHari);

    let tahun = sekarang.getFullYear();
    let bulan = String(sekarang.getMonth()+1).padStart(2,'0');
    let hari = String(sekarang.getDate()).padStart(2,'0');
    let tanggalMinimal = `${tahun}-${bulan}-${hari}`;
    
    inputTanggal.min = tanggalMinimal;
    const inputSelesai = document.getElementById("tanggal_selesai");
    if (inputSelesai) {
        inputSelesai.min = tanggalMinimal;
    }

    let formatTanggal = new Date(tanggalMinimal)
        .toLocaleDateString('id-ID',{
            day:'numeric',
            month:'long',
            year:'numeric'
        });

    info.innerHTML = 
    `Pengajuan cuti dapat dilakukan mulai tanggal 
    <b>${formatTanggal}</b> 
    (minimal <b>{{ $pengaturan->minimal_pengajuan_hari ?? 7 }}</b> hari sebelum cuti)`;
}
</script>

</body>
</html>