<?php
use App\Models\Lowongan;
// use Illuminate\Support\Facades\Auth\LoginController;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SetcutiController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\admin\XmlController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\admin\MesinController;
use App\Http\Controllers\admin\ShiftController;
use App\Http\Controllers\admin\AtasanController;
use App\Http\Controllers\admin\UploadController;
use App\Http\Controllers\admin\AbsensiController;
use App\Http\Controllers\admin\JabatanController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\admin\AbsensisController;
use App\Http\Controllers\admin\SisacutiController;
use App\Http\Controllers\admin\CutiadminController;
use App\Http\Controllers\admin\IzinAdminController;
use App\Http\Controllers\admin\JeniscutiController;
use App\Http\Controllers\admin\JenisizinController;
use App\Http\Controllers\admin\UserMesinController;
use App\Http\Controllers\manager\ManagerController;
use App\Http\Controllers\superadmin\BankController;
use App\Http\Controllers\admin\DepartemenController;
use App\Http\Controllers\admin\OrganisasiController;
use App\Http\Controllers\manager\CutiizinController;
use App\Http\Controllers\admin\AlokasicutiController;
use App\Http\Controllers\admin\DetailhadirController;
use App\Http\Controllers\admin\FormPelamarController;
use App\Http\Controllers\admin\JadwalkerjaController;
use App\Http\Controllers\admin\KalenderController;
use App\Http\Controllers\admin\SettingcutiController;
use App\Http\Controllers\karyawan\karyawanController;
use App\Http\Controllers\admin\LeveljabatanController;
use App\Http\Controllers\karyawan\KaryawansController;
use App\Http\Controllers\superadmin\PartnerController;
use App\Http\Controllers\manager\TimKaryawanController;
use App\Http\Controllers\admin\SettingabsensiController;
use App\Http\Controllers\superadmin\ListmesinController;
use App\Http\Controllers\karyawan\CutikaryawanController;
use App\Http\Controllers\karyawan\IzinkaryawanController;
use App\Http\Controllers\manager\PembatalanIzinController;
use App\Http\Controllers\admin\SettingorganisasiController;
use App\Http\Controllers\admin\SettingalokasicutiController;
use App\Http\Controllers\karyawan\AbsensiKaryawanController;
use App\Http\Controllers\admin\PrediksiController;
use App\Http\Controllers\manager\PembatalanPerubahanController;
use App\Http\Controllers\superadmin\SettingorganisasiSAController;
use App\Http\Controllers\Testmail;
use Illuminate\Redis\Connectors\PredisConnector;

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
Route::post('/registrasi', [HomeController::class, 'registrasi'])->name('registrasi');

// Role HRD

Route::prefix('/karyawan')->name('karyawan.')->group(function () {

    Route::get('/', [karyawanController::class, 'index'])->name('index');
    Route::post('/store', [karyawanController::class, 'store'])->name('store');
    Route::post('/store_page', [karyawanController::class, 'store_page'])->name('store_page');
    Route::put('/update/{id}', [karyawanController::class, 'update'])->name('update');
    Route::get('/destroy/{id}', [karyawanController::class, 'destroy'])->name('destroy');
});

Route::prefix('/prediksi-resign')->name('deteksi.')->group(function () {
    Route::get('/', [PrediksiController::class, 'index'])->name('index');
    Route::post('/store', [PrediksiController::class, 'store'])->name('store');
    // Route::post('/store_page', [PrediksiController::class, 'store_page'])->name('store_page');
    // Route::put('/update/{id}', [PrediksiController::class, 'update'])->name('update');
    // Route::get('/destroy/{id}', [PrediksiController::class, 'destroy'])->name('destroy');
});

Route::get('karyawanshow{id}', [karyawanController::class, 'show'])->name('show');
Route::get('karyawanedit{id}', [karyawanController::class, 'edit'])->name('edit');
Route::put('karyawanupdate{id}', [karyawanController::class, 'update'])->name('update');

