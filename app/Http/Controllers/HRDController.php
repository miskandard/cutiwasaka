<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Services\GmailService;

class HRDController extends Controller
{
   

    /* =========================================================
        DASHBOARD HRD
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
       $menungguVerifikasi = DB::table('pengajuan_cuti')
    ->join('users', 'pengajuan_cuti.id_user', '=', 'users.id_user')
    ->where('users.jabatan', 'karyawan')
    ->where('status_hrd', 'menunggu')
    ->count();

$diproses = DB::table('pengajuan_cuti')
    ->join('users', 'pengajuan_cuti.id_user', '=', 'users.id_user')
    ->where('users.jabatan', 'karyawan')
    ->where('status_hrd', 'disetujui')
    ->where('status_direktur', 'menunggu')
    ->count();

$disetujui = DB::table('pengajuan_cuti')
    ->join('users', 'pengajuan_cuti.id_user', '=', 'users.id_user')
    ->where('users.jabatan', 'karyawan')
    ->where('status_pengajuan', 'disetujui')
    ->count();

$ditolak = DB::table('pengajuan_cuti')
    ->join('users', 'pengajuan_cuti.id_user', '=', 'users.id_user')
    ->where('users.jabatan', 'karyawan')
    ->where('status_pengajuan', 'ditolak')
    ->count();

$totalCuti = DB::table('pengajuan_cuti')
    ->join('users', 'pengajuan_cuti.id_user', '=', 'users.id_user')
    ->where('users.jabatan', 'karyawan')
    ->count();

        $totalCuti = DB::table('pengajuan_cuti')->count();

        // FIX: hanya yang perlu HRD action
        $pengajuanTerbaru = DB::table('pengajuan_cuti')
    ->join('users', 'pengajuan_cuti.id_user', '=', 'users.id_user')
    ->leftJoin('jenis_cuti', 'pengajuan_cuti.id_jenis_cuti', '=', 'jenis_cuti.id_jenis_cuti')
    ->where('users.jabatan', 'karyawan')
    ->where('status_hrd', 'menunggu')
    ->select(
        'pengajuan_cuti.*',
        'users.nama',
        'jenis_cuti.nama_jenis_cuti'
    )
    ->orderBy('pengajuan_cuti.created_at', 'desc')
    ->limit(5)
    ->get();

        $cutiMendatang = DB::table('pengajuan_cuti')
    ->join('users', 'users.id_user', '=', 'pengajuan_cuti.id_user')
    ->where('users.jabatan', 'karyawan')
    ->where('status_pengajuan', 'disetujui')
    ->whereDate('tanggal_mulai', '>=', now())
    ->select(
        'users.nama',
        'pengajuan_cuti.tanggal_mulai',
        'pengajuan_cuti.tanggal_selesai'
    )
    ->orderBy('tanggal_mulai')
    ->limit(5)
    ->get();

        $cutiPerDivisi = DB::table('pengajuan_cuti')
    ->join('users', 'users.id_user', '=', 'pengajuan_cuti.id_user')
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
        LIST KARYAWAN
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
        STORE KARYAWAN
    ========================================================= */
    public function storeKaryawan(Request $request)
    {
        if ($request->password != $request->password_confirmation) {
            return back()->with('error', 'Password tidak sama');
        }

        $cekUsername = DB::table('users')
            ->where('username', $request->username)
            ->first();

        if ($cekUsername) {
            return back()->with('error', 'Username sudah digunakan');
        }

        DB::table('users')->insert([
            'nama' => $request->nama,
            'email' => $request->email,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'jabatan' => $request->jabatan,
            'divisi' => $request->divisi,
            'alamat' => $request->alamat,
            'no_hp' => $request->no_hp,
            'sisa_cuti' => 12,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect('/list-karyawan')
            ->with('success', 'Karyawan berhasil ditambahkan');
    }

    /* =========================================================
        UPDATE KARYAWAN
    ========================================================= */
   public function updateKaryawan(Request $request, $id)
{
    $user = DB::table('users')->where('id_user', $id)->first();

    if (!$user) {
        return back()->with('error', 'User tidak ditemukan');
    }

    $aksi = strtolower(trim($request->aksi_cuti));
    $jumlah = (int) $request->jumlah_cuti;

    // 🔴 LIMIT 12 HARI
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
            'divisi' => $request->divisi,
            'alamat' => $request->alamat,
            'no_hp' => $request->no_hp,
            'sisa_cuti' => $sisaCuti,
            'updated_at' => now()
        ]);

    return redirect('/list-karyawan')->with('success', 'Data karyawan berhasil di ubah');
}
    /* =========================================================
       INPUT CUTI HRD
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

    // 🔥 CEK ANTI DOUBLE CUTI (SEMUA STATUS BELUM SELESAI)
    $cutiAktif = DB::table('pengajuan_cuti')
        ->where('id_user', session('id_user'))
        ->whereIn('status_pengajuan', ['menunggu', 'diproses'])
        ->first();

    $cutiBelumAcc = DB::table('pengajuan_cuti')
    ->where('id_user', session('id_user'))
    ->whereIn('status_pengajuan', ['menunggu', 'diproses'])
    ->exists();

    return view('hrd.input_cuti', [
    'user' => $user,
    'jenisCuti' => DB::table('jenis_cuti')->get(),
    'cutiBelumAcc' => $cutiBelumAcc
]);
}

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

    // INSERT CUTI (HRD = langsung ke direktur)
    DB::table('pengajuan_cuti')->insert([
        'id_user' => session('id_user'),
        'id_jenis_cuti' => $request->id_jenis_cuti,
        'tanggal_pengajuan' => now(),
        'tanggal_mulai' => $request->tanggal_mulai,
        'tanggal_selesai' => $request->tanggal_selesai,
        'jumlah_hari' => $request->jumlah_hari,
        'alasan_pengajuan' => $request->alasan_pengajuan,
        'dokumen_pendukung' => $dokumen,

        // 🔥 HRD BYPASS
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
        "Yth. Direktur,\n\n" .
        "HRD telah mengajukan cuti yang membutuhkan persetujuan Anda.\n\n" .
        "Nama : {$user->nama}\n" .
        "Jenis Cuti : {$jenisCuti->nama_jenis_cuti}\n" .
        "Tanggal Mulai : {$request->tanggal_mulai}\n" .
        "Tanggal Selesai : {$request->tanggal_selesai}\n" .
        "Jumlah Hari : {$request->jumlah_hari}\n\n" .
        "Silakan lakukan approval di sistem.";

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
        Riwayat Cuti HRD
    ========================================================= */
public function riwayatCutiHRD()
{
    if (!session()->has('jabatan') || strtolower(session('jabatan')) !== 'hrd') {
        return redirect('/login');
    }

    $riwayatCuti = DB::table('pengajuan_cuti')
        ->join('users', 'pengajuan_cuti.id_user', '=', 'users.id_user')
        ->leftJoin('jenis_cuti', 'pengajuan_cuti.id_jenis_cuti', '=', 'jenis_cuti.id_jenis_cuti')
        ->where('pengajuan_cuti.id_user', session('id_user')) // hanya HRD yang login
        ->select(
            'pengajuan_cuti.*',
            'users.nama',
            'users.divisi',
            'jenis_cuti.nama_jenis_cuti'
        )
        ->orderBy('pengajuan_cuti.created_at', 'desc')
        ->get();

    return view('hrd.riwayat_cuti', compact('riwayatCuti'));
}

