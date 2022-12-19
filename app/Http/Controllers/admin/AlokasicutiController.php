<?php

namespace App\Http\Controllers\admin;

use Carbon\Carbon;
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
        //index
        $alokasicuti = Alokasicuti::all();

        //create
        $karyawan = Karyawan::all();
        $settingalokasi = Settingalokasi::all();
        $jeniscuti= DB::table('settingalokasi')
        ->join('jeniscuti', 'settingalokasi.id_jeniscuti','=','jeniscuti.id')
        ->get();
        return view('admin.alokasicuti.index', compact('jeniscuti','karyawan','alokasicuti','settingalokasi'));
    }

    public function getTglmasuk(Request $request)
    {
        try {
            $getTglmasuk = Karyawan::select('tglmasuk')
            ->where('id','=',$request->id_karyawan)->first();

            // dd($request->id_karyawan,$getTglmasuk);
            if(!$getTglmasuk) {
                throw new \Exception('Data not found');
            }
            return response()->json($getTglmasuk,200);
            
        } catch (\Exception $e){
            return response()->json([
                'message' =>$e->getMessage()
            ], 500);
        }
    }

    public function getSettingalokasi(Request $request)
    {
        try {
            $getSettingalokasi = Settingalokasi::select('id','id_jeniscuti','durasi','mode_alokasi')
            ->where('id_jeniscuti','=',$request->id_jeniscuti)->first();

            if(!$getSettingalokasi) {
                throw new \Exception('Data not found');
            }
            return response()->json($getSettingalokasi,200);

        } catch (\Exception $e){
            return response()->json([
                'message' =>$e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        // dd($request->id_jeniscuti);
       
        if($request->id_jeniscuti == 1)
        {
            $validate = $request->validate([
                'id_karyawan'  => 'required',
                'id_settingalokasi'=> 'required',
                'id_jeniscuti' => 'required',
                'tgl_masuk'    => 'required',
                'tgl_sekarang' => 'required',
                'aktif_dari'   => 'required',
                'sampai'       => 'required',
            ]);

            $alokasicuti = New Alokasicuti;
            $alokasicuti->id_karyawan  = $request->id_karyawan;
            $alokasicuti->id_settingalokasi= $request->id_settingalokasi?? NULL;
            $alokasicuti->id_jeniscuti = $request->id_jeniscuti;
            $alokasicuti->durasi       = $request->durasi;
            $alokasicuti->mode_alokasi = $request->mode_alokasi;
            $alokasicuti->tgl_masuk    = Carbon::parse($request->tgl_masuk)->format('Y-m-d');
            $alokasicuti->tgl_sekarang = Carbon::parse($request->tgl_sekarang)->format('Y-m-d'); 
            $alokasicuti->aktif_dari   = Carbon::parse($request->aktif_dari)->format('Y-m-d'); 
            $alokasicuti->sampai       = Carbon::parse($request->sampai)->format('Y-m-d');

            // dd($alokasicuti);
            $alokasicuti->save();
            return redirect()->back()->withInput();
        }else
        {
            $validate = $request->validate([
                'id_karyawan'  => 'required',
                'id_settingalokasi'=> 'required',
                'id_jeniscuti' => 'required',
                'aktif_dari'   => 'required',
                'sampai'       => 'required',
            ]);
            // dd($validate);
            $alokasicuti = New Alokasicuti;
            $alokasicuti->id_karyawan  = $request->id_karyawan;
            $alokasicuti->id_settingalokasi= $request->id_settingalokasi?? NULL;
            $alokasicuti->id_jeniscuti = $request->id_jeniscuti;
            $alokasicuti->durasi       = $request->durasi;
            $alokasicuti->mode_alokasi = $request->mode_alokasi;
            $alokasicuti->tgl_masuk    = NULL; 
            $alokasicuti->tgl_sekarang = NULL; 
            $alokasicuti->aktif_dari   = Carbon::parse($request->aktif_dari)->format('Y-m-d'); 
            $alokasicuti->sampai       = Carbon::parse($request->sampai)->format('Y-m-d');

            // dd($alokasicuti);
            $alokasicuti->save();
            return redirect()->back()->withInput();
        }
    }

    public function show($id)
    {
        $alokasicuti = Alokasicuti::find($id);
        return view('admin.alokasicuti.showalokasi',compact('alokasicuti'));
    }

    //get data alokascuti
    //public function edit($id)
    // {
    //     $karyawan = Karyawan::find($id);
    //     $alokasicuti = Alokasicuti::find($id);
    //     $settingalokasi = Settingalokasi::find($id);
    //     if( $alokasicuti)
    //     {
    //         return response()->json([
    //             'status'=>200,
    //             'data'=>$alokasicuti, 
    //         ]);
    //     }else
    //     {
    //         return response()->json([
    //             'status'=>404,
    //             'message'=>'Alokasi Cuti Not Found', 
    //         ]);
    //     }
       
    // }

    public function edit($id)
    {
        try {
            $alokasicuti = Alokasicuti::find($id);

            if(!$alokasicuti) {
                throw new \Exception('Alokasi Data not found');
            }
            return response()->json($alokasicuti,200);

        } catch (\Exception $e){
            return response()->json([
                'message' =>$e->getMessage()
            ], 500);
        }
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
