<?php

namespace App\Http\Controllers\admin;

use App\Models\User;
use App\Models\Karyawan;
use App\Models\Jeniscuti;
use App\Models\Alokasicuti;
use Illuminate\Http\Request;
use App\Models\Settingalokasi;
use App\Imports\AlokasicutiImport;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class AlokasicutiController extends Controller
{
    public function index()
    {
        $jenis_cuti = Jeniscuti::all();

        //create
        $settingalokasi = Settingalokasi::all();
        $jeniscuti= DB::table('settingalokasi')
        ->join('jeniscuti', 'settingalokasi.id_jeniscuti','=','jeniscuti.id')
        ->get();
        $karyawan = Karyawan::all();
        return view('admin.alokasicuti.index', compact('jeniscuti','karyawan','jenis_cuti','settingalokasi'));
    }

    public function store(Request $request)
    {
        $alokasicuti = New Alokasicuti;
        $alokasicuti->id_pegawai   = $request->id_pegawai;
        $alokasicuti->id_jeniscuti = $request->id_jeniscuti;
        $alokasicuti->durasi       = $request->durasi;
        $alokasicuti->mode_alokasi = $request->mode_alokasi;
        $alokasicuti->tgl_masuk    = $request->tgl_masuk; 
        $alokasicuti->tgl_sekarang = $request->tgl_sekarang; 
        $alokasicuti->aktif_dari   = $request->aktif_dari; 
        $alokasicuti->sampai       = $request->sampai; 

        dd($alokasicuti->all());
        $alokasicuti->save();
        return redirect()->back()->withInput();
    }

    public function show($id)
    {
        $alokasicuti = Alokasicuti::find($id);
        return view('admin.alokasicuti.showalokasi',compact('alokasicuti'));
    }

    public function update(Request $request, $id)
    {
        $alokasicuti = Alokasicuti::find($id);
        $alokasicuti->update($request->all());

        return redirect('/alokasicuti');
    }

    public function importexcel(Request $request)
    {
        Excel::import(new AlokasicutiImport, request()->file('file'));
        return redirect()->back();
    }
}
