<?php

namespace App\Http\Controllers\direktur;

use Carbon\Carbon;
use App\Models\Cuti;
use App\Models\Izin;
use App\Models\Status;
use App\Models\Karyawan;
use App\Models\Sisacuti;
use App\Models\Jenisizin;
use App\Models\Datareject;
use App\Models\Alokasicuti;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\CutiApproveNotification;
use App\Mail\IzinApproveNotification;

class DirekturController extends Controller
{
    public function index(Request $request)
    {
        $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
        $role = Auth::user()->role;

        if($row->jabatan == "Management" && $role == 3)
        {
        // return $row->jabatan;
            $id_user_login = Auth::user()->id_pegawai;
            $cuti = DB::table('cuti')
                ->leftjoin('karyawan','cuti.id_karyawan','karyawan.id')
                ->leftjoin('jeniscuti','cuti.id_jeniscuti','jeniscuti.id')
                ->leftjoin('settingalokasi','cuti.id_jeniscuti','settingalokasi.id_jeniscuti')
                ->leftjoin('datareject','datareject.id_cuti','=','cuti.id')
                ->where(function($query) use ($id_user_login) {
                    $query->where('karyawan.jabatan', 'Manajer','HRD')
                    ->where('karyawan.atasan_pertama', Auth::user()->id_pegawai)
                    ->orWhere(function($query) use ($id_user_login) {
                    $query->where('karyawan.jabatan', 'Asisten Manajer')
                    ->where('karyawan.atasan_kedua', Auth::user()->id_pegawai);
                });
                })
                ->select('cuti.*', 'jeniscuti.jenis_cuti', 'karyawan.nama','karyawan.jabatan','karyawan.atasan_pertama','karyawan.atasan_kedua','datareject.alasan as alasan')
                ->distinct()
                ->get();

            $izin = DB::table('izin')
                ->leftjoin('karyawan','izin.id_karyawan','karyawan.id')
                ->leftjoin('jenisizin','izin.id_jenisizin','jenisizin.id')
                ->leftjoin('statuses','izin.status','=','statuses.id')
                ->leftjoin('datareject','datareject.id_izin','=','izin.id')
                ->where(function($query) use ($id_user_login) {
                    $query->where('karyawan.jabatan', 'Manajer','HRD')
                    ->where('karyawan.atasan_pertama', Auth::user()->id_pegawai)
                    ->orWhere(function($query) use ($id_user_login) {
                    $query->where('karyawan.jabatan', 'Asisten Manajer')
                    ->where('karyawan.atasan_kedua', Auth::user()->id_pegawai);
                });
                })
                ->select('izin.*','karyawan.nama','jenisizin.jenis_izin','statuses.name_status','karyawan.jabatan','datareject.alasan as alasan_izin','karyawan.atasan_pertama','karyawan.atasan_kedua')
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

        if($role == 3 && $row->jabatan = "Management")
        {
            $cutis = Cuti::where('id', $id)->first();
            $lyear = Carbon::now()->subYear()->year;
            $cekSisacuti = Sisacuti::join('cuti', 'cuti.id_jeniscuti', 'sisacuti.jenis_cuti')
                ->join('alokasicuti', 'sisacuti.id_alokasi', 'alokasicuti.id')
                ->where('cuti.id',$cutis->id)
                ->where('cuti.id_alokasi',$cutis->id_alokasi)
                ->where('sisacuti.id_alokasi',$cutis->id_alokasi)
                ->where('sisacuti.id_pegawai',$cutis->id_karyawan)
                ->exists();
            // $cekSisacuti = Sisacuti::leftJoin('cuti', 'cuti.id_jeniscuti', 'sisacuti.jenis_cuti')
            // ->leftJoin('alokasicuti', 'cuti.id_alokasi', 'alokasicuti.id')
            // ->select('cuti.id as id_cuti','cuti.id_alokasi','alokasicuti.id','cuti.id_settingalokasi','alokasicuti.id_settingalokasi as setting_in_alokasicuti','cuti.jml_cuti','cuti.tgl_mulai', 'cuti.tgl_selesai','sisacuti.*')
            // ->where('cuti.id', $cutis->id)
            // ->where('sisacuti.id_pegawai', $cutis->id_karyawan)
            // ->where('sisacuti.id_alokasi',$cutis->id_alokasi)
            // ->where('sisacuti.jenis_cuti', 1) // cek apakah jenis cuti adalah 1
            // ->where(function($query) use ($cutis) {
            //     $query->where(function($q) use ($cutis) {
            //         $q->where('alokasicuti.id_karyawan', $cutis->id_karyawan)
            //           ->where('alokasicuti.id_settingalokasi', $cutis->id_settingalokasi)
            //           ->where('alokasicuti.id_jeniscuti', $cutis->id_jeniscuti);
            //     })
            //     ->orWhere(function($q) use ($cutis) {
            //         $q->where('sisacuti.id_pegawai', $cutis->id_karyawan)
            //           ->where('sisacuti.jenis_cuti', $cutis->id_jeniscuti);
            //     });
            // })
            // ->where('cuti.status', '<>', 1) // cek apakah status cuti belum disetujui
            // ->get();


            // return $cekSisacuti;
            if ($cekSisacuti) 
            {
                // Inisialisasi variable jml_cuti dengan nilai jumlah hari cuti yang diambil
                $jml_cuti = $cutis->jml_cuti;

                // return  $jml_cuti;
                //Update status cuti menjadi 'Disetujui'
                $status= Status::find(7);
                Cuti::where('id', $id)->update(
                    ['status' => $status->id]
                );
                $cuti = Cuti::where('id', $id)->first();

                $sisacuti = Sisacuti::where('jenis_cuti', $cuti->id_jeniscuti)
                    ->where('id_pegawai', $cuti->id_karyawan)
                    ->first();
                $sisa = $sisacuti->sisa_cuti;
            
                $sisacuti_baru = $sisa - $jml_cuti;
        
                // return  $sisacuti_baru;
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
                    ->select('email as email','nama as nama','nama_jabatan as jabatan','divisi as departemen')
                    ->first();
                $atasan2 = Auth::user()->email;
                //$epegawai = Karyawan::select('email as email','nama as nama')->where('id','=',$cuti->id_karyawan)->first();
                $tujuan =  $emailkry->email;
                // dd($tujuan);
                $alasan = '';
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
                    'alasan'      =>$alasan,
                ];
                // return $data;
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
                    ->select('email as email','nama as nama','nama_jabatan as jabatan','divisi as departemen')
                    ->first();
                $atasan2 = Auth::user()->email;
                $alasan = '';
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
                    'alasan'      =>$alasan,
                ];
                // dd($data);
                Mail::to($tujuan)->send(new CutiApproveNotification($data));

                return redirect()->back()->withInput();
            }

        }else{
            return redirect()->back();
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

        //----SEND EMAIL KE KARYAWAN DAN ATASAN 2 TINGKAT-------
        //ambil nama jeniscuti
        $ct = DB::table('cuti')
            ->join('jeniscuti','cuti.id_jeniscuti','=','jeniscuti.id')
            ->join('statuses','cuti.status','=','statuses.id')
            ->where('cuti.id',$id)
            ->select('cuti.*','jeniscuti.jenis_cuti as jenis_cuti','statuses.name_status')
            ->first();
        $alasan = Datareject::where('id_cuti',$cuti->id)->first();
        //ambil nama dan email karyawan tujuan
        //sementara tidak digunakan
        $karyawan = DB::table('cuti')
            ->join('karyawan','cuti.id_karyawan','=','karyawan.id')
            ->where('cuti.id',$cuti->id)
            ->select('karyawan.email as email','karyawan.nama as nama','karyawan.atasan_pertama','karyawan.atasan_kedua')
            ->first(); 
        $atasan1 = Karyawan::where('id',$karyawan->atasan_pertama)
            ->select('email as email','nama as nama','jabatan')
            ->first();
        $atasan2 = NULL;
        if($karyawan->atasan_kedua !== NULL){
            $atasan2 = Karyawan::where('id',$karyawan->atasan_kedua)
            ->select('email as email','nama as nama','jabatan')
            ->first();
        }
        $tujuan = $karyawan->email;
        $data = [
            'subject'     => 'Notifikasi Permintaan Cuti Ditolak, ' . $ct->jenis_cuti . ' #' . $ct->id . ' ' . $karyawan->nama,
            'id'          =>$ct->id,
            'atasan1'     => $atasan1->email,
            'namaatasan1' => $atasan1->nama,
            'karyawan_email'=>$karyawan->email,
            'id_jeniscuti'=>$ct->jenis_cuti,
            'keperluan'   =>$ct->keperluan,
            'nama'        =>$karyawan->nama,
            'namakaryawan'=> $karyawan->nama,
            'tgl_mulai'   =>Carbon::parse($ct->tgl_mulai)->format("d M Y"),
            'tgl_selesai' =>Carbon::parse($ct->tgl_selesai)->format("d M Y"),
            'jml_cuti'    =>$ct->jml_cuti,
            'status'      =>$ct->name_status,
            'alasan'      =>$alasan->alasan,
        ];
        if($atasan2 !== NULL){
            $data['atasan2'] = $atasan2->email;
            $data['namaatasan2'] = $atasan2->nama;
        }
        Mail::to($tujuan)->send(new CutiApproveNotification($data));
        return redirect()->back()->withInput();
    }

