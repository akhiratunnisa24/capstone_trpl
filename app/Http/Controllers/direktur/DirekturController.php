<?php

namespace App\Http\Controllers\direktur;

use Carbon\Carbon;
use App\Models\Cuti;
use App\Models\Izin;
use App\Models\Status;
use App\Models\Karyawan;
use App\Models\Sisacuti;
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
        $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
        $role = Auth::user()->role;

        if($row->jabatan == "Management" && $role == 4)
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
                    ->where('karyawan.atasan_kedua', Auth::user()->id_pegawai);
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

            $izin = DB::table('izin')
                ->leftjoin('karyawan','izin.id_karyawan','karyawan.id')
                ->leftjoin('jenisizin','izin.id_jenisizin','jenisizin.id')
                ->leftjoin('statuses','izin.status','=','statuses.id')
                ->leftjoin('datareject','datareject.id_izin','=','izin.id')
                ->where(function($query) use ($row){
                    $query->where('karyawan.atasan_pertama',Auth::user()->id_pegawai)
                    ->orWhere(function($query) use ($row){
                        $query->where('karyawan.atasan_kedua',Auth::user()->id_pegawai);
                    });    
                })
                ->select('izin.*','karyawan.nama','jenisizin.jenis_izin','statuses.name_status','datareject.alasan as alasan_izin')
                ->distinct()
                ->get();

        // dd($cuti);
            return view('direktur.cuti.index', compact('cuti','izin','row'));
        }
        else{
            return redirect()->back();
        }
        
    }

    public function showLeave($id)
    {

        $cuti = Cuti::findOrFail($id);
        return view('direktur.cuti.cutiStaff',compact('cuti'));
    }

    public function leaveapproved($id)
    {
        $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
        $role = Auth::user()->role;

        $cutis = Cuti::where('id', $id)->first();
        
        $cekSisacuti = Sisacuti::leftJoin('cuti', 'cuti.id_jeniscuti', 'sisacuti.jenis_cuti')
            ->select('cuti.id as id_cuti','cuti.jml_cuti','cuti.tgl_mulai', 'cuti.tgl_selesai','sisacuti.*')
            ->where('cuti.id',$cutis->id)
            ->where('sisacuti.id_pegawai',$cutis->id_karyawan)
            ->first();

        if ($cekSisacuti !== null) 
        {
             // Inisialisasi variable jml_cuti dengan nilai jumlah hari cuti yang diambil
            $jml_cuti = $cutis->jml_cuti;

            //Update status cuti menjadi 'Disetujui'
            $status= Status::find(7);
            Cuti::where('id', $id)->update(
                 ['status' => $status->id]
            );
            $cuti = Cuti::where('id', $id)->first();

            $sisacuti = Sisacuti::where('jenis_cuti', $cuti->id_jeniscuti)
                ->where('id_pegawai', $cuti->id_karyawan)
                ->first();
                
            $sisacuti_baru = $sisacuti->sisacuti - $jml_cuti;
    
            Sisacuti::where('id', $sisacuti->id)
                ->update(
                    ['sisa_cuti' => $sisacuti_baru]
            );

            $emailkry = DB::table('cuti')->join('karyawan','cuti.id_karyawan','=','karyawan.id')
                ->where('cuti.id_karyawan','=',$cuti->id_karyawan)
                ->select('karyawan.email','karyawan.nama')
                ->first();

            $idatasan1 = DB::table('karyawan')
                ->join('cuti','karyawan.id','=','cuti.id_karyawan')
                ->where('cuti.id_karyawan','=',$cuti->id_karyawan)
                ->select('karyawan.atasan_pertama as atasan_pertama')
                ->first();

            $atasan1 = Karyawan::where('id',$idatasan1->atasan_pertama)
                ->select('email as email','nama as nama','jabatan as jabatan','divisi as departemen')
                ->first();
            $atasan2 = Auth::user()->email;
            //$epegawai = Karyawan::select('email as email','nama as nama')->where('id','=',$cuti->id_karyawan)->first();
            $tujuan =  $emailkry->email;
            // dd($tujuan);
            $data = [
                'subject'     =>'Notifikasi Cuti Disetujui',
                'id'          =>$cuti->id,
                'id_jeniscuti'=>$cuti->jeniscutis->jenis_cuti,
                'karyawan_email' =>$tujuan,
                'atasan1'     => $atasan1->email,
                'atasan2'     =>$atasan2,
                'namaatasan1' =>$atasan1->nama,
                'namaatasan2' =>Auth::user()->name,
                'namakaryawan'=>$emailkry->nama,
                'keperluan'   =>$cuti->keperluan,
                'tgl_mulai'   =>Carbon::parse($cuti->tgl_mulai)->format("d M Y"),
                'tgl_selesai' =>Carbon::parse($cuti->tgl_selesai)->format("d M Y"),
                'jml_cuti'    =>$cuti->jml_cuti,
                'status'      =>$status->name_status,
            ];
            Mail::to($tujuan)->send(new CutiApproveNotification($data));

            return redirect()->back();
    
        }else
        {
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
            $emailkry = DB::table('cuti')->join('karyawan','cuti.id_karyawan','=','karyawan.id')
                ->where('cuti.id_karyawan','=',$cuti->id_karyawan)
                ->select('karyawan.email','karyawan.nama')
                ->first();

            $idatasan1 = DB::table('karyawan')
                ->join('cuti','karyawan.id','=','cuti.id_karyawan')
                ->where('cuti.id_karyawan','=',$cuti->id_karyawan)
                ->select('karyawan.atasan_pertama as atasan_pertama','karyawan.nama')
                ->first();

            $atasan1 = Karyawan::where('id',$idatasan1->atasan_pertama)
                ->select('email as email','nama as nama','jabatan as jabatan','divisi as departemen')
                ->first();
            $atasan2 = Auth::user()->email;
            //$epegawai = Karyawan::select('email as email','nama as nama')->where('id','=',$cuti->id_karyawan)->first();
            $tujuan =  $emailkry->email;
            // dd($tujuan);
            $data = [
                'subject'     =>'Notifikasi Cuti Disetujui',
                'id'          =>$cuti->id,
                'id_jeniscuti'=>$cuti->jeniscutis->jenis_cuti,
                'karyawan_email' =>$tujuan,
                'atasan1'     => $atasan1->email,
                'atasan2'     =>$atasan2,
                'namaatasan1' =>$atasan1->nama,
                'namaatasan2' =>Auth::user()->name,
                'namakaryawan'=>$emailkry->nama,
                'keperluan'   =>$cuti->keperluan,
                'tgl_mulai'   =>Carbon::parse($cuti->tgl_mulai)->format("d M Y"),
                'tgl_selesai' =>Carbon::parse($cuti->tgl_selesai)->format("d M Y"),
                'jml_cuti'    =>$cuti->jml_cuti,
                'status'      =>$status->name_status,
                'nama'        =>$emailkry->nama,
            ];
            Mail::to($tujuan)->send(new CutiApproveNotification($data));

            return redirect()->back()->withInput();
        }
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
