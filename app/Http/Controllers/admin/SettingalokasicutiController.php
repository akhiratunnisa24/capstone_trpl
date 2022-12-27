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
        if($request->mode_alokasi == 'Berdasarkan Departemen')
        {
            $validate = $request->validate([
                'id_jeniscuti' => 'required',
                'durasi'       => 'required',
                'mode_alokasi' => 'required',
                'departemen'   => 'required',
            ]);

            $settingalokasi = New Settingalokasi;
            $settingalokasi->id_jeniscuti = $request->id_jeniscuti;
            $settingalokasi->durasi       = $request->durasi;
            $settingalokasi->mode_alokasi = $request->mode_alokasi;
            $settingalokasi->departemen   = $request->departemen; 
            $settingalokasi->save();
        
            return redirect()->back()->withInput();
        }else{
            $validate = $request->validate([
                'id_jeniscuti' => 'required',
                'durasi'       => 'required',
                'mode_alokasi' => 'required',
                'mode_karyawan'=> 'required',
            ]);

            $settingalokasi = New Settingalokasi;
            $settingalokasi->id_jeniscuti = $request->id_jeniscuti;
            $settingalokasi->durasi       = $request->durasi;
            $settingalokasi->mode_alokasi = $request->mode_alokasi;
            $mode = implode(',', $request->mode_karyawan);
            $settingalokasi['mode_karyawan']= $mode;
            $settingalokasi->save();
        
            return redirect()->back()->withInput();
        }
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
