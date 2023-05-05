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

        $karyawan1 = Karyawan::where('status_kerja','Aktif')
                      ->whereNotIn('id', function($query){
                          $query->select('id_karyawan')->from('resign');
                      })->get();
                      
        $idkaryawan = $request->id_karyawan;
        // dd($karyawan);
        $resign = Resign::orderBy('created_at', 'desc')->get();
     
        // $tes = Auth::user()->karyawan->departemen->nama_departemen;


        return view('admin.resign.index', compact('karyawan','karyawan1','resign','row'));
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
        // $karyawan = Auth::user()->id_pegawai;
        // $status = Status::find(4);  
        // $tes = DB::table('karyawan')
        //     ->join('departemen','karyawan.divisi','=','departemen.id')
        //     ->where('karyawan.id', )
        //     ->select('departemen.id as id_dep')
        //     ->first();
             
        //     $resign = New Resign;
        //     $resign->id_karyawan = $request->namaKaryawan;
        //     $resign->departemen = $request->departemen;
        //     $resign->tgl_masuk = Carbon::parse($request->tgl_masuk)->format("Y-m-d");
        //     $resign->tgl_resign  = Carbon::parse($request->tgl_resign)->format("Y-m-d");
        //     $resign->tipe_resign = $request->tipe_resign;
        //     $resign->alasan      = $request->alasan;          
        //     $resign->status      = $status->id;

        //     $resign->save();
        //     return redirect()->back();

        // mendapatkan id karyawan yang sedang login
        $karyawan = Auth::user()->id_pegawai;

        // mendapatkan data status resign dengan id = 8
        $status = Status::find(4);

        // mendapatkan id departemen karyawan yang sedang login
        $tes = DB::table('karyawan')
            ->join('departemen','karyawan.divisi','=','departemen.id')
            ->where('karyawan.id', )
            ->select('departemen.id as id_dep')
            ->first();

        // menyimpan file pdf ke dalam folder public/pdf
        $file = $request->file('filepdf');
        $filename = time() . '-' . $file->getClientOriginalName(); // mendapatkan nama asli file
        $file->move(public_path('pdf'), $filename);

        // menyimpan data resign ke dalam database
        $resign = new Resign;
        $resign->id_karyawan = $request->namaKaryawan;
        $resign->departemen = $request->departemen;
        $resign->tgl_masuk = Carbon::parse($request->tgl_masuk)->format("Y-m-d");
        $resign->tgl_resign  = Carbon::parse($request->tgl_resign)->format("Y-m-d");
        $resign->tipe_resign = $request->tipe_resign;
        $resign->alasan      = $request->alasan;          
        $resign->status      = 1;
        $resign->filepdf     = $filename; // menyimpan nama file di kolom filepdf

        $resign->save();
        return redirect()->back();

    }

    public function show($id)
    {
        
        $resign = Resign::findOrFail($id);
        return view('admin.resign.index',compact('resign','karyawan'));
    }

    public function approved( $id)
    {
        $resign = Resign::where('id',$id)->first();
        Resign::where('id',$id)->update([
            'status' => 6,
        ]);
 
        $sk = Karyawan::where('id',$resign->id_karyawan);
        $resign1 = Resign::where('id',$id)->first();
        // dd($resign1);
        // if ($resign1->tgl_resign <= Carbon::now()) {
        //     $sk->status_kerja = 'Non-Aktif';
        // }
        return redirect()->back();
    }

    public function approvedmanager( $id)
    {
        $resign = Resign::where('id',$id)->first();
        Resign::where('id',$id)->update([
            'status' => 7,
        ]);
        return redirect()->back();
    }

    public function reject( $id)
    {
        $resign = Resign::where('id',$id)->first();
        Resign::where('id',$id)->update([
            'status' => 5,
        ]);
        return redirect()->back()->withInput();
    }

    public function getUserData($id)
    {
        $user = Karyawan::with('Departemen')->find($id);
        return response()->json($user);
    }

    public function destroy($id)
    {
        $resigndelete = Resign::find($id);
        $resigndelete->delete();

        return redirect()->back();
    }

}
