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
use Illuminate\Support\Facades\Auth;

class AlokasicutiController extends Controller
{
    public function index(Request $request)
    {
        $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
        $role = Auth::user()->role;        
        if ($role == 1) {
        
            //index
            $alokasicuti = Alokasicuti::all();

            //create
            $karyawan = Karyawan::all();
            $settingalokasi = Settingalokasi::all();
            $jeniscuti= DB::table('settingalokasi')
                ->join('jeniscuti', 'settingalokasi.id_jeniscuti','=','jeniscuti.id')
                ->get();

            //search
            $cari = $request->kata;
            $mode_karyawan = Settingalokasi::get('mode_karyawan');
            // $data = DB::table('karyawan')
            //     ->join('settingalokasi','karyawan.jenis_kelamin','settingalokasi.mode_karyawan')
            //     ->join('keluarga', 'karyawan.id', 'keluarga.id_pegawai')
            //     ->select('karyawan.*','keluarga.*')
            //     ->where('karyawan.jenis_kelamin', $mode_karyawan)
            //     ->orWhere('keluarga.status_pernikahan', $mode_karyawan)
            //     ->orWhere('karyawan.jenis_kelamin', 'like', '%'.$cari.'%')
            //     ->orWhere('keluarga.status_pernikahan', 'like', '%'.$cari.'%')
            // $data = DB::table('karyawan')
            //     ->join('keluarga', 'karyawan.id', '=', 'keluarga.id_pegawai')
            //     ->join('settingalokasi', function($join) use ($request){
            //     $join->on('settingalokasi.id_jeniscuti', '=', $request->id_jeniscuti);})
            //     ->select('karyawan.nama')
            //     ->where(function($query) use ($mode_karyawan){
            //         $query->where('karyawan.jenis_kelamin', $mode_karyawan)
            //         ->orWhere('keluarga.status_pernikahan', $mode_karyawan);
            //     })
            //     ->where(function($query) use ($cari)
            //         {
            //         $query->where('karyawan.nama', 'like', '%'.$cari.'%')
            //         ->orWhere('keluarga.status_pernikahan', 'like', '%'.$cari.'%');
            //         })
            //     ->get();
            return view('admin.alokasicuti.index', compact('jeniscuti','karyawan','alokasicuti','settingalokasi','row'));
            
        } else {
            
            return redirect()->back(); 
        }
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
            $getSettingalokasi = Settingalokasi::select('id','id_jeniscuti','durasi','mode_alokasi','departemen')
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

    // public function getDepartemen(Request $request)
    // {
    //     try {
    //         $getDepartemen = DB::table('settingalokasi')
    //         ->join('departemen', 'settingalokasi.departemen','=','departemen.id')
    //         ->select('departemen.*','settingalokasi.departemen')
    //         ->where('id_jeniscuti','=',$request->id_jeniscuti)->first();

    //         if(!$getDepartemen) {
    //             throw new \Exception('Data not found');
    //         }
    //         return response()->json($getDepartemen,200);

    //     } catch (\Exception $e){
    //         return response()->json([
    //             'message' =>$e->getMessage()
    //         ], 500);
    //     }
    // }

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
            $alokasicuti->id_settingalokasi= $request->id_settingalokasi;
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
            $alokasicuti->id_settingalokasi= $request->id_settingalokasi;
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
    public function edit($id)
    {
        $alokasicuti = Alokasicuti::find($id);
        return response()->json([
            'success' => true,
            'message' => 'Data Alokasi Didapatkan',
            'data'    => $alokasicuti
        ]); 
        dd($alokasicuti);
        // dd($alokasicuti);
    }
   
    public function update(Request $request, $id)
    {
        $alokasicuti = Alokasicuti::find($id);
        // dd($request->all());
        if($request->id_jeniscuti == 1)
        {
            $validate = $request->validate([
                'id_karyawan'  => 'required',
                'id_jeniscuti' => 'required',
                // 'tgl_masuk'    => 'required',
                // 'tgl_sekarang' => 'required',
                'aktif_dari'   => 'required',
                'sampai'       => 'required',
            ]);
            $alokasicuti->update([
                'id_karyawan'  =>$request->id_karyawan,
                'id_settingalokasi'=> $request->id_settingalokasi,
                'id_jeniscuti' =>$request->id_jeniscuti,
                'durasi'       =>$request->durasi,
                'mode_alokasi' =>$request->mode_alokasi,
                'tgl_masuk'    => Carbon::parse($request->tgl_masuk)->format('Y-m-d'),
                'tgl_sekarang' => Carbon::parse($request->tgl_sekarang)->format('Y-m-d'),
                'aktif_dari'   => Carbon::parse($request->aktif_dari)->format('Y-m-d'),
                'sampai'       => Carbon::parse($request->sampai)->format('Y-m-d'),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Data Berhasil Diudapte!',
                'statusCode'=>200,
                'data'    => $alokasicuti 
            ]);
        }else
        {
            $validate = $request->validate([
                'id_karyawan'  => 'required',
                'id_jeniscuti' => 'required',
                'aktif_dari'   => 'required',
                'sampai'       => 'required',
            ]);

            // dd($validate);
            $alokasicuti->update([
                'id_karyawan'=>$request->id_karyawan,
                'id_settingalokasi'=> $request->id_settingalokasi,
                'id_jeniscuti'=>$request->id_jeniscuti,
                'durasi'=>$request->durasi,
                'mode_alokasi'=>$request->mode_alokasi,
                'tgl_masuk' =>NULL,
                'tgl_sekarang' =>NULL,
                'aktif_dari'=> Carbon::parse($request->aktif_dari)->format('Y-m-d'),
                'sampai' => Carbon::parse($request->sampai)->format('Y-m-d'),
            ]);

            // dd($alokasicuti);
            return response()->json([
                'success' => true,
                'message' => 'Data Berhasil Diudapte!',
                'statusCode'=>200,
                'data'    => $alokasicuti 
            ]);
        }
    }

    public function destroy($id)
    {
        $alokasicuti = Alokasicuti::find($id);
        $alokasicuti->delete();

        return redirect('/alokasicuti');
    }

    public function importexcel(Request $request)
    {
        Excel::import(new AlokasicutiImport, request()->file('file'));
        return back();
    }
}

           
