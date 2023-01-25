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
            $settingalokasi = Settingalokasi::orderBy('id', 'asc')->get();
            //untuk edit
            $setal = Settingalokasi::find($id);
            $jeniscuti = Jeniscuti::all();
            $departemen = Departemen::all();
            return view('admin.settingcuti.setting_index', compact('settingalokasi', 'jeniscuti', 'setal', 'departemen', 'row'));
        } else {

            return redirect()->back();
        }
    }


    public function store(Request $request)
    {
        // dd($request->all());
        $year = date('Y');

        if ($request->mode_alokasi == 'Berdasarkan Departemen') {
            $validate = $request->validate([
                'id_jeniscuti' => 'required',
                'durasi'       => 'required',
                'mode_alokasi' => 'required',
                'departemen'   => 'required',
            ]);

            $settingalokasi = new Settingalokasi;
            $settingalokasi->id_jeniscuti = $request->id_jeniscuti;
            $settingalokasi->durasi       = $request->durasi;
            $settingalokasi->mode_alokasi = $request->mode_alokasi;
            $settingalokasi->departemen   = $request->departemen;
            $settingalokasi->save();

            $karyawan = Karyawan::where('divisi',$request->departemen)->get();
            foreach($karyawan as $karyawan)
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
                $alokasicuti->save();
            }
            return redirect()->back()->withInput();
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
            $settingalokasi->save();


            //whereIn('price', [150, 200]);

            $karyawan = DB::table('karyawan')
            ->join('keluarga','karyawan.id','=','keluarga.id_pegawai')
            ->whereIn('karyawan.jenis_kelamin','=',$request->mode_karyawan)
            ->orWhere('keluarga.status_pernikahan','=',$request->mode_karyawan)
            ->select('karyawan.*','keluarga.id_karyawan','karyawan.status_pernikahan')
            ->distinct()
            ->get();

            if($request->id_jeniscuti != 1)
            {
                foreach($karyawan as $karyawan)
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
                    $alokasicuti->save();
                }
            }

            return redirect()->back()->withInput();
        }
    }

    public function show($id)
    {
        $settingalokasi = Settingalokasi::find($id);
        return view('admin.settingcuti.showsetting', compact('settingalokasi'));
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