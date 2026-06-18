<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>List Karyawan</title>
    <link rel="icon" type="image/png" href="{{ asset('img/logo/wg.png') }}">
    <link rel="stylesheet" href="{{ asset('css/hrd.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

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

.alert{
    padding: 12px 16px;
    margin: 15px 0;
    border-radius: 8px;
    font-weight: 500;
}

.alert-success{
    background: #d1fae5;
    color: #065f46;
    border-left: 5px solid #10b981;
}

.alert-danger{
    background: #fee2e2;
    color: #991b1b;
    border-left: 5px solid #ef4444;
}

.toast{
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

.toast.show{
    opacity: 1;
    transform: translateY(0);
}

.toast.success{
    background: #10b981;
}

.toast.error{
    background: #ef4444;
}
    </style>
</head>
</head>

<body>

<div id="toast" class="toast"></div>


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
    <h1 class="fw-bold text-primary-emphasis">List Karyawan</h1>

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
                <div>
                    <button type="button" class="btn-add" onclick="openModal()">
                        <i class="fa-solid fa-user-plus"></i> Tambah Karyawan
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
                        <th>No HP</th>
                        <th>Sisa Cuti</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $user->nama }}</td>
                        <td>{{ $user->email ?? '-' }}</td>
                        <td>{{ $user->username }}</td>
                        <td>{{ ucfirst($user->jabatan) }}</td>
                        <td>{{ $user->divisi }}</td>
                        <td>{{ $user->no_hp }}</td>
                        <td>{{ $user->sisa_cuti }}</td>
                        <td>
                            <button type="button" class="btn-edit" onclick="openEditModal(
                            '{{ $user->id_user }}',
                            '{{ $user->nama }}',
                            '{{ $user->email }}',
                            '{{ $user->username }}',
                            '{{ $user->jabatan }}',
                            '{{ $user->divisi }}',
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
                        <select name="jabatan" required>
                            <option value="" selected disabled>Pilih jabatan</option>
                            <option value="direktur">Direktur</option>
                            <option value="hrd">HRD</option>
                            <option value="karyawan">Karyawan</option>
                        </select>
                    </div>

                    <div>
                        <label>Username :</label>
                        <input type="text" name="username" required>
                    </div>

                    <div>
                        <label>Divisi :</label>
                        <select name="divisi" required>
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

</body>
<script>
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
    alamat,
    nohp
) {
    document.getElementById("formEdit").action = "/karyawan/update/" + id;

    document.getElementById("edit_nama").value = nama || "";
    document.getElementById("edit_email").value = email || "";
    document.getElementById("edit_username").value = username || "";
    document.getElementById("edit_jabatan").value = jabatan || "";
    document.getElementById("edit_divisi").value = divisi || "";
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
    if (localStorage.getItem("sidebar") === "closed") {
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
                row.style.display = row.textContent.toLowerCase().includes(keyword)
                    ? ""
                    : "none";
            });
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
</script>
</html>