Route::get('karyawancreate', [karyawanController::class, 'create'])->name('create');
Route::get('editPassword{id}', [karyawanController::class, 'editPassword'])->name('editPassword');
Route::put('updatePassword{id}', [karyawanController::class, 'updatePassword'])->name('updatePassword');
Route::get('/search', [karyawanController::class, 'index'])->name('search');
Route::get('downloadpdf{id}', [karyawanController::class, 'downloadpdf'])->name('downloadpdf');
Route::get('showfile{id}', [karyawanController::class, 'showfile'])->name('showfile');
Route::get('editfile{id}', [karyawanController::class, 'editfile'])->name('editfile');
Route::put('updatefile{id}', [karyawanController::class, 'updatefile'])->name('updatefile');

Route::put('/update-identitas{id}', [karyawanController::class, 'updateidentita'])->name('updateidentita');
Route::post('/tambah-struktur{id}', [karyawanController::class, 'addstruktur'])->name('addstruktur');
Route::put('/update-detail-informasi{id}', [karyawanController::class, 'updatedetailinformasi'])->name('updatedetailinformasi');
Route::put('/update-informasigaji{id}', [karyawanController::class, 'updateinformasigaji'])->name('updateinformasigaji');

// Edit Data Karyawan Vesi Baru

// Role Karyawan

Route::get('karyawandashboard', [karyawanController::class, 'karyawanDashboard'])->name('karyawanDashboard');
Route::get('showkaryawan{id}', [karyawanController::class, 'showkaryawan'])->name('showkaryawan');
Route::post('/import_excel', [karyawanController::class, 'importexcel'])->name('importexcelKaryawan');
Route::get('/exportexcelkaryawan', [karyawanController::class, 'exportExcel'])->name('exportexcelkaryawan');
Route::post('/getemail', [karyawanController::class, 'getEmail'])->name('getEmail');
Route::post('/getpartner', [karyawanController::class, 'getPartner'])->name('getPartner');
Route::post('/getemail2', [karyawanController::class, 'getEmail2'])->name('getEmail2');
Route::post('/tidakmasuk', [AbsensiController::class, 'storeTidakmasuk'])->name('tidakmasuk');
Route::put('/update-pendidikan/{id}', [karyawanController::class, 'updatePendidikan'])->name('update.Pendidikan');
Route::post('/tambah-pendidikan{id}', [karyawanController::class, 'addPendidikan'])->name('add.pendidikan');
Route::post('/tambah-pendidikan/{id}', [karyawanController::class, 'tambahPendidikan'])->name('tambahPendidikan');
//download data absensi ke mesin absen
Route::post('/import-absensi', [AbsensiController::class, 'mesinabsen'])->name('download.mesin');


//HALAMAN KARYAWAN
//cuti
Route::get('/absensi-karyawan', [AbsensiController::class, 'create'])->name('absensi_karyawan');
Route::get('/riwayat-absensi', [AbsensiKaryawanController::class, 'index'])->name('riwayat.absen');
Route::get('/cuti-karyawan', [CutikaryawanController::class, 'index'])->name('cuti_karyawan');
Route::get('/getlibur', [CutikaryawanController::class, 'getLibur'])->name('getlibur');
Route::get('/getliburs', [CutikaryawanController::class, 'getLibur'])->name('getliburs');
Route::post('/getdurasialokasi', [CutikaryawanController::class, 'getDurasi'])->name('get.Durasi');
Route::post('/getdurasi', [CutikaryawanController::class, 'getDurasi'])->name('getDurasi');
Route::post('/cuti_karyawan', [CutikaryawanController::class, 'store'])->name('cuti.store');
Route::put('/pembatalan-cuti/{id}', [CutikaryawanController::class, 'batal'])->name('cuti.batal');
Route::put('/update-cuti/{id}', [CutikaryawanController::class, 'update'])->name('cuti.update');
Route::get('/cuti_karyawan/{id}', [JeniscutiController::class, 'show'])->name('cutis_show');
//izin
Route::post('/izin_karyawan', [IzinkaryawanController::class, 'store'])->name('izinstore');
Route::get('/izin_karyawan/{id}', [IzinkaryawanController::class, 'show'])->name('izin.show');
Route::put('/pembatalan-izin/{id}', [IzinkaryawanController::class, 'batal'])->name('izin.batal');
Route::put('/update-izin/{id}', [IzinkaryawanController::class, 'update'])->name('izin.update');
Route::get('/getliburdata', [IzinkaryawanController::class, 'getLiburdata'])->name('getliburdata');
Route::get('/getlibursdata', [IzinkaryawanController::class, 'getLiburdata'])->name('getlibursdata');


