<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CutiController;
use App\Http\Controllers\Auth\RegisterController;

use App\Http\Controllers\HomeController;

use App\Http\Controllers\admin\AbsensiController;
use App\Http\Controllers\admin\CutiadminController;
use App\Http\Controllers\admin\IzinAdminController;
use App\Http\Controllers\admin\JeniscutiController;
use App\Http\Controllers\admin\JenisizinController;
use App\Http\Controllers\admin\AlokasicutiController;
use App\Http\Controllers\admin\SettingalokasicutiController;

use App\Http\Controllers\karyawan\karyawanController;

use App\Http\Controllers\user\CutikaryawanController;
use App\Http\Controllers\user\IzinkaryawanController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::routes();

// Dashboard
Route::get('/', [HomeController::class, 'index'])->name('dashboard');
Route::post('/registrasi', [App\Http\Controllers\HomeController::class, 'registrasi'])->name('registrasi');


// Data Karyawan

Route::prefix('/karyawan')->name('karyawan.')->group(function () {

    Route::get('/', [karyawanController::class, 'index'])->name('index');
    Route::post('/store', [karyawanController::class, 'store'])->name('store');
    Route::post('/store_page', [karyawanController::class, 'store_page'])->name('store_page');
    Route::put('/update/{id}', [karyawanController::class, 'update'])->name('update'); 
    Route::get('/destroy/{id}', [karyawanController::class, 'destroy']) ->name('destroy');
   

});

    Route::get('karyawanshow{id}', [karyawanController::class, 'show'])->name('show');
    Route::get('karyawanedit{id}', [karyawanController::class, 'edit'])->name('edit');
    Route::put('karyawanupdate{id}', [karyawanController::class, 'update'])->name('update');
    Route::get('karyawancreate', [karyawanController::class, 'create'])->name('create');

// Role Karyawan

    Route::get('karyawandashboard', [karyawanController::class, 'karyawanDashboard'])->name('karyawanDashboard');
    Route::get('showkaryawan{id}', [karyawanController::class, 'showkaryawan'])->name('showkaryawan');


//HALAMAN KARYAWAN
//cuti
Route::get('/absensi_karyawan',[AbsensiController::class,'create'])->name('absensi_karyawan');
Route::get('/cuti_karyawan',[CutikaryawanController::class,'index'])->name('cuti_karyawan');
Route::post('/cuti_karyawan', [CutikaryawanController::class, 'store'])->name('cuti.store');
Route::get('/cuti_karyawan/{id}', [JeniscutiController::class, 'show'])->name('cutis_show');
//izin
Route::post('/izin_karyawan', [IzinkaryawanController::class, 'store'])->name('izinstore');
Route::get('/izin_karyawan/{id}', [IzinkaryawanController::class, 'show'])->name('izin.show');

//==================================================================================

//HALAMAN ADMIN
//data karyawan

// Route::get('/karyawan', [KaryawanController::class,'index'])->name('karyawan.index');

//absensi
Route::get('/absensi', [AbsensiController::class,'index']);
Route::post('/absensi_karyawan',[AbsensiController::class,'store'])->name('absensi.action');
Route::post('/absensi_karyawan/{id}',[AbsensiController::class,'update'])->name('absen_pulang');
Route::get('/exportexcel',[AbsensiController::class,'exportExcel'])->name('exportexcel');
Route::get('/exportpdf',[AbsensiController::class,'exportpdf'])->name('exportpdf');
Route::post('/importexcel',[AbsensiController::class,'importexcel'])->name('importexcel');
Route::post('/importcsv',[AbsensiController::class,'importcsv'])->name('importcsv');
//rekap absensi
Route::get('/rekapabsensi',[AbsensiController::class,'rekapabsensi'])->name('rekapabsensi');
Route::get('/rekapabsensipdf',[AbsensiController::class,'rekapabsensipdf'])->name('rekapabsensipdf');
Route::get('/rekapabsensiExcel',[AbsensiController::class,'rekapabsensiExcel'])->name('rekapabsensiExcel');
//cuti
Route::get('/permintaan_cuti', [CutiadminController::class,'index'])->name('permintaancuti.index');
Route::post('/permintaan_cuti/{id}', [CutiadminController::class, 'update'])->name('cuti.update');
Route::post('/permintaan/{id}', [CutiadminController::class, 'tolak'])->name('cuti.tolak');
//izin 
Route::post('/permintaanizin/{id}', [IzinAdminController::class, 'approved'])->name('izinapproved');
Route::post('/permintaanizinreject/{id}', [IzinAdminController::class, 'reject'])->name('izinreject');
//kategori cuti
Route::get('/kategori_cuti', [JeniscutiController::class,'index'])->name('kategori.index');
Route::post('/kategori_cuti', [JeniscutiController::class, 'store'])->name('kategori.store');
Route::put('/cuti_update/{id}', [JeniscutiController::class, 'update'])->name('cuti_update');
Route::get('/cuti_show/{id}', [JeniscutiController::class, 'show'])->name('cuti_show');
Route::get('/kategoridelete{id}', [JeniscutiController::class, 'destroy']) ->name('kategoridelete');

//kategori izin
Route::post('/kategori_izin', [JenisizinController::class, 'store'])->name('izin.store');
Route::put('/izin_update/{id}', [JenisizinController::class, 'update'])->name('izin_update');
Route::get('/izin_show/{id}', [JenisizinController::class, 'show'])->name('izin_show');
// Route::delete('/destroy/{id}', [JeniscutiController::class, 'destroy']) ->name('destroy');

//setting alokasi
Route::get('/settingalokasi', [SettingalokasicutiController::class, 'index'])->name('setting_alokasi.index');
Route::post('/settingalokasi', [SettingalokasicutiController::class, 'store'])->name('setting_alokasi.store');
Route::get('/showsettingalokasi/{id}', [SettingalokasicutiController::class, 'show'])->name('showsettingalokasi');
Route::get('/settingalokasi/{id}', [SettingalokasicutiController::class, 'destroy']) ->name('deletesetting');
Route::put('/updatesettingalokasi/{id}', [SettingalokasicutiController::class, 'update'])->name('updatesettingalokasi');

//alokasi cuti
Route::get('/alokasicuti', [AlokasicutiController::class, 'index'])->name('alokasi.index');
Route::post('/alokasicuti', [AlokasicutiController::class, 'store'])->name('alokasi.store');
Route::get('/showalokasi/{id}', [AlokasicutiController::class, 'show'])->name('showalokasi');
// Route::get('/editalokasi/{id}', [AlokasicutiController::class, 'edit'])->name('editalokasi');
Route::post('/alokasiimporexcel',[AlokasicutiController::class,'importexcel'])->name('alokasi.importexcel');

//create alokasi cuti
Route::post('/gettglmasuk', [AlokasicutiController::class, 'getTglmasuk'])->name('get.Tglmasuk');
Route::post('/getsettingalokasi', [AlokasicutiController::class, 'getSettingalokasi'])->name('get.Settingalokasi');

//update alokasi cuti
Route::post('/gettanggalmasuk', [AlokasicutiController::class, 'getTglmasuk'])->name('get.Tanggalmasuk');
Route::post('/getsettingalokas', [AlokasicutiController::class, 'getSettingalokasi'])->name('get.Setting.alokasi');
Route::get('/edit-alokasi/{id}',[AlokasicutiController::class,'edit']);
Route::put('/updatealokasi/{id}', [AlokasicutiController::class, 'update'])->name('updatealokasi');

// Route::put('/updatealokasi', [AlokasicutiController::class, 'update'])->name('update.alokasi');
    