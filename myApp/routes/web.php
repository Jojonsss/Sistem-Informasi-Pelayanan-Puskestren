<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\DokterController;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PasienController;

/*
|--------------------------------------------------------------------------
| Halaman Publik
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.process');

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');


/*
|--------------------------------------------------------------------------
| Dashboard Pasien
|--------------------------------------------------------------------------
*/


Route::middleware([
    'auth',
    RoleMiddleware::class . ':pasien',
])
    ->prefix('pasien')
    ->name('pasien.')
    ->group(function () {
        Route::get('/dashboard', [PasienController::class, 'dashboard'])
            ->name('dashboard');

        Route::get('/pendaftaran', [PasienController::class, 'createKunjungan'])
            ->name('pendaftaran');

        Route::post('/pendaftaran', [PasienController::class, 'storeKunjungan'])
            ->name('pendaftaran.store');

        Route::get('/antrean', [PasienController::class, 'antrean'])
            ->name('antrean');

        Route::get('/riwayat', [PasienController::class, 'riwayat'])
            ->name('riwayat');

        Route::get('/status-antrean', [PasienController::class, 'statusAntrean'])
            ->name('status-antrean');
    });

/*
|--------------------------------------------------------------------------
| Dashboard Dokter
|--------------------------------------------------------------------------
*/

Route::middleware([
    'auth',
    RoleMiddleware::class . ':dokter',
])->prefix('dokter')->name('dokter.')->group(function () {

    // Dashboard dokter
    Route::get('/dashboard', [
        DokterController::class,
        'dashboard'
    ])->name('dashboard');

    // Melihat daftar pasien
    Route::get('/pasien', [
        DokterController::class,
        'pasien'
    ])->name('pasien');

    // Menyimpan pasien baru
    Route::post('/pasien', [
        DokterController::class,
        'simpanPasien'
    ])->name('pasien.simpan');

    // Memperbarui data pasien
    Route::put('/pasien/{id}', [
        DokterController::class,
        'updatePasien'
    ])->name('pasien.update');

    // Menghapus data pasien
    Route::delete('/pasien/{id}', [
        DokterController::class,
        'hapusPasien'
    ])->name('pasien.hapus');

    // Detail pasien
    Route::get('/pasien/{id}', [
        DokterController::class,
        'detailPasien'
    ])->name('pasien.detail');

    // Menu melakukan pemeriksaan
    Route::get('/pemeriksaan', [
        DokterController::class,
        'pemeriksaan'
    ])->name('pemeriksaan');

    Route::post('/pemeriksaan/{kunjunganId}', [
        DokterController::class,
        'simpanPemeriksaan'
    ])->name('pemeriksaan.simpan');

// Menu catat diagnosis
Route::get('/diagnosis', [
    DokterController::class,
    'diagnosis'
])->name('diagnosis');

Route::post('/diagnosis/{kunjunganId}', [
    DokterController::class,
    'simpanDiagnosis'
])->name('diagnosis.simpan');

// Menu riwayat pasien
Route::get('/riwayat', [
    DokterController::class,
    'riwayat'
])->name('riwayat');



});

/*
|--------------------------------------------------------------------------
| Dashboard Admin
|--------------------------------------------------------------------------
*/

Route::middleware([
    'auth',
    RoleMiddleware::class . ':admin',
])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');

        Route::resource('/users', UserManagementController::class)
            ->except(['show']);
    });
