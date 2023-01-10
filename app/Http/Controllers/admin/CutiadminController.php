<?php

namespace App\Http\Controllers\admin;

use App\Models\Cuti;
use App\Models\Izin;
use App\Models\Alokasicuti;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CutiadminController extends Controller
{
   
    public function index(Request $request)
    {
        $type = $request->query('type', 1);
        $cuti = Cuti::latest()->paginate(10);
        $izin = Izin::latest()->paginate(10);
        return view('admin.cuti.index', compact('cuti','izin','type'));
    }

    public function show($id)
    {
        $cuti = Cuti::findOrFail($id);
        $karyawan = Auth::user()->id_pegawai;
 
        return view('admin.cuti.index',compact('cuti','karyawan'));
    }

    public function update(Request $request, $id)
    {
        $cuti = Cuti::where('id',$id)->first();

        $status = 'Disetujui';
        $sisacuti = DB::table('alokasicuti')
            ->join('cuti','alokasicuti.id_jeniscuti','cuti.id_jeniscuti') 
            ->where('alokasicuti.id_karyawan','=','cuti.id_karyawan')
            ->where('cuti.id',$id)
            ->selectraw('alokasicuti.durasi - cuti.jml_cuti as sisa, cuti.id_jeniscuti,cuti.id_karyawan')
            ->first();
        dd($sisacuti);

        Cuti::where('id',$id)->update([
            'status' => $status,
        ]);
        Alokasicuti::where('id_jeniscuti',$sisacuti->id_jeniscuti)
        ->where('id_karyawan',$sisacuti->id_karyawan)->update([
            'durasi' => $sisacuti->sisa,
        ]);
        return redirect()->back()->withInput();
    }

    public function tolak(Request $request, $id)
    {
        $cuti = Cuti::where('id',$id)->first();
        $status = 'Ditolak';
        Cuti::where('id',$id)->update([
            'status' => $status,
        ]);
        return redirect()->back()->withInput();
    }
}
