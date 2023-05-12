<?php

namespace App\Http\Controllers\admin;

use Carbon\Carbon;
use App\Models\Karyawan;
use App\Models\Jeniscuti;
use App\Models\Departemen;
use App\Models\Alokasicuti;
use Illuminate\Http\Request;
use App\Models\Settingalokasi;
use App\Models\SettingHarilibur;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SettingalokasicutiController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
        $role = Auth::user()->role;
        if ($role == 1 || $role == 2) {

            $id = Settingalokasi::find('id');
            $settingalokasi = Settingalokasi::where('status', true)->get();

            //untuk edit
            $setal = Settingalokasi::find($id);
            $jeniscuti = Jeniscuti::where('status', true)->get();
            $departemen = Departemen::all();

            return view('admin.settingalokasi.setting_index', compact('settingalokasi', 'jeniscuti', 'setal', 'departemen', 'row'));
        } else {

            return redirect()->back();
        }
    }

    public function store(Request $request)
    {

        // dd($request->id_jeniscuti);
        $year = date('Y');

        if ($request->id_jeniscuti != 1) 
        {
            $validate = $request->validate([
                'id_jeniscuti' => 'required',
                'mode_karyawan' => 'required',
            ]);

            $settingalokasi = new Settingalokasi;
            $settingalokasi->id_jeniscuti = $request->id_jeniscuti;
            $settingalokasi->durasi       = 0;
            $mode = implode(',', $request->mode_karyawan);
            $settingalokasi['mode_karyawan']        = $mode;
            $settingalokasi->cuti_bersama_terhutang = null;
            $settingalokasi->periode = $year;
            $settingalokasi->status  = 1;

            $settingalokasi->save();

            $mode_karyawan_array = $settingalokasi->getModeKaryawanArrayAttribute();

            $karyawan = DB::table('karyawan')
                ->where(function ($query) use ($request, $mode_karyawan_array) {
                    if (in_array("Perempuan", $mode_karyawan_array) && in_array("Sudah Menikah", $mode_karyawan_array)) {
                        $query->orWhere(function ($q) {
                            $q->where('jenis_kelamin', 'Perempuan')
                                ->where('status_pernikahan', 'Sudah Menikah');
                        });
                    }

                    if (in_array("Semua Karyawan", $mode_karyawan_array)) {
                        $query->orWhere(function($q) {
                            $q->where('jenis_kelamin', 'Laki-Laki')
                            ->orWhere('jenis_kelamin', 'Perempuan');
                        });
                    }
            })
            ->select('id', 'jenis_kelamin', 'status_pernikahan','nip','nama_jabatan','divisi')
            ->get();
            //  if(in_array("Laki-Laki", $mode_karyawan_array)){
                //     $query->orWhere('jenis_kelamin', 'Laki-Laki');
                // }
                
                // if(in_array("Belum Menikah", $mode_karyawan_array)){
                //     $query->orWhere('status_pernikahan', 'Belum Menikah');
                // }
            
                // if(in_array("Duda", $mode_karyawan_array)){
                //     $query->orWhere('status_pernikahan', 'Duda');
                // }
                // if(in_array("Janda", $mode_karyawan_array)){
                //     $query->orWhere('status_pernikahan', 'Janda');
                // }

            // return $karyawan;
            foreach ($karyawan as $karyawan) {
                $check = Alokasicuti::where('id_jeniscuti', $settingalokasi->id_jeniscuti)
                    ->where('id_karyawan', $karyawan->id)
                    ->whereYear('aktif_dari', '=', $year)
                    ->exists();
                if (!$check) {

                    $alokasicuti = new Alokasicuti;
                    $alokasicuti->nik              = $karyawan->nip;
                    $alokasicuti->id_karyawan      = $karyawan->id;
                    $alokasicuti->jabatan          = $karyawan->nama_jabatan;
                    $alokasicuti->departemen       = $karyawan->divisi;
                    $alokasicuti->id_settingalokasi = $settingalokasi->id;
                    $alokasicuti->id_jeniscuti     = $request->id_jeniscuti;
                    $alokasicuti->durasi           = 0;
                    $alokasicuti->status_durasialokasi = null;
                    $alokasicuti->tgl_masuk        = null;
                    $alokasicuti->tgl_sekarang     = null;
                    $alokasicuti->aktif_dari       = $year . '-01-01';
                    $alokasicuti->sampai           = $year . '-12-31';
                    $alokasicuti->status           = 1;
                    $alokasicuti->save();
                } else {
                    Log::info('data alokasi cuti sudah ada');
                }
            }
            return redirect()->back()->withInput();
        } else 
        {
            $validate = $request->validate([
                'id_jeniscuti' => 'required',
                'durasi'       => 'required',
                'mode_karyawans' => 'required',
                'cuti_bersama_terhutang' => 'required',
            ]);

            $settingalokasi = new Settingalokasi;
            $settingalokasi->id_jeniscuti  = $request->id_jeniscuti;
            $settingalokasi->durasi        = $request->durasi;
            $settingalokasi->mode_karyawan = $request->mode_karyawans;
            $settingalokasi->cuti_bersama_terhutang = $request->cuti_bersama_terhutang;
            $settingalokasi->periode       = $year;
            $settingalokasi->status        = 1;

            $settingalokasi->save();

            $dataKaryawan = Karyawan::all();

            $hasil = $dataKaryawan->map(function ($karyawan) use ($settingalokasi) {

                $tglMasuk      = Carbon::parse($karyawan->tglmasuk); // Parse tanggal masuk karyawan menjadi objek Carbon
                $tglJatuhTempo = $tglMasuk->copy()->addDays(365);
                $year          = Carbon::now()->year;
                $tglHakCutiTahunan = Carbon::createFromDate($year, 12, 31);

                $selisih    = $tglJatuhTempo->diffInMonths($tglHakCutiTahunan, false);
                if ($tglMasuk->format('m-d') == '01-01') {
                    $tglHakCutiTahunan = Carbon::createFromDate($year + 1, 1, 1);
                    $selisih    = $tglJatuhTempo->diffInMonths($tglHakCutiTahunan, true);
                }else{
                    $selisih = $selisih;
                }

                $keterangan = "";
                $cutidimuka = 0;

                //cek cuti bersama ke daftar hari libur 
                $settinglibur = SettingHarilibur::where('tipe', '=', 'Cuti Bersama')
                    ->whereYear('tanggal', '=', Carbon::now()->year)
                    ->get();

                $jumsetting = $settinglibur->count();
                // $jum        = -1* abs($jumsetting);
                $jum = 0;

                $cutiminus = Alokasicuti::where('durasi', '<', 0)
                    ->whereYear('aktif_dari', '=', Carbon::now()->subMonth()->year)
                    ->where('id_karyawan', '=', $karyawan->id)
                    ->select('durasi')
                    ->get();

                $cutmin = $cutiminus->sum('durasi');

                if ($selisih >= 12) {
                    $selisih    = 12;
                    $keterangan = "Karyawan Lama";
                    // $cutidimuka = 0;
                    // $jum = $jum;
                    $cutmin = $cutmin;
                    $aktifdari = $year . '-01-01';
                    $sampai    = $year . '-12-31';
                    // $saldo   = $selisih - abs($cutmin) - abs($jum);
                } elseif ($selisih > 0 && $selisih < 12) {

                    if($tglMasuk->format('m-d') == '02-01'){
                        $selisih = 11 ;
                    }
                    elseif($tglMasuk->format('m-d') == '03-01'){
                        $selisih = 10 ;
                       
                    }
                    elseif($tglMasuk->format('m-d') == '04-01'){
                        $selisih = 9 ;
                    }
                    elseif($tglMasuk->format('m-d') == '05-01'){
                        $selisih = 8 ;
                    }
                    elseif($tglMasuk->format('m-d') == '06-01'){
                        $selisih = 7 ;
                    }
                    elseif($tglMasuk->format('m-d') == '07-01'){
                        $selisih = 6 ;
                    }
                    elseif($tglMasuk->format('m-d') == '08-01'){
                        $selisih = 5 ;
                    }
                    elseif($tglMasuk->format('m-d') == '09-01'){
                        $selisih = 4 ;
                    }
                    elseif($tglMasuk->format('m-d') == '10-01'){
                        $selisih = 3 ;
                    }
                    elseif($tglMasuk->format('m-d') == '11-01'){
                        $selisih = 2 ;
                    }
                    elseif($tglMasuk->format('m-d') == '12-01'){
                        $selisih = 1 ;
                    }else{
                        $selisih = $selisih;
                    }
                   
                    $keterangan = "Karyawan Baru (Transisi)";
                    // $cutidimuka = -1*abs(12);
                    // $jum = $jum;
                    $cutmin = 0;

                    // $jatuhtempo = $tglJatuhTempo->addDays();
                    // $tgljatuhtempo =  $jatuhtempo->format('-m-d');
                    $tgljatuhtempo = $tglJatuhTempo->format('-m-d');
                    $aktifdari = $year . $tgljatuhtempo;
                    $sampai    = $year . '-12-31';
                    // dd($selisih);
                    // $saldo   = $selisih - abs($cutidimuka) - abs($cutmin) - abs($jum);
                } else {
                    $selisih   = 0;
                    $keterangan = "Hak Cuti Belum Timbul";
                    // $cutidimuka = 0;
                    // $jum = 0;
                    $cutmin = 0;
                    // $saldo   = 0;
                    // return $saldo;
                    $aktifdari = null;
                    $sampai = null;
                }
                $saldo   = $selisih - abs($cutidimuka) - abs($cutmin) - abs($jum);

                // Menambahkan data ke dalam tabel alokasicuti
                // $check = Alokasicuti::where('id_jeniscuti', $settingalokasi->id_jeniscuti)
                //     ->where('id_karyawan', $karyawan->id)
                //     ->whereYear('aktif_dari', '=', $year)
                //     ->exists();
                $check = Alokasicuti::where('id_jeniscuti', $settingalokasi->id_jeniscuti)
                    ->where('id_karyawan', $karyawan->id)
                    ->where(function ($query) {
                        $query->whereYear('aktif_dari', '=', Carbon::now()->year)
                              ->orWhereNull('aktif_dari');
                    })
                    ->exists();

                if(!$check) 
                {
                    $alokasicuti                    = new Alokasicuti();
                    $alokasicuti->nik               = $karyawan->nip;
                    $alokasicuti->id_karyawan       = $karyawan->id;
                    $alokasicuti->jabatan           = $karyawan->nama_jabatan;
                    $alokasicuti->departemen        = $karyawan->divisi;
                    $alokasicuti->id_settingalokasi = $settingalokasi->id;
                    $alokasicuti->id_jeniscuti      = $settingalokasi->id_jeniscuti;
                    $alokasicuti->tgl_masuk          = $karyawan->tglmasuk;
                    $alokasicuti->tgl_sekarang      = $year . '-01-01';
                    $alokasicuti->jatuhtempo_awal   = $tglJatuhTempo->format('Y-m-d');
                    $alokasicuti->jatuhtempo_akhir  = $tglJatuhTempo->year . '-12-31';
                    $alokasicuti->jmlhakcuti        = $selisih;
                    $alokasicuti->cutidimuka        = $cutidimuka;
                    $alokasicuti->cutiminus         = $cutmin;
                    $alokasicuti->jmlcutibersama    = $jum;
                    $alokasicuti->durasi            = $saldo;
                    $alokasicuti->keterangan        = $keterangan;
                    $alokasicuti->aktif_dari        = $aktifdari;
                    $alokasicuti->sampai            = $sampai;
                    $alokasicuti->status            = 1;

                    $alokasicuti->save();

                }else{
                    Log::info('data alokasi cuti keguguran /bersalin sudah ada');
                }
            });

            // return $hasil;
            return redirect()->back()->withInput();
        }
    }

    public function show($id)
    {
        $settingalokasi = Settingalokasi::find($id);
        return view('admin.settingalokasi.showsetting', compact('settingalokasi'));
    }

    public function update(Request $request, $id)
    {
        $settingalokasi = Settingalokasi::find($id);
        if ($request->mode_alokasi == 'Berdasarkan Departemen') {
            // dd($settingalokasi->departemen);
            $validate = $request->validate([
                'id_jeniscuti' => 'required',
                'durasi'       => 'required',
            ]);

            $settingalokasi->id_jeniscuti = $request->id_jeniscuti;
            $settingalokasi->durasi       = $request->durasi;
            $settingalokasi->tipe_alokasi = $request->tipe_alokasi;

            $settingalokasi->update();
            // dd($settingalokasi);

        } else {
            $validate = $request->validate([
                'id_jeniscuti' => 'required',
                'durasi'       => 'required',
                'mode_karyawan' => 'required',
            ]);
            $settingalokasi->id_jeniscuti = $request->id_jeniscuti;
            $settingalokasi->durasi       = $request->durasi;
            $mode = implode(',', $request->mode_karyawan);
            $settingalokasi['mode_karyawan'] = $mode;
            $settingalokasi->update();
        }
        return redirect()->back();
    }

    public function destroy($id)
    {
        $settingalokasi = Settingalokasi::find($id);
        $settingalokasi->delete();

        return redirect()->back();
    }
}

     // $karyawan = DB::table('karyawan')
            // ->join('keluarga','karyawan.id','keluarga.id_pegawai')
            // ->where(function ($query) use ($request,$mode_karyawan_array){
            //     if(in_array("Laki-Laki",$mode_karyawan_array)){
            //         $query->orWhere('karyawan.jenis_kelamin','Laki-Laki');
            //     }
            //     if(in_array("Perempuan", $mode_karyawan_array)){
            //         $query->orWhere('karyawan.jenis_kelamin','Perempuan');
            //     }
            //     if(in_array("Belum Menikah",$mode_karyawan_array)){
            //         $query->orWhere('keluarga.status_pernikahan','Belum Menikah');
            //     }
            //     if(in_array("Sudah Menikah",$mode_karyawan_array)){
            //         $query->orWhere('keluarga.status_pernikahan','Sudah Menikah');
            //     }
            //     if(in_array("Duda",$mode_karyawan_array)){
            //         $query->orWhere('keluarga.status_pernikahan','Duda');
            //     }
            //     if(in_array("Janda",$mode_karyawan_array)){
            //         $query->orWhere('keluarga.status_pernikahan','Janda');
            //     }
            // })
            // ->select('karyawan.id','karyawan.jenis_kelamin','keluarga.status_pernikahan')
            // ->get();

    // public function stores(Request $request)
    // {
    //     // dd($request->all());
    //     $year = date('Y');

    //     if ($request->mode_alokasi == 'Berdasarkan Departemen') 
    //     {
    //         $validate = $request->validate([
    //             'id_jeniscuti' => 'required',
    //             'durasi'       => 'required',
    //             'mode_alokasi' => 'required',
    //             'departemen'   => 'required',
    //         ]);
    //         $cek = Settingalokasi::where('id_jeniscuti', $request->id_jeniscuti)->where('departemen', $request->departemen)->exists();
    //         if(!$cek)
    //         {
    //             $settingalokasi = new Settingalokasi;
    //             $settingalokasi->id_jeniscuti = $request->id_jeniscuti;
    //             $settingalokasi->durasi       = $request->durasi;
    //             $settingalokasi->mode_alokasi = $request->mode_alokasi;
    //             $settingalokasi->departemen   = $request->departemen;
    //             $settingalokasi->tipe_approval= $request->tipe_approval;
    //             $settingalokasi->save();

    //             $karyawan = Karyawan::where('divisi',$request->departemen)->get();
    //             foreach($karyawan as $karyawan)
    //             {
    //                 $check = Alokasicuti::where('id_jeniscuti',$settingalokasi->id_jeniscuti)->where('id_karyawan',$karyawan->id)->exists();
    //                 if(!$check)
    //                 {
    //                     $alokasicuti = new Alokasicuti;
    //                     $alokasicuti->id_karyawan      = $karyawan->id;
    //                     $alokasicuti->id_settingalokasi= $settingalokasi->id;
    //                     $alokasicuti->id_jeniscuti     = $request->id_jeniscuti;
    //                     $alokasicuti->durasi           = $request->durasi;
    //                     $alokasicuti->mode_alokasi     = $request->mode_alokasi;
    //                     $alokasicuti->tgl_masuk        = null;
    //                     $alokasicuti->tgl_sekarang     = null;
    //                     $alokasicuti->aktif_dari       = $year.'-01-01';
    //                     $alokasicuti->sampai           = $year.'-12-31';
    //                     $alokasicuti->status           = 1;
    //                     $alokasicuti->save();

    //                     Log::info('Data Alokasi Cuti Karyawan Berhasil Disimpan');
    //                 }else{
    //                     Log::info('DATA ALOKASI SUDAH ADA');
    //                 } 
    //             }
    //             return redirect()->route('setting_alokasi.index')->with('success', 'Data setting alokasi berhasil disimpan.');
    //         }else{
    //             // Log::info('DATA SETTING ALOKASI SUDAH ADA');
    //             return redirect()->route('setting_alokasi.index')->with('error', 'Data setting alokasi sudah ada.');
    //         }
    //     } else {
    //         $validate = $request->validate([
    //             'id_jeniscuti' => 'required',
    //             'durasi'       => 'required',
    //             'mode_alokasi' => 'required',
    //             'mode_karyawan' => 'required',
    //         ]);

    //         $settingalokasi = new Settingalokasi;
    //         $settingalokasi->id_jeniscuti = $request->id_jeniscuti;
    //         $settingalokasi->durasi       = $request->durasi;
    //         $settingalokasi->mode_alokasi = $request->mode_alokasi;
    //         $mode = implode(',', $request->mode_karyawan);
    //         $settingalokasi['mode_karyawan'] = $mode;
    //         $settingalokasi->tipe_approval= $request->tipe_approval;
    //         $settingalokasi->save();

    //         if($settingalokasi->id_jeniscuti != 1)
    //         {
    //             // $model = Settingalokasi::all();
    //             // foreach ($settingalokasi as $settingalokasi) {
    //                 $mode_karyawan_array = $settingalokasi->getModeKaryawanArrayAttribute();
    //                 // $mode_karyawan_array = $model->getModeKaryawanArrayAttribute();
    //                 // dd($mode_karyawan_array);
    //             // }

    //             $karyawan = DB::table('karyawan')
    //             ->join('keluarga','karyawan.id','keluarga.id_pegawai')
    //             ->where(function ($query) use ($request,$mode_karyawan_array){
    //                 if(in_array("L",$mode_karyawan_array)){
    //                     $query->orWhere('karyawan.jenis_kelamin','L');
    //                 }
    //                 if(in_array("P", $mode_karyawan_array)){
    //                     $query->orWhere('karyawan.jenis_kelamin','P');
    //                 }
    //                 if(in_array("Belum Menikah",$mode_karyawan_array)){
    //                     $query->orWhere('keluarga.status_pernikahan','Belum Menikah');
    //                 }
    //                 if(in_array("Sudah Menikah",$mode_karyawan_array)){
    //                     $query->orWhere('keluarga.status_pernikahan','Sudah Menikah');
    //                 }
    //             })
    //             ->select('karyawan.id','karyawan.jenis_kelamin','keluarga.status_pernikahan')
    //             ->get();

    //             // dd($karyawan);

    //             foreach($karyawan as $karyawan)
    //             {
    //                 $check = Alokasicuti::where('id_jeniscuti',$settingalokasi->id_jeniscuti)->where('id_karyawan',$karyawan->id)->exists();
    //                 if(!$check)
    //                 {
    //                     $alokasicuti = new Alokasicuti;
    //                     $alokasicuti->id_karyawan      = $karyawan->id;
    //                     $alokasicuti->id_settingalokasi= $settingalokasi->id;
    //                     $alokasicuti->id_jeniscuti     = $request->id_jeniscuti;
    //                     $alokasicuti->durasi           = $request->durasi;
    //                     $alokasicuti->mode_alokasi     = $request->mode_alokasi;
    //                     $alokasicuti->tgl_masuk        = null;
    //                     $alokasicuti->tgl_sekarang     = null;
    //                     $alokasicuti->aktif_dari       = $year.'-01-01';
    //                     $alokasicuti->sampai           = $year.'-12-31';
    //                     $alokasicuti->status           = 1;
    //                     $alokasicuti->save();
    //                 }else
    //                 {
    //                     Log::info('data alokasi cuti sudah ada');
    //                 }
    //             }
    //             return redirect()->back()->withInput();
    //         }else{
    //             //untuk id_jeniscuti ==1
    //             $datakaryawan = DB::table('karyawan')
    //                          ->whereRaw("MONTH(NOW()) - MONTH(tglmasuk) >= 12")
    //                          ->orWhereRaw("MONTH(NOW()) - MONTH(tglmasuk) < 12")
    //                          ->get();

    //             foreach($datakaryawan as $karyawan)
    //             {
    //                 $check = Alokasicuti::where('id_jeniscuti',$settingalokasi->id_jeniscuti)->where('id_karyawan',$karyawan->id)->exists();
    //                 if(!$check)
    //                 {
    //                     $alokasicuti = new Alokasicuti;
    //                     $alokasicuti->id_karyawan      = $karyawan->id;
    //                     $alokasicuti->id_settingalokasi= $settingalokasi->id;
    //                     $alokasicuti->id_jeniscuti     = $request->id_jeniscuti;

    //                     $now = Carbon::now();
    //                     $diffInMonths = $now->diffInMonths($karyawan->tglmasuk);

    //                     if($diffInMonths >= 12){
    //                         $alokasicuti->durasi = 12;
    //                     }else{
    //                         $alokasicuti->durasi = $diffInMonths;
    //                     }
                    
    //                     $alokasicuti->mode_alokasi     = $request->mode_alokasi;
    //                     $alokasicuti->tgl_masuk        = $karyawan->tglmasuk;
    //                     $alokasicuti->tgl_sekarang     = $now;
    //                     $alokasicuti->aktif_dari       = $year.'-01-01';
    //                     $alokasicuti->sampai           = $year.'-12-31';
    //                     $alokasicuti->status           = 1;
    //                     $alokasicuti->save();
    //                 }else
    //                 {
    //                     Log::info('KARYAWAN DENGAN ID DAN ID_JENISCUTI SUDAH MEMILIKI JATAH CUTI TAHUNAN');
    //                 }
    //             }
    //             return redirect()->back()->withInput();
    //         }

    //     }
    // }