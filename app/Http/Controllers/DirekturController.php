<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\GmailService;

class DirekturController extends Controller
{
    // =========================
    // AUTH SAFE CHECK
    // =========================
    private function authCheck()
    {
        return session()->has('id_user')
            && strtolower(session('jabatan')) === 'direktur';
    }

    
    // =========================
    // DASHBOARD
    // =========================
    public function dashboard()
    {
        if (!$this->authCheck()) {
            return redirect('/login');
        }

        $jumlahKaryawan = DB::table('users')
            ->where('jabatan', 'karyawan')
            ->count();

        $totalPengajuan = DB::table('pengajuan_cuti')->count();

        $pending = DB::table('pengajuan_cuti')
            ->where('status_pengajuan', 'diproses')
            ->where('status_hrd', 'disetujui')
            ->where('status_direktur', 'menunggu')
            ->count();

        $disetujui = DB::table('pengajuan_cuti')
            ->where('status_pengajuan', 'disetujui')
            ->count();

              // 🔥 INI YANG KAMU LUPA
    $ditolak = DB::table('pengajuan_cuti')
        ->where('status_direktur', 'ditolak')
        ->count();

        $menungguVerifikasi = DB::table('pengajuan_cuti')
    ->where('status_hrd', 'disetujui')
    ->where('status_direktur', 'menunggu')
    ->count();

$diproses = DB::table('pengajuan_cuti')
    ->where('status_pengajuan', 'diproses')
    ->where('status_hrd', 'disetujui')
    ->where('status_direktur', 'menunggu')
    ->count();

        $pengajuan = $this->queryPengajuanDirektur()
            ->where('pengajuan_cuti.status_direktur', 'menunggu')
            ->get();

        return view('direktur.dashboard', compact(
    'jumlahKaryawan',
    'totalPengajuan',
    'menungguVerifikasi',
    'diproses',
    'disetujui',
    'ditolak',
    'pengajuan'
));
    }

    // =========================
    // VERIFIKASI PAGE
    // =========================
    public function verifikasiCuti()
    {
        if (!$this->authCheck()) {
            return redirect('/login');
        }

        $pengajuan = $this->queryPengajuanDirektur()->get();

        return view('direktur.verifikasi_cuti', array_merge(
            ['pengajuanCuti' => $pengajuan],
            
        ));
    }

