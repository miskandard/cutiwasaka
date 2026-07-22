<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Services\GmailService;
use Illuminate\Support\Facades\Password;
use Carbon\Carbon;


class KaryawanController extends Controller
{

/* =========================================================
   MENAMPILKAN HALAMAN DASHBOARD KARYAWAN
========================================================= */
    public function dashboard()
    {
        if (session('jabatan') != 'karyawan') {
            return redirect('/login');
        }

        $user = DB::table('users')
            ->where('id_user', session('id_user'))
            ->first();

        $statusCuti = DB::table('cuti')
            ->where('id_user', session('id_user'))
            ->latest('created_at')
            ->value('status_pengajuan');

        $totalDipakai = DB::table('cuti')
    ->leftJoin('jenis_cuti', 'cuti.id_jenis_cuti', '=', 'jenis_cuti.id_jenis_cuti')
    ->where('cuti.id_user', session('id_user'))
    ->where('cuti.status_pengajuan', 'disetujui')
    ->whereRaw("LOWER(jenis_cuti.nama_jenis_cuti) NOT LIKE '%sakit%'")
    ->sum('cuti.jumlah_hari');

        $pending = DB::table('cuti')
    ->where('id_user', session('id_user'))
    ->where(function($q){
        $q->where('status_pengajuan','menunggu')
          ->orWhere('status_pengajuan','diproses');
    })
    ->count();
        $riwayatCuti = DB::table('cuti')
            ->leftJoin('jenis_cuti', 'cuti.id_jenis_cuti', '=', 'jenis_cuti.id_jenis_cuti')
            ->where('cuti.id_user', session('id_user'))
            ->select(
                'cuti.*',
                'jenis_cuti.nama_jenis_cuti'
            )
            ->orderBy('cuti.created_at', 'desc')
            ->limit(5)
            ->get();

        return view('karyawan.dashboard', compact(
            'user',
            'statusCuti',
            'totalDipakai',
            'pending',
            'riwayatCuti'
        ));
    }

public function inputCuti()
{
    if (session('jabatan') != 'karyawan') {
        return redirect('/login');
    }

    $user = DB::table('users')
        ->where('id_user', session('id_user'))
        ->first();

    $jenisCuti = DB::table('jenis_cuti')->get();


    $pengaturan = DB::table('pengaturan')
        ->first();


    if(!$pengaturan){
        $pengaturan = (object)[
            'minimal_pengajuan_hari' => 7,
            'hak_cuti_tahunan' => 12
        ];
    }


    $cutiBelumAcc = DB::table('cuti')
        ->where('id_user', session('id_user'))
        ->where(function ($q) {
            $q->where('status_hrd', 'menunggu')
              ->orWhere('status_direktur', 'menunggu')
              ->orWhere('status_pengajuan', 'diproses');
        })
        ->exists();


    return view('karyawan.input_cuti', compact(
        'user',
        'jenisCuti',
        'cutiBelumAcc',
        'pengaturan'
    ));
}

/* =========================================================
   MEMPROSES PENGAJUAN CUTI KARYAWAN
========================================================= */

