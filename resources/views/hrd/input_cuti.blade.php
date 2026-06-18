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

<div class="main-content p-4">

    <div class="top-card bg-white rounded-4 shadow-sm p-4 d-flex justify-content-between align-items-center">
        <h1 class="fw-bold mb-0" style="color:#0d1f6b;font-size:32px;">
            Input Cuti
        </h1>

        <div class="d-flex align-items-center gap-3">
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

    <div class="form-card bg-white rounded-4 shadow-sm mt-4 p-4">
        <div class="mb-4">
            <h2 class="fw-bold" style="color:#0d1f6b;">
                Form Pengajuan Cuti
            </h2>
            <p class="text-muted mb-0">
                Silakan lengkapi data pengajuan cuti dengan benar.
            </p>
        </div>

       <form action="/hrd/input-cuti/store" method="POST" enctype="multipart/form-data">
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
                onchange="hitungCuti()"
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

        <h2 class="text-2xl font-bold text-gray-800 mb-2">
            Konfirmasi Keluar
        </h2>

        <p class="text-gray-600 mb-6">
            Apakah Anda yakin ingin keluar?
        </p>

        <div class="flex justify-center gap-3">
            <a href="/logout"
               class="bg-red-500 hover:bg-red-600 text-white px-6 py-3 rounded-lg font-bold transition">
                Ya, Keluar
            </a>

            <button type="button" onclick="closeLogoutModal()"
                class="bg-gray-400 hover:bg-gray-500 text-white px-6 py-3 rounded-lg font-bold transition">
                Batal
            </button>
        </div>
    </div>
</div>

@if(isset($cutiBelumAcc) && $cutiBelumAcc)
<script>
document.addEventListener("DOMContentLoaded", function () {
    Swal.fire({
        icon: 'warning',
        title: 'Pengajuan Masih Aktif',
        text: 'Anda masih memiliki pengajuan cuti yang belum disetujui atau masih diproses.',
        confirmButtonText: 'OK'
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
    if (localStorage.getItem("sidebar") === "closed") {
        document.body.classList.add("sidebar-closed");
    }

    if (localStorage.getItem("theme") === "dark") {
        setDarkMode();
    } else {
        setLightMode();
    }
});

function hitungCuti() {
    const jenis = document.getElementById("id_jenis_cuti");
    const selected = jenis.options[jenis.selectedIndex];

    if (!selected) return;

    const jenisText = selected.text.toLowerCase();

    const sisaAwal = parseInt(document.getElementById("sisa_awal").value) || 0;
    const jumlahInput = document.getElementById("jumlah_hari");
    const sisaSekarang = document.getElementById("sisa_sekarang");
    const tanggalMulai = document.getElementById("tanggal_mulai");
    const tanggalSelesai = document.getElementById("tanggal_selesai");
    const fileMc = document.getElementById("file_mc_box");

    let jumlahHari = 0;

    if (jenisText.includes("melahirkan") && jenisText.includes("istri")) {
        jumlahHari = 90;
        jumlahInput.value = jumlahHari;
        jumlahInput.readOnly = true;
        sisaSekarang.value = sisaAwal;
        tanggalSelesai.value = hitungTanggalSelesai(tanggalMulai.value, jumlahHari);
        fileMc.classList.add("d-none");
    }

    else if (jenisText.includes("melahirkan") && jenisText.includes("suami")) {
        jumlahHari = 2;
        jumlahInput.value = jumlahHari;
        jumlahInput.readOnly = true;
        sisaSekarang.value = sisaAwal;
        tanggalSelesai.value = hitungTanggalSelesai(tanggalMulai.value, jumlahHari);
        fileMc.classList.add("hidden");
    }

    else if (jenisText.includes("sakit")) {
        jumlahInput.readOnly = false;
        sisaSekarang.value = sisaAwal;
        tanggalSelesai.value = "";
        fileMc.classList.remove("d-none");
    }

    else {
        jumlahInput.readOnly = false;
        jumlahHari = parseInt(jumlahInput.value) || 0;
        sisaSekarang.value = Math.max(0, sisaAwal - jumlahHari);
        tanggalSelesai.value = "";
        fileMc.classList.add("hidden");
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

    const jenis = document.getElementById("id_jenis_cuti");
    const jenisText = jenis.options[jenis.selectedIndex]?.text.toLowerCase() || "";

    if (jenisText.includes("melahirkan")) {
        return;
    }

    if (mulai && selesai) {
        const start = new Date(mulai);
        const end = new Date(selesai);

        const selisih = end - start;
        const hari = Math.floor(selisih / (1000 * 60 * 60 * 24)) + 1;

        if (hari > 0) {
            document.getElementById("jumlah_hari").value = hari;

            if (jenisText.includes("tahunan")) {
                document.getElementById("sisa_sekarang").value = Math.max(0, sisaAwal - hari);
            } else {
                document.getElementById("sisa_sekarang").value = sisaAwal;
            }
        } else {
            alert("Tanggal selesai tidak boleh sebelum tanggal mulai");
            document.getElementById("jumlah_hari").value = "";
            document.getElementById("sisa_sekarang").value = sisaAwal;
        }
    }
}

function hitungSisaCuti() {
    const sisaAwal = parseInt(document.getElementById("sisa_awal").value) || 0;
    const jumlah = parseInt(document.getElementById("jumlah_hari").value) || 0;

    document.getElementById("sisa_sekarang").value = Math.max(0, sisaAwal - jumlah);
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
</script>

</body>
</html>