Route::get('/export-absensi', [AbsensiKaryawanController::class, 'absensiPeroranganExcel'])->name('expor.absensi');
Route::get('/export-absensi-pdf', [AbsensiKaryawanController::class, 'absensiPeroranganPdf'])->name('pdf.absensi');
//==================================================================================

//HALAMAN ADMIN
//data karyawan

// Route::get('/karyawan', [KaryawanController::class,'index'])->name('karyawan.index');

//absensi
Route::get('/absensi', [AbsensiController::class, 'index'])->name('absensi.index');
Route::get('/setting-absensi', [SettingabsensiController::class, 'setting'])->name('absensi.setting'); //setting-absensi-update/
Route::post('/settingabsensi', [SettingabsensiController::class, 'store'])->name('settingabsensi.store');
Route::put('/setting-absensi-update/{id}', [SettingabsensiController::class, 'update'])->name('absensi.setting.update');
Route::post('/absensi_karyawan', [AbsensiController::class, 'store'])->name('absensi.action');
Route::post('/absensi_karyawan/{id}', [AbsensiController::class, 'update'])->name('absen_pulang');
// Route::get('/exportexcel',[AbsensiController::class,'exportExcel'])->name('exportexcel');
// Route::get('/exportpdf',[AbsensiController::class,'exportpdf'])->name('exportpdf');
Route::post('/importexcel', [AbsensiController::class, 'importexcel'])->name('importexcel');
Route::post('/importcsv', [AbsensiController::class, 'importcsv'])->name('importcsv');
Route::post('/importdata', [AbsensiController::class, 'importdataexcel'])->name('importdataexcel');
Route::get('/rekapabsensipdf', [AbsensiController::class, 'rekapabsensipdf'])->name('rekapabsensipdf');
Route::get('/rekapabsensiExcel', [AbsensiController::class, 'rekapabsensiExcel'])->name('rekapabsensiExcel');

//absensis
Route::post('/import-excel', [AbsensisController::class, 'importexcel'])->name('import.excel');
Route::post('/import-csv', [AbsensisController::class, 'importcsv'])->name('import.csv');

//cuti
Route::get('/permintaan_cuti', [CutiadminController::class, 'index'])->name('permintaancuti.index');
Route::post('/permintaan_cuti/{id}', [CutiadminController::class, 'update'])->name('cuti.updates');
Route::post('/permintaan/{id}', [CutiadminController::class, 'tolak'])->name('cuti.tolak');
Route::get('/getkaryawan', [CutiadminController::class, 'getkaryawan'])->name('get.Karyawan');
Route::get('/getcuti', [CutiadminController::class, 'getCuti'])->name('get.Cuti');
Route::get('/getharilibur', [CutiadminController::class, 'getLibur'])->name('get.liburs');
Route::post('/getalokasi', [CutiadminController::class, 'getAlokasiCuti'])->name('get.Alokasicuti');
Route::post('/permintaan_cutis', [CutiadminController::class, 'storeCuti'])->name('cuti.stores');
Route::get('/rekapcutiExcel', [CutiadminController::class, 'rekapcutiExcel'])->name('rekapcutiExcel');
Route::get('/rekapcutipdf', [CutiadminController::class, 'rekapcutipdf'])->name('rekapcutipdf');
//izin
Route::get('/permintaan_izin', [IzinadminController::class, 'index'])->name('permintaanizin.index');
Route::post('/permintaanizin/{id}', [IzinAdminController::class, 'approved'])->name('izinapproved');
Route::post('/permintaanizinreject/{id}', [IzinAdminController::class, 'reject'])->name('izinreject');
Route::get('/rekapizinExcel', [IzinAdminController::class, 'rekapizinExcel'])->name('rekapizinExcel');
Route::get('/rekapizinpdf', [IzinAdminController::class, 'rekapizinpdf'])->name('rekapizinpdf');
//kategori cuti
Route::get('/kategori_cuti', [JeniscutiController::class, 'index'])->name('kategori.index');
Route::get('/setting-kategori-cuti', [SetcutiController::class, 'index'])->name('setkategori.index');
Route::put('/update-kategori/{id}', [SetcutiController::class, 'update'])->name('setkategori.update');
Route::post('/kategori_cuti', [JeniscutiController::class, 'store'])->name('kategori.store');
Route::put('/cuti_update/{id}', [JeniscutiController::class, 'update'])->name('cuti_update');
Route::get('/cuti_show/{id}', [JeniscutiController::class, 'show'])->name('cuti_show');
Route::get('/kategoridelete{id}', [JeniscutiController::class, 'destroy'])->name('kategoridelete');

