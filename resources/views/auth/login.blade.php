<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login - Wasaka Group</title>

    <link rel="icon" type="image/png" href="{{ asset('img/logo/wg.png') }}">
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <link rel="stylesheet" href="{{ asset('css/login.css') }}">

    <style>
        /* FIX AUTOFILL CHROME */
        input:-webkit-autofill,
        input:-webkit-autofill:hover,
        input:-webkit-autofill:focus {
            -webkit-box-shadow: 0 0 0px 1000px white inset !important;
            -webkit-text-fill-color: #000 !important;
        }
    </style>
</head>

<body>

<div class="login-wrapper">

    <!-- KIRI -->
    <div class="login-banner">

        <video autoplay muted loop playsinline class="banner-video">
            <source src="{{ asset('vidio/Company Profile WASAKA (5min).mp4') }}" type="video/mp4">
        </video>

        <div class="overlay"></div>

        <div class="banner-content">
            <img src="{{ asset('img/logo/wg-putih.png') }}" alt="">
            <h2>WASAKA GROUP</h2>
            <p>Sistem Informasi Cuti Karyawan</p>
        </div>

    </div>

    <!-- KANAN -->
    <div class="login-form-area">

        <div class="login-card">

            <div class="login-header">
                <img src="{{ asset('img/logo/wg.png') }}" alt="">
            </div>

            @if(session('success'))
                <div class="alert-success">{{ session('success') }}</div>
            @endif

            @if(session('error'))
                <div class="alert-error">{{ session('error') }}</div>
            @endif

            <p class="login-subtitle">
                Silakan masuk ke akun Anda
            </p>

            <!-- 🔥 FIX AUTOFILL DI FORM -->
            <form action="{{ url('/login') }}" method="POST" autocomplete="off">
                @csrf

                <!-- fake input untuk jebak autofill browser -->
                <input type="text" style="display:none">
                <input type="password" style="display:none">

                <div class="input-group">
                    <i class="fa-solid fa-user"></i>

                    <input
                        type="text"
                        name="username"
                        placeholder="Masukkan Username"
                        autocomplete="off"
                        required>
                </div>

                <div class="input-group password-group">
                    <i class="fa-solid fa-lock input-icon"></i>

                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Masukkan Password"
                        autocomplete="new-password"
                        required>

                    <span class="toggle-password" onclick="togglePassword()">
                        <i class="fa-solid fa-eye"></i>
                    </span>
                </div>

                <div class="input-group">
                    <i class="fa-solid fa-user-tie"></i>

                    <select name="jabatan" required autocomplete="off">
                        <option value="" disabled selected>Pilih Jabatan</option>
                        <option value="karyawan">Karyawan</option>
                        <option value="hrd">HRD</option>
                        <option value="direktur">Direktur</option>
                    </select>
                </div>

                <div class="forgot-password">
                    <a href="{{ url('/reset-password') }}">
                        Lupa Password?
                    </a>
                </div>

                <button type="submit" class="btn-login">
                    Masuk
                </button>

            </form>

            <div class="footer">
                ©2026 Sistem Cuti Karyawan
            </div>

        </div>

    </div>

</div>

</body>

<script>
function togglePassword() {
    const password = document.getElementById('password');
    const icon = document.querySelector('.toggle-password i');

    if (password.type === 'password') {
        password.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        password.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}
</script>

</html>