<?php

namespace App\Http\Controllers\karyawan;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Models\Departemen;
use App\Models\Resign;
use App\Models\Karyawan;
use App\Models\Tidakmasuk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ResignController extends Controller
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
    public function index()
    {
        $cek = Resign::where('id_karyawan', Auth::user()->id_pegawai)->exists();
        $karyawan = karyawan::where('id', Auth::user()->id_pegawai)->first();
        // dd($karyawan);
        $resign = Resign::all();
     
        // $tes = Auth::user()->karyawan->divisi;
        $tes = DB::table('karyawan')
            ->join('departemen','karyawan.divisi','=','departemen.id')
            ->where('karyawan.id', Auth::user()->id_pegawai)
            ->select('departemen.id as id_dep','departemen.nama_departemen as departemen')
            ->first();
        
        
        // $namdiv = $tes->departemen->nama_departemen;

        return view('karyawan.resign.index', compact('karyawan','tes','resign','cek'));
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
        $tes = DB::table('karyawan')
            ->join('departemen','karyawan.divisi','=','departemen.id')
            ->where('karyawan.id', Auth::user()->id_pegawai)
            ->select('departemen.id as id_dep')
            ->first();
        //  $validate = $request->validate([
        //         'id_karyawan'  => 'required',
        //         'departemen'  => 'required',
        //         'tgl_masuk'  => 'required',
        //         'tgl_resign'    => 'required',
        //         'tipe_resign'  => 'required',
        //         'alasan'    => 'required',
        //     ]);
        //     dd($validate);
            $resign = New Resign;
            $resign->id_karyawan = $karyawan;
            $resign->departemen = $tes->id_dep;
            $resign->tgl_masuk = Carbon::parse($request->tgl_masuk)->format("Y-m-d");
            $resign->tgl_resign  = Carbon::parse($request->tgl_resign)->format("Y-m-d");
            $resign->tipe_resign = $request->tipe_resign;
            $resign->alasan      = $request->alasan;          
            $resign->status      = 'Pending';

            $resign->save();
            return redirect()->back();

    }

    public function show($id)
    {
        
        $resign = Resign::findOrFail($id);
        // $karyawan = Auth::user()->id_pegawai;

        return view('karyawan.resign.index',compact('resign','karyawan'));
    }

}