//kategori izin
Route::post('/kategori_izin', [JenisizinController::class, 'store'])->name('izin.store');
Route::put('/izin_update/{id}', [JenisizinController::class, 'update'])->name('izin_update');
Route::get('/izin_show/{id}', [JenisizinController::class, 'show'])->name('izin_show');
Route::get('/kategorizindelete/{id}', [JenisizinController::class, 'destroy'])->name('destroy.jizin');

//setting alokasi
Route::get('/settingalokasi', [SettingalokasicutiController::class, 'index'])->name('setting_alokasi.index');
Route::post('/settingalokasi', [SettingalokasicutiController::class, 'store'])->name('setting_alokasi.store');
Route::get('/showsettingalokasi/{id}', [SettingalokasicutiController::class, 'show'])->name('showsettingalokasi');
Route::put('/updatesettingalokasi/{id}', [SettingalokasicutiController::class, 'update'])->name('updatesettingalokasi');
Route::get('/deletesetting/{id}', [SettingalokasicutiController::class, 'destroy'])->name('deletesetting');

//alokasi cuti
Route::get('/alokasicuti', [AlokasicutiController::class, 'index'])->name('alokasi.index');
Route::post('/alokasicuti', [AlokasicutiController::class, 'store'])->name('alokasi.store');
Route::get('/showalokasi/{id}', [AlokasicutiController::class, 'show'])->name('showalokasi');
Route::get('/edit-alokasi/{id}', [AlokasicutiController::class, 'edit']);
Route::put('/updatealokasi/{id}', [AlokasicutiController::class, 'update']);
Route::post('/alokasi-import-excel', [AlokasicutiController::class, 'importexcel'])->name('alokasi.importexcel');
Route::get('/deletealokasi{id}', [AlokasicutiController::class, 'destroy'])->name('deletealokasi');
Route::get('/alokasi-cuti', [AlokasicutiController::class, 'alokasicuti'])->name('alokasi');

//setting cuti
Route::get('/settingcuti', [SettingcutiController::class, 'index'])->name('settingcuti.index');
Route::post('/reset-cuti-tahunan', [SettingcutiController::class, 'resetCutiTahunan'])->name('reset.cuti.tahunan');
Route::post('/reset-cuti-tahun-ini', [SettingcutiController::class, 'resetTahunini'])->name('reset.tahun.ini');
// Route::put('/settingcuti/update', [SettingcutiController::class, 'update'])->name('settingcuti.update');


//sisacuti
Route::get('/sisacuti', [SisacutiController::class, 'index'])->name('sisacuti.index');
Route::post('/sisa-cuti/{id}', [SisacutiController::class, 'sendEmail'])->name('siacuti.email');

//create alokasi cuti
Route::post('/gettglmasuk', [AlokasicutiController::class, 'getTglmasuk'])->name('get.Tglmasuk');
Route::post('/getsettingalokasi', [AlokasicutiController::class, 'getSettingalokasi'])->name('get.Settingalokasi');
// Route::post('/getAlokasicuti', [AlokasicutiController::class, 'getAlokasicuti'])->name('get.Alokasicuti');
//Route::post('/getDepartemen', [AlokasicutiController::class, 'getDepartemen'])->name('get.Departemen');

//update alokasi cuti
Route::post('/gettanggalmasuk', [AlokasicutiController::class, 'getTglmasuk'])->name('get.Tanggalmasuk');
Route::post('/getsettingalokas', [AlokasicutiController::class, 'getSettingalokasi'])->name('get.Setting.alokasi');

//Departemen
Route::get('/divisi', [DepartemenController::class, 'index'])->name('divisi.index');
Route::post('/divisi', [DepartemenController::class, 'store'])->name('divisi.store');
Route::put('/divisi/update/{id}', [DepartemenController::class, 'update'])->name('divisi.update');
Route::get('/divisi/delete{id}', [DepartemenController::class, 'destroy'])->name('divisi.delete');

