<?php

namespace App\Http\Controllers\API;

use App\Models\Cuti;
use GuzzleHttp\Client;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CutiController extends Controller
{
    //get All data
    public function getData(Request $request)
    {
        $id_karyawan = $request->input('id_karyawan');
        $batas       = $request->input('batas',5);
        $nik         = $request->input('nik');
        $departemen  = $request->input('departemen');
        $id_jeniscuti   = $request->input('id_jeniscuti');
        
        $Cuti = Cuti::with('jeniscuti', 'departemen')->get();

        return response()->json($Cuti, 200);
        

    }
}
