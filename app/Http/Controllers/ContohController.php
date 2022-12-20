<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Alokasicuti;
use Illuminate\Http\Request;

class ContohController extends Controller
{

    public function update(Request $request, $id)
    {
        $alokasicuti = Alokasicuti::find($id);
        $alokasicuti->id_karyawan  = $request->id_karyawan;
        $alokasicuti->id_settingalokasi= $request->id_settingalokasi?? NULL;
        $alokasicuti->id_jeniscuti = $request->id_jeniscuti;
        $alokasicuti->durasi       = $request->durasi;
        $alokasicuti->mode_alokasi = $request->mode_alokasi;
        $alokasicuti->tgl_masuk    = Carbon::parse($request->tgl_masuk)->format('Y-m-d');
        $alokasicuti->tgl_sekarang = Carbon::parse($request->tgl_sekarang)->format('Y-m-d'); 
        $alokasicuti->aktif_dari   = Carbon::parse($request->aktif_dari)->format('Y-m-d'); 
        $alokasicuti->sampai       = Carbon::parse($request->sampai)->format('Y-m-d');
        
        $alokasicuti->update();
        return response()->json($alokasicuti);
    }

    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

   
    public function store(Request $request)
    {
        //
    }

   
    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }


   

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