//Jabatan
Route::get('/jabatan', [JabatanController::class, 'index'])->name('jabatan.index');
Route::post('/jabatan', [JabatanController::class, 'store'])->name('jabatan.store');
Route::put('/jabatan/update/{id}', [JabatanController::class, 'update'])->name('jabatan.update');
Route::get('/jabatan/delete/{id}', [JabatanController::class, 'destroy'])->name('jabatan.delete');

//Level Jabatan
Route::get('/level-jabatan', [LeveljabatanController::class, 'index'])->name('leveljabatan.index');
Route::post('/level-jabatan', [LeveljabatanController::class, 'store'])->name('leveljabatan.store');
Route::put('/level-jabatan/update/{id}', [LeveljabatanController::class, 'update'])->name('leveljabatan.update');
Route::get('/level-jabatan/delete/{id}', [LeveljabatanController::class, 'destroy'])->name('leveljabatan.delete');

//Atasan
Route::get('/atasan', [AtasanController::class, 'index'])->name('atasan.index');
Route::post('/atasan', [AtasanController::class, 'store'])->name('atasan.store');

//Shift
Route::get('/shift', [ShiftController::class, 'index'])->name('shift.index');
Route::post('/shift', [ShiftController::class, 'store'])->name('shift.store');
Route::put('/shift/update/{id}', [ShiftController::class, 'update'])->name('shift.update');
Route::get('/shift/delete/{id}', [ShiftController::class, 'destroy'])->name('shift.delete');

//jadwal
Route::get('/jadwal', [JadwalkerjaController::class, 'index'])->name('jadwal.index');
Route::post('/getshift', [JadwalkerjaController::class, 'getShift'])->name('get.Shift');
Route::post('/getShift', [JadwalkerjaController::class, 'getShift'])->name('getshift');
Route::post('/jadwal', [JadwalkerjaController::class, 'store'])->name('jadwal.store');
Route::put('/jadwal/update/{id}', [JadwalkerjaController::class, 'update'])->name('jadwal.update');
Route::get('/jadwal/delete/{id}', [JadwalkerjaController::class, 'destroy'])->name('jadwal.delete');

//setting organisasi
Route::get('/setting-organisasi', [SettingorganisasiController::class, 'index'])->name('organisasi.index');
Route::put('/setting-organisasi/update/{id}', [SettingorganisasiController::class, 'update'])->name('organisasi.update');

//User Mesin
Route::get('/user_mesin', [UserMesinController::class, 'index'])->name('user_mesin.index');
Route::post('/user_mesin', [UserMesinController::class, 'store'])->name('user_mesin.store');
Route::put('/user_mesin/update/{id}', [UserMesinController::class, 'update'])->name('user_mesin.update');
Route::get('/user_mesin/delete/{id}', [UserMesinController::class, 'destroy'])->name('user_mesin.delete');
Route::get('/get_karyawan_info/{id}', [UserMesinController::class, 'getKaryawanInfo'])->name('get_karyawan_info');
Route::get('/search_karyawan', [UserMesinController::class, 'searchKaryawan'])->name('search_karyawan');

//================================================================================
//ROLE MANAGER atau SUPERVISOR

//data staff
Route::get('/data-staff', [ManagerController::class, 'dataStaff'])->name('data.Staff');
Route::get('/absensi-staff', [ManagerController::class, 'absensiStaff'])->name('absensi.Staff');
Route::get('/export-to-pdf', [ManagerController::class, 'exportpdf'])->name('exportpdf');
Route::get('/export-pdf', [ManagerController::class, 'exportallpdf'])->name('exportallpdf');
Route::get('/export-all-excel', [ManagerController::class, 'exportallExcel'])->name('export.allExcel');
Route::get('/export-to-excel', [ManagerController::class, 'exportToExcel'])->name('export.ToExcel');
//cuti dan izin

