<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    JabatanController,
    DepartemenController,
    KaryawanController,
    ShiftController,
    KaryawanShiftController,
    AbsensiController,
    CutiController,
    PenggajianController,
    PotonganController,
    ProfileController,
    UserController,
    DashboardController,
    AturanPotonganJabatanController
};

/*
|--------------------------------------------------------------------------
| ROUTE GUEST
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
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard');

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
| ADMIN ONLY
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:Admin'])->group(function () {

    // Master Data
    Route::resource('jabatan', JabatanController::class);
    Route::resource('departemen', DepartemenController::class)
        ->parameters(['departemen' => 'departemen']);

    // User Management
    Route::resource('users', UserController::class)->except(['show']);

    // System Settings
    Route::get('/system/settings', function () {
        return "Pengaturan Sistem (Under Development)";
    })->name('system.settings');
});

/*
|--------------------------------------------------------------------------
| HRD ONLY
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:HRD'])->group(function () {

    Route::resource('karyawan', KaryawanController::class);
    Route::resource('shift', ShiftController::class);

    // Jadwal Shift Karyawan
    Route::get('karyawan_shift', [KaryawanShiftController::class, 'index'])->name('karyawan_shift.index');
    Route::post('karyawan_shift/store', [KaryawanShiftController::class, 'store'])->name('karyawan_shift.store');
    Route::post('karyawan_shift/bulk-store', [KaryawanShiftController::class, 'bulkStore'])->name('karyawan_shift.bulkStore');
    Route::delete('karyawan_shift/destroy', [KaryawanShiftController::class, 'destroy'])->name('karyawan_shift.destroy');
    Route::get('karyawan_shift/schedule', [KaryawanShiftController::class, 'getSchedule'])->name('karyawan_shift.getSchedule');

    // Aturan Potongan
    Route::resource('aturan-potongan', AturanPotonganJabatanController::class);

    // Penggajian
    Route::get('/penggajian', [PenggajianController::class, 'index'])->name('penggajian.index');
    Route::post('/penggajian/generate', [PenggajianController::class, 'generateBulanan'])->name('penggajian.generate');
    Route::get('/penggajian/{id}', [PenggajianController::class, 'show'])->name('penggajian.show');

    // Potongan manual
    Route::post('/potongan', [PotonganController::class, 'store'])->name('potongan.store');
});

/*
|--------------------------------------------------------------------------|
| ABSENSI
|--------------------------------------------------------------------------|
*/
Route::middleware(['auth'])->group(function () {

    // HRD & KARYAWAN
    Route::middleware('role:HRD,Karyawan')->group(function () {

        Route::get('/absensi', [AbsensiController::class, 'index'])
            ->name('absensi.index');

        Route::post('/absensi/masuk', [AbsensiController::class, 'absenMasuk'])
            ->name('absensi.masuk');

        Route::post('/absensi/keluar', [AbsensiController::class, 'absenKeluar'])
            ->name('absensi.keluar');
    });

    // KHUSUS HRD
    Route::middleware('role:HRD')->group(function () {

        Route::get('/absensi/{absensi}/edit', [AbsensiController::class, 'edit'])
            ->name('absensi.edit');

        Route::put('/absensi/{absensi}', [AbsensiController::class, 'update'])
            ->name('absensi.update');

        Route::delete('/absensi/{absensi}', [AbsensiController::class, 'destroy'])
            ->name('absensi.destroy');
    });
});



/*
|--------------------------------------------------------------------------
| CUTI (HRD & KARYAWAN)  ✅ DIBENARKAN
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:HRD,Karyawan'])->group(function () {

    // ======================
    // KHUSUS KARYAWAN
    // ======================
    Route::middleware('role:Karyawan')->group(function () {
        Route::get('/cuti/create', [CutiController::class, 'create'])->name('cuti.create');
        Route::post('/cuti', [CutiController::class, 'store'])->name('cuti.store');
    });

    // ======================
    // BISA DIAKSES KEDUANYA
    // ======================
    Route::get('/cuti', [CutiController::class, 'index'])->name('cuti.index');
    Route::get('/cuti/{cuti}', [CutiController::class, 'show'])->name('cuti.show');

    // ======================
    // KHUSUS HRD
    // ======================
    Route::middleware('role:HRD')->group(function () {
        Route::get('/cuti/{cuti}/edit', [CutiController::class, 'edit'])->name('cuti.edit');
        Route::put('/cuti/{cuti}', [CutiController::class, 'update'])->name('cuti.update');
        Route::delete('/cuti/{cuti}', [CutiController::class, 'destroy'])->name('cuti.destroy');
        Route::patch('/cuti/{cuti}/status', [CutiController::class, 'updateStatus'])->name('cuti.updateStatus');
    });
});

/*
|--------------------------------------------------------------------------
| AUTH ROUTES (BREEZE)
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';
