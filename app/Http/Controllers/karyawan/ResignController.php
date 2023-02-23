<?php

namespace App\Http\Controllers\karyawan;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Models\Departemen;
use App\Models\Resign;
use App\Models\Karyawan;
use App\Models\Status;
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
        $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
        $jumlah_resign = Resign::where('id_karyawan', Auth::user()->id_pegawai)->count();
        $status0 = 0;
        $status1 = 0;
        if ($jumlah_resign > 0) {
            $resign0 = Resign::where('id_karyawan', Auth::user()->id_pegawai)->orderBy('id', 'asc')->first();
            $status0 = $resign0->status ?? 0;
            if ($jumlah_resign > 1) {
                $resign1 = Resign::where('id_karyawan', Auth::user()->id_pegawai)->orderBy('id', 'asc')->skip(1)->first();
                $status1 = $resign1->status ?? 0;
            }
        }

        
        $karyawan = karyawan::where('id', Auth::user()->id_pegawai)->first();
        // dd($karyawan);
        $resign = Resign::orderBy('created_at', 'desc')->get();

      
     
        // $tes = Auth::user()->karyawan->divisi;
        $tes = DB::table('karyawan')
            ->join('departemen','karyawan.divisi','=','departemen.id')
            ->where('karyawan.id', Auth::user()->id_pegawai)
            ->select('departemen.id as id_dep','departemen.nama_departemen as departemen')
            ->first(); 

            
     
            return view('karyawan.resign.index', compact('karyawan','tes','resign','row','status0', 'status1','jumlah_resign'));
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
        $status = Status::find(8);
        $tes = DB::table('karyawan')
            ->join('departemen','karyawan.divisi','=','departemen.id')
            ->where('karyawan.id', Auth::user()->id_pegawai)
            ->select('departemen.id as id_dep')
            ->first();
    
        $resign = New Resign;
        $resign->id_karyawan = $karyawan;
        $resign->departemen = $tes->id_dep;
        $resign->tgl_masuk = Carbon::parse($request->tgl_masuk)->format("Y-m-d");
        $resign->tgl_resign  = Carbon::parse($request->tgl_resign)->format("Y-m-d");
        $resign->tipe_resign = $request->tipe_resign;
        $resign->alasan      = $request->alasan;
        $resign->status      = $status->id;
    
        // Upload file PDF
        if ($request->hasFile('filepdf')) {
            $file = $request->file('filepdf');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $path = public_path('pdf/' . $filename);
            $file->move('pdf/', $filename);
        
            $resign->filepdf = $filename;
        }
    
        $resign->save();
        return redirect()->back();

    }

    public function show($id)
    {
        
        $resign = Resign::findOrFail($id);
        // $karyawan = Auth::user()->id_pegawai;

        return view('karyawan.resign.index',compact('resign','karyawan'));
    }

    public function delete($id)
        {
            Resign::destroy($id);
            return redirect()->back();
            
        }
}
