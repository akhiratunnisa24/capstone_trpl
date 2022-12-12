<?php

namespace App\Http\Controllers\admin;

use Carbon\Carbon;
use App\Models\Jeniscuti;
use Illuminate\Http\Request;
use App\Models\Settingalokasi;
use App\Http\Controllers\Controller;

class SettingalokasicutiController extends Controller
{
    public function index()
    {
        $settingalokasi = Settingalokasi::all();
        $jeniscuti= Jeniscuti::all();
        return view('admin.settingcuti.setting_index', compact('settingalokasi','jeniscuti'));
    } 

    public function store(Request $request)
    {
        // dd($request->all());
        $settingalokasi = New Settingalokasi;

        $settingalokasi->id_jeniscuti = $request->id_jeniscuti;
        $settingalokasi->tipe_alokasi = $request->tipe_alokasi;
        $settingalokasi->durasi       = $request->durasi;
        $settingalokasi->mode_alokasi = $request->mode_alokasi;
        $settingalokasi->departemen   = $request->departemen; 
        $settingalokasi['mode_karyawan']= json_encode($request->mode_karyawan);

        $settingalokasi->save();
        
        return redirect()->back()->withInput();
    }

    public function show($id)
    {
        $settingalokasi = Settingalokasi::find($id);
        return view('admin.settingcuti.showsetting',compact('settingalokasi'));
    }

    public function update(Request $request, $id)
    {
        $settingalokasi = Settingalokasi::find($id);
        $settingalokasi->update($request->all());

        return redirect('/settingalokasi');
    }

    public function destroy($id)
    {
        $settingalokasi = Settingalokasi::find($id);
        $settingalokasi->delete();

        return redirect('/settingalokasi');
    }
}
