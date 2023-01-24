<?php

namespace App\Http\Controllers\admin;

use Carbon\Carbon;
use App\Models\Jeniscuti;
use App\Models\Departemen;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use App\Models\Settingalokasi;
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