    public function izinApprove($id)
    {
        $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
        $role = Auth::user()->role;
        $izn = Izin::where('id',$id)->first();
        // return $izn;
        $izin = Izin::leftJoin('karyawan', 'izin.id_karyawan', '=', 'karyawan.id')
        ->where(function($query) use ($izn) {
            $query->where('izin.id_jenisizin', '=', $izn->id_jenisizin)
                ->where('izin.id_karyawan', '=', $izn->id_karyawan);
        })
        ->where(function($query) use ($row) {
            $query->where('karyawan.atasan_pertama', '=', $row->id)
                ->orWhere('karyawan.atasan_kedua', '=', $row->id);
        })
        ->select('izin.*', 'karyawan.nama', 'karyawan.atasan_pertama', 'karyawan.atasan_kedua')
        ->first();

        if($row->jabatan == "Management" && $role == 3)
        {
                // dd($row->jabatan, $role);
                $status = Status::find(7);
            
                Izin::where('id',$id)->update([
                    'status' => $status->id,
                ]);
    
                $izinn = Izin::where('id',$id)->first();
                $jenisizin = Jenisizin::where('id',$izinn->id_jenisizin)->first();
    
                //KIRIM EMAIL NOTIFIKASI KE KARYAWAN, ATASAN 2 TUNGKAT DAN HRD
                    
                $emailkry = DB::table('izin')->join('karyawan','izin.id_karyawan','=','karyawan.id')
                    ->where('izin.id_karyawan','=',$izin->id_karyawan)
                    ->select('karyawan.email','karyawan.nama','karyawan.atasan_pertama','karyawan.atasan_kedua')
                    ->first();
    
                $atasan1 = Karyawan::where('id',$emailkry->atasan_pertama)
                    ->select('email as email','nama as nama','nama_jabatan as jabatan','divisi as departemen')
                    ->first();
     
                $atasan2 = NULL;

                if($emailkry->atasan_kedua !== NULL){
                    $atasan2 = Karyawan::where('id',$emailkry->atasan_kedua)
                    ->select('email as email','nama as nama','nama_jabatan as jabatan','divisi as departemen')
                    ->first();  
                }
                    
                //tujuan email karyawan
                $tujuan = $emailkry->email;
                 
                $data = [
                    'title'       =>$izinn->id,
                    'subject'     =>'Notifikasi Disetujui Izin '  . $jenisizin->jenis_izin . ' #' . $izinn->id . ' ' . $emailkry->nama,
                    'id'          =>$izinn->id,
                    'karyawan_email'=>$emailkry->email,
                    'id_jenisizin'=>$izinn->jenis_izin,
                    'atasan1'     =>$atasan1->email,
                    'jenisizin'   =>$jenisizin->jenis_izin,
                    'keperluan'   =>$izinn->keperluan,
                    'tgl_mulai'   =>Carbon::parse($izinn->tgl_mulai)->format("d M Y"),
                    'tgl_selesai' =>Carbon::parse($izinn->tgl_selesai)->format("d M Y"),
                    'jam_mulai'   =>Carbon::parse($izinn->jam_mulai)->format("H:i"),
                    'jam_selesai' =>Carbon::parse($izinn->jam_selesai)->format("H:i"),
                    'jml_hari'    =>$izinn->jml_hari,
                    'jumlahjam'   =>$izinn->jml_jam,
                    'status'      =>$status->name_status,
                    'namakaryawan'=>$izinn->nama,
                    'namaatasan1' =>$atasan1->nama,
                    'jabatanatasan'=>$atasan1->jabatan,
                    'nama'=>$izinn->nama,
                ];
                if($atasan2 !== NULL){
                    $data['atasan2'] = $atasan2->email;
                    $data['namaatasan2'] = $atasan2->nama;
                }
                Mail::to($tujuan)->send(new IzinApproveNotification($data));
                return redirect()->route('cuti.Staff',['tp'=>2]);
        }
        else{
            return redirect()->back();
        }
    }

