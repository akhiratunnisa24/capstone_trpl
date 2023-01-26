<?php

namespace App\Http\Controllers\direktur;

use App\Models\Cuti;
use App\Models\Alokasicuti;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DirekturController extends Controller
{
    public function index(Request $request)
    {
        $cuti = DB::table('cuti')
        ->leftjoin('alokasicuti','cuti.id_jeniscuti','alokasicuti.id_jeniscuti')
        ->leftjoin('settingalokasi','cuti.id_jeniscuti','settingalokasi.id_jeniscuti')
        ->leftjoin('jeniscuti','cuti.id_jeniscuti','jeniscuti.id')
        ->leftjoin('karyawan','cuti.id_karyawan','karyawan.id')
        ->where('settingalokasi.tipe_approval','=','Bertingkat')
        ->select('cuti.*', 'jeniscuti.jenis_cuti', 'karyawan.nama','settingalokasi.tipe_approval')
        ->distinct()
        ->get();

        // ->where('cuti.status','=','Disetujui Manager')
        // ->orWhere('cuti.status','=','Disetujui')

        return view('direktur.cuti.index', compact('cuti'));
    }

    public function showLeave($id)
    {
        $cuti = Cuti::findOrFail($id);
        return view('direktur.cuti.cutiStaff',compact('cuti'));
    }

    public function leaveapproved($id){
        $cuti = Cuti::where('id', $id)->first();

        // Inisialisasi variable jml_cuti dengan nilai jumlah hari cuti yang diambil
        $jml_cuti = $cuti->jml_cuti;

        //Update status cuti menjadi 'Disetujui'
        Cuti::where('id', $id)->update(
            ['status' => 'Disetujui']
        );

        //Ambil data alokasi cuti yang sesuai dengan id karyawan dan id jenis cuti
        $alokasicuti = Alokasicuti::where('id', $cuti->id_alokasi)
            ->where('id_karyawan', $cuti->id_karyawan)
            ->where('id_jeniscuti', $cuti->id_jeniscuti)
            ->first();

        // Hitung durasi baru setelah pengurangan
        $durasi_baru = $alokasicuti->durasi - $jml_cuti;
        // dd($durasi_baru);
        Alokasicuti::where('id', $alokasicuti->id)
            ->update(
                ['durasi' => $durasi_baru]
            );
        return redirect()->back()->withInput();
    }

    public function leaverejected(Request $request, $id)
    {
        $cuti = Cuti::where('id',$id)->first();
        $status = 'Ditolak';
        Cuti::where('id',$id)->update([
            'status' => $status,
        ]);
        return redirect()->back()->withInput();
    }
}
