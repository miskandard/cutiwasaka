<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Sistem Cuti')</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="icon" type="image/png" href="{{ asset('img/logo/wg.png') }}">
</head>
<style>
    .alert-error{
    background: #fff1f2;
    color: #be123c;
    border: 1px solid #fecdd3;
    padding: 10px 14px;
    margin: 22px 0 18px;
    border-radius: 10px;
    font-size: 13px;
    font-weight: 600;
    text-align: center;
    box-shadow: none;
}
.login-container{
    width: 380px;
    background: #fff;
    padding: 35px 32px 18px;
    border-radius: 20px;
    box-shadow: 0 15px 40px rgba(0,0,0,0.12);
}

.logo{
    text-align: center;
    margin-bottom: 18px;
}

.logo img{
    width: 210px;
}

.subtitle{
    text-align: center;
    font-size: 15px;
    font-weight: 600;
    color: #555;
    margin-bottom: 28px;
}

.input-group{
    margin-bottom: 16px;
}

button{
    width: 100%;
    padding: 14px;
    border: none;
    border-radius: 999px;
    background: #1e2a78;
    color: white;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    margin-top: 8px;
}
.footer{
    margin-top: 14px;
    text-align: center;
    font-size: 12px;
    color: #888;
}
</style>
<body>

    @yield('content')

</body>
</html>