<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Reset Password - Wasaka Group</title>

    <link rel="icon" type="image/png" href="{{ asset('img/logo/wg.png') }}">
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <link rel="stylesheet" href="{{ asset('css/login.css') }}">

    <!-- 🔥 FIX AUTOFILL CHROME -->
    <style>
        input:-webkit-autofill,
        input:-webkit-autofill:hover,
        input:-webkit-autofill:focus {
            -webkit-box-shadow: 0 0 0px 1000px white inset !important;
            -webkit-text-fill-color: #000 !important;
        }
    </style>
</head>

<body>

<div class="wrapper">

    <!-- KIRI -->
    <div class="banner">

        <video autoplay muted loop playsinline>
            <source src="{{ asset('vidio/Company Profile WASAKA (5min).mp4') }}" type="video/mp4">
        </video>

        <div class="overlay"></div>

        <div class="banner-content">
            <h2>WASAKA GROUP</h2>
            <p>Sistem Informasi Cuti Karyawan</p>
        </div>

    </div>

    <!-- KANAN -->
    <div class="form-area">

        <div class="card">

            <div class="login-header">
                <img src="{{ asset('img/logo/wg.png') }}" alt="">
            </div>

            <div class="subtitle">
                Masukkan email dan password baru Anda
            </div>

            @if(session('success'))
                <div class="alert-success">{{ session('success') }}</div>
            @endif

            @if(session('error'))
                <div class="alert-error">{{ session('error') }}</div>
            @endif

            @if ($errors->any())
                <div class="alert-error">{{ $errors->first() }}</div>
            @endif

            <!-- 🔥 FIX FORM -->
            <form action="{{ route('reset.password') }}" method="POST" autocomplete="off">

                @csrf

                <!-- fake input biar browser tidak autofill -->
                <input type="text" style="display:none">
                <input type="password" style="display:none">

                <!-- EMAIL -->
                <div class="input-group">
                    <i class="fa-solid fa-envelope left"></i>

                    <input type="email"
                           name="email"
                           placeholder="Masukkan Email"
                           autocomplete="off"
                           required>
                </div>

                <!-- PASSWORD -->
                <div class="input-group">
                    <i class="fa-solid fa-lock left"></i>

                    <input type="password"
                           id="password"
                           name="password"
                           placeholder="Masukkan Password"
                           autocomplete="new-password"
                           required>

                    <span class="toggle-password"
                          onclick="togglePassword('password', this.querySelector('i'))">
                        <i class="fa-solid fa-eye"></i>
                    </span>
                </div>

                <!-- CONFIRM PASSWORD -->
                <div class="input-group">
                    <i class="fa-solid fa-lock left"></i>

                    <input type="password"
                           id="password_confirmation"
                           name="password_confirmation"
                           placeholder="Konfirmasi Password Baru"
                           autocomplete="new-password"
                           required>

                    <span class="toggle-password"
                          onclick="togglePassword('password_confirmation', this.querySelector('i'))">
                        <i class="fa-solid fa-eye"></i>
                    </span>
                </div>

                <button type="submit" class="btn">
                    Reset Password
                </button>

            </form>

            <div class="back-login">
                <a href="/login">← Kembali ke Login</a>
            </div>

            <div class="footer">
                © 2026 Wasaka Group
            </div>

        </div>

    </div>

</div>

<script>
function togglePassword(id, icon) {
    const input = document.getElementById(id);

    if (input.type === "password") {
        input.type = "text";
        icon.classList.remove("fa-eye");
        icon.classList.add("fa-eye-slash");
    } else {
        input.type = "password";
        icon.classList.remove("fa-eye-slash");
        icon.classList.add("fa-eye");
    }
}
</script>

</body>
</html>