    /* =========================================================
        DELETE KARYAWAN
    ========================================================= */
    public function deleteKaryawan($id)
    {
        DB::table('users')
            ->where('id_user', $id)
            ->delete();

        return redirect('/list-karyawan')
            ->with('success', 'Data berhasil dihapus');
    }

    /* =========================================================
        CUTI BERSAMA
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
        DATA CUTI
    ========================================================= */
    public function dataCuti(Request $request)
    {
        if (session('jabatan') != 'hrd') {
            return redirect('/login');
        }

        $query = DB::table('pengajuan_cuti')
            ->join('users', 'pengajuan_cuti.id_user', '=', 'users.id_user')
            ->leftJoin('jenis_cuti', 'pengajuan_cuti.id_jenis_cuti', '=', 'jenis_cuti.id_jenis_cuti')
            ->select(
                'pengajuan_cuti.*',
                'users.nama',
                'users.divisi',
                'jenis_cuti.nama_jenis_cuti'
            );

        if ($request->tanggal_awal && $request->tanggal_akhir) {
            $query->whereBetween('pengajuan_cuti.tanggal_pengajuan', [
                $request->tanggal_awal,
                $request->tanggal_akhir
            ]);
        }

        if ($request->bulan) {
            $query->whereMonth('pengajuan_cuti.tanggal_pengajuan', $request->bulan);
        }

        if ($request->tahun) {
            $query->whereYear('pengajuan_cuti.tanggal_pengajuan', $request->tahun);
        }

        $dataCuti = $query
            ->orderBy('pengajuan_cuti.created_at', 'desc')
            ->get();

        return view('hrd.data_cuti', compact('dataCuti'));
    }

    /* =========================================================
        VERIFIKASI CUTI HRD
    ========================================================= */
    public function verifikasiCuti()
    {
        if (session('jabatan') != 'hrd') {
            return redirect('/login');
        }

        $pengajuanCuti = DB::table('pengajuan_cuti')
            ->join('users', 'pengajuan_cuti.id_user', '=', 'users.id_user')
            ->leftJoin('jenis_cuti', 'pengajuan_cuti.id_jenis_cuti', '=', 'jenis_cuti.id_jenis_cuti')
            ->where('status_hrd', 'menunggu')
            ->select(
                'pengajuan_cuti.*',
                'users.nama',
                'users.email',
                'users.divisi',
                'users.no_hp',
                'users.sisa_cuti',
                'jenis_cuti.nama_jenis_cuti'
            )
            ->orderBy('pengajuan_cuti.created_at', 'desc')
            ->get();

        return view('hrd.verifikasi_cuti', compact('pengajuanCuti'));
    }

/* =========================================================
   VERIFIKASI CUTI HRD (FINAL FIX + EMAIL DIREKTUR)
========================================================= */
public function updateVerifikasiCuti(Request $request, $id)
{
    if (session('jabatan') != 'hrd') {
        return redirect('/login');
    }

    $cuti = DB::table('pengajuan_cuti')
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

        DB::table('pengajuan_cuti')
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
                'Pengajuan Cuti Diproses',
                "Yth. {$karyawan->nama},

Pengajuan cuti Anda telah disetujui HRD dan saat ini menunggu persetujuan Direktur.

Detail:
- Mulai : {$cuti->tanggal_mulai}
- Selesai : {$cuti->tanggal_selesai}
- Jumlah Hari : {$cuti->jumlah_hari}

Status: Menunggu Direktur.

HR Department"
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

        DB::table('pengajuan_cuti')
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
            'Pengajuan Cuti Ditolak HRD',
            "Yth. {$karyawan->nama},

Pengajuan cuti Anda ditolak oleh HRD.

Alasan: {$request->alasan_ditolak}"
        );

        return redirect('/verifikasi-cuti')
            ->with('success', 'Pengajuan ditolak HRD');
    }

    return redirect('/verifikasi-cuti')
        ->with('error', 'Status tidak valid');
}
}