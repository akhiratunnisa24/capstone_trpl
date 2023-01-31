<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\MailController;

use App\Http\Controllers\admin\AbsensiController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\admin\CutiadminController;
use App\Http\Controllers\admin\IzinAdminController;
use App\Http\Controllers\admin\JeniscutiController;
use App\Http\Controllers\admin\JenisizinController;
use App\Http\Controllers\karyawan\ResignController;
use App\Http\Controllers\manager\ManagerController;
use App\Http\Controllers\admin\AlokasicutiController;
use App\Http\Controllers\admin\RekruitmenController;
use App\Http\Controllers\admin\ResignAdminController;

use App\Http\Controllers\direktur\DirekturController;
use App\Http\Controllers\karyawan\karyawanController;
use App\Http\Controllers\karyawan\CutikaryawanController;
use App\Http\Controllers\karyawan\IzinkaryawanController;
use App\Http\Controllers\admin\SettingalokasicutiController;
use App\Http\Controllers\karyawan\AbsensiKaryawanController;

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


// Role HRD

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
    Route::get('editPassword{id}', [karyawanController::class, 'editPassword'])->name('editPassword');
    Route::put('updatePassword{id}', [karyawanController::class, 'updatePassword'])->name('updatePassword');

    Route::get('showkaryawancuti', [karyawanController::class, 'showKaryawanCuti'])->name('showKaryawanCuti');
    Route::get('showkaryawanabsen', [karyawanController::class, 'showkaryawanabsen'])->name('showkaryawanabsen');
    Route::get('showkaryawanterlambat', [karyawanController::class, 'showkaryawanterlambat'])->name('showkaryawanterlambat');
    Route::get('showkaryawantidakmasuk', [karyawanController::class, 'showkaryawantidakmasuk'])->name('showkaryawantidakmasuk');

    Route::get('data_rekrutmen', [RekruitmenController::class, 'index'])->name('data_rekrutmen');
    Route::post('store_rekrutmen', [RekruitmenController::class, 'store'])->name('store_rekrutmen');
    Route::get('show_rekrutmen{id}', [RekruitmenController::class, 'show'])->name('show_rekrutmen');
    Route::get('create_pelamar', [RekruitmenController::class, 'create_pelamar'])->name('create_pelamar');
    Route::post('store_pelamar', [RekruitmenController::class, 'store_pelamar'])->name('store_pelamar');
    Route::get('show_formSelesai', [RekruitmenController::class, 'formSelesai'])->name('formSelesai');
    Route::get('show_kanidat{id}', [RekruitmenController::class, 'show_kanidat'])->name('show_kanidat');


    Route::get('show_pdf{id}', [RekruitmenController::class, 'show_pdf'])->name('show.pdf');






// Role Karyawan

    Route::get('karyawandashboard', [karyawanController::class, 'karyawanDashboard'])->name('karyawanDashboard');
    Route::get('showkaryawan{id}', [karyawanController::class, 'showkaryawan'])->name('showkaryawan');
    Route::post('/import_excel',[karyawanController::class,'importexcel'])->name('importexcelKaryawan');
    Route::get('/exportexcelkaryawan',[karyawanController::class,'exportExcel'])->name('exportexcelkaryawan');
    Route::post('/getemail', [karyawanController::class, 'getEmail'])->name('getEmail');
    Route::post('/tidakmasuk',[AbsensiController::class,'storeTidakmasuk'])->name('tidakmasuk');



//HALAMAN KARYAWAN
//cuti
    Route::get('/absensi-karyawan',[AbsensiController::class,'create'])->name('absensi_karyawan');
    Route::get('/history-absensi', [AbsensiKaryawanController::class,'index']);
    Route::get('/cuti-karyawan',[CutikaryawanController::class,'index'])->name('cuti_karyawan');
    Route::post('/getdurasialokasi', [CutikaryawanController::class, 'getDurasi'])->name('get.Durasi');
    Route::post('/cuti_karyawan', [CutikaryawanController::class, 'store'])->name('cuti.store');
    Route::get('/cuti_karyawan/{id}', [JeniscutiController::class, 'show'])->name('cutis_show');
//izin
    Route::post('/izin_karyawan', [IzinkaryawanController::class, 'store'])->name('izinstore');
    Route::get('/izin_karyawan/{id}', [IzinkaryawanController::class, 'show'])->name('izin.show');
//resign
    Route::get('/resign-karyawan',[ResignController::class,'index'])->name('resign_karyawan');
    Route::post('/resign_karyawan', [ResignController::class, 'store'])->name('resign.store');
    Route::get('/resign_karyawan/{id}', [ResignController::class, 'show'])->name('resign.show');

//==================================================================================

//HALAMAN ADMIN
//data karyawan

// Route::get('/karyawan', [KaryawanController::class,'index'])->name('karyawan.index');

