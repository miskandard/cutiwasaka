<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Services\GmailService;
use Illuminate\Support\Facades\Password;

class KaryawanController extends Controller
{
    public function dashboard()
    {
        if (session('jabatan') != 'karyawan') {
            return redirect('/login');
        }

        $user = DB::table('users')
            ->where('id_user', session('id_user'))
            ->first();

        $statusCuti = DB::table('pengajuan_cuti')
            ->where('id_user', session('id_user'))
            ->latest('created_at')
            ->value('status_pengajuan');

        $totalDipakai = DB::table('pengajuan_cuti')
    ->leftJoin('jenis_cuti', 'pengajuan_cuti.id_jenis_cuti', '=', 'jenis_cuti.id_jenis_cuti')
    ->where('pengajuan_cuti.id_user', session('id_user'))
    ->where('pengajuan_cuti.status_pengajuan', 'disetujui')
    ->whereRaw("LOWER(jenis_cuti.nama_jenis_cuti) NOT LIKE '%sakit%'")
    ->sum('pengajuan_cuti.jumlah_hari');

        $pending = DB::table('pengajuan_cuti')
            ->where('id_user', session('id_user'))
            ->where('status_pengajuan', 'menunggu')
            ->count();

        $riwayatCuti = DB::table('pengajuan_cuti')
            ->leftJoin('jenis_cuti', 'pengajuan_cuti.id_jenis_cuti', '=', 'jenis_cuti.id_jenis_cuti')
            ->where('pengajuan_cuti.id_user', session('id_user'))
            ->select(
                'pengajuan_cuti.*',
                'jenis_cuti.nama_jenis_cuti'
            )
            ->orderBy('pengajuan_cuti.created_at', 'desc')
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

    $cutiBelumAcc = DB::table('pengajuan_cuti')
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
        'cutiBelumAcc'
    ));
}

     public function storeCuti(Request $request)
    {
        if (session('jabatan') != 'karyawan') {
            return redirect('/login');
        }

        $user = DB::table('users')
            ->where('id_user', session('id_user'))
            ->first();

        if (!$user) {
            return redirect('/login');
        }

        $cutiBelumAcc = DB::table('pengajuan_cuti')
            ->where('id_user', session('id_user'))
            ->whereIn('status_pengajuan', ['menunggu', 'diproses'])
            ->exists();

        if ($cutiBelumAcc) {
            return redirect('/input-cuti')
                ->with('error', 'Anda masih memiliki pengajuan cuti yang belum disetujui.');
        }

        $jenisCuti = DB::table('jenis_cuti')
            ->where('id_jenis_cuti', $request->id_jenis_cuti)
            ->first();

        // VALIDASI CUTI SAKIT WAJIB MC
        if (
            $jenisCuti &&
            strtolower(trim($jenisCuti->nama_jenis_cuti)) == 'cuti sakit' &&
            !$request->hasFile('dokumen_pendukung')
        ) {
            return back()->with('error', 'Cuti sakit wajib melampirkan Surat Dokter / MC.');
        }

        // UPLOAD FILE
        $dokumen = null;

        if ($request->hasFile('dokumen_pendukung')) {
            $file = $request->file('dokumen_pendukung');

            $namaFile =
                'MC_' .
                str_replace(' ', '_', $user->nama) .
                '_' .
                time() .
                '.' .
                $file->getClientOriginalExtension();

            $dokumen = $file->storeAs(
                'dokumen_cuti',
                $namaFile,
                'public'
            );
        }

        // SIMPAN CUTI (NO potong_cuti)
        DB::table('pengajuan_cuti')->insert([
            'id_user' => session('id_user'),
            'id_jenis_cuti' => $request->id_jenis_cuti,
            'tanggal_pengajuan' => now(),
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'jumlah_hari' => $request->jumlah_hari,
            'alasan_pengajuan' => $request->alasan_pengajuan,
            'dokumen_pendukung' => $dokumen,
            'status_pengajuan' => 'menunggu',
            'status_hrd' => 'menunggu',
            'status_direktur' => 'menunggu',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // EMAIL KE KARYAWAN
        $bodyKaryawan =
            "Halo {$user->nama},\n\n" .
            "Pengajuan cuti Anda berhasil dikirim.\n\n" .
            "Jenis Cuti : " . ($jenisCuti->nama_jenis_cuti ?? 'Cuti') . "\n" .
            "Tanggal Mulai : {$request->tanggal_mulai}\n" .
            "Tanggal Selesai : {$request->tanggal_selesai}\n" .
            "Jumlah Hari : {$request->jumlah_hari}\n\n" .
            "Status saat ini : Menunggu Verifikasi HRD.";

        GmailService::send(
            $user->email,
            'Pengajuan Cuti Berhasil Dikirim',
            $bodyKaryawan
        );

        // EMAIL KE HRD
        $bodyHrd =
            "Halo HRD,\n\n" .
            "Ada pengajuan cuti baru yang perlu diverifikasi.\n\n" .
            "Nama Karyawan : {$user->nama}\n" .
            "Jenis Cuti : " . ($jenisCuti->nama_jenis_cuti ?? 'Cuti') . "\n" .
            "Tanggal Mulai : {$request->tanggal_mulai}\n" .
            "Tanggal Selesai : {$request->tanggal_selesai}\n" .
            "Jumlah Hari : {$request->jumlah_hari}\n" .
            "Keterangan : {$request->alasan_pengajuan}\n\n" .
            "Silakan login untuk verifikasi.";

        $attachmentPath = null;

        if ($dokumen) {
            $attachmentPath = storage_path('app/public/' . $dokumen);
        }

        $hrdList = DB::table('users')
            ->whereRaw('LOWER(jabatan) = ?', ['hrd'])
            ->whereNotNull('email')
            ->where('email', '!=', '')
            ->get();

        foreach ($hrdList as $hrd) {
            GmailService::send(
                $hrd->email,
                'Pengajuan Cuti Baru',
                $bodyHrd,
                $attachmentPath
            );
        }

        return redirect('/dashboard-karyawan')
            ->with('success', 'Pengajuan cuti berhasil dikirim');
    }

      public function riwayatCuti()
    {
        if (session('jabatan') != 'karyawan') {
            return redirect('/login');
        }

        $riwayatCuti = DB::table('pengajuan_cuti')
            ->leftJoin('jenis_cuti', 'pengajuan_cuti.id_jenis_cuti', '=', 'jenis_cuti.id_jenis_cuti')
            ->where('pengajuan_cuti.id_user', session('id_user'))
            ->select(
                'pengajuan_cuti.*',
                'jenis_cuti.nama_jenis_cuti'
            )
            ->orderBy('pengajuan_cuti.created_at', 'desc')
            ->get();

        return view('karyawan.riwayat_cuti', compact('riwayatCuti'));
    }

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
}

