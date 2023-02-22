<?php

namespace App\Http\Controllers\direktur;

use Carbon\Carbon;
use App\Models\Cuti;
use App\Models\Status;
use App\Models\Karyawan;
use App\Models\Datareject;
use App\Models\Alokasicuti;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\CutiApproveNotification;

class DirekturController extends Controller
{
    public function index(Request $request)
    {
        $id_user_login = Auth::user()->id_pegawai;
        $cuti = DB::table('cuti')
            ->leftjoin('karyawan','cuti.id_karyawan','karyawan.id')
            ->leftjoin('jeniscuti','cuti.id_jeniscuti','jeniscuti.id')
            ->leftjoin('settingalokasi','cuti.id_jeniscuti','settingalokasi.id_jeniscuti')
            ->where(function($query) use ($id_user_login) {
                $query->where('karyawan.jabatan', 'Manager','HRD')
                ->where('karyawan.atasan_pertama', Auth::user()->id_pegawai)
                 ->orWhere(function($query) use ($id_user_login) {
                $query->where('karyawan.jabatan', 'Supervisor')
                ->where('karyawan.atasan_kedua', Auth::user()->id_pegawai)
                ->where('settingalokasi.tipe_approval', 'Bertingkat');
            });
            })
            ->select('cuti.*', 'jeniscuti.jenis_cuti', 'karyawan.nama','karyawan.jabatan','karyawan.atasan_pertama','karyawan.atasan_kedua')
            ->distinct()
            ->get();
        // dd($cuti);
        $alasancuti = DB::table('datareject')
            ->join('cuti','datareject.id_cuti','=','cuti.id')
            ->select('datareject.alasan as alasan_cuti','datareject.id_cuti as id_cuti')
            ->first();

        // dd($cuti);
        return view('direktur.cuti.index', compact('cuti'));
    }

    public function showLeave($id)
    {
        $cuti = Cuti::findOrFail($id);
        return view('direktur.cuti.cutiStaff',compact('cuti'));
    }

    public function leaveapproved($id){
        $cutis = Cuti::where('id', $id)->first();
        // Inisialisasi variable jml_cuti dengan nilai jumlah hari cuti yang diambil
        $jml_cuti = $cutis->jml_cuti;

        //Update status cuti menjadi 'Disetujui'
        $status= Status::find(7);
        Cuti::where('id', $id)->update(
            ['status' => $status->id]
        );
        $cuti = Cuti::where('id', $id)->first();
        //Ambil data alokasi cuti yang sesuai dengan id karyawan dan id jenis cuti
        $alokasicuti = Alokasicuti::where('id', $cutis->id_alokasi)
            ->where('id_karyawan', $cutis->id_karyawan)
            ->where('id_jeniscuti', $cutis->id_jeniscuti)
            ->first();

        // Hitung durasi baru setelah pengurangan
        $durasi_baru = $alokasicuti->durasi - $jml_cuti;
        // dd($durasi_baru);
        Alokasicuti::where('id', $alokasicuti->id)
            ->update(
                ['durasi' => $durasi_baru]
        );
        $epegawai = Karyawan::select('email as email','nama as nama')->where('id','=',$cuti->id_karyawan)->first();
        $tujuan = $epegawai->email;
        $data = [
            'subject'     =>'Notifikasi Cuti Disetujui',
            'id'          =>$cuti->id,
            'id_jeniscuti'=>$cuti->jeniscutis->jenis_cuti,
            'keperluan'   =>$cuti->keperluan,
            'tgl_mulai'   =>Carbon::parse($cuti->tgl_mulai)->format("d M Y"),
            'tgl_selesai' =>Carbon::parse($cuti->tgl_selesai)->format("d M Y"),
            'jml_cuti'    =>$cuti->jml_cuti,
            'status'      =>$status->name_status,
            'nama'        =>$epegawai->nama,
        ];
        Mail::to($tujuan)->send(new CutiApproveNotification($data));
        // dd($alokasicuti,$epegawai,$tujuan,$data);
        return redirect()->back()->withInput();
    }

    public function leaverejected(Request $request, $id)
    {
        $cuti = Cuti::where('id',$id)->first();
        $status = Status::find(5);
        Cuti::where('id',$id)->update([
            'status' => $status->id,
        ]);
        $cuti = Cuti::where('id',$id)->first();

        $datareject          = new Datareject;
        $datareject->id_cuti = $cuti->id;
        $datareject->id_izin = NULL;
        $datareject->alasan  = $request->alasan;
        $datareject->save();  

        //----SEND EMAIL KE KARYAWAN -------
        //ambil nama jeniscuti
        $ct = DB::table('cuti')
            ->join('jeniscuti','cuti.id_jeniscuti','=','jeniscuti.id')
            ->join('statuses','cuti.status','=','statuses.id')
            ->where('cuti.id',$id)
            ->select('cuti.*','jeniscuti.jenis_cuti as jenis_cuti','statuses.name_status')
            ->first();

        //ambil nama dan email karyawan tujuan
        //sementara tidak digunakan
        $karyawan = DB::table('cuti')
            ->join('karyawan','cuti.id_karyawan','=','karyawan.id')
            ->where('cuti.id',$cuti->id)
            ->select('karyawan.email as email','karyawan.nama as nama')
            ->first(); 
        //Stujuan = $karyawan->email;
        $tujuan = 'akhiratunnisahasanah0917@gmail.com';
        $data = [
            'subject'     =>'Notifikasi Cuti Ditolak',
            'id'          =>$ct->id,
            'id_jeniscuti'=>$ct->jenis_cuti,
            'keperluan'   =>$ct->keperluan,
            'nama'        =>$karyawan->nama,
            'tgl_mulai'   =>Carbon::parse($ct->tgl_mulai)->format("d M Y"),
            'tgl_selesai' =>Carbon::parse($ct->tgl_selesai)->format("d M Y"),
            'jml_cuti'    =>$ct->jml_cuti,
            'status'      =>$ct->name_status,
        ];
        Mail::to($tujuan)->send(new CutiApproveNotification($data));
        return redirect()->back()->withInput();
    }
}
