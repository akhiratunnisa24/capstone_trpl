<?php

namespace App\Http\Controllers\admin;

use Carbon\Carbon;
use App\Models\Karyawan;
use App\Models\Jeniscuti;
use App\Models\Departemen;
use App\Models\Alokasicuti;
use Illuminate\Http\Request;
use App\Models\Settingalokasi;
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
        if ($role == 1) {

            $id = Settingalokasi::find('id');
            $settingalokasi = Settingalokasi::orderBy('id', 'desc')->get();
            //untuk edit
            $setal = Settingalokasi::find($id);
            $jeniscuti = Jeniscuti::all();
            $departemen = Departemen::all();
            return view('admin.settingalokasi.setting_index', compact('settingalokasi', 'jeniscuti', 'setal', 'departemen', 'row'));
        } else {

            return redirect()->back();
        }
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $year = date('Y');

        if ($request->mode_alokasi == 'Berdasarkan Departemen') 
        {
            $validate = $request->validate([
                'id_jeniscuti' => 'required',
                'durasi'       => 'required',
                'mode_alokasi' => 'required',
                'departemen'   => 'required',
            ]);
            $cek = Settingalokasi::where('id_jeniscuti', $request->id_jeniscuti)->where('departemen', $request->departemen)->exists();
            if(!$cek)
            {
                $settingalokasi = new Settingalokasi;
                $settingalokasi->id_jeniscuti = $request->id_jeniscuti;
                $settingalokasi->durasi       = $request->durasi;
                $settingalokasi->mode_alokasi = $request->mode_alokasi;
                $settingalokasi->departemen   = $request->departemen;
                $settingalokasi->tipe_approval= $request->tipe_approval;
                $settingalokasi->save();

                $karyawan = Karyawan::where('divisi',$request->departemen)->get();
                foreach($karyawan as $karyawan)
                {
                    $check = Alokasicuti::where('id_jeniscuti',$settingalokasi->id_jeniscuti)->where('id_karyawan',$karyawan->id)->exists();
                    if(!$check)
                    {
                        $alokasicuti = new Alokasicuti;
                        $alokasicuti->id_karyawan      = $karyawan->id;
                        $alokasicuti->id_settingalokasi= $settingalokasi->id;
                        $alokasicuti->id_jeniscuti     = $request->id_jeniscuti;
                        $alokasicuti->durasi           = $request->durasi;
                        $alokasicuti->mode_alokasi     = $request->mode_alokasi;
                        $alokasicuti->tgl_masuk        = null;
                        $alokasicuti->tgl_sekarang     = null;
                        $alokasicuti->aktif_dari       = $year.'-01-01';
                        $alokasicuti->sampai           = $year.'-12-31';
                        $alokasicuti->status           = 1;
                        $alokasicuti->save();

                        Log::info('Data Alokasi Cuti Karyawan Berhasil Disimpan');
                    }else{
                        Log::info('DATA ALOKASI SUDAH ADA');
                    } 
                }
                return redirect()->route('setting_alokasi.index')->with('success', 'Data setting alokasi berhasil disimpan.');
            }else{
                // Log::info('DATA SETTING ALOKASI SUDAH ADA');
                return redirect()->route('setting_alokasi.index')->with('error', 'Data setting alokasi sudah ada.');
            }
        } else {
            $validate = $request->validate([
                'id_jeniscuti' => 'required',
                'durasi'       => 'required',
                'mode_alokasi' => 'required',
                'mode_karyawan' => 'required',
            ]);

            $settingalokasi = new Settingalokasi;
            $settingalokasi->id_jeniscuti = $request->id_jeniscuti;
            $settingalokasi->durasi       = $request->durasi;
            $settingalokasi->mode_alokasi = $request->mode_alokasi;
            $mode = implode(',', $request->mode_karyawan);
            $settingalokasi['mode_karyawan'] = $mode;
            $settingalokasi->tipe_approval= $request->tipe_approval;
            $settingalokasi->save();

            if($settingalokasi->id_jeniscuti != 1)
            {
                // $model = Settingalokasi::all();
                // foreach ($settingalokasi as $settingalokasi) {
                    $mode_karyawan_array = $settingalokasi->getModeKaryawanArrayAttribute();
                    // $mode_karyawan_array = $model->getModeKaryawanArrayAttribute();
                    // dd($mode_karyawan_array);
                // }

                $karyawan = DB::table('karyawan')
                ->join('keluarga','karyawan.id','keluarga.id_pegawai')
                ->where(function ($query) use ($request,$mode_karyawan_array){
                    if(in_array("L",$mode_karyawan_array)){
                        $query->orWhere('karyawan.jenis_kelamin','L');
                    }
                    if(in_array("P", $mode_karyawan_array)){
                        $query->orWhere('karyawan.jenis_kelamin','P');
                    }
                    if(in_array("Belum Menikah",$mode_karyawan_array)){
                        $query->orWhere('keluarga.status_pernikahan','Belum Menikah');
                    }
                    if(in_array("Sudah Menikah",$mode_karyawan_array)){
                        $query->orWhere('keluarga.status_pernikahan','Sudah Menikah');
                    }
                })
                ->select('karyawan.id','karyawan.jenis_kelamin','keluarga.status_pernikahan')
                ->get();

                // dd($karyawan);

                foreach($karyawan as $karyawan)
                {
                    $check = Alokasicuti::where('id_jeniscuti',$settingalokasi->id_jeniscuti)->where('id_karyawan',$karyawan->id)->exists();
                    if(!$check)
                    {
                        $alokasicuti = new Alokasicuti;
                        $alokasicuti->id_karyawan      = $karyawan->id;
                        $alokasicuti->id_settingalokasi= $settingalokasi->id;
                        $alokasicuti->id_jeniscuti     = $request->id_jeniscuti;
                        $alokasicuti->durasi           = $request->durasi;
                        $alokasicuti->mode_alokasi     = $request->mode_alokasi;
                        $alokasicuti->tgl_masuk        = null;
                        $alokasicuti->tgl_sekarang     = null;
                        $alokasicuti->aktif_dari       = $year.'-01-01';
                        $alokasicuti->sampai           = $year.'-12-31';
                        $alokasicuti->status           = 1;
                        $alokasicuti->save();
                    }else
                    {
                        Log::info('data alokasi cuti sudah ada');
                    }
                }
                return redirect()->back()->withInput();
            }else{
                //untuk id_jeniscuti ==1
                $datakaryawan = DB::table('karyawan')
                             ->whereRaw("MONTH(NOW()) - MONTH(tglmasuk) >= 12")
                             ->orWhereRaw("MONTH(NOW()) - MONTH(tglmasuk) < 12")
                             ->get();

                foreach($datakaryawan as $karyawan)
                {
                    $check = Alokasicuti::where('id_jeniscuti',$settingalokasi->id_jeniscuti)->where('id_karyawan',$karyawan->id)->exists();
                    if(!$check)
                    {
                        $alokasicuti = new Alokasicuti;
                        $alokasicuti->id_karyawan      = $karyawan->id;
                        $alokasicuti->id_settingalokasi= $settingalokasi->id;
                        $alokasicuti->id_jeniscuti     = $request->id_jeniscuti;

                        $now = Carbon::now();
                        $diffInMonths = $now->diffInMonths($karyawan->tglmasuk);

                        if($diffInMonths >= 12){
                            $alokasicuti->durasi = 12;
                        }else{
                            $alokasicuti->durasi = $diffInMonths;
                        }
                    
                        $alokasicuti->mode_alokasi     = $request->mode_alokasi;
                        $alokasicuti->tgl_masuk        = $karyawan->tglmasuk;
                        $alokasicuti->tgl_sekarang     = $now;
                        $alokasicuti->aktif_dari       = $year.'-01-01';
                        $alokasicuti->sampai           = $year.'-12-31';
                        $alokasicuti->status           = 1;
                        $alokasicuti->save();
                    }else
                    {
                        Log::info('KARYAWAN DENGAN ID DAN ID_JENISCUTI SUDAH MEMILIKI JATAH CUTI TAHUNAN');
                    }
                }
                return redirect()->back()->withInput();
            }

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
                'mode_alokasi' => 'required',
                'departemen'   => 'required',
            ]);

            $settingalokasi->id_jeniscuti = $request->id_jeniscuti;
            $settingalokasi->durasi       = $request->durasi;
            $settingalokasi->mode_alokasi = $request->mode_alokasi;
            $settingalokasi->departemen   = $request->departemen;
            $settingalokasi->tipe_approval= $request->tipe_approval;

            $settingalokasi->update();
            // dd($settingalokasi);

        } else {
            $validate = $request->validate([
                'id_jeniscuti' => 'required',
                'durasi'       => 'required',
                'mode_alokasi' => 'required',
                'mode_karyawan' => 'required',
            ]);
            $settingalokasi->id_jeniscuti = $request->id_jeniscuti;
            $settingalokasi->durasi       = $request->durasi;
            $settingalokasi->mode_alokasi = $request->mode_alokasi;
            $mode = implode(',', $request->mode_karyawan);
            $settingalokasi['mode_karyawan'] = $mode;
            $settingalokasi->tipe_approval= $request->tipe_approval;
            $settingalokasi->update();
        }
        return redirect('/settingalokasi');
    }

    public function destroy($id)
    {
        $settingalokasi = Settingalokasi::find($id);
        $settingalokasi->delete();

        return redirect('/settingalokasi');
    }
}