    // =========================
    // QUERY
    // =========================
   private function queryPengajuanDirektur()
{
    return DB::table('pengajuan_cuti')
        ->join('users', 'pengajuan_cuti.id_user', '=', 'users.id_user')
        ->leftJoin('jenis_cuti', 'pengajuan_cuti.id_jenis_cuti', '=', 'jenis_cuti.id_jenis_cuti')
        ->select(
            'pengajuan_cuti.*',
            'users.nama',
            'users.email',
            'users.divisi',
            'users.sisa_cuti',
            'jenis_cuti.nama_jenis_cuti'
        )
        ->where('pengajuan_cuti.status_hrd', 'disetujui')
        ->where('pengajuan_cuti.status_direktur', 'menunggu') // 
        ->orderBy('pengajuan_cuti.created_at', 'desc');
}
    // =========================
    // UPDATE STATUS
    // =========================
  public function updateVerifikasiCuti(Request $request, $id)
{
    if (!$this->authCheck()) {
        return redirect('/login');
    }

    if ($request->status_pengajuan == 'disetujui') {
        return $this->approveDirektur($id, '/verifikasi-cuti-direktur');
    }

    if ($request->status_pengajuan == 'ditolak') {
        return $this->tolakDirektur($request, $id, '/verifikasi-cuti-direktur');
    }

    return redirect('/verifikasi-cuti-direktur')
        ->with('error', 'Status tidak valid');
}
    // =========================
    // APPROVE + GMAIL (AMAN)
    // =========================
   public function approveDirektur($id, $redirect = '/dashboard-direktur')
{
    $cuti = DB::table('pengajuan_cuti')
        ->where('id_pengajuan', $id)
        ->first();

    if (!$cuti) {
        return redirect($redirect)->with('error', 'Data tidak ditemukan');
    }

    $user = DB::table('users')->where('id_user', $cuti->id_user)->first();
    $jenisCuti = DB::table('jenis_cuti')->where('id_jenis_cuti', $cuti->id_jenis_cuti)->first();

    DB::table('pengajuan_cuti')
        ->where('id_pengajuan', $id)
        ->update([
            'status_direktur' => 'disetujui',
            'status_pengajuan' => 'disetujui',
            'alasan_ditolak' => null,
            'updated_at' => now(),
        ]);

    /* =========================
       FIX CUTI SAKIT LOGIC
    ========================= */
    if ($user) {

        $isSakit = $jenisCuti
            ? strtolower(trim($jenisCuti->nama_jenis_cuti)) === 'cuti sakit'
            : false;

        $adaMC = !empty($cuti->dokumen_pendukung);

        // 🔥 HANYA POTONG JIKA BUKAN (SAKIT + ADA MC)
        if (!($isSakit && $adaMC)) {

            $sisaBaru = max(0, $user->sisa_cuti - $cuti->jumlah_hari);

            DB::table('users')
                ->where('id_user', $cuti->id_user)
                ->update([
                    'sisa_cuti' => $sisaBaru,
                    'updated_at' => now(),
                ]);
        }
    }

    /* =========================
       EMAIL
    ========================= */
    if ($user && !empty($user->email)) {

    $pesan = "Yth. {$user->nama},

Dengan hormat,

Kami informasikan bahwa pengajuan cuti Anda telah DISETUJUI oleh Direktur.

Detail Cuti:
- Tanggal Mulai : {$cuti->tanggal_mulai}
- Tanggal Selesai : {$cuti->tanggal_selesai}
- Jumlah Hari : {$cuti->jumlah_hari} hari";

    // Jika cuti sakit
    if (
        isset($cuti->nama_jenis_cuti) &&
        strtolower(trim($cuti->nama_jenis_cuti)) == 'cuti sakit'
    ) {
        $pesan .= "

Kami turut prihatin atas kondisi kesehatan Anda.
Semoga lekas sembuh, segera pulih, dan dapat kembali beraktivitas seperti sediakala dalam keadaan sehat.";
    } else {
        $pesan .= "

Selamat menikmati waktu cuti Anda dan semoga dapat dimanfaatkan dengan baik.";
    }

    $pesan .= "

Terima kasih atas kerja sama dan kontribusi Anda kepada perusahaan.

Hormat kami,

HR Department
PT Wasaka Group";

    GmailService::send(
        $user->email,
        'Pengajuan Cuti Disetujui Direktur',
        $pesan
    );
}

return redirect($redirect)->with('success', 'Cuti disetujui Direktur');
}
    // =========================
    // TOLAK + GMAIL (AMAN)
    // =========================
   public function tolakDirektur(Request $request, $id, $redirect = '/dashboard-direktur')
{
    $cuti = DB::table('pengajuan_cuti')
        ->where('id_pengajuan', $id)
        ->first();

    if (!$cuti) {
        return redirect($redirect)
            ->with('error', 'Data tidak ditemukan');
    }

    DB::table('pengajuan_cuti')
        ->where('id_pengajuan', $id)
        ->update([
            'status_direktur'  => 'ditolak',
            'status_pengajuan' => 'ditolak',
            'alasan_ditolak'   => $request->alasan_ditolak,
            'updated_at'       => now(),
        ]);

    $user = DB::table('users')
        ->where('id_user', $cuti->id_user)
        ->first();

    if ($user && !empty($user->email)) {

        GmailService::send(
    $user->email,
    'Pemberitahuan Hasil Pengajuan Cuti',
    "Yth. Bapak/Ibu {$user->nama},

Dengan hormat,

Berdasarkan hasil peninjauan dan pertimbangan yang telah dilakukan, kami informasikan bahwa pengajuan cuti yang Anda ajukan belum dapat disetujui.

Adapun alasan penolakan pengajuan cuti tersebut adalah sebagai berikut:

{$request->alasan_ditolak}

Kami mengharapkan pengertian Anda atas keputusan ini. Apabila diperlukan, Anda dapat mengajukan kembali permohonan cuti pada waktu yang lebih sesuai dengan ketentuan dan kebutuhan operasional perusahaan.

Atas perhatian dan pengertiannya, kami ucapkan terima kasih.

Hormat kami,

Direktur
PT Wasaka Group"
);
    }

    return redirect($redirect)
        ->with('success', 'Cuti ditolak Direktur');
}


public function dataCuti()
{
    if (!$this->authCheck()) {
        return redirect('/login');
    }

    $dataCuti = DB::table('pengajuan_cuti')
        ->join('users', 'pengajuan_cuti.id_user', '=', 'users.id_user')
        ->leftJoin('jenis_cuti', 'pengajuan_cuti.id_jenis_cuti', '=', 'jenis_cuti.id_jenis_cuti')
        ->select(
            'pengajuan_cuti.*',
            'users.nama',
            'users.divisi',
            'jenis_cuti.nama_jenis_cuti'
        )
        ->whereIn('pengajuan_cuti.status_direktur', ['disetujui', 'ditolak']) // 🔥 TAMBAHAN INI
        ->orderBy('pengajuan_cuti.created_at', 'desc')
        ->get();

    return view('direktur.data_cuti', compact('dataCuti'));
}
}