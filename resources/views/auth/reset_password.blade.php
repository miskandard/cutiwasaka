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

    <!-- 🔥 FIX AUTOFILL CHROME & FUNCTIONAL WIDGET STYLES -->
    <style>
        input:-webkit-autofill,
        input:-webkit-autofill:hover,
        input:-webkit-autofill:focus {
            -webkit-box-shadow: 0 0 0px 1000px white inset !important;
            -webkit-text-fill-color: #000 !important;
        }

        /* PASSWORD STRENGTH METER */
        .strength-container {
            margin-top: -10px;
            margin-bottom: 15px;
            display: none;
            text-align: left;
        }
        
        .strength-meter {
            height: 5px;
            width: 100%;
            background: #e2e8f0;
            border-radius: 99px;
            overflow: hidden;
            margin-top: 6px;
        }

        .strength-bar {
            height: 100%;
            width: 0%;
            transition: all 0.4s ease;
            border-radius: 99px;
        }

        .strength-text {
            font-size: 11px;
            font-weight: 600;
            margin-top: 4px;
            text-align: right;
            display: block;
        }

        /* PASSWORD MATCH */
        .match-indicator {
            font-size: 11px;
            font-weight: 600;
            margin-top: -10px;
            margin-bottom: 15px;
            display: none;
            text-align: left;
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

            @if(session('error') && session('error') != 'Email tidak ditemukan')
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
                           value="{{ old('email') }}"
                           autocomplete="off"
                           style="{{ session('error') == 'Email tidak ditemukan' ? 'border-color: #ef4444; background: #fdf2f2;' : '' }}"
                           required>
                    @if(session('error') == 'Email tidak ditemukan')
                        <span style="color: #ef4444; font-size: 11.5px; font-weight: 600; display: block; margin-top: 5px; text-align: left;">
                            ✗ Email ini tidak terdaftar di sistem
                        </span>
                    @endif
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

document.addEventListener("DOMContentLoaded", function () {
    const passwordInput = document.getElementById("password");
    const confirmInput = document.getElementById("password_confirmation");

    // Add elements for strength meter
    const strengthContainer = document.createElement("div");
    strengthContainer.className = "strength-container";
    strengthContainer.innerHTML = `
        <div class="strength-meter">
            <div class="strength-bar"></div>
        </div>
        <span class="strength-text"></span>
    `;
    passwordInput.parentNode.after(strengthContainer);

    const strengthBar = strengthContainer.querySelector(".strength-bar");
    const strengthText = strengthContainer.querySelector(".strength-text");

    // Add elements for match indicator
    const matchIndicator = document.createElement("div");
    matchIndicator.className = "match-indicator";
    confirmInput.parentNode.after(matchIndicator);

    // Password strength evaluator
    passwordInput.addEventListener("input", function () {
        const val = passwordInput.value;
        if (!val) {
            strengthContainer.style.display = "none";
            return;
        }

        strengthContainer.style.display = "block";
        let score = 0;
        if (val.length >= 6) score++;
        if (val.length >= 10) score++;
        if (/[A-Z]/.test(val)) score++;
        if (/[0-9]/.test(val)) score++;
        if (/[^A-Za-z0-9]/.test(val)) score++;

        let percentage = 0;
        let color = "";
        let text = "";

        switch (score) {
            case 0:
            case 1:
                percentage = 20;
                color = "#ef4444"; // Red
                text = "Sangat Lemah 🔴";
                break;
            case 2:
                percentage = 40;
                color = "#f97316"; // Orange
                text = "Lemah 🟠";
                break;
            case 3:
                percentage = 60;
                color = "#eab308"; // Yellow
                text = "Cukup Kuat 🟡";
                break;
            case 4:
                percentage = 80;
                color = "#3b82f6"; // Blue
                text = "Kuat 🔵";
                break;
            case 5:
                percentage = 100;
                color = "#22c55e"; // Green
                text = "Sangat Kuat 🟢";
                break;
        }

        strengthBar.style.width = percentage + "%";
        strengthBar.style.backgroundColor = color;
        strengthText.innerText = text;
        strengthText.style.color = color;
        
        checkMatch();
    });

    // Password matching validator
    function checkMatch() {
        const p1 = passwordInput.value;
        const p2 = confirmInput.value;

        if (!p2) {
            matchIndicator.style.display = "none";
            return;
        }

        matchIndicator.style.display = "block";

        if (p1 === p2) {
            matchIndicator.innerText = "✓ Password cocok";
            matchIndicator.style.color = "#22c55e";
        } else {
            matchIndicator.innerText = "✗ Password tidak cocok";
            matchIndicator.style.color = "#ef4444";
        }
    }

    confirmInput.addEventListener("input", checkMatch);
});
</script>

</body>
</html>