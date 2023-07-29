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
use App\Http\Controllers\admin\KalenderController;
use App\Http\Controllers\admin\SisacutiController;

use App\Http\Controllers\RequestAbsensiController;


use App\Http\Controllers\admin\CutiadminController;
use App\Http\Controllers\admin\InformasiController;
use App\Http\Controllers\admin\IzinAdminController;
use App\Http\Controllers\admin\JeniscutiController;
use App\Http\Controllers\admin\JenisizinController;
use App\Http\Controllers\admin\MasterkpiController;
use App\Http\Controllers\admin\UserMesinController;
use App\Http\Controllers\karyawan\ResignController;
use App\Http\Controllers\manager\ManagerController;
use App\Http\Controllers\admin\DepartemenController;
use App\Http\Controllers\admin\OrganisasiController;
use App\Http\Controllers\admin\RekruitmenController;
use App\Http\Controllers\admin\TidakMasukController;
use App\Http\Controllers\manager\CutiizinController;
use App\Http\Controllers\admin\AlokasicutiController;
use App\Http\Controllers\admin\FormPelamarController;
use App\Http\Controllers\admin\JadwalkerjaController;
use App\Http\Controllers\admin\ResignAdminController;
use App\Http\Controllers\admin\SettingcutiController;
use App\Http\Controllers\direktur\DirekturController;
use App\Http\Controllers\karyawan\karyawanController;
use App\Http\Controllers\admin\LeveljabatanController;
use App\Http\Controllers\karyawan\KaryawansController;
use App\Http\Controllers\manager\KpimanagerController;
use App\Http\Controllers\manager\TimKaryawanController;
use App\Http\Controllers\admin\SettingabsensiController;
use App\Http\Controllers\karyawan\KpikaryawanController;
use App\Http\Controllers\karyawan\CutikaryawanController;
use App\Http\Controllers\karyawan\IzinkaryawanController;
use App\Http\Controllers\manager\TugasKaryawanController;
use App\Http\Controllers\manager\PembatalanIzinController;
use App\Http\Controllers\admin\SettingorganisasiController;
use App\Http\Controllers\admin\SettingalokasicutiController;
use App\Http\Controllers\karyawan\AbsensiKaryawanController;
use App\Http\Controllers\admin\NotifMailRekruitmenController;
use App\Http\Controllers\manager\PembatalanPerubahanController;

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
// Route::post('/registrasi', [HomeController::class, 'registrasi'])->name('registrasi');   

// Role HRD 

