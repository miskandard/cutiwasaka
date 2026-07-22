<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Services\GmailService;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class HRDController extends Controller
{
   

    /* =========================================================
        MENAMPILKAN DASHBOARD HRD
    ========================================================= */
    public function dashboard()
    {
        if (session('jabatan') != 'hrd') {
            return redirect('/login');
        }

        $jumlahKaryawan = DB::table('users')
            ->where('jabatan', 'karyawan')
            ->count();

        // FIX: pakai status_hrd (bukan status_pengajuan)
       $menungguVerifikasi = DB::table('cuti')
    ->join('users', 'cuti.id_user', '=', 'users.id_user')
    ->where('users.jabatan', 'karyawan')
    ->where('status_hrd', 'menunggu')
    ->count();

$diproses = DB::table('cuti')
    ->join('users', 'cuti.id_user', '=', 'users.id_user')
    ->where('users.jabatan', 'karyawan')
    ->where('status_hrd', 'disetujui')
    ->where('status_direktur', 'menunggu')
    ->count();

$disetujui = DB::table('cuti')
    ->join('users', 'cuti.id_user', '=', 'users.id_user')
    ->where('users.jabatan', 'karyawan')
    ->where('status_pengajuan', 'disetujui')
    ->count();

$ditolak = DB::table('cuti')
    ->join('users', 'cuti.id_user', '=', 'users.id_user')
    ->where('users.jabatan', 'karyawan')
    ->where('status_pengajuan', 'ditolak')
    ->count();

$totalCuti = DB::table('cuti')
    ->join('users', 'cuti.id_user', '=', 'users.id_user')
    ->where('users.jabatan', 'karyawan')
    ->count();

        $totalCuti = DB::table('cuti')->count();

        // FIX: hanya yang perlu HRD action
        $pengajuanTerbaru = DB::table('cuti')
    ->join('users', 'cuti.id_user', '=', 'users.id_user')
    ->leftJoin('jenis_cuti', 'cuti.id_jenis_cuti', '=', 'jenis_cuti.id_jenis_cuti')
    ->where('users.jabatan', 'karyawan')
    ->where('status_hrd', 'menunggu')
    ->select(
        'cuti.*',
        'users.nama',
        'jenis_cuti.nama_jenis_cuti'
    )
    ->orderBy('cuti.created_at', 'desc')
    ->limit(5)
    ->get();

        $cutiMendatang = DB::table('cuti')
    ->join('users', 'users.id_user', '=', 'cuti.id_user')
    ->where('users.jabatan', 'karyawan')
    ->where('status_pengajuan', 'disetujui')
    ->whereDate('tanggal_mulai', '>=', now())
    ->select(
        'users.nama',
        'cuti.tanggal_mulai',
        'cuti.tanggal_selesai'
    )
    ->orderBy('tanggal_mulai')
    ->limit(5)
    ->get();

        $cutiPerDivisi = DB::table('cuti')
    ->join('users', 'users.id_user', '=', 'cuti.id_user')
    ->where('users.jabatan', 'karyawan')
    ->select(
        'users.divisi',
        DB::raw('COUNT(*) as total')
    )
    ->groupBy('users.divisi')
    ->orderByDesc('total')
    ->get();

     return view('hrd.dashboard', compact(
    'jumlahKaryawan',
    'menungguVerifikasi',
    'diproses',
    'disetujui',
    'ditolak',
    'totalCuti',
    'pengajuanTerbaru',
    'cutiMendatang',
    'cutiPerDivisi'
));
    }

    /* =========================================================
        MENAMPILKAN LIST KARYAWAN
    ========================================================= */
    public function listKaryawan()
    {
        if (session('jabatan') != 'hrd') {
            return redirect('/login');
        }

        $users = DB::table('users')->get();

       return view('hrd.list_karyawan', compact('users'));
    }

/* =========================================================
   MENYIMPAN DATA KARYAWAN
========================================================= */
public function storeKaryawan(Request $request)
{
    // Validasi password
    if ($request->password != $request->password_confirmation) {
        return back()->withInput()->with('error', 'Password tidak sama');
    }

    // Validasi Format Email
    if (!filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
        return back()->withInput()->with('error', 'Format email tidak valid.');
    }

    // Cek email
    $cekEmail = DB::table('users')
        ->where('email', $request->email)
        ->first();

    if ($cekEmail) {
        return back()->withInput()->with('error', 'Email sudah terdaftar');
    }

    // Cek username
    $cekUsername = DB::table('users')
        ->where('username', $request->username)
        ->first();

    if ($cekUsername) {
        return back()->withInput()->with('error', 'Username sudah digunakan');
    }

    // Validasi Divisi
    if ($request->jabatan != 'direktur' && empty($request->divisi)) {
        return back()->withInput()->with('error', 'Divisi wajib dipilih.');
    }

    // Validasi Tipe Kerja
    if ($request->jabatan != 'direktur' && empty($request->tipe_kerja)) {
        return back()->withInput()->with('error', 'Tipe kerja wajib dipilih.');
    }

    // Ambil pengaturan cuti
    $pengaturan = DB::table('pengaturan')->first();

    // Generate token verifikasi
    $verificationToken = bin2hex(random_bytes(32));

    DB::table('users')->insert([
        'nama'        => $request->nama,
        'email'       => $request->email,
        'username'    => $request->username,
        'password'    => Hash::make($request->password),

        'jabatan'     => $request->jabatan,

        // Direktur tidak memiliki divisi
        'divisi'      => $request->jabatan == 'direktur'
                            ? '-'
                            : $request->divisi,

        // Direktur tidak memiliki tipe kerja
        'tipe_kerja'  => $request->jabatan == 'direktur'
                            ? '-'
                            : $request->tipe_kerja,

        'alamat'      => $request->alamat,
        'no_hp'       => $request->no_hp,

        // Hak cuti dari pengaturan
        'sisa_cuti'   => $pengaturan ? $pengaturan->hak_cuti_tahunan : 12,

        // Kolom status verifikasi
        'email_verified_at'  => null,
        'verification_token' => $verificationToken,

        'created_at'  => now(),
        'updated_at'  => now(),
    ]);

    // Dapatkan host (protokol + nama host + port)
    $host = $request->getSchemeAndHttpHost();
    
    // Jika diakses via localhost/127.0.0.1 dari komputer server,
    // ganti dengan IP lokal asli PC agar link bisa dibuka langsung dari HP lain di jaringan Wi-Fi yang sama
    if (str_contains($host, 'localhost') || str_contains($host, '127.0.0.1')) {
        $localIp = $this->getLocalIp();
        $port = $request->getPort();
        $host = $request->getScheme() . '://' . $localIp . ($port ? ':' . $port : '');
    }

    $verifyUrl = $host . '/verify-email/' . $verificationToken;
    
    $emailSubject = 'Verifikasi Akun Anda - Wasaka Group';
    $emailBody = "Yth. <b>{$request->nama}</b>,\n\n" .
        "Akun Anda telah berhasil didaftarkan oleh HRD di sistem Wasaka Group.\n" .
        "Untuk mengaktifkan akun Anda dan dapat login ke dalam sistem, silakan lakukan verifikasi email dengan mengklik tombol di bawah ini:\n\n" .
        "<a href=\"{$verifyUrl}\" style=\"display: inline-block; padding: 12px 24px; font-family: sans-serif; font-size: 14px; font-weight: bold; color: #ffffff; background-color: #1e2a78; text-decoration: none; border-radius: 6px;\">Verifikasi Akun Saya</a>\n\n" .
        "Atau buka tautan berikut jika tombol di atas tidak berfungsi:\n" .
        "<a href=\"{$verifyUrl}\" style=\"color: #1e2a78;\">{$verifyUrl}</a>\n\n" .
        "Setelah melakukan verifikasi, Anda dapat login menggunakan:\n" .
        "• Username: <b>{$request->username}</b>\n" .
        "• Password: <b>{$request->password}</b>\n\n" .
        "Terima kasih.\n\n" .
        "Hormat kami,\n" .
        "Human Resources Department\n" .
        "PT Wasaka Group";

    try {
        GmailService::send($request->email, $emailSubject, $emailBody);
    } catch (\Exception $e) {
        // Gagal kirim email tapi database tersimpan
    }

    return redirect('/list-karyawan')
        ->with('success', 'Karyawan berhasil ditambahkan. Silakan minta karyawan untuk melakukan verifikasi akun melalui email mereka.');
}

    /* =========================================================
        MENGUBAH DATA KARYAWAN
    ========================================================= */
   public function updateKaryawan(Request $request, $id)
{
    $user = DB::table('users')->where('id_user', $id)->first();

    if (!$user) {
        return back()->with('error', 'User tidak ditemukan');
    }

    // Validasi Format Email
    if (!filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
        return back()->withInput()->with('error', 'Format email tidak valid.');
    }

    // Cek email apakah sudah digunakan oleh user lain
    $cekEmail = DB::table('users')
        ->where('email', $request->email)
        ->where('id_user', '!=', $id)
        ->first();

    if ($cekEmail) {
        return back()->withInput()->with('error', 'Email sudah digunakan oleh karyawan lain');
    }

    // Cek username apakah sudah digunakan oleh user lain
    $cekUsername = DB::table('users')
        ->where('username', $request->username)
        ->where('id_user', '!=', $id)
        ->first();

    if ($cekUsername) {
        return back()->withInput()->with('error', 'Username sudah digunakan oleh karyawan lain');
    }

    // Validasi Divisi & Tipe Kerja jika bukan direktur
    if ($request->jabatan != 'direktur') {
        if (empty($request->divisi)) {
            return back()->withInput()->with('error', 'Divisi wajib dipilih.');
        }
        if (empty($request->tipe_kerja)) {
            return back()->withInput()->with('error', 'Tipe kerja wajib dipilih.');
        }
    }

    $aksi = strtolower(trim($request->aksi_cuti));
    $jumlah = (int) $request->jumlah_cuti;

    // LIMIT 12 HARI
    if ($aksi === 'tambah' && $jumlah > 12) {
        return back()->with('error', 'Penambahan cuti maksimal 12 hari');
    }

    $sisaCuti = $user->sisa_cuti;

    if ($aksi === 'tambah') {

        if (($sisaCuti + $jumlah) > 12) {
            return redirect('/list-karyawan')
                ->with('error', 'Sisa cuti tidak boleh melebihi 12 hari');
        }

        $sisaCuti += $jumlah;

    } else {

        $sisaCuti -= $jumlah;

        if ($sisaCuti < 0) {
            $sisaCuti = 0;
        }
    }

    DB::table('users')
        ->where('id_user', $id)
        ->update([
            'nama' => $request->nama,
            'email' => $request->email,
            'username' => $request->username,
            'jabatan' => $request->jabatan,
            'divisi' => $request->jabatan == 'direktur' ? '-' : $request->divisi,
            'tipe_kerja' => $request->jabatan == 'direktur' ? '-' : $request->tipe_kerja,
            'alamat' => $request->alamat,
            'no_hp' => $request->no_hp,
            'sisa_cuti' => $sisaCuti,
            'updated_at' => now()
        ]);

    return redirect('/list-karyawan')
        ->with('success', 'Data karyawan berhasil diubah');
}
    /* =========================================================
       MENAMPILKAN FORM PENGAJUAN CUTI HRD
    ========================================================= */
    public function inputCutiHRD()
{
    if (!session()->has('id_user') || session('jabatan') !== 'hrd') {
        return redirect('/login');
    }

    $user = DB::table('users')
        ->where('id_user', session('id_user'))
        ->first();

    if (!$user) {
        return redirect('/login');
    }

    //CEK ANTI DOUBLE CUTI (SEMUA STATUS BELUM SELESAI)
    $cutiAktif = DB::table('cuti')
        ->where('id_user', session('id_user'))
        ->whereIn('status_pengajuan', ['menunggu', 'diproses'])
        ->first();

    $cutiBelumAcc = DB::table('cuti')
    ->where('id_user', session('id_user'))
    ->whereIn('status_pengajuan', ['menunggu', 'diproses'])
    ->exists();

    return view('hrd.input_cuti', [
    'user' => $user,
    'jenisCuti' => DB::table('jenis_cuti')->get(),
    'cutiBelumAcc' => $cutiBelumAcc
]);
}

/* =========================================================
   MENYIMPAN PENGAJUAN CUTI HRD
========================================================= */
public function storeCutiHRD(Request $request)
{
    if (session('jabatan') != 'hrd') {
        return redirect('/login');
    }

    $user = DB::table('users')
        ->where('id_user', session('id_user'))
        ->first();

    $jenisCuti = DB::table('jenis_cuti')
        ->where('id_jenis_cuti', $request->id_jenis_cuti)
        ->first();

        // =======================================
// VALIDASI MINIMAL PENGAJUAN CUTI
// =======================================

$pengaturan = DB::table('pengaturan')->first();

if (!$pengaturan) {
    return back()
        ->withInput()
        ->with('error', 'Pengaturan cuti belum dibuat.');
}

$batasPengajuan = Carbon::today()->addDays($pengaturan->minimal_pengajuan_hari);

if (Carbon::parse($request->tanggal_mulai)->lt($batasPengajuan)) {

    return back()
        ->withInput()
        ->with(
            'error',
            'Pengajuan cuti minimal dilakukan <b>H-' .
            $pengaturan->minimal_pengajuan_hari .
            '</b> sebelum tanggal mulai cuti.<br><br>' .
            'Silakan pilih tanggal mulai cuti pada <b>' .
            $batasPengajuan->format('d-m-Y') .
            '</b> atau setelahnya.'
        );
}
    $dokumen = null;

    if ($request->hasFile('dokumen_pendukung')) {
        $file = $request->file('dokumen_pendukung');

        $namaFile =
            'MC_' .
            str_replace(' ', '_', $user->nama) .
            '_' . time() . '.' .
            $file->getClientOriginalExtension();

        $dokumen = $file->storeAs('dokumen_cuti', $namaFile, 'public');
    }

    // Hitung jumlah hari cuti otomatis
$jumlahHari = $this->hitungHariCuti(
    $request->tanggal_mulai,
    $request->tanggal_selesai,
    $user->tipe_kerja
);

// INSERT CUTI (HRD = langsung ke direktur)
DB::table('cuti')->insert([
    'id_user' => session('id_user'),
    'id_jenis_cuti' => $request->id_jenis_cuti,
    'tanggal_pengajuan' => now(),
    'tanggal_mulai' => $request->tanggal_mulai,
    'tanggal_selesai' => $request->tanggal_selesai,

    // hasil perhitungan sistem
    'jumlah_hari' => $jumlahHari,

    'alasan_pengajuan' => $request->alasan_pengajuan,
    'dokumen_pendukung' => $dokumen,

    'status_hrd' => 'disetujui',
    'status_direktur' => 'menunggu',
    'status_pengajuan' => 'diproses',

    'created_at' => now(),
    'updated_at' => now(),
]);

    // EMAIL KE HRD (CONFIRM)
    GmailService::send(
    $user->email,
    'Pengajuan Cuti Berhasil Dikirim',
    "Yth. Bapak/Ibu {$user->nama},

Dengan hormat,

Kami informasikan bahwa pengajuan cuti yang Anda ajukan telah berhasil diterima dan tercatat pada sistem.

Detail pengajuan cuti:

Tanggal Mulai   : {$request->tanggal_mulai}
Tanggal Selesai : {$request->tanggal_selesai}
Jumlah Hari     : {$request->jumlah_hari} hari

Status Pengajuan:
Menunggu Persetujuan Direktur.

Mohon menunggu informasi lebih lanjut mengenai hasil persetujuan pengajuan cuti tersebut. Status pengajuan dapat dipantau melalui sistem yang tersedia.

Demikian informasi ini kami sampaikan. Atas perhatian dan kerja samanya kami ucapkan terima kasih.

Hormat kami,

HR Department
PT Wasaka Group"
);

    // EMAIL KE DIREKTUR
    $direkturList = DB::table('users')
        ->whereRaw('LOWER(TRIM(jabatan)) = ?', ['direktur'])
        ->get();

    $bodyDirektur =
    "Yth. Bapak/Ibu {$direktur->nama},\n\n" .
    "Dengan hormat,\n\n" .
    "Kami informasikan bahwa terdapat pengajuan cuti karyawan yang telah diverifikasi oleh Human Resources Department (HRD) dan saat ini menunggu persetujuan.\n\n" .
    "Detail pengajuan cuti:\n\n" .
    "Nama Karyawan : {$user->nama}\n" .
    "Jenis Cuti     : {$jenisCuti->nama_jenis_cuti}\n" .
    "Tanggal Mulai  : {$request->tanggal_mulai}\n" .
    "Tanggal Selesai: {$request->tanggal_selesai}\n" .
    "Jumlah Hari    : {$request->jumlah_hari} hari\n\n" .
    "Mohon melakukan peninjauan dan memberikan keputusan melalui sistem informasi manajemen cuti.\n\n" .
    "Atas perhatian dan kerja sama Bapak/Ibu, kami ucapkan terima kasih.\n\n" .
    "Hormat kami,\n" .
    "Human Resources Department (HRD)";

    foreach ($direkturList as $d) {

    GmailService::send(
        $d->email,
        'Pengajuan Cuti HRD - Menunggu Persetujuan Direktur',
        "Yth. {$d->nama},

Terdapat pengajuan cuti dari HRD yang membutuhkan persetujuan Anda.

Nama HRD : {$user->nama}
Jenis Cuti : {$jenisCuti->nama_jenis_cuti}
Tanggal Mulai : {$request->tanggal_mulai}
Tanggal Selesai : {$request->tanggal_selesai}
Jumlah Hari : {$request->jumlah_hari}

Silakan login ke sistem untuk melakukan approval."
    );

}

    return redirect('/dashboard-hrd')
        ->with('success', 'Pengajuan cuti HRD berhasil dikirim ke Direktur');
}

  /* =========================================================
        MENAMPILKAN RIWAYAT CUTI HRD
    ========================================================= */
public function riwayatCutiHRD()
{
    if (!session()->has('jabatan') || strtolower(session('jabatan')) !== 'hrd') {
        return redirect('/login');
    }

    $riwayatCuti = DB::table('cuti')
        ->join('users', 'cuti.id_user', '=', 'users.id_user')
        ->leftJoin('jenis_cuti', 'cuti.id_jenis_cuti', '=', 'jenis_cuti.id_jenis_cuti')
        ->where('cuti.id_user', session('id_user')) // hanya HRD yang login
        ->select(
            'cuti.*',
            'users.nama',
            'users.divisi',
            'jenis_cuti.nama_jenis_cuti'
        )
        ->orderBy('cuti.created_at', 'desc')
        ->get();

    return view('hrd.riwayat_cuti', compact('riwayatCuti'));
}

    /* =========================================================
        MENGHAPUS DATA KARYAWAN
    ========================================================= */
    public function deleteKaryawan($id)
{
    DB::beginTransaction();

    try {

        // hapus riwayat cuti karyawan
        DB::table('cuti')
            ->where('id_user', $id)
            ->delete();

        // hapus data user
        DB::table('users')
            ->where('id_user', $id)
            ->delete();


        DB::commit();

        return redirect('/list-karyawan')
            ->with('success', 'Data karyawan berhasil dihapus');

    } catch (\Exception $e) {

        DB::rollBack();

        return redirect('/list-karyawan')
            ->with('error', 'Data gagal dihapus : '.$e->getMessage());
    }
}

    /* =========================================================
        IMPORT DATA KARYAWAN DARI EXCEL / CSV
    ========================================================= */
    public function importKaryawan(Request $request)
    {
        if (session('jabatan') != 'hrd') {
            return redirect('/login');
        }

        $dataJson = $request->input('karyawan_data');
        if (empty($dataJson)) {
            return back()->with('error', 'Tidak ada data yang diimport.');
        }

        $karyawans = json_decode($dataJson, true);
        if (!is_array($karyawans) || empty($karyawans)) {
            return back()->with('error', 'Format data tidak valid.');
        }

        $successCount = 0;
        $errors = [];

        $pengaturan = DB::table('pengaturan')->first();
        $defaultSisaCuti = $pengaturan ? $pengaturan->hak_cuti_tahunan : 12;

        foreach ($karyawans as $index => $row) {
            $rowNum = $index + 2; // header is row 1
            
            $nama = trim($row['Nama'] ?? $row['nama'] ?? '');
            $email = trim($row['Email'] ?? $row['email'] ?? '');
            $no_hp = trim($row['No HP'] ?? $row['No Hp'] ?? $row['no_hp'] ?? $row['NoHP'] ?? $row['nohp'] ?? '');
            
            // Bersihkan jika ada formula Excel terikut (misal: ="08123" menjadi 08123)
            if (str_starts_with($no_hp, '="') && str_ends_with($no_hp, '"')) {
                $no_hp = substr($no_hp, 2, -1);
            }
            // Bersihkan jika ada tanda petik tunggal di depan (misal: '08123 menjadi 08123)
            if (str_starts_with($no_hp, "'")) {
                $no_hp = ltrim($no_hp, "'");
            }
            // Hapus semua karakter non-angka (spasi, strip, dll)
            $no_hp = preg_replace('/[^0-9]/', '', $no_hp);
            // Otomatis tambahkan 0 di depan jika terpotong oleh Excel (misal: 89599 menjadi 089599)
            if (str_starts_with($no_hp, '8') && strlen($no_hp) >= 9 && strlen($no_hp) <= 13) {
                $no_hp = '0' . $no_hp;
            }

            $jabatan = strtolower(trim($row['Jabatan'] ?? $row['jabatan'] ?? ''));
            $username = trim($row['Username'] ?? $row['username'] ?? '');
            $divisi = trim($row['Divisi'] ?? $row['divisi'] ?? '');
            $password = trim($row['Password'] ?? $row['password'] ?? '');
            $tipe_kerja = strtolower(trim($row['Tipe Kerja'] ?? $row['tipe_kerja'] ?? $row['tipekerja'] ?? ''));
            $alamat = trim($row['Alamat'] ?? $row['alamat'] ?? '');

            // Skip completely empty rows
            if (empty($nama) && empty($email) && empty($username) && empty($password) && empty($jabatan)) {
                continue;
            }

            // Validations
            if (empty($nama) || empty($email) || empty($username) || empty($password) || empty($jabatan)) {
                $errors[] = "Baris {$rowNum}: Kolom Nama, Email, Username, Password, dan Jabatan wajib diisi.";
                continue;
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Baris {$rowNum}: Format email tidak valid.";
                continue;
            }

            // Cek email unique
            $cekEmail = DB::table('users')->where('email', $email)->first();
            if ($cekEmail) {
                $errors[] = "Baris {$rowNum}: Email '{$email}' sudah terdaftar.";
                continue;
            }

            // Cek username unique
            $cekUsername = DB::table('users')->where('username', $username)->first();
            if ($cekUsername) {
                $errors[] = "Baris {$rowNum}: Username '{$username}' sudah digunakan.";
                continue;
            }

            // Validasi jabatan
            if (!in_array($jabatan, ['direktur', 'hrd', 'karyawan'])) {
                $errors[] = "Baris {$rowNum}: Jabatan harus berupa 'direktur', 'hrd', atau 'karyawan'.";
                continue;
            }

            // Validasi divisi & tipe kerja
            if ($jabatan != 'direktur') {
                if (empty($divisi)) {
                    $errors[] = "Baris {$rowNum}: Divisi wajib diisi untuk jabatan {$jabatan}.";
                    continue;
                }
                $divisi = strtoupper($divisi);
                if (!in_array($divisi, ['WGS', 'WSL', 'WTG', 'WMS'])) {
                    $errors[] = "Baris {$rowNum}: Divisi harus berupa WGS, WSL, WTG, atau WMS.";
                    continue;
                }

                if (empty($tipe_kerja)) {
                    $errors[] = "Baris {$rowNum}: Tipe kerja wajib diisi untuk jabatan {$jabatan}.";
                    continue;
                }
                if (str_contains($tipe_kerja, 'back') || str_contains($tipe_kerja, 'office')) {
                    $tipe_kerja = 'back_office';
                } elseif (str_contains($tipe_kerja, 'operasional') || str_contains($tipe_kerja, 'lapangan')) {
                    $tipe_kerja = 'operasional';
                } else {
                    $errors[] = "Baris {$rowNum}: Tipe kerja harus 'back_office' atau 'operasional'.";
                    continue;
                }
            } else {
                $divisi = '-';
                $tipe_kerja = '-';
            }

            // Generate verification token
            $verificationToken = bin2hex(random_bytes(32));

            // Insert user
            DB::table('users')->insert([
                'nama'        => $nama,
                'email'       => $email,
                'username'    => $username,
                'password'    => Hash::make($password),
                'jabatan'     => $jabatan,
                'divisi'      => $divisi,
                'tipe_kerja'  => $tipe_kerja,
                'alamat'      => $alamat,
                'no_hp'       => $no_hp,
                'sisa_cuti'   => $defaultSisaCuti,
                'email_verified_at' => null,
                'verification_token' => $verificationToken,
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);

            // Dapatkan host (protokol + nama host + port)
            $host = $request->getSchemeAndHttpHost();
            if (str_contains($host, 'localhost') || str_contains($host, '127.0.0.1')) {
                $localIp = $this->getLocalIp();
                $port = $request->getPort();
                $host = $request->getScheme() . '://' . $localIp . ($port ? ':' . $port : '');
            }

            $verifyUrl = $host . '/verify-email/' . $verificationToken;
            $emailSubject = 'Verifikasi Akun Anda - Wasaka Group';
            $emailBody = "Yth. <b>{$nama}</b>,\n\n" .
                "Akun Anda telah berhasil didaftarkan oleh HRD di sistem Wasaka Group.\n" .
                "Untuk mengaktifkan akun Anda dan dapat login ke dalam sistem, silakan lakukan verifikasi email dengan mengklik tombol di bawah ini:\n\n" .
                "<a href=\"{$verifyUrl}\" style=\"display: inline-block; padding: 12px 24px; font-family: sans-serif; font-size: 14px; font-weight: bold; color: #ffffff; background-color: #1e2a78; text-decoration: none; border-radius: 6px;\">Verifikasi Akun Saya</a>\n\n" .
                "Atau buka tautan berikut jika tombol di atas tidak berfungsi:\n" .
                "<a href=\"{$verifyUrl}\" style=\"color: #1e2a78;\">{$verifyUrl}</a>\n\n" .
                "Setelah melakukan verifikasi, Anda dapat login menggunakan:\n" .
                "• Username: <b>{$username}</b>\n" .
                "• Password: <b>{$password}</b>\n\n" .
                "Terima kasih.\n\n" .
                "Hormat kami,\n" .
                "Human Resources Department\n" .
                "PT Wasaka Group";

            try {
                GmailService::send($email, $emailSubject, $emailBody);
            } catch (\Exception $e) {
                // Log/ignore
            }

            $successCount++;
        }

        if (count($errors) > 0) {
            $msg = "Berhasil mengimport {$successCount} karyawan.";
            if ($successCount == 0) {
                return back()->with('error', 'Gagal mengimport data.<br>' . implode('<br>', $errors));
            }
            return redirect('/list-karyawan')
                ->with('success', $msg)
                ->with('error', 'Beberapa data gagal diimport:<br>' . implode('<br>', $errors));
        }

        return redirect('/list-karyawan')
            ->with('success', "Berhasil mengimport {$successCount} karyawan.");
    }

    /* =========================================================
        KIRIM ULANG EMAIL VERIFIKASI
    ========================================================= */
    public function resendVerification($id)
    {
        if (session('jabatan') != 'hrd') {
            return redirect('/login');
        }

        $user = DB::table('users')->where('id_user', $id)->first();

        if (!$user) {
            return back()->with('error', 'Karyawan tidak ditemukan.');
        }

        if (!is_null($user->email_verified_at)) {
            return back()->with('error', 'Akun karyawan ini sudah aktif.');
        }

        // Generate token baru jika belum ada
        $verificationToken = $user->verification_token;
        if (empty($verificationToken)) {
            $verificationToken = bin2hex(random_bytes(32));
            DB::table('users')
                ->where('id_user', $id)
                ->update(['verification_token' => $verificationToken, 'updated_at' => now()]);
        }

        $host = request()->getSchemeAndHttpHost();
        if (str_contains($host, 'localhost') || str_contains($host, '127.0.0.1')) {
            $localIp = $this->getLocalIp();
            $port = request()->getPort();
            $host = request()->getScheme() . '://' . $localIp . ($port ? ':' . $port : '');
        }

        $verifyUrl = $host . '/verify-email/' . $verificationToken;
        $emailSubject = 'Verifikasi Akun Anda - Wasaka Group';
        
        $emailBody = "Yth. <b>{$user->nama}</b>,\n\n" .
            "HRD mengirimkan kembali tautan verifikasi untuk akun Anda di sistem Wasaka Group.\n" .
            "Untuk mengaktifkan akun Anda dan dapat login ke dalam sistem, silakan lakukan verifikasi email dengan mengklik tombol di bawah ini:\n\n" .
            "<a href=\"{$verifyUrl}\" style=\"display: inline-block; padding: 12px 24px; font-family: sans-serif; font-size: 14px; font-weight: bold; color: #ffffff; background-color: #1e2a78; text-decoration: none; border-radius: 6px;\">Verifikasi Akun Saya</a>\n\n" .
            "Atau buka tautan berikut jika tombol di atas tidak berfungsi:\n" .
            "<a href=\"{$verifyUrl}\" style=\"color: #1e2a78;\">{$verifyUrl}</a>\n\n" .
            "Setelah melakukan verifikasi, Anda dapat login menggunakan:\n" .
            "• Username: <b>{$user->username}</b>\n" .
            "• Password: (Password yang telah didaftarkan oleh HRD)\n\n" .
            "Terima kasih.\n\n" .
            "Hormat kami,\n" .
            "Human Resources Department\n" .
            "PT Wasaka Group";

        try {
            GmailService::send($user->email, $emailSubject, $emailBody);
            return back()->with('success', 'Email verifikasi berhasil dikirim ulang ke ' . $user->email);
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengirim email verifikasi: ' . $e->getMessage());
        }
    }

    /* =========================================================
        MENGURANGI SISA CUTI KARENA CUTI BERSAMA
    ========================================================= */
    public function cutiBersama(Request $request)
    {
        $jumlahHari = (int) $request->jumlah_hari;

        if ($jumlahHari <= 0) {
            return redirect('/list-karyawan')
                ->with('error', 'Jumlah hari harus lebih dari 0');
        }

        $affected = DB::table('users')
            ->whereRaw('LOWER(TRIM(jabatan)) = ?', ['karyawan'])
            ->where('sisa_cuti', '>=', $jumlahHari)
            ->decrement('sisa_cuti', $jumlahHari);

        return redirect('/list-karyawan')
            ->with('success', 'Cuti bersama berhasil mengurangi sisa cuti ' . $affected . ' karyawan');
    }

    /* =========================================================
        MENAMPILKAN DATA CUTI KARYAWAN
    ========================================================= */
    public function dataCuti(Request $request)
    {
        if (session('jabatan') != 'hrd') {
            return redirect('/login');
        }

        $query = DB::table('cuti')
            ->join('users', 'cuti.id_user', '=', 'users.id_user')
            ->leftJoin('jenis_cuti', 'cuti.id_jenis_cuti', '=', 'jenis_cuti.id_jenis_cuti')
            ->select(
                'cuti.*',
                'users.nama',
                'users.divisi',
                'jenis_cuti.nama_jenis_cuti'
            );

        if ($request->tanggal_awal && $request->tanggal_akhir) {
            $query->whereBetween('cuti.tanggal_pengajuan', [
                $request->tanggal_awal,
                $request->tanggal_akhir
            ]);
        }

        if ($request->bulan) {
            $query->whereMonth('cuti.tanggal_pengajuan', $request->bulan);
        }

        if ($request->tahun) {
            $query->whereYear('cuti.tanggal_pengajuan', $request->tahun);
        }

        $dataCuti = $query
            ->orderBy('cuti.created_at', 'desc')
            ->get();

        return view('hrd.data_cuti', compact('dataCuti'));
    }

    /* =========================================================
        MENAMPILKAN HALAMAN VERIFIKASI CUTI
    ========================================================= */
    public function verifikasiCuti()
    {
        if (session('jabatan') != 'hrd') {
            return redirect('/login');
        }

        $pengajuanCuti = DB::table('cuti')
            ->join('users', 'cuti.id_user', '=', 'users.id_user')
            ->leftJoin('jenis_cuti', 'cuti.id_jenis_cuti', '=', 'jenis_cuti.id_jenis_cuti')
            ->where('status_hrd', 'menunggu')
            ->select(
                'cuti.*',
                'users.nama',
                'users.email',
                'users.divisi',
                'users.no_hp',
                'users.sisa_cuti',
                'jenis_cuti.nama_jenis_cuti'
            )
            ->orderBy('cuti.created_at', 'desc')
            ->get();

        return view('hrd.verifikasi_cuti', compact('pengajuanCuti'));
    }

/* =========================================================
    MEMPROSES VERIFIKASI PENGAJUAN CUTI OLEH HRD
========================================================= */
public function updateVerifikasiCuti(Request $request, $id)
{
    if (session('jabatan') != 'hrd') {
        return redirect('/login');
    }

    $cuti = DB::table('cuti')
        ->where('id_pengajuan', $id)
        ->first();

    if (!$cuti) {
        return redirect('/verifikasi-cuti')
            ->with('error', 'Data cuti tidak ditemukan');
    }

    $karyawan = DB::table('users')
        ->where('id_user', $cuti->id_user)
        ->first();

    $jenisCuti = DB::table('jenis_cuti')
        ->where('id_jenis_cuti', $cuti->id_jenis_cuti)
        ->first();

    if (!$karyawan || !$jenisCuti) {
        return back()->with('error', 'Data tidak valid');
    }

    /* =========================
       VALIDASI TOLAK
    ========================= */
    if ($request->status_pengajuan == 'ditolak' && empty($request->alasan_ditolak)) {
        return back()->with('error', 'Alasan penolakan wajib diisi');
    }

    /* =========================
       HRD SETUJUI
    ========================= */
    if ($request->status_pengajuan == 'disetujui') {

        DB::table('cuti')
            ->where('id_pengajuan', $id)
            ->update([
                'status_hrd' => 'disetujui',
                'status_direktur' => 'menunggu',
                'status_pengajuan' => 'diproses',
                'alasan_ditolak' => null,
                'updated_at' => now(),
            ]);

        /* =========================
           DETEKSI CUTI SAKIT (FIX ERROR)
        ========================= */
        $isSakit = $jenisCuti && str_contains(
            strtolower($jenisCuti->nama_jenis_cuti),
            'sakit'
        );

        /* =========================
           EMAIL KE KARYAWAN
        ========================= */
        if ($isSakit) {

            GmailService::send(
                $karyawan->email,
                'Pengajuan Cuti Sakit Diproses',
                "Yth. {$karyawan->nama},

Dengan hormat,

Pengajuan cuti sakit Anda telah disetujui HRD dan saat ini menunggu persetujuan Direktur.

Detail:
- Mulai : {$cuti->tanggal_mulai}
- Selesai : {$cuti->tanggal_selesai}
- Jumlah Hari : {$cuti->jumlah_hari}

Status: Menunggu Direktur.

Semoga lekas sembuh.

HR Department"
            );

        } else {

         GmailService::send(
    $karyawan->email,
    'Informasi Status Pengajuan Cuti',
    "Yth. Bapak/Ibu {$karyawan->nama},

Dengan hormat,

Kami informasikan bahwa pengajuan cuti yang telah Anda ajukan telah selesai melalui tahap verifikasi oleh Departemen Human Resources (HRD).

Berdasarkan hasil verifikasi tersebut, pengajuan cuti Anda telah disetujui oleh HRD dan saat ini sedang menunggu proses persetujuan dari Direktur.

Berikut detail pengajuan cuti Anda:

Nama Karyawan  : {$karyawan->nama}
Tanggal Mulai   : {$cuti->tanggal_mulai}
Tanggal Selesai : {$cuti->tanggal_selesai}
Jumlah Hari     : {$cuti->jumlah_hari} hari

Status Pengajuan:
Menunggu Persetujuan Direktur.

Mohon menunggu proses persetujuan selanjutnya. Informasi mengenai hasil akhir pengajuan cuti akan kami sampaikan melalui sistem setelah Direktur memberikan keputusan.

Demikian pemberitahuan ini kami sampaikan. Atas perhatian dan kerja sama Bapak/Ibu, kami ucapkan terima kasih.

Hormat kami,

Human Resources Department
PT Wasaka Group"
);
        }

        /* =========================
   EMAIL KE DIREKTUR
========================= */
$direkturList = DB::table('users')
    ->whereRaw('LOWER(TRIM(jabatan)) = ?', ['direktur'])
    ->get();



foreach ($direkturList as $d) {

    GmailService::send(
        $d->email,
        'Pengajuan Cuti HRD - Menunggu Direktur',
        "Yth. {$d->nama},

Ada pengajuan cuti yang sudah disetujui HRD dan menunggu persetujuan Anda.

Nama: {$karyawan->nama}
Jenis: {$jenisCuti->nama_jenis_cuti}
Tanggal: {$cuti->tanggal_mulai} - {$cuti->tanggal_selesai}
Jumlah: {$cuti->jumlah_hari}

Silakan login untuk approval."
    );
}

        return redirect('/verifikasi-cuti')
            ->with('success', 'Pengajuan diteruskan ke Direktur');
    }

    /* =========================
       HRD TOLAK
    ========================= */
    if ($request->status_pengajuan == 'ditolak') {

        DB::table('cuti')
            ->where('id_pengajuan', $id)
            ->update([
                'status_hrd' => 'ditolak',
                'status_direktur' => 'ditolak',
                'status_pengajuan' => 'ditolak',
                'alasan_ditolak' => $request->alasan_ditolak,
                'updated_at' => now(),
            ]);

        GmailService::send(
    $karyawan->email,
    'Pemberitahuan Hasil Pengajuan Cuti',
    "Yth. Bapak/Ibu {$karyawan->nama},

Dengan hormat,

Terima kasih atas pengajuan cuti yang telah Anda sampaikan.

Setelah dilakukan proses verifikasi dan pertimbangan oleh Departemen Human Resources (HRD), kami informasikan bahwa pengajuan cuti Anda belum dapat disetujui.

Adapun alasan penolakan pengajuan cuti adalah sebagai berikut:

{$request->alasan_ditolak}

Apabila Anda memerlukan informasi lebih lanjut atau ingin mengajukan kembali permohonan cuti pada waktu yang sesuai, silakan menghubungi Departemen Human Resources (HRD).

Kami mengucapkan terima kasih atas pengertian dan kerja sama Anda.

Hormat kami,

Human Resources Department
PT Wasaka Group"
);

        return redirect('/verifikasi-cuti')
            ->with('success', 'Pengajuan ditolak HRD');
    }

    return redirect('/verifikasi-cuti')
        ->with('error', 'Status tidak valid');
}


public function pengaturanCuti()
{
    if (session('jabatan') != 'hrd') {
        return redirect('/login');
    }

    $pengaturan = DB::table('pengaturan')->first();

    return view('hrd.pengaturan_cuti', compact('pengaturan'));
}


public function updatePengaturanCuti(Request $request)
{
    if (session('jabatan') != 'hrd') {
        return redirect('/login');
    }

    $request->validate([
        'hak_cuti_tahunan' => 'required|integer|min:1',
        'minimal_pengajuan_hari' => 'required|integer|min:1',
    ]);

    DB::table('pengaturan')
        ->where('id', 1)
        ->update([
            'hak_cuti_tahunan' => $request->hak_cuti_tahunan,
            'minimal_pengajuan_hari' => $request->minimal_pengajuan_hari,
            'updated_at' => now(),
        ]);

    // Jika ingin langsung diterapkan ke semua karyawan
    if ($request->has('terapkan_semua')) {

        DB::table('users')
            ->where('jabatan', 'karyawan')
            ->update([
                'sisa_cuti' => $request->hak_cuti_tahunan,
                'updated_at' => now(),
            ]);
    }

    return back()->with('success', 'Pengaturan cuti berhasil diperbarui.');
}

  /* =========================================================
       MENGHITUNG JUMLAH HARI CUTI
    ========================================================= */
    private function hitungHariCuti($tanggalMulai, $tanggalSelesai, $tipeKerja)
    {
        $mulai = Carbon::parse($tanggalMulai);
        $selesai = Carbon::parse($tanggalSelesai);

        $jumlahHari = 0;

        // Daftar hari libur nasional
        $hariLibur = [
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
            '2026-12-25',
        ];

        while ($mulai <= $selesai) {

            $tanggal = $mulai->format('Y-m-d');
            $hari = $mulai->dayOfWeek;

            // Back Office
            if ($tipeKerja == 'back_office') {

                if (
                    $hari != Carbon::SATURDAY &&
                    $hari != Carbon::SUNDAY &&
                    !in_array($tanggal, $hariLibur)
                ) {
                    $jumlahHari++;
                }

            }
            // Operasional
            else {

                if (
                    $hari != Carbon::SUNDAY &&
                    !in_array($tanggal, $hariLibur)
                ) {
                    $jumlahHari++;
                }

            }

            $mulai->addDay();
        }

        return $jumlahHari;
    }

    private function getLocalIp()
    {
        $ip = '127.0.0.1';
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            $output = shell_exec('ipconfig');
            preg_match_all('/IPv4 Address.*: (192\.168\.\d+\.\d+|10\.\d+\.\d+\.\d+|172\.(1[6-9]|2\d|3[0-1])\.\d+\.\d+)/', $output, $matches);
            if (!empty($matches[1])) {
                foreach ($matches[1] as $match) {
                    if (!str_starts_with($match, '192.168.56.')) {
                        $ip = $match;
                        break;
                    }
                }
                if ($ip === '127.0.0.1') {
                    $ip = $matches[1][0];
                }
            }
        } else {
            $ip = gethostbyname(gethostname());
        }
        return $ip;
    }

}
