<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Karyawan</title>

    <link rel="stylesheet"
          href="{{ asset('css/dashboard.css') }}">

    <style>
        body{
            background:#f4f7fb;
            font-family:Arial;
        }

        .edit-box{
            width:500px;
            margin:50px auto;
            background:white;
            padding:30px;
            border-radius:12px;
            box-shadow:0 5px 20px rgba(0,0,0,0.1);
        }

        h2{
            margin-bottom:25px;
            color:#1e3a8a;
        }

        input,select{
            width:100%;
            padding:12px;
            margin-bottom:15px;
            border-radius:8px;
            border:1px solid #ddd;
        }

        button{
            background:#1e3a8a;
            color:white;
            border:none;
            padding:12px 20px;
            border-radius:8px;
            cursor:pointer;
        }

        button:hover{
            background:#172554;
        }
    </style>
</head>
<body>

<div class="edit-box">

    <h2>Edit Karyawan</h2>

    <form action="/karyawan/update/{{ $user->id_user }}"
          method="POST">

        @csrf

        <input type="text"
               name="nama"
               value="{{ $user->nama }}"
               placeholder="Nama">

        <input type="text"
               name="username"
               value="{{ $user->username }}"
               placeholder="Username">

        <select name="jabatan">

            <option value="hrd"
            {{ $user->jabatan == 'hrd' ? 'selected' : '' }}>
            HRD
            </option>

            <option value="karyawan"
            {{ $user->jabatan == 'karyawan' ? 'selected' : '' }}>
            Karyawan
            </option>

            <option value="direktur"
            {{ $user->jabatan == 'direktur' ? 'selected' : '' }}>
            Direktur
            </option>

        </select>

        <input type="text"
               name="divisi"
               value="{{ $user->divisi }}"
               placeholder="Divisi">

        <input type="text"
               name="alamat"
               value="{{ $user->alamat }}"
               placeholder="Alamat">

        <input type="text"
               name="no_hp"
               value="{{ $user->no_hp }}"
               placeholder="No HP">

        <button type="submit">
            Update Data
        </button>

    </form>

</div>

</body>
</html>