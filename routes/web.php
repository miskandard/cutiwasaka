<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HRDController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\DirekturController;

use App\Services\GmailService;
use Google\Client;
use Google\Service\Gmail;

/*
|--------------------------------------------------------------------------
| HALAMAN LOGIN
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/verify-email/{token}', [AuthController::class, 'verifyEmail'])->name('verify.email');

/*
|--------------------------------------------------------------------------
| AUTENTIKASI
|--------------------------------------------------------------------------
*/

Route::get('/login', [AuthController::class, 'loginForm']);
Route::post('/login', [AuthController::class, 'login'])->name('login.proses');

Route::get('/logout', [AuthController::class, 'logout']);

/*
|--------------------------------------------------------------------------
| RESET KATA SANDI
|--------------------------------------------------------------------------
*/

Route::get('/reset-password', [AuthController::class, 'showResetForm']);
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('reset.password');

/*
|--------------------------------------------------------------------------
| HRD
|--------------------------------------------------------------------------
*/

Route::get('/dashboard-hrd', [HRDController::class, 'dashboard']);

Route::get('/hrd/input-cuti', [HRDController::class, 'inputCutiHRD']);
Route::post('/hrd/input-cuti/store', [HRDController::class, 'storeCutiHRD']);

Route::get('/hrd/riwayat-cuti-hrd', [HRDController::class, 'riwayatCutiHRD']);

Route::get('/list-karyawan', [HRDController::class, 'listKaryawan']);
Route::post('/karyawan/store', [HRDController::class, 'storeKaryawan']);
Route::post('/karyawan/update/{id}', [HRDController::class, 'updateKaryawan']);
Route::post('/karyawan/import', [HRDController::class, 'importKaryawan']);
Route::get('/karyawan/resend-verification/{id}', [HRDController::class, 'resendVerification']);
Route::get('/karyawan/delete/{id}', [HRDController::class, 'deleteKaryawan']);

Route::post('/cuti-bersama/store', [HRDController::class, 'cutiBersama']);

Route::get('/data-cuti', [HRDController::class, 'dataCuti']);

Route::get('/verifikasi-cuti', [HRDController::class, 'verifikasiCuti']);
Route::post('/verifikasi-cuti/update/{id}', [HRDController::class, 'updateVerifikasiCuti']);

Route::get('/pengaturan-cuti', [HRDController::class, 'pengaturanCuti']);
Route::post('/pengaturan-cuti/update', [HRDController::class, 'updatePengaturanCuti']);

/*
|--------------------------------------------------------------------------
| KARYAWAN
|--------------------------------------------------------------------------
*/

Route::get('/dashboard-karyawan', [KaryawanController::class, 'dashboard']);
Route::get('/input-cuti', [KaryawanController::class, 'inputCuti']);
Route::post('/input-cuti/store', [KaryawanController::class, 'storeCuti']);
Route::get('/riwayat-cuti', [KaryawanController::class, 'riwayatCuti']);

/*
|--------------------------------------------------------------------------
| DIREKTUR
|--------------------------------------------------------------------------
*/

Route::get('/dashboard-direktur', [DirekturController::class, 'dashboard']);

Route::get('/verifikasi-cuti-direktur', [DirekturController::class, 'verifikasiCuti']);

Route::post('/verifikasi-cuti-direktur/update/{id}', [DirekturController::class, 'updateVerifikasiCuti']);

Route::get('/data-cuti-direktur', [DirekturController::class, 'dataCuti']);


/*
|--------------------------------------------------------------------------
| GMAIL OAUTH
|--------------------------------------------------------------------------
*/

Route::get('/gmail/auth', function () {

    $client = new Client();

    $client->setAuthConfig(storage_path('app/google/credentials.json'));
    $client->setRedirectUri('http://127.0.0.1:8000/gmail/callback');
    $client->addScope(Gmail::GMAIL_SEND);
    $client->setAccessType('offline');
    $client->setPrompt('consent');

    return redirect($client->createAuthUrl());
});

Route::get('/gmail/callback', function () {

    $client = new Client();

    $client->setAuthConfig(storage_path('app/google/credentials.json'));
    $client->setRedirectUri('http://127.0.0.1:8000/gmail/callback');
    $client->addScope(Gmail::GMAIL_SEND);

    $token = $client->fetchAccessTokenWithAuthCode(request('code'));

    if (isset($token['error'])) {
        return 'Error: ' . $token['error'];
    }

    if (!file_exists(storage_path('app/google'))) {
        mkdir(storage_path('app/google'), 0777, true);
    }

    file_put_contents(
        storage_path('app/google/token.json'),
        json_encode($token, JSON_PRETTY_PRINT)
    );

    return '<h2>Gmail berhasil terhubung ✅</h2>';
});


