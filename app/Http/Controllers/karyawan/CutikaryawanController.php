<?php

namespace App\Http\Controllers\karyawan;

use Carbon\Carbon;
use App\Models\Cuti;
use App\Models\Izin;
use App\Models\Jeniscuti;
use App\Models\Jenisizin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CutikaryawanController extends Controller
{

    public function index(Request $request)
    {
        $jeniscuti = Jeniscuti::all();
        $jenisizin = Jenisizin::all();
        $cuti = Cuti::latest()->paginate(10);
        $izin = Izin::latest()->paginate(10);

        $karyawan = Auth::user()->id_pegawai;
        $tipe = $request->query('tipe', 1);
        return view('karyawan.cuti.index', compact('izin','jenisizin','cuti','jeniscuti','karyawan','tipe'));
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