Route::get('/cuti-staff', [ManagerController::class, 'cutiStaff'])->name('cuti_Staff');
Route::post('/cuti-staff/{id}', [ManagerController::class, 'cutiapproved'])->name('cuti.approved');
Route::post('/cuti-reject/{id}', [ManagerController::class, 'cutireject'])->name('cuti.reject');
Route::post('/batal-cuti-staff/{id}', [PembatalanPerubahanController::class, 'batalApprove'])->name('batal.approved');
Route::post('/batal-reject-cuti-staff/{id}', [PembatalanPerubahanController::class, 'batalRejected'])->name('batal.rejected');
Route::post('/update-cuti-staff/{id}', [PembatalanPerubahanController::class, 'ubahApprove'])->name('ubah.approved');
Route::post('/update-reject-cuti-staff/{id}', [PembatalanPerubahanController::class, 'ubahRejected'])->name('ubah.rejected');
Route::get('/rekapcutiexcel', [CutiizinController::class, 'rekapcutiExcel'])->name('rekapcuti.excel');
Route::get('/rekapcutiPdf', [CutiizinController::class, 'rekapcutipdf'])->name('rekapcuti.pdf');

Route::post('/izin-staff/{id}', [ManagerController::class, 'izinApproved'])->name('izin.approved');
Route::post('/izin-reject/{id}', [ManagerController::class, 'izinReject'])->name('izin.reject');
Route::post('/batal-izin-staff/{id}', [PembatalanIzinController::class, 'batalApprove'])->name('batal.setuju');
Route::post('/batal-reject-izin-staff/{id}', [PembatalanIzinController::class, 'batalRejected'])->name('batal.tolak');
Route::post('/update-izin-staff/{id}', [PembatalanIzinController::class, 'ubahApprove'])->name('ubah.setuju');
Route::post('/update-reject-izin-staff/{id}', [PembatalanIzinController::class, 'ubahRejected'])->name('ubah.tolak');
Route::get('/rekapizinexcel', [CutiizinController::class, 'rekapizinExcel'])->name('rekapizin.Excel');
Route::get('/rekapizinPdf', [CutiizinController::class, 'rekapizinpdf'])->name('rekapizin.pdf');

//tim
Route::get('/tim', [TimKaryawanController::class, 'index'])->name('tim.index');
Route::post('/tim', [TimKaryawanController::class, 'store'])->name('tim.store');
Route::put('/tim-update/{id}', [TimKaryawanController::class, 'update'])->name('tim.update');
Route::get('/tim-delete{id}', [TimKaryawanController::class, 'destroy'])->name('tim.delete');

//tim karyawan
Route::get('/tim-karyawan', [TimKaryawanController::class, 'indexs'])->name('timkaryawan.index');
Route::post('/tim-karyawan', [TimKaryawanController::class, 'stores'])->name('timkaryawan.store');
Route::put('/tugas-update/{id}', [TimKaryawanController::class, 'update'])->name('tugas.update');
Route::get('/tim-karyawan-delete{id}', [TimKaryawanController::class, 'destroys'])->name('timkaryawan.delete');
// Route::post('/getNik', [TimKaryawanController::class, 'getNik'])->name('get.nik');

//form data karyawan
Route::get('/karyawancreates', [KaryawansController::class, 'create'])->name('creates');
Route::post('/storepage', [karyawansController::class, 'store_page'])->name('storepage');

    // Show Identitas Karyawan Vesi Baru
    Route::get('showidentitas{id}', [karyawanController::class, 'showidentitas'])->name('showidentitas');
    Route::get('editidentitas{id}', [karyawanController::class, 'editidentitas'])->name('editidentitas');
    Route::put('updateidentitas{id}', [karyawanController::class, 'updateidentitas'])->name('updateidentitas');

//preview data dan save ke database
Route::get('/preview-data-karyawan', [KaryawansController::class, 'previewData'])->name('preview.data');
Route::post('/storeData', [KaryawansController::class, 'storetoDatabase'])->name('store.data.karyawan');

//update data
Route::put('/updateIdentitas/{id}', [karyawansController::class, 'update'])->name('identitas.update');

// Managemen User
Route::get('settinguser', [SettingController::class, 'settinguser'])->name('settinguser');
Route::put('editUser{id}', [SettingController::class, 'editUser'])->name('editUser');
Route::get('hapususer{id}', [SettingController::class, 'hapususer'])->name('hapususer');

// Setting Role Login
Route::get('settingrole', [SettingController::class, 'settingrole'])->name('settingrole');
Route::post('storerole', [SettingController::class, 'storerole'])->name('storerole');
Route::put('editrole{id}', [SettingController::class, 'editrole'])->name('editrole');
Route::get('hapusrole{id}', [SettingController::class, 'hapusrole'])->name('hapusrole');

