<?php

namespace App\Http\Controllers\admin;

use Carbon\Carbon;
use App\Models\Jeniscuti;
use App\Models\Departemen;
use Illuminate\Http\Request;
use App\Models\Settingalokasi;
use App\Http\Controllers\Controller;

class SettingalokasicutiController extends Controller
{
    public function index()
    {
        $id = Settingalokasi::find('id');
        $settingalokasi = Settingalokasi::all();

        //untuk edit
        $setal = Settingalokasi::find($id);
        $jeniscuti= Jeniscuti::all();
        $departemen = Departemen::all();
        return view('admin.settingcuti.setting_index', compact('settingalokasi','jeniscuti','setal','departemen'));
    } 


    public function store(Request $request)
    {
        // dd($request->all());
        $settingalokasi = New Settingalokasi;

        $settingalokasi->id_jeniscuti = $request->id_jeniscuti;
        $settingalokasi->durasi       = $request->durasi;
        $settingalokasi->mode_alokasi = $request->mode_alokasi;
        $settingalokasi->departemen   = $request->departemen; 

        $mode = implode(',', $request->mode_karyawan);
        $settingalokasi['mode_karyawan']= $mode;

        // dd($settingalokasi['mode_karyawan']);

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