//absensi
    Route::get('/absensi', [AbsensiController::class,'index'])->name('absensi.index');
    Route::post('/absensi_karyawan',[AbsensiController::class,'store'])->name('absensi.action');
    Route::post('/absensi_karyawan/{id}',[AbsensiController::class,'update'])->name('absen_pulang');
    // Route::get('/exportexcel',[AbsensiController::class,'exportExcel'])->name('exportexcel');
    // Route::get('/exportpdf',[AbsensiController::class,'exportpdf'])->name('exportpdf');
    Route::post('/importexcel',[AbsensiController::class,'importexcel'])->name('importexcel');
    Route::post('/importcsv',[AbsensiController::class,'importcsv'])->name('importcsv');
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
    Route::put('/updatesettingalokasi/{id}', [SettingalokasicutiController::class, 'update'])->name('updatesettingalokasi');
    Route::get('/deletesetting/{id}', [SettingalokasicutiController::class, 'destroy']) ->name('deletesetting');

//alokasi cuti
    Route::get('/alokasicuti', [AlokasicutiController::class, 'index'])->name('alokasi.index');
    Route::post('/alokasicuti', [AlokasicutiController::class, 'store'])->name('alokasi.store');
    Route::get('/showalokasi/{id}', [AlokasicutiController::class, 'show'])->name('showalokasi');
    Route::get('/edit-alokasi/{id}',[AlokasicutiController::class,'edit']);
    Route::put('/updatealokasi/{id}', [AlokasicutiController::class,'update']);
    Route::post('/alokasi-import-excel',[AlokasicutiController::class,'importexcel'])->name('alokasi.importexcel');
    Route::get('/deletealokasi{id}', [AlokasicutiController::class, 'destroy']) ->name('deletealokasi');
    Route::get('/alokasi-cuti', [AlokasicutiController::class, 'alokasicuti'])->name('alokasi');

//create alokasi cuti
    Route::post('/gettglmasuk', [AlokasicutiController::class, 'getTglmasuk'])->name('get.Tglmasuk');
    Route::post('/getsettingalokasi', [AlokasicutiController::class, 'getSettingalokasi'])->name('get.Settingalokasi');
    // Route::post('/getAlokasicuti', [AlokasicutiController::class, 'getAlokasicuti'])->name('get.Alokasicuti');
    //Route::post('/getDepartemen', [AlokasicutiController::class, 'getDepartemen'])->name('get.Departemen');

//update alokasi cuti
    Route::post('/gettanggalmasuk', [AlokasicutiController::class, 'getTglmasuk'])->name('get.Tanggalmasuk');
    Route::post('/getsettingalokas', [AlokasicutiController::class, 'getSettingalokasi'])->name('get.Setting.alokasi');

//resign
    Route::get('/resign_karyawan',[ResignAdminController::class,'index'])->name('resignkaryawan');
    Route::post('/resignkaryawan', [ResignAdminController::class, 'store'])->name('resign.store');
    Route::get('/resignkaryawan/{id}', [ResignAdminController::class, 'show'])->name('resign.show');
    
//================================================================================
//ROLE MANAGER

//data staff
    Route::get('/data-staff', [ManagerController::class, 'dataStaff'])->name('data.Staff');
    Route::get('/absensi-staff', [ManagerController::class, 'absensiStaff'])->name('absensi.Staff');
    Route::get('/export-to-pdf',[ManagerController::class,'exportpdf'])->name('exportpdf');
    Route::get('/export-pdf',[ManagerController::class,'exportallpdf'])->name('exportallpdf');
    Route::get('/export-all-excel', [ManagerController::class, 'exportallExcel'])->name('export.allExcel');
    Route::get('/export-to-excel',[ManagerController::class,'exportToExcel'])->name('export.ToExcel');
//cuti dan izin
    Route::get('/cuti-staff', [ManagerController::class, 'cutiStaff'])->name('cuti.Staff');
    Route::post('/cuti-staff/{id}', [ManagerController::class, 'cutiapproved'])->name('cuti.approved');
    Route::post('/cuti-reject/{id}', [ManagerController::class, 'cutireject'])->name('cuti.reject');
    Route::post('/izin-staff/{id}', [ManagerController::class, 'izinApproved'])->name('izin.approved');
    Route::post('/izin-reject/{id}', [ManagerController::class, 'izinReject'])->name('izin.reject');

//================================================================================
//ROLE DIREKTUR

    Route::get('/data-cuti-staff', [DirekturController::class, 'index'])->name('cuti.index');
    Route::post('/data-cuti-staff/{id}', [DirekturController::class, 'leaveapproved'])->name('leave.approved');

//testing notifikasi email mailtrap
// Route::get('kirimemail', function(){
//     Mail::raw('Ini adalah email testing', function ($message){
//         $message->to('andiny700@gmail.com','Manager Teknologi Informasi');
//         $message->subject('Notifikasi Pengajuan Cuti Baru Oleh Karyawan');
//     });

// });
    // Route::get('/sendmail', [MailController::class, 'index']);