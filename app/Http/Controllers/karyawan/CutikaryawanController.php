<?php

namespace App\Http\Controllers\karyawan;

use Carbon\Carbon;
use App\Models\Cuti;
use App\Models\Izin;
use App\Models\Jeniscuti;
use App\Models\Jenisizin;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CutikaryawanController extends Controller
{

    public function index(Request $request)
    {

        $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
        //form cuti
        $jeniscuti = DB::table('alokasicuti')
        ->join('jeniscuti','alokasicuti.id_jeniscuti','=','jeniscuti.id')
        ->where('alokasicuti.id_karyawan','=', Auth::user()->id_pegawai)->get();

        //form izin
        $jenisizin = Jenisizin::all();

        //index cuti
        $cuti = Cuti::latest()->paginate(10);

        //index izin
        $izin = Izin::latest()->paginate(10);

        $karyawan = Auth::user()->id_pegawai;
        $tipe = $request->query('tipe', 1);
        return view('karyawan.cuti.index', compact('izin','jenisizin','cuti','jeniscuti','karyawan','tipe','row'));
    }

    public function store(Request $request)
    {
        $karyawan = Auth::user()->id_pegawai;

        $cuti = New Cuti;
        $cuti->id_karyawan = $karyawan;
        $cuti->id_jeniscuti= $request->id_jeniscuti;
        $cuti->keperluan   = $request->keperluan;
        $cuti->tgl_mulai   = Carbon::parse($request->tgl_mulai)->format("Y-m-d");
        $cuti->tgl_selesai = Carbon::parse($request->tgl_selesai)->format("Y-m-d");
        $cuti->jml_cuti    = $request->jml_cuti;
        $cuti->status      = 'Pending';
        // dd($cuti);
        $cuti->save();

        // dd($cuti);
        return redirect()->back();
    }

    public function show($id)
    {
        $cuti = Cuti::findOrFail($id);
        $karyawan = Auth::user()->id_pegawai;

        return view('karyawan.kategori.index',compact('cuti','karyawan'));
    }
}
