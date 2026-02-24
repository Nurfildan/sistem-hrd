<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    DashboardController,
    ProfileController,

    // MASTER
    JabatanController,
    DepartemenController,
    ShiftController,
    KaryawanController,
    KaryawanShiftController,

    // TRANSAKSI
    AbsensiController,
    CutiController,
    PenggajianController,
    PotonganController,

    // ATURAN
    AturanPotonganJabatanController,

    // USER & SYSTEM
    UserController,
    SystemSettingController,
    BackupController,

    // LAPORAN
    LaporanAbsensiController,
    LaporanCutiController,
    LaporanPenggajianController
};

/*
|--------------------------------------------------------------------------
| GUEST
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| DASHBOARD (SEMUA ROLE LOGIN)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

/*
|--------------------------------------------------------------------------
| PROFILE (SEMUA ROLE)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| ADMIN (FULL ACCESS)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:Admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

    // ========================
    // MASTER & USER
    // ========================    
    Route::resource('jabatan', JabatanController::class);
    Route::resource('departemen', DepartemenController::class)
    ->parameters(['departemen' => 'departemen']);
    Route::resource('users', UserController::class)->except(['show']);

    // ========================
    // LAPORAN
    // ========================
    Route::get('/laporan/absensi', [LaporanAbsensiController::class, 'index'])
        ->name('laporan.absensi');
    Route::get('/laporan/absensi/export-pdf', [LaporanAbsensiController::class, 'exportPdf'])
        ->name('laporan.absensi.export-pdf');
    Route::get('/laporan/absensi/export-excel', [LaporanAbsensiController::class, 'exportExcel'])
        ->name('laporan.absensi.export-excel');

    Route::get('/laporan/cuti', [LaporanCutiController::class, 'index'])
        ->name('laporan.cuti');
    Route::get('/laporan/cuti/export-pdf', [LaporanCutiController::class, 'exportPdf'])
        ->name('laporan.cuti.export-pdf');
    Route::get('/laporan/cuti/export-excel', [LaporanCutiController::class, 'exportExcel'])
        ->name('laporan.cuti.export-excel');

    Route::get('/laporan/penggajian', [LaporanPenggajianController::class, 'index'])
        ->name('laporan.penggajian');
    Route::get('/laporan/penggajian/export-pdf', [LaporanPenggajianController::class, 'exportPdf'])
        ->name('laporan.penggajian.export-pdf');
    Route::get('/laporan/penggajian/export-excel', [LaporanPenggajianController::class, 'exportExcel'])
        ->name('laporan.penggajian.export-excel');

    // ========================
    // SYSTEM
    // ========================
    Route::get('/system/settings', [SystemSettingController::class, 'index'])
        ->name('system.settings');

    Route::post('/system/settings', [SystemSettingController::class, 'update'])
        ->name('system.settings.update');

    Route::post('/system/backup', [BackupController::class, 'backup'])
        ->name('system.backup');
});

/*
|--------------------------------------------------------------------------
| HRD ONLY
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:HRD,Admin'])->group(function () {

    Route::resource('karyawan', KaryawanController::class);
    Route::resource('shift', ShiftController::class);

    // Jadwal Shift Karyawan
    Route::get('/karyawan-shift', [KaryawanShiftController::class, 'index'])
        ->name('karyawan_shift.index');

    Route::post('/karyawan-shift', [KaryawanShiftController::class, 'store'])
        ->name('karyawan_shift.store');

    Route::post('/karyawan-shift/bulk', [KaryawanShiftController::class, 'bulkStore'])
        ->name('karyawan_shift.bulk');

    Route::delete('/karyawan-shift', [KaryawanShiftController::class, 'destroy'])
        ->name('karyawan_shift.destroy');

    // Aturan Potongan
    Route::resource('aturan-potongan', AturanPotonganJabatanController::class);

    // Penggajian
    Route::get('/penggajian', [PenggajianController::class, 'index'])
        ->name('penggajian.index');

    Route::post('/penggajian/generate', [PenggajianController::class, 'generateBulanan'])
        ->name('penggajian.generate');

    Route::get('/penggajian/{id}', [PenggajianController::class, 'show'])
        ->name('penggajian.show');

    // Potongan Manual
    Route::post('/potongan', [PotonganController::class, 'store'])
        ->name('potongan.store');
});

/*
|--------------------------------------------------------------------------
| ABSENSI (HRD & KARYAWAN)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:HRD,Karyawan'])->group(function () {

    Route::get('/absensi', [AbsensiController::class, 'index'])
        ->name('absensi.index');

    Route::post('/absensi/masuk', [AbsensiController::class, 'absenMasuk'])
        ->name('absensi.masuk');

    Route::post('/absensi/keluar', [AbsensiController::class, 'absenKeluar'])
        ->name('absensi.keluar');
});

/*
|--------------------------------------------------------------------------
| ABSENSI KHUSUS HRD
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:HRD'])->group(function () {

    Route::get('/absensi/{absensi}/edit', [AbsensiController::class, 'edit'])
        ->name('absensi.edit');

    Route::put('/absensi/{absensi}', [AbsensiController::class, 'update'])
        ->name('absensi.update');

    Route::delete('/absensi/{absensi}', [AbsensiController::class, 'destroy'])
        ->name('absensi.destroy');
});

/*
|--------------------------------------------------------------------------
| CUTI (HRD & KARYAWAN)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:HRD,Karyawan'])->group(function () {

    // Karyawan
    Route::middleware('role:Karyawan')->group(function () {
        Route::get('/cuti/create', [CutiController::class, 'create'])->name('cuti.create');
        Route::post('/cuti', [CutiController::class, 'store'])->name('cuti.store');
    });

    // Bersama
    Route::get('/cuti', [CutiController::class, 'index'])->name('cuti.index');
    Route::get('/cuti/{cuti}', [CutiController::class, 'show'])->name('cuti.show');

    // HRD
    Route::middleware('role:HRD')->group(function () {
        Route::get('/cuti/{cuti}/edit', [CutiController::class, 'edit'])->name('cuti.edit');
        Route::put('/cuti/{cuti}', [CutiController::class, 'update'])->name('cuti.update');
        Route::delete('/cuti/{cuti}', [CutiController::class, 'destroy'])->name('cuti.destroy');
        Route::patch('/cuti/{cuti}/status', [CutiController::class, 'updateStatus'])->name('cuti.updateStatus');
    });
});

/*
|--------------------------------------------------------------------------
| AUTH (BREEZE)
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';
