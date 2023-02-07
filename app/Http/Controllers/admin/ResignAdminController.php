<?php

namespace App\Http\Controllers\admin;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Models\Departemen;
use App\Models\Resign;
use App\Models\Status;
use App\Models\Karyawan;
use App\Models\Tidakmasuk;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Input;

class ResignAdminController extends Controller
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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
        $karyawan = karyawan::where('id', Auth::user()->id_pegawai)->first();
        $karyawan1 = Karyawan::where('status_kerja','Aktif')->get();
        $idkaryawan = $request->id_karyawan;
        // dd($karyawan);
        $resign = Resign::orderBy('created_at', 'desc')->get();
     
        $tes = Auth::user()->karyawan->departemen->nama_departemen;
        
        
        // $namdiv = $tes->departemen->nama_departemen;

        return view('admin.resign.index', compact('karyawan','karyawan1','tes','resign','row'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $karyawan = Auth::user()->id_pegawai;
        $status = Status::find(4);  
        $tes = DB::table('karyawan')
            ->join('departemen','karyawan.divisi','=','departemen.id')
            ->where('karyawan.id', )
            ->select('departemen.id as id_dep')
            ->first();
             
            $resign = New Resign;
            $resign->id_karyawan = $request->namaKaryawan;
            $resign->departemen = $request->departemen;
            $resign->tgl_masuk = Carbon::parse($request->tgl_masuk)->format("Y-m-d");
            $resign->tgl_resign  = Carbon::parse($request->tgl_resign)->format("Y-m-d");
            $resign->tipe_resign = $request->tipe_resign;
            $resign->alasan      = $request->alasan;          
            $resign->status      = $status->id;

            $resign->save();

            // $resign = Resign::where('id',$id)->first();        
    // $sk = Karyawan::where('id',$resign->id_karyawan);
    // $resign1 = Resign::where('id',$id)->first();
    // if ($resign1->tgl_resign <= Carbon::now()) {
    //     $sk->status_kerja = 'Non-Aktif';
    // }

            return redirect()->back();

    }

    public function show($id)
    {
        
        $resign = Resign::findOrFail($id);
        // $karyawan = Auth::user()->id_pegawai;

        return view('admin.resign.index',compact('resign','karyawan'));
    }

    public function approved(Request $request, $id)
    {
        $resign = Resign::where('id',$id)->first();
        $status = 3;
        Resign::where('id',$id)->update([
            'status' => $status,
        ]);
 

        
        $sk = Karyawan::where('id',$resign->id_karyawan);
        $resign1 = Resign::where('id',$id)->first();
    // dd($resign1);
        if ($resign1->tgl_resign <= Carbon::now()) {
            $sk->status_kerja = 'Non-Aktif';
        }
    // $sk->update($request->all());


        return redirect()->route('resignkaryawan');
    }

    public function approvedmanager(Request $request, $id)
    {
        $resign = Resign::where('id',$id)->first();
        $status = 2;
        Resign::where('id',$id)->update([
            'status' => $status,
        ]);
        return redirect()->back();
    }

    public function reject(Request $request, $id)
    {
        $resign = Resign::where('id',$id)->first();
        $status = 5;
        Resign::where('id',$id)->update([
            'status' => $status,
        ]);
        return redirect()->route('resignkaryawan')->withInput();
    }

        public function getUserData($id)
    {
        $user = Karyawan::with('Departemen')->find($id);

        return response()->json($user);
    }

// {
//     try {
//         $getUserData = Karyawan::all()
//             ->where('id', '=', $request->id_pegawai)->first();

//         if (!getUserData) {
//             throw new \Exception('Data not found');
//         }
//         return response()->json($getUserData, 200);
//     } catch (\Exception $e) {
//         return response()->json([
//             'message' => $e->getMessage()
//         ], 500);
//     }
// }
    public function destroy($id)
        {
            $resigndelete = Resign::find($id);
            $resigndelete->delete();

            return redirect()->back();
        }


}
