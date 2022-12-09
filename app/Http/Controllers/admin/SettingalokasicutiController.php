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
        $jeniscuti= Jeniscuti::all();
        return view('admin.settingcuti.setting_index', compact('jeniscuti'));
    } 

    public function store(Request $request)
    {
        $settingalokasi = New Settingalokasi;
        $settingalokasi->id_jeniscuti= $request->id_jeniscuti;
        $settingalokasi->tipe_alokasi= $request->tipe_alokasi;
        $settingalokasi->durasi      = $request->durasi;
        $settingalokasi->mode_alokasi= $request->mode_alokasi;
        $settingalokasi->departemen   = $request->departemen; 
        $settingalokasi->mode_karyawan=$request->mode_karyawan;
        $settingalokasi->jenis_kelamin=$request->jenis_kelamin; 
        $settingalokasi->status_pernikahan= $request->status; 
        $settingalokasi->save();
         dd($settingalokasi);
        return redirect()->back()->withInput();
       
        // if(isset($request->mode_alokasi) === 'Berdasarkan Karyawan')
        // {
        //     // dd($reques);
        //     if($request->mode_karyawan ='Jenis Kelamin')
        //     {
        //         $validate = $request->validate([
        //             'id_jeniscuti' => 'required',
        //             'tipe_alokasi' => 'required',
        //             'durasi'       => 'required',
        //             'mode_alokasi' => 'required',
        //             'mode_karyawan'=> 'required',
        //             'jenis_kelamin'=> 'required',
        //         ]);
            
        //     // dd($validate);
        //     $settingalokasi = New Settingalokasi;
        //     $settingalokasi->id_jeniscuti= $request->id_jeniscuti;
        //     $settingalokasi->tipe_alokasi= $request->tipe_alokasi;
        //     $settingalokasi->durasi      = $request->durasi;
        //     $settingalokasi->mode_alokasi= $request->mode_alokasi;
        //     $settingalokasi->mode_karyawan=$request->mode_karyawan;
        //     $settingalokasi->jenis_kelamin=$request->jenis_kelamin; 
        //     $settingalokasi->save();
        //      // dd($settingalokasi);
        //     return redirect()->back()->withInput();

        //     } else
        //         {
        //             $validate = $request->validate([
        //                 'id_jeniscuti' => 'required',
        //                 'tipe_alokasi' => 'required',
        //                 'durasi'       => 'required',
        //                 'mode_alokasi' => 'required',
        //                 'mode_karyawan'=> 'required',
        //                 'status'       => 'required',
        //             ]);
        //         // dd($validate);
        //             $settingalokasi = New Settingalokasi;
        //             $settingalokasi->id_jeniscuti = $request->id_jeniscuti;
        //             $settingalokasi->tipe_alokasi = $request->tipe_alokasi;
        //             $settingalokasi->durasi       = $request->durasi;
        //             $settingalokasi->mode_alokasi = $request->mode_alokasi;
        //             $settingalokasi->mode_karyawan= $request->mode_karyawan;
        //             $settingalokasi->status       = $request->status; 
        //             $settingalokasi->save();
        //             // dd($settingalokasi);
        //             return redirect()->back()->withInput();
        //         }
        // }else
        // {
        //     $validate = $request->validate([
        //         'id_jeniscuti' => 'required',
        //         'tipe_alokasi' => 'required',
        //         'durasi'       => 'required',
        //         'mode_alokasi' => 'required',
        //         'departemen'   => 'required',
        //     ]);
        //     //  dd($validate);
        //     $settingalokasi = New Settingalokasi;
        //     $settingalokasi->id_jeniscuti = $request->id_jeniscuti;
        //     $settingalokasi->tipe_alokasi = $request->tipe_alokasi;
        //     $settingalokasi->durasi       = $request->durasi;
        //     $settingalokasi->mode_alokasi = $request->mode_alokasi;
        //     $settingalokasi->departemen   = $request->departemen; 
        //     $settingalokasi->save();
        //     // dd($settingalokasi);
        //     return redirect()->back()->withInput();
        // }     
    }
}
