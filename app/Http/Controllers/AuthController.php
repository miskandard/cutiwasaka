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
            return back()->with('error', 'Email tidak ditemukan');
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