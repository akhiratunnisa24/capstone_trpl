<?php

namespace App\Http\Controllers\karyawan;

use Carbon\Carbon;
use App\Models\Cuti;
use App\Models\Izin;
use App\Models\Jeniscuti;
use App\Models\Jenisizin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CutikaryawanController extends Controller
{

    public function index(Request $request)
    {
         //index cuti
         $cuti = Cuti::latest()->paginate(10);
         //index izin
         $izin = Izin::latest()->paginate(10);
 
        //create cuti
        $karyawan = Auth::user()->id_pegawai;
        $jeniscuti = DB::table('alokasicuti')
            ->join('jeniscuti','alokasicuti.id_jeniscuti','=','jeniscuti.id')
            ->where('alokasicuti.id_karyawan','=', Auth::user()->id_pegawai)
            ->get();

        $sisacuti = DB::table('alokasicuti')
            ->join('cuti','alokasicuti.id_jeniscuti','cuti.id_jeniscuti') 
            ->where('alokasicuti.id_karyawan',Auth::user()->id_pegawai)
            ->where('cuti.id_karyawan',Auth::user()->id_pegawai)
            ->where('cuti.status','=','Disetujui')
            ->selectraw('alokasicuti.durasi - cuti.jml_cuti as sisa, cuti.id_jeniscuti,cuti.jml_cuti')
            ->get();
            // ->where('cuti.status','=','Pending')
        $sisa_cuti = array();
        foreach ($sisacuti as $data) {
            $sisa_cuti[$data->id_jeniscuti] = $data->sisa;
            // dd($sisa_cuti);
        }
        
        //form izin
        $jenisizin = Jenisizin::all();
        $tipe = $request->query('tipe', 1);
        return view('karyawan.cuti.index', compact('izin','jenisizin','cuti','jeniscuti','karyawan','tipe','sisa_cuti'));
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