    public function storeCuti(Request $request)
{
    if (session('jabatan') != 'karyawan') {
        return redirect('/login');
    }

    $request->validate([
    'id_jenis_cuti'     => 'required|exists:jenis_cuti,id_jenis_cuti',
    'tanggal_mulai'     => 'required|date',
    'tanggal_selesai'   => 'required|date|after_or_equal:tanggal_mulai',
    'alasan_pengajuan'  => 'required|string|max:500',
    'dokumen_pendukung' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
]);

    $user = DB::table('users')
        ->where('id_user', session('id_user'))
        ->first();

    if (!$user) {
        return redirect('/login');
    }

    $pengaturan = DB::table('pengaturan')->first();

    if (!$pengaturan) {
    return back()->with(
        'error',
        'Pengaturan cuti belum dibuat oleh HRD.'
    );
    }

    $cutiBelumAcc = DB::table('cuti')
        ->where('id_user', session('id_user'))
        ->where(function($q){
            $q->where('status_hrd','menunggu')
              ->orWhere('status_direktur','menunggu')
              ->orWhere('status_pengajuan','diproses');
        })
        ->exists();

    if ($cutiBelumAcc) {
        return back()->with(
            'error',
            'Anda masih memiliki pengajuan cuti yang belum selesai.'
        );
    }

// =======================================
// AMBIL JENIS CUTI
// =======================================

$jenisCuti = DB::table('jenis_cuti')
    ->where('id_jenis_cuti', $request->id_jenis_cuti)
    ->first();

$isCutiSakit = str_contains(
    strtolower($jenisCuti->nama_jenis_cuti),
    'sakit'
);

// =======================================
// VALIDASI TANGGAL PENGAJUAN
// =======================================

if ($isCutiSakit) {

    // Cuti sakit hanya boleh hari ini atau tanggal yang sudah lewat
    if (Carbon::parse($request->tanggal_mulai)->gt(Carbon::today())) {

        return back()
            ->withInput()
            ->with(
                'error',
                'Cuti sakit hanya dapat diajukan untuk hari ini atau tanggal yang telah berlalu.'
            );
    }

} else {

    // Tidak boleh backdate
    if (Carbon::parse($request->tanggal_mulai)->lt(Carbon::today())) {

        return back()
            ->withInput()
            ->with(
                'error',
                'Pengajuan cuti tidak dapat dilakukan karena tanggal mulai cuti telah melewati tanggal yang ditentukan. Pengajuan cuti dengan tanggal sebelumnya hanya diperbolehkan untuk cuti sakit.'
            );
    }

    // Wajib H-7
    $batasPengajuan = Carbon::today()
    ->addDays($pengaturan->minimal_pengajuan_hari);

    if (Carbon::parse($request->tanggal_mulai)->lt($batasPengajuan)) {

    return back()
        ->withInput()
        ->with(
            'error',
            'Pengajuan cuti harus dilakukan minimal H-' .
            $pengaturan->minimal_pengajuan_hari .
            ' sebelum tanggal mulai cuti.'
        );
}

}

// =======================================
// HITUNG JUMLAH HARI CUTI
// =======================================

$jumlahHari = $this->hitungHariCuti(
    $request->tanggal_mulai,
    $request->tanggal_selesai,
    $user->tipe_kerja
);

if ($jumlahHari <= 0) {

    return back()
        ->withInput()
        ->with(
            'error',
            'Tanggal yang dipilih seluruhnya merupakan hari libur sehingga tidak ada potongan cuti.'
        );
}

// =======================================
// VALIDASI CUTI SAKIT
// =======================================

if ($isCutiSakit && !$request->hasFile('dokumen_pendukung')) {

    return back()->with(
        'error',
        'Cuti sakit wajib melampirkan surat dokter / MC.'
    );
}

// =======================================
// VALIDASI SISA CUTI
// =======================================

if (!$isCutiSakit && $jumlahHari > $user->sisa_cuti) {

    return back()->with(
        'error',
        'Sisa cuti Anda tidak mencukupi.'
    );
}
    $dokumen = null;

    if ($request->hasFile('dokumen_pendukung')) {

        $file = $request->file('dokumen_pendukung');

        $namaFile = 'MC_' .
            str_replace(' ','_',$user->nama) .
            '_' . time() .
            '.' .
            $file->getClientOriginalExtension();

        $dokumen = $file->storeAs(
            'dokumen_cuti',
            $namaFile,
            'public'
        );
    }

    DB::table('cuti')->insert([
        'id_user'           => session('id_user'),
        'id_jenis_cuti'     => $request->id_jenis_cuti,
        'tanggal_pengajuan' => now(),
        'tanggal_mulai'     => $request->tanggal_mulai,
        'tanggal_selesai'   => $request->tanggal_selesai,
        'jumlah_hari'       => $jumlahHari,
        'alasan_pengajuan'  => $request->alasan_pengajuan,
        'dokumen_pendukung' => $dokumen,
        'status_pengajuan'  => 'menunggu',
        'status_hrd'        => 'menunggu',
        'status_direktur'   => 'menunggu',
        'created_at'        => now(),
        'updated_at'        => now(),
    ]);

    try {

        $bodyKaryawan =
            "Halo {$user->nama},\n\n" .
            "Pengajuan cuti Anda berhasil dikirim.\n\n" .
            "Jenis Cuti : {$jenisCuti->nama_jenis_cuti}\n" .
            "Tanggal Mulai : {$request->tanggal_mulai}\n" .
            "Tanggal Selesai : {$request->tanggal_selesai}\n" .
            "Jumlah Hari : {$jumlahHari}\n\n" .
            "Status saat ini : Menunggu Verifikasi HRD.";

        GmailService::send(
            $user->email,
            'Pengajuan Cuti Berhasil Dikirim',
            $bodyKaryawan
        );

    } catch(\Exception $e) {

    }


    $hrdList = DB::table('users')
        ->whereRaw('LOWER(TRIM(jabatan)) = ?', ['hrd'])
        ->get();

    foreach($hrdList as $hrd){

        try {

            $bodyHrd =
                "Halo {$hrd->nama},\n\n" .
                "Ada pengajuan cuti baru yang perlu diverifikasi.\n\n" .
                "Nama Karyawan : {$user->nama}\n" .
                "Jenis Cuti : {$jenisCuti->nama_jenis_cuti}\n" .
                "Tanggal Mulai : {$request->tanggal_mulai}\n" .
                "Tanggal Selesai : {$request->tanggal_selesai}\n" .
                "Jumlah Hari : {$jumlahHari}\n" .
                "Keterangan : {$request->alasan_pengajuan}";

            GmailService::send(
                $hrd->email,
                'Pengajuan Cuti Baru',
                $bodyHrd
            );

        } catch(\Exception $e) {

        }
    }

    return redirect('/dashboard-karyawan')
        ->with('success','Pengajuan cuti berhasil dikirim.');
}

/* =========================================================
   MENAMPILKAN RIWAYAT PENGAJUAN CUTI
========================================================= */
      public function riwayatCuti()
    {
        if (session('jabatan') != 'karyawan') {
            return redirect('/login');
        }

        $riwayatCuti = DB::table('cuti')
            ->leftJoin('jenis_cuti', 'cuti.id_jenis_cuti', '=', 'jenis_cuti.id_jenis_cuti')
            ->where('cuti.id_user', session('id_user'))
            ->select(
                'cuti.*',
                'jenis_cuti.nama_jenis_cuti'
            )
            ->orderBy('cuti.created_at', 'desc')
            ->get();

        return view('karyawan.riwayat_cuti', compact('riwayatCuti'));
    }

/* =========================================================
   MELAKUKAN RESET PASSWORD
========================================================= */
   public function resetPassword(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required|min:6|confirmed',
    ]);

    $user = DB::table('users')
        ->where('email', $request->email)
        ->first();

    if (!$user) {
        return back()->with('error', 'Email tidak ditemukan');
    }

    DB::table('users')
        ->where('email', $request->email)
        ->update([
            'password' => Hash::make($request->password),
            'updated_at' => now()
        ]);

    return redirect('/login')->with('success', 'Password berhasil direset');
}

private function hitungHariCuti($tanggalMulai, $tanggalSelesai, $tipeKerja)
{
    $mulai = Carbon::parse($tanggalMulai);
    $selesai = Carbon::parse($tanggalSelesai);

    // Hari libur nasional
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

    $jumlahHari = 0;

    while ($mulai <= $selesai) {

        $tanggal = $mulai->format('Y-m-d');

        // Minggu
        if ($mulai->isSunday()) {
            $mulai->addDay();
            continue;
        }

        // Back Office: Sabtu juga libur
        if ($tipeKerja == 'back_office' && $mulai->isSaturday()) {
            $mulai->addDay();
            continue;
        }

        // Hari libur nasional
        if (in_array($tanggal, $hariLibur)) {
            $mulai->addDay();
            continue;
        }

        $jumlahHari++;
        $mulai->addDay();
    }

    return $jumlahHari;
}
}