Route::prefix('/karyawan')->name('karyawan.')->group(function () {

    Route::get('/', [karyawanController::class, 'index'])->name('index');
    Route::post('/store', [karyawanController::class, 'store'])->name('store');
    Route::post('/store_page', [karyawanController::class, 'store_page'])->name('store_page');
    Route::put('/update/{id}', [karyawanController::class, 'update'])->name('update');
    Route::get('/destroy/{id}', [karyawanController::class, 'destroy'])->name('destroy');
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



// Show baru
Route::get('showorganisasi{id}', [karyawanController::class, 'showorganisasi'])->name('showorganisasi');
Route::get('showprestasi{id}', [karyawanController::class, 'showprestasi'])->name('showprestasi');
Route::get('showkeluarga{id}', [karyawanController::class, 'showkeluarga'])->name('showkeluarga');
Route::get('showkontakdarurat{id}', [karyawanController::class, 'showkontakdarurat'])->name('showkontakdarurat');

// Edit Data Karyawan Vesi Baru

//Upload File Digital Karyawan

// Route::get('/karyawanupload', [UploadController::class, 'index'])->name('index');
Route::get('/karyawanupload{id}', [UploadController::class, 'index'])->name('index');
Route::post('/storeupload', [UploadController::class, 'store'])->name('store_upload');



Route::get('showkaryawancuti', [karyawanController::class, 'showKaryawanCuti'])->name('showKaryawanCuti');
Route::get('showkaryawanabsen', [karyawanController::class, 'showkaryawanabsen'])->name('showkaryawanabsen');
Route::get('showkaryawanterlambat', [karyawanController::class, 'showkaryawanterlambat'])->name('showkaryawanterlambat');
Route::get('showkaryawantidakmasuk', [karyawanController::class, 'showkaryawantidakmasuk'])->name('showkaryawantidakmasuk');

Route::get('data_rekrutmen', [RekruitmenController::class, 'index'])->name('data_rekrutmen');
Route::post('store_rekrutmen', [RekruitmenController::class, 'store'])->name('store_rekrutmen');
Route::get('show_rekrutmen{id}', [RekruitmenController::class, 'show'])->name('show_rekrutmen');

Route::put('rekrutmenupdate{id}', [RekruitmenController::class, 'rekrutmenupdate'])->name('update');

Route::get('show_formSelesai', [RekruitmenController::class, 'formSelesai'])->name('formSelesai');
Route::get('show_kanidat{id}', [RekruitmenController::class, 'show_kanidat'])->name('show_kanidat');
Route::post('update_pelamar{id}', [RekruitmenController::class, 'update'])->name('update_pelamar');
Route::get('hapuslowongan{id}', [RekruitmenController::class, 'destroy'])->name('hapuslowongan');
Route::get('metode_rekrutmen', [RekruitmenController::class, 'create_metode'])->name('metode_rekrutmen');
Route::post('store_metode_rekrutmen', [RekruitmenController::class, 'store_metode_rekrutmen'])->name('store_metode_rekrutmen');
Route::put('update_metode_rekrutmen{id}', [RekruitmenController::class, 'update_metode_rekrutmen'])->name('update_metode_rekrutmen');
Route::get('metode_rekrutmen_destroy{id}', [RekruitmenController::class, 'metode_rekrutmen_destroy'])->name('metode_rekrutmen_destroy');
// show yang baru
Route::get('showkanidat{id}', [RekruitmenController::class, 'showkanidat'])->name('showkanidat');
// Route::get('showidentitas{id}', [karyawanController::class, 'showidentitas'])->name('showidentitas');

// Form Pelamar Controller

    // get persyaratan di form pelamar saat memilih lowongan
    Route::post('/getPersyaratan', [FormPelamarController::class, 'getPersyaratan'])->name('getPersyaratan');
    // Data Identitas
    Route::get('create_pelamar', [FormPelamarController::class, 'create'])->name('create_pelamar');
    Route::post('store_pelamar', [FormPelamarController::class, 'store'])->name('store_pelamar');
    // Data Keluarga
    Route::get('/create_data_keluarga_pelamar', [FormPelamarController::class, 'createKeluarga'])->name('createKeluarga');
    Route::post('/store_data_keluarga', [FormPelamarController::class, 'storedk'])->name('store_data_keluarga');
    Route::post('/update_data_keluarga', [FormPelamarController::class, 'updatedk'])->name('update_data_keluarga');
    //Data kontak darurat
    Route::get('/create_kontak_darurat', [FormPelamarController::class, 'createkonrat'])->name('create_kontak_darurat');
    Route::post('/store_kontak_darurat', [FormPelamarController::class, 'storekd'])->name('store_kontak_darurat');
    Route::post('/update_kontak_darurat', [FormPelamarController::class, 'updatekd'])->name('/update_kontak_darurat');
    //form data pendidikan
    Route::get('/create_data_pendidikan', [FormPelamarController::class, 'creatependidikan'])->name('create_data_pendidikan');
    Route::post('/storep_formal', [FormPelamarController::class, 'storepformal'])->name('storep_formal');
    Route::post('/update_pendidikan', [FormPelamarController::class, 'updaterPendidikan'])->name('update_pendidikan');
    //form data pekerjaan
    Route::get('/create_data_pekerjaan', [FormPelamarController::class, 'createpekerjaan'])->name('create_data_pekerjaan');
    Route::post('/store_pekerjaan', [FormPelamarController::class, 'storepekerjaan'])->name('store_pekerjaan');
    Route::post('/update_pekerjaan', [FormPelamarController::class, 'updaterPekerjaan'])->name('update_pekerjaan');
    //Form data organisasi
    Route::get('/create_data_organisasi', [FormPelamarController::class, 'createorganisasi'])->name('create_data_organisasi');
    Route::post('/store_organisasi', [FormPelamarController::class, 'storeorganisasi'])->name('store_organisasi');
    Route::post('/update_organisasi', [FormPelamarController::class, 'updaterOrganisasi'])->name('update_organisasi');
    //form data prestasi
    Route::get('/create_data_prestasi', [FormPelamarController::class, 'createprestasi'])->name('create_data_prestasi');
    Route::post('/store_prestasi', [FormPelamarController::class, 'storeprestasi'])->name('store_prestasi');
    Route::post('/update_prestasi', [FormPelamarController::class, 'updaterPrestasi'])->name('update_prestasi');
    //preview data dan save ke database
    Route::get('/preview_data_pelamar', [FormPelamarController::class, 'previewData'])->name('preview_data_pelamar');
    Route::post('/store_Data', [FormPelamarController::class, 'storetoDatabase'])->name('store_Data');

// Notifikasi Email ke Pelamar
Route::get('notif_rekrutmen', [NotifMailRekruitmenController::class, 'index']);

// Route::post('/getemail2', [karyawanController::class, 'getEmail2'])->name('getEmail2');

Route::get('/get-persyaratan/{id}', function ($id) {
    $lowongan = Lowongan::find($id);
    return response()->json(['persyaratan' => $lowongan->persyaratan]);
});

Route::get('Form-Rekruitmen-RYNEST', [FormPelamarController::class, 'create'], function () {
    return view('admin.rekruitmen.formPelamar');
});

Route::get('Form-DataKaryawan-RYNEST', [FormPelamarController::class, 'create_karyawan_baru'], function () {
    return view('admin.rekruitmen.formPelamar');
});




Route::get('show_pdf{id}', [RekruitmenController::class, 'show_pdf'])->name('show.pdf');






// Role Karyawan

Route::get('karyawandashboard', [karyawanController::class, 'karyawanDashboard'])->name('karyawanDashboard');
Route::get('showkaryawan{id}', [karyawanController::class, 'showkaryawan'])->name('showkaryawan');
Route::post('/import_excel', [karyawanController::class, 'importexcel'])->name('importexcelKaryawan');
Route::get('/exportexcelkaryawan', [karyawanController::class, 'exportExcel'])->name('exportexcelkaryawan');
Route::post('/getemail', [karyawanController::class, 'getEmail'])->name('getEmail');
Route::post('/getemail2', [karyawanController::class, 'getEmail2'])->name('getEmail2');
Route::post('/tidakmasuk', [AbsensiController::class, 'storeTidakmasuk'])->name('tidakmasuk');

//download data absensi ke mesin absen
Route::post('/import-absensi', [AbsensiController::class, 'mesinabsen'])->name('download.mesin');




//HALAMAN KARYAWAN
//cuti
Route::get('/absensi-karyawan', [AbsensiController::class, 'create'])->name('absensi_karyawan');
Route::get('/history-absensi', [AbsensiKaryawanController::class, 'index'])->name('history.absen');
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

//resign
Route::get('/resign-karyawan', [ResignController::class, 'index'])->name('resign_karyawan');
Route::post('/resign_karyawan', [ResignController::class, 'store'])->name('resignkaryawan.store');
Route::get('/resign_karyawan/{id}', [ResignController::class, 'show'])->name('resign.show');
Route::get('resigndelete{id}', [ResignController::class, 'delete'])->name('resign.delete');


Route::get('/export-absensi', [AbsensiKaryawanController::class, 'absensiPeroranganExcel'])->name('expor.absensi');
Route::get('/export-absensi-pdf', [AbsensiKaryawanController::class, 'absensiPeroranganPdf'])->name('pdf.absensi');

//kpi
Route::get('/kpi', [KpikaryawanController::class, 'index'])->name('kpi.karyawan');
//==================================================================================

//HALAMAN ADMIN
//data karyawan

// Route::get('/karyawan', [KaryawanController::class,'index'])->name('karyawan.index');

//absensi
Route::get('/absensi', [AbsensiController::class, 'index'])->name('absensi.index');
Route::get('/setting-absensi', [SettingabsensiController::class, 'setting'])->name('absensi.setting'); //setting-absensi-update/
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
Route::post('/permintaan_cuti/{id}', [CutiadminController::class, 'update'])->name('cuti.update');
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

//resign
Route::get('/resign_admin', [ResignAdminController::class, 'index'])->name('resignkaryawan');
Route::post('/resignadmin', [ResignAdminController::class, 'store'])->name('resign.store');
Route::get('/resignadmin/{id}', [ResignAdminController::class, 'show'])->name('resign.show');
Route::post('/permintaanresign/{id}', [ResignAdminController::class, 'approved'])->name('resignapproved');
Route::post('/permintaanresignreject/{id}', [ResignAdminController::class, 'reject'])->name('resignreject');
Route::get('/getUserData/{id}', [ResignAdminController::class, 'getUserData'])->name('getUserData');

//Departemen
Route::get('/divisi', [DepartemenController::class, 'index'])->name('divisi.index');
Route::post('/divisi', [DepartemenController::class, 'store'])->name('divisi.store');
Route::put('/divisi/update/{id}', [DepartemenController::class, 'update'])->name('divisi.update');
Route::get('/divisi/delete{id}', [DepartemenController::class, 'destroy'])->name('divisi.delete');

//Informasi
Route::get('/informasi', [InformasiController::class, 'index'])->name('informasi.index');
Route::post('/informasi', [InformasiController::class, 'store'])->name('informasi.store');
Route::put('/informasi/update/{id}', [InformasiController::class, 'update'])->name('informasi.update');
Route::get('/informasi/delete{id}', [InformasiController::class, 'destroy'])->name('informasi.delete');

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
Route::put('/setting-organisasi/update', [SettingorganisasiController::class, 'update'])->name('organisasi.update');


//Absensi Tidak Masuk
Route::get('/absensi-tidak-masuk', [TidakMasukController::class, 'index'])->name('tidakmasuk.index');
Route::get('/absensi-tidak-masuk-pdf', [TidakMasukController::class, 'tidakMasukPdf'])->name('tidakmasuk.pdf');
Route::get('/absensi-tidak-masuk-excel', [TidakMasukController::class, 'tidakMasukExcel'])->name('tidakmasuk.excel');
Route::get('/tindakan-tidak-masuk', [TidakMasukController::class, 'tampil'])->name('tidakmasuk.tampil');
Route::get('/show-detail{id}', [TidakMasukController::class, 'show'])->name('tidakmasuk.show');
Route::get('/tindakan-terlambat', [TidakMasukController::class, 'tampilTerlambat'])->name('terlambat.tampil');
Route::get('/terlambat-detail{id}', [TidakMasukController::class, 'showTerlambat'])->name('terlambat.show');


//KPI
Route::get('/masterkpi', [MasterkpiController::class, 'index'])->name('master.index');
Route::post('/masterkpi', [MasterkpiController::class, 'store'])->name('master.store');
Route::post('/masterkpi-update/{id}', [MasterkpiController::class, 'update'])->name('master.update');

Route::get('/indikator-kpi', [MasterkpiController::class, 'indikator'])->name('indicator.index');
Route::post('/indikator-kpi', [MasterkpiController::class, 'stores'])->name('indikator.store');
Route::post('/indikator-kpi-update/{id}', [MasterkpiController::class, 'updates'])->name('indikator.update');

//User Mesin
Route::get('/user_mesin', [UserMesinController::class, 'index'])->name('jabatan.index');
Route::post('/user_mesin', [UserMesinController::class, 'store'])->name('jabatan.store');
Route::put('/user_mesin/update/{id}', [UserMesinController::class, 'update'])->name('jabatan.update');
Route::get('/user_mesin/delete/{id}', [UserMesinController::class, 'destroy'])->name('jabatan.delete');
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

Route::get('/cuti-staff', [ManagerController::class, 'cutiStaff'])->name('cuti.Staff');
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

Route::get('/resign_manager', [ManagerController::class, 'resignStaff'])->name('resignstaff');
Route::get('/resignmanager/{id}', [ResignAdminController::class, 'show'])->name('resign.show');
// Route::post('/permintaan_resign/{id}', [ResignAdminController::class, 'approved'])->name('resign_approved');
Route::post('/permintaan_resign_manager/{id}', [ResignAdminController::class, 'approvedmanager'])->name('resign_approved_manager');
Route::post('/permintaanresign_reject/{id}', [ResignAdminController::class, 'reject'])->name('resign_reject');

//KPI
Route::get('/master-kpi', [KpimanagerController::class, 'index'])->name('manager.kpi');
Route::get('/data-kpi', [KpimanagerController::class, 'data'])->name('data.kpi');

//tim
Route::get('/tim', [TimKaryawanController::class, 'index'])->name('tim.index');
Route::post('/tim', [TimKaryawanController::class, 'store'])->name('tim.store');
Route::put('/tim-update/{id}', [TimKaryawanController::class, 'update'])->name('tim.update');
Route::get('/tim-delete{id}', [TimKaryawanController::class, 'destroy'])->name('tim.delete');

//tim karyawan
Route::get('/tim-karyawan', [TimKaryawanController::class, 'indexs'])->name('timkaryawan.index');
Route::post('/tim-karyawan', [TimKaryawanController::class, 'stores'])->name('timkaryawan.store');
Route::put('/tugas-update/{id}', [TimKaryawanController::class, 'update'])->name('tim.update');
Route::get('/tim-karyawan-delete{id}', [TimKaryawanController::class, 'destroys'])->name('timkaryawan.delete');
// Route::post('/getNik', [TimKaryawanController::class, 'getNik'])->name('get.nik');

//tugas karyawan
Route::get('/tugas-karyawan', [TugasKaryawanController::class, 'index'])->name('tugas.index');
Route::post('/tugas-karyawan', [TugasKaryawanController::class, 'stores'])->name('timkaryawan.store');
Route::post('/getNik', [TugasKaryawanController::class, 'getNik'])->name('get.nik');
Route::post('/getTim', [TugasKaryawanController::class, 'getTim'])->name('get.tim');

//================================================================================
//ROLE DIREKTUR

Route::get('/data-cuti-staff', [DirekturController::class, 'index'])->name('cuti.index');
Route::post('/data-cuti-staff/{id}', [DirekturController::class, 'leaveapproved'])->name('leave.approved');
Route::post('/data-cuti-staffs/{id}', [DirekturController::class, 'leaverejected'])->name('leave.rejected');
Route::get('/data-staf', [DirekturController::class, 'dataStaff'])->name('direktur.staff');

//================================================================================
//ROLE SUPERVISOR

//data staff
// Route::get('/datastaff', [SupervisorController::class, 'dataStaff'])->name('dataStaff');
// Route::get('/absensi-staff', [SupervisorController::class, 'absensiStaff'])->name('absensi.Staff');
// Route::get('/export-to-pdf',[SupervisorController::class,'exportpdf'])->name('exportpdf');
// Route::get('/export-pdf',[SupervisorController::class,'exportallpdf'])->name('exportallpdf');
// Route::get('/export-all-excel', [SupervisorController::class, 'exportallExcel'])->name('export.allExcel');
// Route::get('/export-to-excel',[SupervisorController::class,'exportToExcel'])->name('export.ToExcel');
//cuti dan izin
// Route::get('/cuti-staff', [ManagerController::class, 'cutiStaff'])->name('cuti.Staff');
// Route::post('/cuti-staff/{id}', [ManagerController::class, 'cutiapproved'])->name('cuti.approved');
// Route::post('/cuti-reject/{id}', [ManagerController::class, 'cutireject'])->name('cuti.reject');
// Route::post('/izin-staff/{id}', [ManagerController::class, 'izinApproved'])->name('izin.approved');
// Route::post('/izin-reject/{id}', [ManagerController::class, 'izinReject'])->name('izin.reject');

// Route::get('/resign_manager',[ManagerController::class,'resignStaff'])->name('resignstaff');
// Route::get('/resignmanager/{id}', [ResignAdminController::class, 'show'])->name('resign.show');
// Route::post('/permintaan_resign/{id}', [ResignAdminController::class, 'approved'])->name('resign_approved');
// Route::post('/permintaan_resign_manager/{id}', [ResignAdminController::class, 'approvedmanager'])->name('resign_approved_manager');
// Route::post('/permintaanresign_reject/{id}', [ResignAdminController::class, 'reject'])->name('resign_reject');

//testing notifikasi email mailtrap
// Route::get('kirimemail', function(){
//     Mail::raw('Ini adalah email testing', function ($message){
//         $message->to('andiny700@gmail.com','Manager Teknologi Informasi');
//         $message->subject('Notifikasi Pengajuan Cuti Baru Oleh Karyawan');
//     });

// });
// Route::get('/sendmail', [MailController::class, 'index']);

//form data karyawan
Route::get('/karyawancreates', [KaryawansController::class, 'create'])->name('creates');
Route::post('/storepage', [karyawansController::class, 'store_page'])->name('storepage');

    // Show Identitas Karyawan Vesi Baru
    Route::get('showidentitas{id}', [karyawanController::class, 'showidentitas'])->name('showidentitas');
    Route::get('editidentitas{id}', [karyawanController::class, 'editidentitas'])->name('editidentitas');
    Route::put('updateidentitas{id}', [karyawanController::class, 'updateidentitas'])->name('updateidentitas');

//form data keluarga
Route::get('/create-data-keluarga', [KaryawansController::class, 'createdakel'])->name('create.dakel');
Route::post('/storedatakeluarga', [KaryawansController::class, 'storedk'])->name('storedk');
Route::post('/updatedatakeluarga', [KaryawansController::class, 'updatedk'])->name('updatedk');
Route::delete('/delete-keluarga', [KaryawansController::class, 'deletedk'])->name('deletedk');
// Route::post('/delete-keluarga/{{key}}', [KaryawansController::class, 'deletedk'])->name('deletedk');

// Tambah Data Keluarga saat data sudah di database / saat Show
Route::post('/storesdatakeluarga/{id}', [karyawansController::class, 'storedatakel'])->name('storedatakel');
// Edit Data Keluarga saat data sudah di database / saat Show
Route::put('/updateKeluarga/{id}', [karyawansController::class, 'updateKeluarga'])->name('updateKeluarga');
// Delete Keluarga saat show data
Route::get('/destroyKeluarga{id}', [karyawanController::class, 'destroyKeluarga'])->name('destroyKeluarga');



//form data kontak darurat
Route::get('/create-kontak-darurat', [KaryawansController::class, 'createkonrat'])->name('create.konrat');
Route::post('/storekontakdarurat', [KaryawansController::class, 'storekd'])->name('storekd');
Route::delete('/delete-kontakdarurat', [KaryawansController::class, 'deletekd'])->name('deletekd');
Route::post('/updatekontakdarurat', [KaryawansController::class, 'updatekd'])->name('updatekd');
// Tambah Data Kontak Darurat Karyawan saat data sudah di database / saat Show
Route::post('/storeskontakdarurat/{id}', [karyawansController::class, 'storekonrat'])->name('storekonrat');
// Edit Data Kontak Darurat saat data sudah di database / saat Show
Route::put('/updateKontak/{id}', [karyawansController::class, 'updateKontak'])->name('updateKontak');
// Delete Konrat saat show data
Route::get('/destroyKonrat{id}', [karyawanController::class, 'destroyKonrat'])->name('destroyKonrat');

// Route::post('/delete-kontak-darurat/{key}', [KeluargaController::class, 'deletedk'])->name('deletedk');

//form data pendidikan
Route::get('/create-data-pendidikan', [KaryawansController::class, 'creatependidikan'])->name('create.pendidikan');
Route::post('/storepformal', [karyawansController::class, 'storepformal'])->name('storepformal');
Route::post('/storepnformal', [karyawansController::class, 'storepformal'])->name('storepnformal');
Route::post('/updatependidikan', [KaryawansController::class, 'updaterPendidikan'])->name('updatePendidikan');
Route::delete('/delete-pendidikan', [KaryawansController::class, 'deletePendidikan'])->name('deletependidikan');

    // Show Pendidikan Karyawan 
    Route::get('showpendidikan{id}', [karyawanController::class, 'showpendidikan'])->name('showpendidikan');
    // Update saat data sudah di database
    Route::put('/updatePendidikan/{id}', [karyawansController::class, 'updatePendidikan'])->name('updatePendidikan');
    // Tambah Data Pendidikan Formal Karyawan saat data sudah di database / saat Show
    Route::post('addpformal{id}', [karyawanController::class, 'addpformal'])->name('addpformal');
    // Tambah Data Pendidikan nonFormal Karyawan saat data sudah di database / saat Show
    Route::post('/storespnformal/{id}', [karyawansController::class, 'storespformal'])->name('storespformal');
    // Delete Pendidikan
    Route::get('/destroyPendidikan{id}', [karyawanController::class, 'destroyPendidikan'])->name('destroyPendidikan');
    


//form data pekerjaan
Route::get('/create-data-pekerjaan', [KaryawansController::class, 'createpekerjaan'])->name('create.pekerjaan');
Route::post('/updatepekerjaan', [KaryawansController::class, 'updaterPekerjaan'])->name('updatePekerjaan');
Route::delete('/delete-pekerjaan', [KaryawansController::class, 'deletePekerjaan'])->name('deletepekerjaan');

// Tambah Data Pekerjaan saat data sudah di database / saat Show
Route::post('/storepekerjaan', [karyawansController::class, 'storepekerjaan'])->name('storepekerjaan');
// Show Data Pekerjaan
Route::get('showpekerjaan{id}', [karyawanController::class, 'showpekerjaan'])->name('showpekerjaan');
// Edit Data Pekerjaan saat data sudah di database / saat Show
Route::put('/updatePekerjaan/{id}', [karyawansController::class, 'updatePekerjaan'])->name('updatePekerjaan');
// Delete Pekerjaan
Route::get('/destroyPekerjaan{id}', [karyawanController::class, 'destroyPekerjaan'])->name('destroyPekerjaan');


//Form data organisasi
Route::get('/create-data-organisasi', [KaryawansController::class, 'createorganisasi'])->name('create.organisasi');
Route::post('/storeorganisasi', [karyawansController::class, 'storeorganisasi'])->name('storeorganisasi');
Route::post('/updateorganisasi', [KaryawansController::class, 'updaterOrganisasi'])->name('updateOrganisasi');
Route::delete('/delete-organisasi', [KaryawansController::class, 'deleteOrganisasi'])->name('deleteorganisasi');
// Tambah Data Organisasi saat data sudah di database / saat Show
Route::post('/storesorganisasi/{id}', [karyawansController::class, 'storesorganisasi'])->name('storesorganisasi');
// Edit Data Pekerjaan saat data sudah di database / saat Show
Route::put('/updateOrganisasi/{id}', [karyawansController::class, 'updateOrganisasi'])->name('updateOrganisasi');
// Delete Organisasi
Route::get('/destroyOrganisasi{id}', [karyawanController::class, 'destroyOrganisasi'])->name('destroyOrganisasi');

//form data prestasi
Route::get('/create-data-prestasi', [KaryawansController::class, 'createprestasi'])->name('create.prestasi');
Route::post('/storeprestasi', [karyawansController::class, 'storeprestasi'])->name('storeprestasi');
Route::post('/updateprestasi', [KaryawansController::class, 'updaterPrestasi'])->name('updaterPrestasi');
Route::delete('/delete-prestasi', [KaryawansController::class, 'deletePrestasi'])->name('deleteprestasi');

// Tambah Data Prestasi saat data sudah di database / saat Show
Route::post('/storesprestasi/{id}', [karyawansController::class, 'storesprestasi'])->name('storesprestasi');
// Edit Data Prestasi saat data sudah di database / saat Show
Route::put('/updatePrestasi/{id}', [karyawansController::class, 'updatePrestasi'])->name('updatePrestasi');
// Delete Prestasi
Route::get('/destroyPrestasi{id}', [karyawanController::class, 'destroyPrestasi'])->name('destroyPrestasi');

//form data prestasi
Route::get('/create-data-skeputusan', [KaryawansController::class, 'createskeputusan'])->name('create.skeputusan');
// Route::post('/storeprestasi', [karyawansController::class, 'storeprestasi'])->name('storeprestasi');
// Route::post('/updateprestasi', [KaryawansController::class, 'updaterPrestasi'])->name('updaterPrestasi');

//preview data dan save ke database
Route::get('/preview-data-karyawan', [KaryawansController::class, 'previewData'])->name('preview.data');
Route::post('/storeData', [KaryawansController::class, 'storetoDatabase'])->name('store.data.karyawan');

//update data
Route::put('/updateIdentitas/{id}', [karyawansController::class, 'update'])->name('identitas.update');

//store setelah show data
Route::post('/storespformal/{id}', [karyawansController::class, 'storespformal'])->name('storespformal');   
Route::post('/storespekerjaan/{id}', [karyawansController::class, 'storespekerjaan'])->name('storespekerjaan');

Route::get('/delete-pekerjaan/{id}', [karyawansController::class, 'destroy'])->name('destroy.pekerjaan');

//Kalender
Route::get('/kalender', [KalenderController::class, 'index'])->name('kalender');
Route::get('/get-harilibur-data', [KalenderController::class, 'getHarilibur'])->name('getharilibur'); //getdatajson untuk ditampilkan di kalender
Route::get('/manajemen-harilibur', [KalenderController::class, 'setting'])->name('setting.kalender');
Route::post('/store-kalender', [KalenderController::class, 'storeSetting'])->name('store.kalender');
Route::put('/update-kalender/{id}', [KalenderController::class, 'update'])->name('kalender.update');
Route::get('/delete-kalender/{id}', [KalenderController::class, 'destroy'])->name('kalender.delete');
Route::post('/store-kegiatan', [KalenderController::class, 'store'])->name('store.kegiatan');
Route::put('/update-kegiatan/{id}', [KalenderController::class, 'updatekegiatan'])->name('kegiatan.update');
Route::get('/delete-kegiatan/{id}', [KalenderController::class, 'delete'])->name('kegiatan.delete');

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

//Direktur
Route::get('/cutistaff', [DirekturController::class, 'index'])->name('cuti.Staff');
Route::post('/izinstaff/{id}', [DirekturController::class, 'izinApprove'])->name('izin.approv');
Route::post('/izinstaf/{id}', [DirekturController::class, 'izinRejected'])->name('permission.rejected');

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
<<<<<<< HEAD
=======








Route::post('/tarik-absen', [MesinController::class, 'tarikAbsen'])->name('tarik.absen');
>>>>>>> 001d96e173d1799fd783aa889c8e49b85859c6e3
