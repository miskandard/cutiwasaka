<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Input Cuti</title>

    <link rel="icon" type="image/png" href="{{ asset('img/logo/wg.png') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <script src="https://cdn.tailwindcss.com"></script>
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
            width: 90%;
            max-width: 420px;
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

    <a href="/input-cuti" class="active">
        <i class="fa-solid fa-pen-to-square"></i> Input Cuti
    </a>

    <a href="/riwayat-cuti">
        <i class="fa-solid fa-clipboard-list"></i> Riwayat Cuti
    </a>

    <a href="javascript:void(0)" class="logout" onclick="showLogoutModal(event)">
        <i class="fa-solid fa-right-from-bracket"></i> Keluar
    </a>
</div>

<!-- Sidebar Overlay for mobile -->
<div class="sidebar-overlay" onclick="toggleSidebar()"></div>

<div class="main-content min-h-screen p-6">

    <div class="top-card bg-white rounded-xl shadow-sm px-4 md:px-8 py-6 flex justify-between items-center">
        <div class="flex items-center gap-3 md:gap-4">
            <button type="button" class="hamburger-btn" onclick="toggleSidebar()">
                <i class="fa-solid fa-bars"></i>
            </button>
            <h1 class="text-xl md:text-3xl font-bold text-[#0d1f6b] leading-tight">
                Input Cuti
            </h1>
        </div>

        <div class="flex items-center gap-4">
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

    <div class="form-card bg-white rounded-2xl shadow-md mt-8 p-6 sm:p-8">
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-[#0d1f6b]">
                Form Pengajuan Cuti
            </h2>
            <p class="text-gray-500 mt-1">
    Silakan lengkapi data pengajuan cuti dengan benar.
</p>

<div class="mt-4 bg-blue-50 border border-blue-200 text-blue-800 px-4 py-3 rounded-xl">
    <i class="fa-solid fa-calendar-days mr-2"></i>
    <span id="infoCuti"></span>
</div>
        </div>

        <form action="/input-cuti/store" method="POST" enctype="multipart/form-data" onsubmit="return validateCuti()">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div>
                    <label class="block font-semibold text-gray-700 mb-2">Nama Lengkap</label>
                    <input type="text" value="{{ $user->nama ?? '' }}" readonly
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 bg-gray-100 focus:ring-2 focus:ring-blue-400 outline-none">
                </div>

                <div>
                    <label class="block font-semibold text-gray-700 mb-2">Tanggal Pengajuan</label>
                    <input type="date" name="tanggal_pengajuan" value="{{ date('Y-m-d') }}" readonly
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 bg-gray-100 focus:ring-2 focus:ring-blue-400 outline-none">
                </div>

                <div>
                    <label class="block font-semibold text-gray-700 mb-2">Jabatan</label>
                    <input type="text" value="{{ ucfirst($user->jabatan ?? '') }}" readonly
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 bg-gray-100 focus:ring-2 focus:ring-blue-400 outline-none">
                </div>

                <div>
                    <label class="block font-semibold text-gray-700 mb-2">Divisi</label>
                    <input type="text" value="{{ $user->divisi ?? '' }}" readonly
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 bg-gray-100 focus:ring-2 focus:ring-blue-400 outline-none">
                </div>

                <div>
                    <label class="block font-semibold text-gray-700 mb-2">Jenis Cuti</label>
                    <select name="id_jenis_cuti" id="id_jenis_cuti" onchange="resetInputsAndHitung()" required
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 bg-white focus:ring-2 focus:ring-blue-400 outline-none">
                        <option value="" selected disabled>Pilih Jenis Cuti</option>

                        @foreach($jenisCuti as $jenis)
                            <option
                                value="{{ $jenis->id_jenis_cuti }}"
                                data-nama="{{ strtolower($jenis->nama_jenis_cuti) }}"
                                data-hari="{{ $jenis->maksimal_hari }}"
                            >
                                {{ $jenis->nama_jenis_cuti }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block font-semibold text-gray-700 mb-2">Sisa Cuti Terakhir</label>
                    <input type="number" id="sisa_awal" value="{{ $user->sisa_cuti }}" readonly
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 bg-gray-100 focus:ring-2 focus:ring-blue-400 outline-none">
                </div>

                <div>
                    <label class="block font-semibold text-gray-700 mb-2">Tanggal Mulai</label>
                    <input type="date" name="tanggal_mulai" id="tanggal_mulai" onchange="hitungCuti()" required
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 bg-white focus:ring-2 focus:ring-blue-400 outline-none">
                </div>

                <div>
                    <label class="block font-semibold text-gray-700 mb-2">Tanggal Selesai</label>
                    <input type="date" name="tanggal_selesai" id="tanggal_selesai" onchange="hitungHari()" required
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 bg-white focus:ring-2 focus:ring-blue-400 outline-none">
                </div>

                <div>
                    <label class="block font-semibold text-gray-700 mb-2">Jumlah Cuti Diambil</label>
                    <input type="number" name="jumlah_hari" id="jumlah_hari" oninput="hitungSisaCuti()" required
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 bg-white focus:ring-2 focus:ring-blue-400 outline-none">
                </div>

                <div>
                    <label class="block font-semibold text-gray-700 mb-2">Sisa Cuti Sekarang</label>
                    <input type="number" id="sisa_sekarang" name="sisa_sekarang" value="{{ $user->sisa_cuti }}" readonly
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 bg-gray-100 focus:ring-2 focus:ring-blue-400 outline-none">
                </div>

                <div class="md:col-span-2">
                    <label class="block font-semibold text-gray-700 mb-2">Keterangan Cuti</label>
                    <textarea name="alasan_pengajuan" rows="4" required
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 bg-white focus:ring-2 focus:ring-blue-400 outline-none resize-none"
                        placeholder="Masukkan alasan pengajuan cuti"></textarea>
                </div>

                <div class="md:col-span-2 hidden" id="file_mc_box">
                    <label class="block font-semibold text-gray-700 mb-2">Upload Surat Dokter / MC</label>
                    <input type="file" name="dokumen_pendukung" id="dokumen_pendukung"
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 bg-white focus:ring-2 focus:ring-blue-400 outline-none">
                </div>

            </div>

            <div class="mt-8 flex flex-col sm:flex-row justify-end gap-3">
                <button type="button" onclick="history.back()"
                    class="px-6 py-3 rounded-xl bg-gray-400 text-white font-bold hover:bg-gray-500 transition w-full sm:w-auto text-center">
                    Tutup
                </button>

                @if($cutiBelumAcc)

<button
    type="button"
    onclick="alertCutiBelumAcc()"
    class="px-6 py-3 rounded-xl bg-[#1e2a78] text-white font-bold hover:bg-blue-900 transition shadow-md w-full sm:w-auto text-center">

    Simpan Data

</button>

@else

<button
    type="submit"
   class="px-6 py-3 rounded-xl bg-[#1e2a78] text-white font-bold hover:bg-blue-900 transition shadow-md w-full sm:w-auto text-center">

    Simpan Data

</button>

@endif
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


@if(session('error'))
<script>
document.addEventListener("DOMContentLoaded", function () {
    Swal.fire({
    icon: 'warning',
    title: 'Pengajuan Cuti Ditolak',
    text: "{{ session('error') }}",
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
            window.location.href = "{{ url('/dashboard-karyawan') }}";
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
    const savedSidebarState = localStorage.getItem("sidebar");
    if (savedSidebarState === "closed" || (!savedSidebarState && window.innerWidth < 1024)) {
        document.body.classList.add("sidebar-closed");
    }

    if (localStorage.getItem("theme") === "dark") {
        setDarkMode();
    } else {
        setLightMode();
    }
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

    const jenisText = selected.text.toLowerCase();


    // ===============================
    // H-7 KHUSUS CUTI TAHUNAN
    // ===============================
    if (jenisText.includes("tahunan")) {

        setTanggalMinimalCuti();

    } else {

        tanggalMulai.removeAttribute("min");

        document.getElementById("infoCuti").innerHTML =
        "Pengajuan cuti ini tidak memiliki batas minimal hari pengajuan.";

    }


    let jumlahHari = 0;


    // CUTI MELAHIRKAN ISTRI
    if (jenisText.includes("melahirkan") && jenisText.includes("istri")) {

        jumlahHari = 90;

        jumlahInput.value = jumlahHari;
        jumlahInput.readOnly = true;

        sisaSekarang.value = sisaAwal;

        if (tanggalMulai.value) {
            tanggalSelesai.value =
            hitungTanggalSelesai(tanggalMulai.value, jumlahHari);
        }

        fileMc.classList.add("hidden");
    }


    // CUTI MELAHIRKAN SUAMI
    else if (jenisText.includes("melahirkan") && jenisText.includes("suami")) {

        jumlahHari = 2;

        jumlahInput.value = jumlahHari;
        jumlahInput.readOnly = true;

        sisaSekarang.value = sisaAwal;

        if (tanggalMulai.value) {
            tanggalSelesai.value =
            hitungTanggalSelesai(tanggalMulai.value, jumlahHari);
        }

        fileMc.classList.add("hidden");
    }


    // CUTI SAKIT
    else if (jenisText.includes("sakit")) {

        jumlahInput.readOnly = false;
        fileMc.classList.remove("hidden");

        if (tanggalMulai.value && tanggalSelesai.value) {
            hitungHari();
        } else {
            jumlahInput.value = "";
            sisaSekarang.value = sisaAwal;
        }
    }


    // CUTI TAHUNAN
    else {

        jumlahInput.readOnly = false;
        fileMc.classList.add("hidden");

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

document.addEventListener("DOMContentLoaded", function () {

    const savedSidebarState = localStorage.getItem("sidebar");

    if (savedSidebarState === "closed" || (!savedSidebarState && window.innerWidth < 1024)) {
        document.body.classList.add("sidebar-closed");
    }

    if (localStorage.getItem("theme") === "dark") {
        setDarkMode();
    } else {
        setLightMode();
    }


    // VALIDASI H-7 CUTI
    setTanggalMinimalCuti();

});

function setTanggalMinimalCuti(){

    const inputTanggal = document.getElementById("tanggal_mulai");
    const info = document.getElementById("infoCuti");


    let sekarang = new Date();


    let minimalHari = {{ $pengaturan->minimal_pengajuan_hari ?? 7 }};


    sekarang.setDate(
        sekarang.getDate() + minimalHari
    );


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
    `Pengajuan cuti dapat dilakukan mulai tanggal <b>${formatTanggal}</b> (minimal <b>{{ $pengaturan->minimal_pengajuan_hari ?? 7 }}</b> hari sebelum cuti)`;
}
</script>

</body>
</html>