Route::post('/getsisacuti', [KaryawanController::class, 'getSisacuti'])->name('get.Sisacuti');
Route::post('storesisacuti', [KaryawanController::class, 'storeSisacuti'])->name('store.sisa');

//Integrasi Mesin Absensi ke HRMS
// Route::get('/tarik-data', [AbsensiController::class, 'indexs'])->name('tarikdata');
Route::get('/tarikdatas', [AbsensiController::class, 'tarikdata'])->name('tarikdata.tarik');

Route::get('/tarik-data', [AbsensiController::class, 'showDownloadLogForm'])->name('tarikdata');
Route::get('/download-data', [AbsensiController::class, 'downloadLogData'])->name('tarikdata.download');
//Route::get('/download-data', [XmlController::class, 'index'])->name('tarikdata');
// Route::post('/downloaddata', [XmlController::class, 'download'])->name('tarikdata.download');
Route::get('/download-logs', [AbsensiController::class, 'showDownloadLog'])->name('tarikdatas');
Route::get('/download-log', [AbsensiController::class, 'downloadLog'])->name('tarikdatas');
// Route buat tes koneksi ke IP lainnya
Route::get('/test-connection', [AbsensiController::class, 'someControllerMethod']);
Route::post('/tarik-absen', [MesinController::class, 'tarikAbsen'])->name('tarik.absen');

Route::get('/rekap-kehadiran', [DetailhadirController::class, 'indexs'])->name('kehadirans');
Route::post('/rekap-kehadiran', [DetailhadirController::class, 'storehadir'])->name('storehadir');
//===============================================================================
//ROLE SUPER ADMIN
//master partnert
Route::get('/partner', [PartnerController::class, 'index'])->name('partner.index');
Route::post('/partner', [PartnerController::class, 'store'])->name('partner.store');
Route::put('/partner/update/{id}', [PartnerController::class, 'update'])->name('partner.update');

//master mesin absensi
Route::get('/list-mesin', [ListmesinController::class, 'index'])->name('listmesin.index');
Route::post('/list-mesin', [ListmesinController::class, 'store'])->name('listmesin.store');
Route::put('/list-mesin/update/{id}', [ListmesinController::class, 'update'])->name('listmesin.update');
Route::post('/connect/{id}', [ListmesinController::class, 'connect'])->name('connect');
Route::post('/list-mesin/tarikdata/{id}', [ListmesinController::class, 'tarikAbsen'])->name('listmesin.tarikdata');
Route::get('/list-mesin/daftar-user/{id}', [ListmesinController::class, 'getuser'])->name('listmesin.getuser');

//setting organisasi
Route::get('/settingorganisasi', [SettingorganisasiSAController::class, 'index'])->name('organisasiindex');
Route::post('/settingorganisasi', [SettingorganisasiSAController::class, 'store'])->name('organisasistore');
Route::put('/settingorganisasi/update/{id}', [SettingorganisasiSAController::class, 'update'])->name('organisasiupdate');

//master partnert
Route::get('/bank', [BankController::class, 'index'])->name('bank.index');
Route::post('/bank', [BankController::class, 'store'])->name('bank.store');
Route::put('/bank/update/{id}', [BankController::class, 'update'])->name('bank.update');
Route::delete('/bank/delete/{id}', [BankController::class, 'destroy'])->name('bank.delete');

//role 7 partner
Route::post('set/partner/{id}', [SettingController::class, 'setPartner'])->name('set.partner');

Route::get('/phpinfo', function () {
    phpinfo();
});
Route::get('/testmail', [Testmail::class, 'index'])->name('index');
Route::post('/getPersyaratan', [FormPelamarController::class, 'getPersyaratan'])->name('getPersyaratan');

Route::get('/kalender', [KalenderController::class, 'index'])->name('kalender');
Route::get('/get-harilibur-data', [KalenderController::class, 'getHarilibur'])->name('getharilibur'); //getdatajson untuk ditampilkan di kalender
Route::get('/manajemen-harilibur', [KalenderController::class, 'setting'])->name('setting.kalender');
Route::post('/store-kalender', [KalenderController::class, 'storeSetting'])->name('store.kalender');
Route::put('/update-kalender/{id}', [KalenderController::class, 'update'])->name('kalender.update');
Route::get('/delete-kalender/{id}', [KalenderController::class, 'destroy'])->name('kalender.delete');


















