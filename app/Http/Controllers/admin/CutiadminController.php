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
        $role = Auth::user()->role;        
        if ($role == 1) {
            
        $type = $request->query('type', 1);
        $cuti = Cuti::latest()->paginate(10);
        $izin = Izin::latest()->paginate(10);
        return view('admin.cuti.index', compact('cuti','izin','type'));
        
        } else {
        
            return redirect()->back(); 
        }
    }

    public function show($id)
    {
        $cuti = Cuti::findOrFail($id);
        $karyawan = Auth::user()->id_pegawai;
 
        return view('admin.cuti.index',compact('cuti','karyawan'));
    }

    public function update(Request $request, $id)
    {
        $cuti = Cuti::where('id', $id)->first();
        // Inisialisasi variable jml_cuti dengan nilai jumlah hari cuti yang diambil
        $jml_cuti = $cuti->jml_cuti;

        //Update status cuti menjadi 'Disetujui'
        Cuti::where('id', $id)->update(
            ['status' => 'Disetujui']
        );

        //Ambil data alokasi cuti yang sesuai dengan id karyawan dan id jenis cuti
        $alokasicuti = AlokasiCuti::where('id', $cuti->id_alokasi)
            ->where('id_karyawan', $cuti->id_karyawan)
            ->where('id_jeniscuti', $cuti->id_jeniscuti)
            ->first();

        // Hitung durasi baru setelah pengurangan
        $durasi_baru = $alokasicuti->durasi - $jml_cuti;
        // dd($durasi_baru);
        AlokasiCuti::where('id', $alokasicuti->id)
            ->update(
                ['durasi' => $durasi_baru]
            );
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
