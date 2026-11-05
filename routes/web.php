<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DepartemenController;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\FrontOfficeController;
use Illuminate\Support\Facades\Route;

// Redirect root ke login atau dashboard
Route::get('/', function () {
    return redirect()->route('login');
});

// Autentikasi
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Ruang Lingkup Hak Akses
Route::middleware('auth')->group(function () {

    // 0. ADMINISTRATOR UTAMA (ADMIN)
    Route::middleware('role:Admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

        // User Management
        Route::get('/users', [AdminController::class, 'usersIndex'])->name('users.index');
        Route::post('/users', [AdminController::class, 'usersStore'])->name('users.store');
        Route::put('/users/{id}', [AdminController::class, 'usersUpdate'])->name('users.update');
        Route::delete('/users/{id}', [AdminController::class, 'usersDestroy'])->name('users.destroy');

        // Dokter Management
        Route::get('/dokters', [AdminController::class, 'doktersIndex'])->name('dokters.index');
        Route::post('/dokters', [AdminController::class, 'doktersStore'])->name('dokters.store');
        Route::put('/dokters/{id}', [AdminController::class, 'doktersUpdate'])->name('dokters.update');
        Route::delete('/dokters/{id}', [AdminController::class, 'doktersDestroy'])->name('dokters.destroy');

        // Master Tarif Management
        Route::get('/tarifs', [AdminController::class, 'tarifsIndex'])->name('tarifs.index');
        Route::post('/tarifs', [AdminController::class, 'tarifsStore'])->name('tarifs.store');
        Route::put('/tarifs/{id}', [AdminController::class, 'tarifsUpdate'])->name('tarifs.update');
        Route::delete('/tarifs/{id}', [AdminController::class, 'tarifsDestroy'])->name('tarifs.destroy');
    });

    // 1. FRONT OFFICE
    Route::middleware('role:Front Office,Admin')->prefix('front-office')->name('front-office.')->group(function () {

        // Pasien
        Route::get('/pasien', [FrontOfficeController::class, 'pasienIndex'])->name('pasien.index');
        Route::post('/pasien', [FrontOfficeController::class, 'pasienStore'])->name('pasien.store');
        Route::put('/pasien/{id}', [FrontOfficeController::class, 'pasienUpdate'])->name('pasien.update');
        Route::delete('/pasien/{id}', [FrontOfficeController::class, 'pasienDestroy'])->name('pasien.destroy');

        // Rawat Jalan (PRJ)
        Route::get('/rawat-jalan', [FrontOfficeController::class, 'prjIndex'])->name('prj.index');
        Route::post('/rawat-jalan', [FrontOfficeController::class, 'prjStore'])->name('prj.store');
        Route::put('/rawat-jalan/{id}', [FrontOfficeController::class, 'prjUpdate'])->name('prj.update');
        Route::delete('/rawat-jalan/{id}', [FrontOfficeController::class, 'prjDestroy'])->name('prj.destroy');

        // Rawat Inap (PRI)
        Route::get('/rawat-inap', [FrontOfficeController::class, 'priIndex'])->name('pri.index');
        Route::post('/rawat-inap', [FrontOfficeController::class, 'priStore'])->name('pri.store');
        Route::put('/rawat-inap/{id}', [FrontOfficeController::class, 'priUpdate'])->name('pri.update');
        Route::delete('/rawat-inap/{id}', [FrontOfficeController::class, 'priDestroy'])->name('pri.destroy');

        // Tarif
        Route::get('/tarif', [FrontOfficeController::class, 'tarifIndex'])->name('tarif.index');
    });

    // 2. DEPARTEMEN / POLI
    Route::middleware('role:Departemen')->prefix('departemen')->name('departemen.')->group(function () {
        Route::get('/pasien', [DepartemenController::class, 'index'])->name('pasien.index');
        Route::post('/pasien/{id}/assign-dokter', [DepartemenController::class, 'assignDokter'])->name('pasien.assign-dokter');
        Route::get('/jadwal-dokter', [DepartemenController::class, 'jadwalDokter'])->name('dokter.jadwal');
    });

    // 3. DOKTER
    Route::middleware('role:Dokter')->prefix('dokter')->name('dokter.')->group(function () {
        Route::get('/pasien', [DokterController::class, 'index'])->name('pasien.index');
        Route::post('/pasien/{id}/diagnosa', [DokterController::class, 'diagnosa'])->name('pasien.diagnosa');

        // E-Resep
        Route::get('/resep', [DokterController::class, 'resepIndex'])->name('resep.index');
        Route::post('/resep', [DokterController::class, 'resepStore'])->name('resep.store');
        Route::put('/resep/{id}', [DokterController::class, 'resepUpdate'])->name('resep.update');
        Route::delete('/resep/{id}', [DokterController::class, 'resepDestroy'])->name('resep.destroy');
        Route::get('/resep/{id}/cetak', [DokterController::class, 'cetakResep'])->name('resep.cetak');
    });
});
