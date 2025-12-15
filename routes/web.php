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
    DashboardController
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
| DASHBOARD
|--------------------------------------------------------------------------
*/
// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');

// Route untuk dashboard - pastikan menggunakan DashboardController
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard');

// Route lainnya...
Route::middleware('auth')->group(function () {
    Route::resource('karyawan', KaryawanController::class);
    Route::resource('absensi', AbsensiController::class);
    Route::resource('cuti', CutiController::class);
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
| ADMIN ONLY
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:Admin'])->group(function () {
    // Master Data
    Route::resource('jabatan', JabatanController::class);
    // Route::resource('departemen', DepartemenController::class);
    Route::resource('departemen', DepartemenController::class)
        ->parameters([
            'departemen' => 'departemen'
        ]);

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
    // Data Karyawan
    Route::resource('karyawan', KaryawanController::class);

    // Shift
    Route::resource('shift', ShiftController::class);
    Route::get('karyawan_shift', [KaryawanShiftController::class, 'index'])->name('karyawan_shift.index');
    Route::post('karyawan_shift/store', [KaryawanShiftController::class, 'store'])->name('karyawan_shift.store');
    Route::post('karyawan_shift/bulk-store', [KaryawanShiftController::class, 'bulkStore'])->name('karyawan_shift.bulkStore');
    Route::delete('karyawan_shift/destroy', [KaryawanShiftController::class, 'destroy'])->name('karyawan_shift.destroy');
    Route::get('karyawan_shift/schedule', [KaryawanShiftController::class, 'getSchedule'])->name('karyawan_shift.getSchedule');

    // Penggajian
    Route::get('/penggajian', [PenggajianController::class, 'index'])->name('penggajian.index');
    Route::get('/penggajian/create', [PenggajianController::class, 'create'])->name('penggajian.create');
    Route::post('/penggajian/store', [PenggajianController::class, 'store'])->name('penggajian.store');
    Route::get('/penggajian/show/{id}', [PenggajianController::class, 'show'])->name('penggajian.show');
    // Hitung otomatis penggajian (AJAX)
    Route::get('/penggajian/hitung', [PenggajianController::class, 'hitung'])
        ->name('penggajian.hitung');


    // Potongan
    Route::resource('potongan', PotonganController::class);
    Route::get('/potongan', [PotonganController::class, 'index'])->name('potongan.index');
    Route::post('/potongan/store', [PotonganController::class, 'store'])->name('potongan.store');
    Route::get('potongan/karyawan/{id}', [PotonganController::class, 'showKaryawan'])->name('potongan.karyawan');
    Route::get('potongan/generate/{bulan}/{tahun}', [PotonganController::class, 'generatePotongan'])->name('potongan.generate');

});


/*
|--------------------------------------------------------------------------
| ABSENSI (HRD & KARYAWAN)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:HRD,Karyawan'])->group(function () {

    // Route yang bisa diakses HRD & Karyawan
    Route::get('/absensi', [AbsensiController::class, 'index'])->name('absensi.index');

    // Route khusus Karyawan (absen masuk/keluar)
    Route::middleware('role:Karyawan')->group(function () {
        Route::get('/absensi/create', [AbsensiController::class, 'create'])->name('absensi.create');
        Route::post('/absensi/masuk', [AbsensiController::class, 'absenMasuk'])->name('absensi.masuk');
        Route::post('/absensi/keluar', [AbsensiController::class, 'absenKeluar'])->name('absensi.keluar');
    });

    // Route khusus HRD (CRUD & Laporan)
    Route::middleware('role:HRD')->group(function () {
        Route::get('/absensi/tambah', [AbsensiController::class, 'tambah'])->name('absensi.tambah');
        Route::post('/absensi/store', [AbsensiController::class, 'store'])->name('absensi.store');
        Route::get('/absensi/{id}/edit', [AbsensiController::class, 'edit'])->name('absensi.edit');
        Route::put('/absensi/{id}', [AbsensiController::class, 'update'])->name('absensi.update');
        Route::delete('/absensi/{id}', [AbsensiController::class, 'destroy'])->name('absensi.destroy');
        Route::get('/absensi/laporan', [AbsensiController::class, 'laporan'])->name('absensi.laporan');
    });
});


/*
|--------------------------------------------------------------------------
| CUTI (HRD & KARYAWAN) - DIGABUNG
|-------------------------------------------------------------------------- 
*/
Route::middleware(['auth', 'role:HRD,Karyawan'])->group(function () {
    // Khusus Karyawan (pengajuan cuti)
    Route::middleware('role:Karyawan')->group(function () {
        Route::get('/cuti/create', [CutiController::class, 'create'])->name('cuti.create');
        Route::post('/cuti', [CutiController::class, 'store'])->name('cuti.store');
    });
    // Bisa diakses HRD & Karyawan
    Route::get('/cuti', [CutiController::class, 'index'])->name('cuti.index');
    Route::get('/cuti/{cuti}', [CutiController::class, 'show'])->name('cuti.show');


    // Khusus HRD (approval & edit cuti)
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