    public function izinRejected(Request $request, $id)
    {
        $status = Status::find(5);
        Izin::where('id',$id)->update([
            'status' => $status->id,
        ]);

        $iz = Izin::where('id',$id)->first();

        $datareject          = new Datareject;
        $datareject->id_cuti = NULL;
        $datareject->id_izin = $iz->id;
        $datareject->alasan  = $request->alasan;
        $datareject->save();  
        
        $izin = DB::table('izin')
            ->join('jenisizin','izin.id_jenisizin','=','jenisizin.id')
            ->join('statuses','izin.status','=','statuses.id')
            ->where('izin.id',$id)
            ->select('izin.*','jenisizin.jenis_izin as jenis_izin','statuses.name_status')
            ->first();
        $alasan = Datareject::where('id_izin',$izin->id)->first();

        //KIRIM EMAIL KE KARAYWAN> 2 tingkat atasan
        $karyawan = DB::table('izin')
            ->join('karyawan','izin.id_karyawan','=','karyawan.id')
            ->where('izin.id',$izin->id)
            ->select('karyawan.email as email','karyawan.nama as nama','karyawan.atasan_pertama','karyawan.atasan_kedua')
            ->first(); 
        $atasan1 = Karyawan::where('id',$karyawan->atasan_pertama)
            ->select('email as email','nama as nama','jabatan')
            ->first();
        $atasan2 = NULL;
        if($karyawan->atasan_kedua !== NULL){
            $atasan2 = Karyawan::where('id',$karyawan->atasan_kedua)
            ->select('email as email','nama as nama','jabatan')
            ->first();
        }
       
        $tujuan = $karyawan->email;
        $data = [
            'subject'  =>'Notifikasi Permintaan Izin Ditolak, Izin ' . $izin->jenis_izin . ' #' . $izin->id . ' ' . $karyawan->nama,
            'id'       =>$izin->id,
            'atasan1'     => $atasan1->email,
            'karyawan_email'=>$karyawan->email,
            'id_jenisizin'=>$izin->jenis_izin,
            'keperluan'   =>$izin->keperluan,
            'tgl_mulai'   =>Carbon::parse($izin->tgl_mulai)->format("d M Y"),
            'tgl_selesai' =>Carbon::parse($izin->tgl_selesai)->format("d M Y"),
            'jam_mulai'   =>Carbon::parse($izin->jam_mulai)->format("H:i"),
            'jam_selesai' =>Carbon::parse($izin->jam_selesai)->format("H:i"),
            'status'   =>$status->name_status,
            'jml_hari'    =>$izin->jml_hari,
            'jumlahjam'   =>$izin->jml_jam,
            'namakaryawan'=> $karyawan->nama,
            'nama'        =>$karyawan->nama,
            'jenisizin'   =>$izin->jenis_izin,
            'alasan'      =>$alasan->alasan,
        ];
        if($atasan2 !== NULL){
            $data['atasan2'] = $atasan2->email;
            $data['namaatasan2'] = $atasan2->nama;
        }
        Mail::to($tujuan)->send(new IzinApproveNotification($data));
        return redirect()->route('cuti.Staff',['type'=>2])->withInput();
    }
}
