<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // =========================
    // LOGIN FORM
    // =========================
    public function loginForm()
    {
        return view('auth.login');
    }

    // =========================
    // LOGIN PROCESS
    // =========================
    public function login(Request $request)
{
    $request->validate([
        'username' => 'required',
        'password' => 'required',
        'jabatan'  => 'required',
    ]);

    $user = DB::table('users')
        ->where('username', $request->username)
        ->first();

    if (!$user) {
        return back()->with('error', 'Username tidak ditemukan');
    }

    if (!Hash::check($request->password, $user->password)) {
        return back()->with('error', 'Password salah');
    }

    // 🔥 VALIDASI ROLE / JABATAN
    if (strtolower(trim($user->jabatan)) !== strtolower(trim($request->jabatan))) {
        return back()->with('error', 'Pilihlah sesuai dengan jabatan anda');
    }

    // 🔥 VALIDASI STATUS AKTIF / VERIFIKASI EMAIL
    if (is_null($user->email_verified_at)) {
        return back()->with('error', 'Akun Anda belum aktif. Silakan lakukan verifikasi melalui tautan yang dikirimkan ke email Anda.');
    }

    // Bersihkan token verifikasi setelah login sukses pertama kali
    if (!is_null($user->verification_token)) {
        DB::table('users')
            ->where('id_user', $user->id_user)
            ->update(['verification_token' => null]);
    }

    session([
        'id_user'  => $user->id_user,
        'nama'     => $user->nama,
        'username' => $user->username,
        'jabatan'  => strtolower(trim($user->jabatan)),
        'welcome_login_id' => uniqid(),
    ]);

    return match (strtolower(trim($user->jabatan))) {
        'hrd'      => redirect('/dashboard-hrd'),
        'karyawan' => redirect('/dashboard-karyawan'),
        'direktur' => redirect('/dashboard-direktur'),
        default    => redirect('/login')
    };
}

    // =========================
    // VERIFY EMAIL PROCESS
    // =========================
    public function verifyEmail($token)
    {
        $user = DB::table('users')
            ->where('verification_token', $token)
            ->first();

        if (!$user) {
            return redirect('/login')->with('error', 'Tautan verifikasi tidak valid atau kedaluwarsa.');
        }

        // Jika sudah terverifikasi sebelumnya (misal ter-click oleh sistem/bot prefetch atau double click)
        if ($user->email_verified_at !== null) {
            return redirect('/login')->with('success', 'Akun Anda sudah aktif sebelumnya! Silakan login.');
        }

        DB::table('users')
            ->where('id_user', $user->id_user)
            ->update([
                'email_verified_at' => now(),
                'updated_at' => now(),
            ]);

        return redirect('/login')->with('success', 'Akun Anda berhasil diaktifkan! Silakan login.');
    }

    // =========================
    // SHOW RESET FORM
    // =========================
    public function showResetForm()
    {
        return view('auth.reset_password');
    }

    // =========================
    // RESET PASSWORD PROCESS
    // =========================
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
        ], [
            'password.confirmed' => 'Password anda tidak sesuai',
        ]);

        $user = DB::table('users')
            ->where('email', $request->email)
            ->first();

        if (!$user) {
            return back()->withInput()->with('error', 'Email tidak ditemukan');
        }

        DB::table('users')
            ->where('email', $request->email)
            ->update([
                'password' => Hash::make($request->password),
                'updated_at' => now(),
            ]);

        return redirect('/login')
            ->with('success', 'Password berhasil diubah');
    }

    // =========================
    // LOGOUT
    // =========================
    public function logout()
    {
        session()->flush();

        return redirect('/login')
            ->with('success', 'Berhasil keluar');
    }
}