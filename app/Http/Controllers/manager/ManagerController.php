<?php

namespace App\Http\Controllers\manager;

use PDF;
use Carbon\Carbon;
use App\Models\Cuti;
use App\Models\Izin;
use App\Models\Resign;
use App\Models\Status;
use App\Models\Absensi;
use App\Models\Karyawan;
use App\Models\Sisacuti;
use App\Models\Jeniscuti;
use App\Models\Jenisizin;
use App\Models\Datareject;
use App\Models\Departemen;
use App\Models\Alokasicuti;
use Illuminate\Http\Request;
use App\Mail\CutiNotification;
use Illuminate\Support\Facades\DB;
use App\Exports\AbsensiFilterExport;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use App\Mail\CutiApproveNotification;
use App\Mail\CutiAtasan2Notification;
use App\Mail\IzinApproveNotification;
use App\Mail\IzinAtasan2Notification;
use App\Exports\AbsensiDepartemenExport;

class ManagerController extends Controller
{
    public function dataStaff(Request $request)
    {
        $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
        $role = Auth::user()->role;        
        if ($role == 3 && $row->jabatan = "Manager") 
        {
            $staff = Karyawan::with('departemens')
                ->where('atasan_pertama',Auth::user()->id_pegawai)
                ->orWhere('atasan_kedua',Auth::user()->id_pegawai)
                ->get();
            // dd($staff);

            return view('manager.staff.dataStaff', compact('staff','row'));
        }
        elseif($role == 3 && $row->jabatan = "Asisten Manajer")
        {
            //mengambil id_departemen 
            $staff= Karyawan::with('departemens')
                ->where('atasan_pertama','=',Auth::user()->id_pegawai)->get();

            return view('manager.staff.dataStaff', compact('staff','row'));
        }elseif($role == 2 && $row->jabatan = "Asisten Manajer")
        {
            $staff= Karyawan::with('departemens')
            ->where('atasan_pertama','=',Auth::user()->id_pegawai)->get();

        return view('manager.staff.dataStaff', compact('staff','row'));
        }
        else{
            return redirect()->back();
        };
    }

    public function absensiStaff(Request $request)
    {
        $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
        $role = Auth::user()->role;  

        //mengambil id_departemen user login
        $pegawai = Karyawan::where('jabatan','Staff')->orWhere('jabatan','Asisten Manajer')
            ->where('karyawan.atasan_pertama', Auth::user()->id_pegawai)
            ->orWhere('karyawan.atasan_kedua', Auth::user()->id_pegawai)
            ->select('id as idkaryawan')
            ->get();
        // return $pegawai;
        // return $role;
        if($role == 3 && $row->jabatan = "Manager") 
        {
            $manager_iddep = DB::table('karyawan')->where('id','=',Auth::user()->id_pegawai)
                ->select('divisi')->first();
            $karyawan= Karyawan::where('divisi',$manager_iddep->divisi)->get();
             //untuk filter data 
            $idkaryawan = $request->id_karyawan;
            $bulan = $request->query('bulan',Carbon::now()->format('m'));
            $tahun = $request->query('tahun',Carbon::now()->format('Y'));

            //simpan session
            $request->session()->put('idkaryawan', $request->id_karyawan);
            $request->session()->put('bulan', $bulan);
            $request->session()->put('tahun', $tahun);
        
            //mengambil data sesuai dengan filter yang dipilih
            if(isset($idkaryawan) && isset($bulan) && isset($tahun))
            {
                $absensi = Absensi::with('karyawans','departemens')
                    ->where('id_karyawan', $idkaryawan)
                    ->whereMonth('tanggal', $bulan)
                    ->whereYear('tanggal',$tahun)
                    ->get();
            }else
            {
                $manager_iddep = DB::table('karyawan')->where('id','=',Auth::user()->id_pegawai)
                ->select('divisi')->first();

                $absensi= Absensi::where('id_departement',$manager_iddep->divisi)->whereIn('id_karyawan',$pegawai->pluck('idkaryawan'))->get();
            }
            return view('manager.staff.absensiStaff', compact('absensi','karyawan','row'));

            //menghapus filter data
            $request->session()->forget('id_karyawan');
            $request->session()->forget('bulan');
            $request->session()->forget('tahun');
        }
        elseif($role == 3 && $row->jabatan = "Asisten Manajer")
        {
            $spv = DB::table('karyawan')->where('id','=',Auth::user()->id_pegawai)
                ->select('divisi')->first();
            $karyawan= Karyawan::where('atasan_pertama',Auth::user()->id_pegawai)->get();

             //untuk filter data 
            $idkaryawan = $request->id_karyawan;
            $bulan = $request->query('bulan',Carbon::now()->format('m'));
            $tahun = $request->query('tahun',Carbon::now()->format('Y'));

            //simpan session
            $request->session()->put('idkaryawan', $request->id_karyawan);
            $request->session()->put('bulan', $bulan);
            $request->session()->put('tahun', $tahun);

            //mengambil data sesuai dengan filter yang dipilih
            if(isset($idkaryawan) && isset($bulan) && isset($tahun))
            {
                $absensi = Absensi::with('karyawans','departemens')
                    ->where('id_karyawan', $idkaryawan)
                    ->whereMonth('tanggal', $bulan)
                    ->whereYear('tanggal',$tahun)
                    ->get();
            }else
            {
                $absensi= Absensi::where('id_departement',$spv->divisi)->whereIn('id_karyawan',$pegawai->pluck('idkaryawan'))->get();
            }
            return view('manager.staff.absensiStaff', compact('absensi','karyawan','row','role'));
            //menghapus filter data
            $request->session()->forget('id_karyawan');
            $request->session()->forget('bulan');
            $request->session()->forget('tahun');

        }
        elseif($role == 2 && $row->jabatan = "Asisten Manajer")
        {
            $spv = DB::table('karyawan')->where('id','=',Auth::user()->id_pegawai)
            ->select('divisi')->first();
            $karyawan= Karyawan::where('atasan_pertama',Auth::user()->id_pegawai)->get();
           
            //untuk filter data 
            $idkaryawan = $request->id_karyawan;
            $bulan = $request->query('bulan',Carbon::now()->format('m'));
            $tahun = $request->query('tahun',Carbon::now()->format('Y'));

            //simpan session
            $request->session()->put('idkaryawan', $request->id_karyawan);
            $request->session()->put('bulan', $bulan);
            $request->session()->put('tahun', $tahun);

            //mengambil data sesuai dengan filter yang dipilih
            if(isset($idkaryawan) && isset($bulan) && isset($tahun))
            {
                $absensi = Absensi::with('karyawans','departemens')
                    ->where('id_karyawan', $idkaryawan)
                    ->whereMonth('tanggal', $bulan)
                    ->whereYear('tanggal',$tahun)
                    ->get();
            }else
            {
            //saring data dengan id_departemen sama dengan manager secara keseluruhan
                $absensi= Absensi::where('id_departement',$spv->divisi)->whereIn('id_karyawan',$pegawai->pluck('idkaryawan'))->get();
                // return $absensi;
            }
            return view('manager.staff.absensiStaff', compact('absensi','karyawan','row','role'));
            //menghapus filter data
            $request->session()->forget('id_karyawan');
            $request->session()->forget('bulan');
            $request->session()->forget('tahun');
        }
        else{
            return redirect()->back();
        }
    }

    public function cutiStaff(Request $request)
    {
        
        $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
        $role= Auth::user()->role;

        $atasan = DB::table('karyawan')->where('id','=',Auth::user()->id_pegawai)
        ->select('divisi')->first();

        $tp = $request->query('tp',1);

        if($role == 3 && $row->jabatan = "Manager" || $role == 3 && $row->jabatan = "Management")
        {
            $cutistaff = DB::table('cuti')
                ->leftjoin('jeniscuti','cuti.id_jeniscuti','jeniscuti.id')
                ->leftjoin('karyawan','cuti.id_karyawan','karyawan.id')
                ->leftjoin('alokasicuti','cuti.id_alokasi','alokasicuti.id')
                ->leftjoin('settingalokasi','cuti.id_settingalokasi','settingalokasi.id')
                ->leftjoin('statuses','cuti.status','=','statuses.id')
                ->leftjoin('datareject','datareject.id_cuti','=','cuti.id')
                ->where(function($query) use ($row){
                    $query->where('karyawan.atasan_pertama',Auth::user()->id_pegawai)
                    ->orWhere(function($query) use ($row){
                        $query->where('karyawan.atasan_kedua',Auth::user()->id_pegawai);
                    });    
                })
                ->select('cuti.*', 'jeniscuti.jenis_cuti', 'karyawan.nama','karyawan.atasan_pertama','karyawan.atasan_kedua','statuses.name_status','datareject.alasan')
                ->distinct()
                ->orderBy('cuti.id', 'desc')
                ->get();
    
                // return $cutistaff;
            $izinstaff = DB::table('izin')
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
                ->select('izin.*','karyawan.nama','karyawan.atasan_pertama','karyawan.atasan_kedua','jenisizin.jenis_izin','statuses.name_status','datareject.alasan as alasan_izin')
                ->distinct()
                ->get();

            // return $izinstaff;
                
            return view('manager.staff.cutiStaff', compact('cutistaff','row','tp','izinstaff'));
        }
        elseif($role == 3 && $row->jabatan = "Asisten Manajer")
        {
            $cutistaff = DB::table('cuti')
                ->leftjoin('jeniscuti','cuti.id_jeniscuti','jeniscuti.id')
                ->leftjoin('karyawan','cuti.id_karyawan','karyawan.id')
                ->leftjoin('statuses','cuti.status','=','statuses.id')
                ->where('karyawan.atasan_pertama',Auth::user()->id_pegawai)
                ->select('cuti.*', 'jeniscuti.jenis_cuti', 'karyawan.nama','karyawan.atasan_pertama','karyawan.atasan_kedua','statuses.name_status')
                ->distinct()
                ->orderBy('cuti.id', 'desc')
                ->get();
            // dd($cutistaff);

            $izinstaff = DB::table('izin')
                ->leftjoin('karyawan','izin.id_karyawan','karyawan.id')
                ->leftjoin('jenisizin','izin.id_jenisizin','jenisizin.id')
                ->leftjoin('statuses','izin.status','=','statuses.id')
                ->where('karyawan.atasan_pertama',Auth::user()->id_pegawai)
                ->select('izin.*','karyawan.nama','jenisizin.jenis_izin','statuses.name_status')
                ->distinct()
                ->get();

            return view('manager.staff.cutiStaff', compact('cutistaff','row','tp','izinstaff'));
        }
        elseif($role == 2 && $row->jabatan = "Asisten Manajer")
        {
            $cutistaff = DB::table('cuti')
                ->leftjoin('jeniscuti','cuti.id_jeniscuti','jeniscuti.id')
                ->leftjoin('karyawan','cuti.id_karyawan','karyawan.id')
                ->leftjoin('statuses','cuti.status','=','statuses.id')
                ->where('karyawan.atasan_pertama',Auth::user()->id_pegawai)
                ->select('cuti.*', 'jeniscuti.jenis_cuti', 'karyawan.nama','karyawan.atasan_pertama','karyawan.atasan_kedua','statuses.name_status')
                ->distinct()
                ->orderBy('cuti.id', 'desc')
                ->get();
            // dd($cutistaff);

            $izinstaff = DB::table('izin')
                ->leftjoin('karyawan','izin.id_karyawan','karyawan.id')
                ->leftjoin('jenisizin','izin.id_jenisizin','jenisizin.id')
                ->leftjoin('statuses','izin.status','=','statuses.id')
                ->where('karyawan.atasan_pertama',Auth::user()->id_pegawai)
                ->select('izin.*','karyawan.nama','jenisizin.jenis_izin','statuses.name_status')
                ->distinct()
                ->get();

            return view('manager.staff.cutiStaff', compact('cutistaff','row','tp','izinstaff'));
        }
        else{
            return redirect()->back();
        }
    }

    public function cutiapproved(Request $request, $id)
    {
        $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
        $role = Auth::user()->role;
        $cuti = Cuti::where('id',$id)->first();
        $year = Carbon::now()->subYear()->year;

        $cekSisacuti = Sisacuti::leftJoin('cuti', 'cuti.id_jeniscuti', 'sisacuti.jenis_cuti')
          ->select('cuti.id as id_cuti','cuti.jml_cuti','cuti.tgl_mulai', 'cuti.tgl_selesai','sisacuti.*')
            ->where('cuti.id',$cuti->id)
            ->where('sisacuti.id_pegawai',$cuti->id_karyawan)
            ->first();
        return $cekSisacuti;
        if ($cekSisacuti !== null) 
        {
            // Cuti berasal dari sisacuti
            if($row->jabatan == "Manager" && $role == 3)
            {
                $datacuti = DB::table('cuti')
                    ->leftjoin('settingalokasi', 'cuti.id_settingalokasi', '=', 'settingalokasi.id')
                    ->leftjoin('karyawan','cuti.id_karyawan','karyawan.id')
                    ->where('cuti.id',$cuti->id)
                    ->where('karyawan.atasan_pertama', Auth::user()->id_pegawai)
                    ->orWhere('karyawan.atasan_kedua',Auth::user()->id_pegawai)
                    ->select('cuti.*','karyawan.atasan_pertama','karyawan.atasan_kedua')
                    ->first();

                if($datacuti && $datacuti->atasan_kedua == Auth::user()->id_pegawai)
                {
                    // return  Auth::user()->name;
                    $cuti = Cuti::where('id',$id)->first();
                    $jeniscuti = Jeniscuti::where('id',$cuti->id_jeniscuti)->first();
                    
                    $jml_cuti = $cuti->jml_cuti;
                    $status = Status::find(7);
                    Cuti::where('id', $id)->update(
                        ['status' => $status->id,]
                    );
            
                    $sisacuti = Sisacuti::where('jenis_cuti', $cuti->id_jeniscuti)
                        ->where('id_pegawai', $cuti->id_karyawan)
                        ->first();
    
                    $sisacuti_baru = $sisacuti->sisacuti - $jml_cuti;
    
                    Sisacuti::where('id', $sisacuti->id)
                    ->update(
                        ['sisa_cuti' => $sisacuti_baru]
                    );
    
                    //KIRIM EMAIL NOTIFIKASI DIKIRIM KE SEMUA ATASAN, HRD dan KARYAWAN
                    //ambil data karyawan
                    $emailkry = DB::table('cuti')->join('karyawan','cuti.id_karyawan','=','karyawan.id')
                        ->where('cuti.id_karyawan','=',$datacuti->id_karyawan)
                        ->select('karyawan.email','karyawan.nama as nama','karyawan.atasan_pertama','karyawan.atasan_kedua')
                        ->first();
    
                    $atasan1 = Karyawan::where('id',$emailkry->atasan_pertama)
                        ->select('email as email','nama as nama','jabatan as jabatan','divisi as departemen')
                        ->first();
                    
                    //atasan yang login
                    $atasan2 = Auth::user()->email;
    
                    // $tujuan = 'akhiratunnisahasanah0917@gmail.com';
                    $tujuan = $emailkry['email'];
                    $alasan = '';
                    
                    $data = [
                        'subject'     =>'Notifikasi Cuti Disetujui ' . $jeniscuti->jenis_cuti . ' #' . $cuti->id . ' ' . $emailkry->nama,
                        'id'          =>$cuti->id,
                        'atasan1'     =>$atasan1->email,
                        'atasan2'     =>$atasan2,
                        'namaatasan1' =>$atasan1->nama,
                        'namaatasan2' =>Auth::user()->name,
                        'namakaryawan'=>$emailkry->nama,
                        'id_jeniscuti'=>$jeniscuti->jenis_cuti,
                        'keperluan'   =>$cuti->keperluan,
                        'tgl_mulai'   =>Carbon::parse($cuti->tgl_mulai)->format("d M Y"),
                        'tgl_selesai' =>Carbon::parse($cuti->tgl_selesai)->format("d M Y"),
                        'jml_cuti'    =>$cuti->jml_cuti,
                        'status'      =>$cuti->name_status,
                        'alasan'      =>$alasan,
                    ];
                    Mail::to($tujuan)->send(new CutiApproveNotification($data));
                    return redirect()->back()->withInput();
    
                }
                elseif($datacuti && $datacuti->atasan_pertama == Auth::user()->id_pegawai && $row->jabatan = "Manager")
                {
                    // return $datacuti->atasan_pertama;
                    $status = Status::find(2);
                    Cuti::where('id',$id)->update([
                        'status' => $status->id,
                    ]);
                    $cuti = Cuti::where('id',$id)->first();
                    $jeniscuti = Jeniscuti::where('id',$cuti->id_jeniscuti)->first();
    
                    //KIRIM NOTIFIKASI EMAIL KE KARYAWAN DAN ATASAN 2
    
                    //ambil data karyawan
                    $emailkry = DB::table('cuti')->join('karyawan','cuti.id_karyawan','=','karyawan.id')
                        ->where('cuti.id_karyawan','=',$datacuti->id_karyawan)
                        ->select('karyawan.email','karyawan.nama as nama','karyawan.atasan_kedua')
                        ->first();
    
                    $atasan = Karyawan::where('id',$emailkry->atasan_kedua)
                        ->select('email as email','nama as nama','jabatan as jabatan')
                        ->first();
    
                    //atasan pertama
                    $atasan1 = Auth::user()->email;
    
                    //ambil data karyawan
                    $tujuan = $atasan->email;
                    $data = [
                        'subject'     =>'Notifikasi Approval Pertama Permintaan ' . $jeniscuti->jenis_cuti . ' #' . $cuti->id . ' ' . $emailkry->nama,
                        'id'          => $cuti->id,
                        'atasan2'     => $atasan->email,
                        'namaatasan2' => $atasan->nama,
                        'jeniscuti'   => $jeniscuti->jenis_cuti,
                        'karyawan_email' =>$emailkry->email,
                        'namakaryawan'=>$emailkry->nama,
                        'id_jeniscuti'=>$cuti->jeniscutis->jenis_cuti,
                        'keperluan'   =>$cuti->keperluan,
                        'tgl_mulai'   =>Carbon::parse($cuti->tgl_mulai)->format("d M Y"),
                        'tgl_selesai' =>Carbon::parse($cuti->tgl_selesai)->format("d M Y"),
                        'jml_cuti'    =>$cuti->jml_cuti,
                        'status'      =>$status->name_status,
                        'jabatanatasan' => $atasan->jabatan
    
                    ];
                    Mail::to($tujuan)->send(new CutiAtasan2Notification($data));
                    return redirect()->back()->withInput();
                }
                else{
                    return redirect()->back();
                }
                   
            }
            elseif($role == 3 && $row->jabatan = "Asisten Manajer" || $role == 2 && $row->jabatan = "Asisten Manajer")
            {
                // return ("INI SUPERVISOR");
                $dacuti = DB::table('cuti')
                    ->leftjoin('settingalokasi', 'cuti.id_settingalokasi', '=', 'settingalokasi.id')
                    ->leftjoin('karyawan','cuti.id_karyawan','karyawan.id')
                    ->where('cuti.id',$cuti->id)
                    ->where('karyawan.atasan_pertama', Auth::user()->id_pegawai)
                    ->select('cuti.*','karyawan.atasan_pertama')
                    ->first();
                    if($dacuti)
                    {
                        // dd($dacuti);
                        $status = Status::find(6);
                        Cuti::where('id',$id)->update([
                            'status' => $status->id,
                        ]);
                        $cuti = Cuti::where('id',$id)->first();
                        $jeniscuti = Jeniscuti::where('id',$cuti->id_jeniscuti)->first();
        
                        //email karyawan
                        $emailkry = DB::table('cuti')->join('karyawan','cuti.id_karyawan','=','karyawan.id')
                            ->where('cuti.id_karyawan','=',$dacuti->id_karyawan)
                            ->select('karyawan.email','karyawan.nama','karyawan.atasan_kedua')
                            ->first();
        
                        $atasan2 = Karyawan::where('id', $emailkry->atasan_kedua)
                            ->select('email as email','nama as nama','jabatan as jabatan')
                            ->first();
        
                        $tujuan = $atasan2->email;
                        
                        $data = [
                            'subject'     =>'Notifikasi Permintaan ' . $jeniscuti->jenis_cuti . ' #' . $cuti->id . ' ' . $emailkry->nama,
                            'id'          =>$cuti->id,
                            'atasan2'     => $atasan2->email,
                            'namaatasan2' => $atasan2->nama,
                            'jeniscuti'   => $jeniscuti->jenis_cuti,
                            'karyawan_email' =>$emailkry->email,
                            'namakaryawan'=>$emailkry->nama,
                            'id_jeniscuti'=>$cuti->jeniscutis->jenis_cuti,
                            'keperluan'   =>$cuti->keperluan,
                            'tgl_mulai'   =>Carbon::parse($cuti->tgl_mulai)->format("d M Y"),
                            'tgl_selesai' =>Carbon::parse($cuti->tgl_selesai)->format("d M Y"),
                            'jml_cuti'    =>$cuti->jml_cuti,
                            'status'      =>$status->name_status,
                            'jabatanatasan' => $atasan2->jabatan
                        ];
                        Mail::to($tujuan)->send(new CutiAtasan2Notification($data));
                        return redirect()->back();
                    }else{
                        return redirect()->back();
                    }
            }
            else{
                return redirect()->back();
            }
        }
        else
        {
            if($row->jabatan == "Manager" && $role == 3)
            {
                $datacuti = DB::table('cuti')
                    ->leftjoin('alokasicuti', 'cuti.id_alokasi', '=', 'alokasicuti.id')
                    ->leftjoin('settingalokasi', 'cuti.id_settingalokasi', '=', 'settingalokasi.id')
                    ->leftjoin('karyawan','cuti.id_karyawan','karyawan.id')
                    ->where('cuti.id',$cuti->id)
                    ->where('karyawan.atasan_pertama', Auth::user()->id_pegawai)
                    ->orWhere('karyawan.atasan_kedua',Auth::user()->id_pegawai)
                    ->select('cuti.*','alokasicuti.*','karyawan.atasan_pertama','karyawan.atasan_kedua')
                    ->first();
                   
                if($datacuti && $datacuti->atasan_kedua == Auth::user()->id_pegawai)
                {
                    // return  Auth::user()->name;
                    $cuti = Cuti::where('id',$id)->first();
                    $jeniscuti = Jeniscuti::where('id',$cuti->id_jeniscuti)->first();
                    $jml_cuti = $cuti->jml_cuti;
                    $status = Status::find(7);
                    Cuti::where('id', $id)->update(
                        ['status' => $status->id,]
                    );
            
                    $alokasicuti = Alokasicuti::where('id', $cuti->id_alokasi)
                        ->where('id_karyawan', $cuti->id_karyawan)
                        ->where('id_jeniscuti', $cuti->id_jeniscuti)
                        ->where('id_settingalokasi', $cuti->id_settingalokasi)
                        ->first();
    
                    $durasi_baru = $alokasicuti->durasi - $jml_cuti;
    
                    Alokasicuti::where('id', $alokasicuti->id)
                    ->update(
                        ['durasi' => $durasi_baru]
                    );
    
                    //KIRIM EMAIL NOTIFIKASI DIKIRIM KE SEMUA ATASAN, HRD dan KARYAWAN
    
                    //ambil data karyawan
                    $emailkry = DB::table('cuti')->join('karyawan','cuti.id_karyawan','=','karyawan.id')
                        ->where('cuti.id_karyawan','=',$datacuti->id_karyawan)
                        ->select('karyawan.email','karyawan.nama as nama','karyawan.atasan_pertama','karyawan.atasan_kedua')
                        ->first();
    
                    $atasan1 = Karyawan::where('id',$emailkry->atasan_pertama)
                        ->select('email as email','nama as nama','jabatan as jabatan','divisi as departemen')
                        ->first();
                    
                    //atasan yang login
                    $atasan2 = Auth::user()->email;
    
                    // $tujuan = 'akhiratunnisahasanah0917@gmail.com';
                    $tujuan = $emailkry->email;
                    $alasan = '';

                    $data = [
                        'subject'     =>'Notifikasi Cuti Disetujui ' . $jeniscuti->jenis_cuti . ' #' . $cuti->id . ' ' . $emailkry->nama,
                        'id'          =>$cuti->id,
                        'atasan1'     =>$atasan1->email,
                        'atasan2'     =>$atasan2,
                        'namaatasan1' =>$atasan1->nama,
                        'namaatasan2' =>Auth::user()->name,
                        'namakaryawan'=>$emailkry->nama,
                        'id_jeniscuti'=>$jeniscuti->jenis_cuti,
                        'keperluan'   =>$cuti->keperluan,
                        'tgl_mulai'   =>Carbon::parse($cuti->tgl_mulai)->format("d M Y"),
                        'tgl_selesai' =>Carbon::parse($cuti->tgl_selesai)->format("d M Y"),
                        'jml_cuti'    =>$cuti->jml_cuti,
                        'status'      =>$cuti->name_status,
                        'alasan'      =>$alasan,
                    ];
                    Mail::to($tujuan)->send(new CutiApproveNotification($data));
                    return redirect()->back()->withInput();
    
                }elseif($datacuti && $datacuti->atasan_pertama == Auth::user()->id_pegawai && $row->jabatan = "Manager")
                {
                    // return $datacuti->atasan_pertama;
                    $status = Status::find(2);
                    Cuti::where('id',$id)->update([
                        'status' => $status->id,
                    ]);
                    $cuti = Cuti::where('id',$id)->first();
                    $jeniscuti = Jeniscuti::where('id',$cuti->id_jeniscuti)->first();
    
                     //KIRIM NOTIFIKASI EMAIL KE KARYAWAN DAN ATASAN 2
    
                    //ambil data karyawan
                    $emailkry = DB::table('cuti')->join('karyawan','cuti.id_karyawan','=','karyawan.id')
                        ->where('cuti.id_karyawan','=',$datacuti->id_karyawan)
                        ->select('karyawan.email','karyawan.nama as nama','karyawan.atasan_kedua')
                        ->first();
    
                    $atasan = Karyawan::where('id', $emailkry->atasan_kedua)
                        ->select('email as email','nama as nama','jabatan as jabatan')
                        ->first();
    
                    //ambil data karyawan
                    $tujuan = $atasan->email;
                    $data = [
                        'subject'     =>'Notifikasi Permintaan ' . $jeniscuti->jenis_cuti . ' #' . $cuti->id . ' ' . $emailkry->nama,
                        'id'          => $cuti->id,
                        'atasan2'     => $atasan->email,
                        'namaatasan2' => $atasan->nama,
                        'jeniscuti'   => $jeniscuti->jenis_cuti,
                        'karyawan_email' =>$emailkry->email,
                        'namakaryawan'=>$emailkry->nama,
                        'id_jeniscuti'=>$cuti->jeniscutis->jenis_cuti,
                        'keperluan'   =>$cuti->keperluan,
                        'tgl_mulai'   =>Carbon::parse($cuti->tgl_mulai)->format("d M Y"),
                        'tgl_selesai' =>Carbon::parse($cuti->tgl_selesai)->format("d M Y"),
                        'jml_cuti'    =>$cuti->jml_cuti,
                        'status'      =>$status->name_status,
                        'jabatanatasan' => $atasan->jabatan
                    ];
                    Mail::to($tujuan)->send(new CutiAtasan2Notification($data));
                    return redirect()->back()->withInput();
                }
                else{
                    return redirect()->back();
                }
            }
            elseif($role == 3 && $row->jabatan = "Asisten Manajer" ||  $role == 2 && $row->jabatan = "Asisten Manajer")
            {
                $dacuti = DB::table('cuti')
                    ->leftjoin('alokasicuti', 'cuti.id_alokasi', '=', 'alokasicuti.id')
                    ->leftjoin('settingalokasi', 'cuti.id_settingalokasi', '=', 'settingalokasi.id')
                    ->leftjoin('karyawan','cuti.id_karyawan','karyawan.id')
                    ->where('cuti.id',$cuti->id)
                    ->where('karyawan.atasan_pertama', Auth::user()->id_pegawai)
                    ->select('cuti.*','karyawan.atasan_pertama')
                    ->first();
    
                // dd($dacuti);
                if($dacuti)
                {
                    // dd($dacuti);
                    $status = Status::find(6);
                    Cuti::where('id',$id)->update([
                        'status' => $status->id,
                    ]);
                    $cuti = Cuti::where('id',$id)->first();
                    $jeniscuti = Jeniscuti::where('id',$cuti->id_jeniscuti)->first();
    
                    //email karyawan
                    $emailkry = DB::table('cuti')->join('karyawan','cuti.id_karyawan','=','karyawan.id')
                        ->where('cuti.id_karyawan','=',$dacuti->id_karyawan)
                        ->select('karyawan.email','karyawan.nama','karyawan.atasan_kedua')
                        ->first();
    
                    $atasan2 = Karyawan::where('id',$emailkry->atasan_kedua)
                        ->select('email as email','nama as nama','jabatan as jabatan')
                        ->first();
                    
                    //ambil email atasan pertama 
                    $atasan1 = Auth::user()->email;
    
                    $tujuan = $atasan2->email;
                    
                    $data = [
                        'subject'     =>'Notifikasi Approval Pertama Permintaan ' . $jeniscuti->jenis_cuti . ' #' . $cuti->id . ' ' . $emailkry->nama,
                        'id'          =>$cuti->id,
                        'atasan2'     => $atasan2->email,
                        'namaatasan2' => $atasan2->nama,
                        'jeniscuti'   => $jeniscuti->jenis_cuti,
                        'karyawan_email' =>$emailkry->email,
                        'namakaryawan'=>$emailkry->nama,
                        'id_jeniscuti'=>$cuti->jeniscutis->jenis_cuti,
                        'keperluan'   =>$cuti->keperluan,
                        'tgl_mulai'   =>Carbon::parse($cuti->tgl_mulai)->format("d M Y"),
                        'tgl_selesai' =>Carbon::parse($cuti->tgl_selesai)->format("d M Y"),
                        'jml_cuti'    =>$cuti->jml_cuti,
                        'status'      =>$status->name_status,
                        'jabatanatasan' => $atasan2->jabatan
                    ];
                    Mail::to($tujuan)->send(new CutiAtasan2Notification($data));
                    // dd($data,$tujuan);
                    return redirect()->back();
                }else{
                    return redirect()->back();
                }
            }
            else{
                return redirect()->back();
            } 

        }  
    }

    public function cutireject(Request $request, $id)
    {
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

        //----SEND EMAIL KE KARYAWAN DAN SEMUA ATASAN -------
        //ambil nama jeniscuti
        $ct = DB::table('cuti')
            ->join('jeniscuti','cuti.id_jeniscuti','=','jeniscuti.id')
            ->join('statuses','izin.status','=','statuses.id')
            ->where('cuti.id',$id)
            ->select('cuti.*','jeniscuti.jenis_cuti as jenis_cuti','statuses.name_status')
            ->first();
        $alasan = Datareject::where('id_cuti',$cuti->id)->first();
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
            'subject'     => 'Notifikasi Permintaan Cuti Ditolak, Cuti ' . $ct->jenis_cuti . ' #' . $ct->id . ' ' . $karyawan->nama,
            'id'          => $ct->id,
            'atasan1'     => $atasan1->email,
            'namaatasan1' => $atasan1->nama,
            'karyawan_email'=>$karyawan->email,
            'id_jeniscuti'=> $ct->jenis_cuti,
            'keperluan'   => $ct->keperluan,
            'namakaryawan'=> $karyawan->nama,
            'tgl_mulai'   => Carbon::parse($ct->tgl_mulai)->format("d M Y"),
            'tgl_selesai' => Carbon::parse($ct->tgl_selesai)->format("d M Y"),
            'jml_cuti'    => $ct->jml_cuti,
            'status'      => $ct->name_status,
            'alasan'      =>$alasan->alasan,
        ];
        if($atasan2 !== NULL){
            $data['atasan2'] = $atasan2->email;
            $data['namaatasan2'] = $atasan2->nama;
        }
        // return $data;
        Mail::to($tujuan)->send(new CutiApproveNotification($data));
        return redirect()->back()->withInput();
    }

    public function izinApproved(Request $request, $id)
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

        if($row->jabatan == "Manager" && $role == 3)
        {
            if($izin && $izin->atasan_kedua == Auth::user()->id_pegawai)
            {
                // return Auth::user()->name;
                $status = Status::find(7);
        
                Izin::where('id',$id)->update([
                    'status' => $status->id,
                ]);

                $izinn = Izin::where('id',$id)->first();
                $jenisizin = Jenisizin::where('id',$izinn->id_jenisizin)->first();

                //KIRIM EMAIL NOTIFIKASI KE KARYAWAN< 2 tingkat atasna dan HRD.
                
                $emailkry = DB::table('izin')->join('karyawan','izin.id_karyawan','=','karyawan.id')
                    ->where('izin.id_karyawan','=',$izin->id_karyawan)
                    ->select('karyawan.email','karyawan.nama','karyawan.atasan_pertama','karyawan.atasan_kedua')
                    ->first();

                $atasan1 = Karyawan::where('id',$emailkry->atasan_pertama)
                    ->select('email as email','nama as nama','jabatan as jabatan','divisi as departemen')
                    ->first();
                
                //atasan kedua yg login
                $atasan2 = Auth::user()->email;
                $tujuan = $emailkry->email;

                $data = [
                    'title'       =>$izinn->id,
                    'subject'     =>'Notifikasi Izin Disetujui, Izin '  . $jenisizin->jenis_izin . ' #' . $izinn->id . ' ' . $emailkry->nama,
                    'id'          =>$izinn->id,
                    'karyawan_email'=>$emailkry->email,
                    'id_jenisizin'=>$izinn->jenis_izin,
                    'atasan1'     =>$atasan1->email,
                    'atasan2'     =>$atasan2,
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
                    'namaatasan2' =>$atasan1->nama,
                    'jabatanatasan'=>$atasan1->jabatan,
                ];
                Mail::to($tujuan)->send(new IzinApproveNotification($data));
                return redirect()->route('cuti.Staff',['tp'=>2]);
            }
            elseif($izin && $izin->atasan_pertama == Auth::user()->id_pegawai)
            {
                // return Auth::user()->role;
                $status = Status::find(2);

                // return $status;
                Izin::where('id',$id)->update([
                    'status' => $status->id,
                ]);

                $izinn = Izin::where('id',$id)->first();
                $jenisizin = Jenisizin::where('id',$izinn->id_jenisizin)->first();

                //KIRIM NOTIFIKASI EMAIL KE KARYAWAN DAN ATASAN 2
                $emailkry = DB::table('izin')->join('karyawan','izin.id_karyawan','=','karyawan.id')
                    ->where('izin.id_karyawan','=',$izinn->id_karyawan)
                    ->select('karyawan.email','karyawan.nama','karyawan.atasan_kedua')
                    ->first();

                $atasan = Karyawan::where('id', $emailkry->atasan_kedua)
                    ->select('email as email','nama as nama','jabatan')
                    ->first();

                //atasan pertama
                $atasan1 = Auth::user()->email;
                $tujuan = $atasan->email;
                $data = [
                    'subject'     =>'Notifikasi Approval Pertama Izin '  . $jenisizin->jenis_izin . ' #' . $izinn->id . ' ' . $emailkry->nama,
                    'id'          =>$izinn->id,
                    'atasan1'     => $atasan1,
                    'karyawan_email'=>$emailkry->email,
                    'id_jenisizin'=> $jenisizin->jenis_izin,
                    'keperluan'   =>$izinn->keperluan,
                    'tgl_mulai'   =>Carbon::parse($izinn->tgl_mulai)->format("d M Y"),
                    'tgl_selesai' =>Carbon::parse($izinn->tgl_selesai)->format("d M Y"),
                    'jam_mulai'   =>Carbon::parse($izinn->jam_mulai)->format("H:i"),
                    'jam_selesai' =>Carbon::parse($izinn->jam_selesai)->format("H:i"),
                    'jml_hari'    =>$izinn->jml_hari,
                    'jumlahjam'   =>$izinn->jml_jam,
                    'status'      =>$status->name_status,
                    'namakaryawan'=> $emailkry->nama,
                    'namaatasan2' =>$atasan->nama,
                    'jabatanatasan'=>$atasan->jabatan,
                ];
                Mail::to($tujuan)->send(new IzinAtasan2Notification($data));
                return redirect()->back()->withInput();
            }  
            else{
                return redirect()->back();
            }
        }
        elseif($role == 3 && $row->jabatan = "Asisten Manajer" || $role == 2 && $row->jabatan = "Asisten Manajer")
        {
            if($izin && $izin->atasan_pertama == Auth::user()->id_pegawai)
            {
                dd($izin->atasan_pertama, Auth::user()->id_pegawai);
                $status = Status::find(6);
            
                Izin::where('id',$id)->update([
                    'status' => $status->id,
                ]);

                $izinn = Izin::where('id',$id)->first();
                $jenisizin = Jenisizin::where('id',$izinn->id_jenisizin)->first();
                    
                //KIRIM NOTIFIKASI EMAIL KE ATASAN 2 dan karyawan
                $emailkry = DB::table('izin')->join('karyawan','izin.id_karyawan','=','karyawan.id')
                    ->where('izin.id_karyawan','=',$izinn->id_karyawan)
                    ->select('karyawan.email','karyawan.nama','karyawan.atasan_pertama','karyawan.atasan_kedua')
                    ->first();

                $atasan = Karyawan::where('id',$emailkry->atasan_kedua)
                    ->select('email as email','nama as nama','jabatan')
                    ->first();

                //atasan pertama
                $atasan1 = Auth::user()->email;
                $tujuan = $atasan->email;

                $data = [
                    'subject'     =>'Notifikasi Approval Pertama Izin ' . $jenisizin->jenis_izin . ' #' . $izinn->id . ' ' . $emailkry->nama,
                    'id'          =>$izinn->id,
                    'atasan1'     => $atasan1,
                    'karyawan_email'=>$emailkry->email,
                    'id_jenisizin'=> $jenisizin->jenis_izin,
                    'keperluan'   =>$izinn->keperluan,
                    'tgl_mulai'   =>Carbon::parse($izinn->tgl_mulai)->format("d M Y"),
                    'tgl_selesai' =>Carbon::parse($izinn->tgl_selesai)->format("d M Y"),
                    'jam_mulai'   =>Carbon::parse($izinn->jam_mulai)->format("H:i"),
                    'jam_selesai' =>Carbon::parse($izinn->jam_selesai)->format("H:i"),
                    'jml_hari'    =>$izinn->jml_hari,
                    'jumlahjam'   =>$izinn->jml_jam,
                    'status'      =>$status->name_status,
                    'namakaryawan'=> $emailkry->nama,
                    'namaatasan2' =>$atasan->nama,
                    'jabatanatasan'=>$atasan->jabatan,
                ];
                Mail::to($tujuan)->send(new IzinAtasan2Notification($data));
                return redirect()->back()->withInput();
            }
            else
            {
                return redirect()->back();
            }
        }
        else
        {
            return redirect()->back(); 
        }
        
    }

    public function izinReject(Request $request, $id)
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
        $atasan2 = Karyawan::where('id',$karyawan->atasan_kedua)
            ->select('email as email','nama as nama','jabatan')
            ->first();
        $atasan1 = Karyawan::where('id',$karyawan->atasan_pertama)
            ->select('email as email','nama as nama','jabatan')
            ->first();

        $tujuan = $karyawan->email;
        $data = [
            'subject'  =>'Notifikasi Permintaan Izin Ditolak, Izin ' . $izin->jenis_izin . ' #' . $izin->id . ' ' . $karyawan->nama,
            'id'       =>$izin->id,
            'atasan1'     => $atasan1->email,
            'atasan2'     => $atasan2->email,
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
            'namaatasan2' =>$atasan2->nama,
            'nama'        =>$karyawan->nama,
            'jenisizin'   =>$izin->jenis_izin,
            'alasan'      =>$alasan->alasan,
        ];
        Mail::to($tujuan)->send(new IzinApproveNotification($data));
        return redirect()->route('cuti.Staff',['type'=>2])->withInput();
    }

    //export excel data by filter di bagian manager 
    //DIGUNAKAN
    public function exportToExcel(Request $request)
    {
        $role = Auth::user()->role;
        $nbulan = $request->query('bulan',Carbon::now()->format('M Y'));
        $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();    
        //mengambil id_departemen user
        $middep = DB::table('absensi')
            ->join('karyawan','absensi.id_departement','=','karyawan.divisi')
            ->where('absensi.id_karyawan','=',Auth::user()->id_pegawai)
            ->select('id_departement')->first();


        $idkaryawan = $request->id_karyawan;
        $bulan      = $request->query('bulan',Carbon::now()->format('m'));
        $tahun      = $request->query('tahun',Carbon::now()->format('Y'));

        // simpan session
        $idkaryawan = $request->session()->get('idkaryawan');
        $bulan      = $request->session()->get('bulan');
        $tahun      = $request->session()->get('tahun');

        if ($role == 3 && $row->jabatan = "Manager") 
        {
            if(isset($idkaryawan) && isset($bulan) && isset($tahun))
            {
                $data = Absensi::with('karyawans','departemens')
                    ->where('id_karyawan', $idkaryawan)
                    ->whereMonth('tanggal', $bulan)
                    ->whereYear('tanggal',$tahun)
                    ->where('id_departement',$middep->id_departement)
                    ->get();
                // dd($data);
                $departemen = Departemen::where('id',$middep->id_departement)->first();
    
                return Excel::download(new AbsensiFilterExport($data,$idkaryawan,$middep), 
                "REKAP ABSENSI BULAN ".$nbulan." ".$data->first()->karyawans->nama." DEPARTEMEN ".$departemen->nama_departemen.".xlsx");
            }else{
                $data = Absensi::with('karyawans','departemens')
                    ->where('id_departement',$middep->id_departement)
                    ->get();
                $departemen = Departemen::where('id',$middep->id_departement)->first();
                return Excel::download(new AbsensiFilterExport($data,$idkaryawan,$middep), 
                "REKAP ABSENSI DEPARTEMEN ".$departemen->nama_departemen.".xlsx");
            };
        }
        elseif ($role == 3 && $row->jabatan = "Asisten Manajer") 
            {
                if(isset($idkaryawan) && isset($bulan) && isset($tahun))
                {
                    $data = Absensi::with('karyawans','departemens')
                        ->where('id_karyawan', $idkaryawan)
                        ->where('id_departement',$middep->id_departement)
                        ->whereMonth('tanggal', $bulan)
                        ->whereYear('tanggal',$tahun)
                        ->get();
                    // dd($data);
                    $departemen = Departemen::where('id',$middep->id_departement)->first();
        
                    return Excel::download(new AbsensiFilterExport($data,$idkaryawan,$middep), 
                    "REKAP ABSENSI BULAN ".$nbulan." ".$data->first()->karyawans->nama." DEPARTEMEN ".$departemen->nama_departemen.".xlsx");
                }else{
                    $pegawai = Karyawan::where('jabatan','Staff')->orWhere('jabatan','Asisten Manajer')
                        ->select('id as idkaryawan')
                        ->get();

                    $data = Absensi::where('id_departement', $middep->id_departement)
                        ->whereIn('id_karyawan',$pegawai->pluck('idkaryawan'))
                        ->get();
                    $departemen = Departemen::where('id',$middep->id_departement)->first();
                    return Excel::download(new AbsensiFilterExport($data,$idkaryawan,$middep), "REKAP ABSENSI DEPARTEMEN ".$departemen->nama_departemen.".xlsx");
                };
            }
            else
                {
                    return redirect()->back();
                }
    }

    //DIGUNAKAN
    public function exportpdf(Request $request)
    {
        $role = Auth::user()->role;
        $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
        $nbulan = $request->query('bulan',Carbon::now()->format('M Y'));

        //mengambil id_departemen user
        $middep = DB::table('absensi')
            ->join('karyawan','absensi.id_departement','=','karyawan.divisi')
            ->where('absensi.id_karyawan','=',Auth::user()->id_pegawai)
            ->select('id_departement')->first();

        $idkaryawan = $request->id_karyawan;
        $bulan      = $request->query('bulan',Carbon::now()->format('m'));
        $tahun      = $request->query('tahun',Carbon::now()->format('Y'));

        // simpan session
        $idkaryawan = $request->session()->get('idkaryawan');
        $bulan      = $request->session()->get('bulan');
        $tahun      = $request->session()->get('tahun',);

        if($role == 3 && $row->jabatan = "Manager")
        {
            if(isset($idkaryawan) && isset($bulan) && isset($tahun))
            {
                $data = Absensi::where('id_karyawan', $idkaryawan)
                    ->where('id_departement',$middep->id_departement)
                    ->whereMonth('tanggal', $bulan)
                    ->whereYear('tanggal',$tahun)
                    ->get();
                $departemen = Departemen::where('id',$middep->id_departement)->first();

                $pdf  = PDF::loadview('manager.staff.absensistaff_pdf',['data'=>$data,'idkaryawan'=>$idkaryawan,'departemen'=>$departemen])
                ->setPaper('A4','landscape');
                return $pdf->stream("REKAP ABSENSI BULAN ".$nbulan." ".$data->first()->karyawans->nama." DEPARTEMEN ".$departemen->nama_departemen.".pdf");
        
            }else
            {
                $data = Absensi::with('karyawans','departemens')
                    ->where('id_departement',$middep->id_departement)
                    ->get();
                $departemen = Departemen::where('id',$middep->id_departement)->first();
            }
            $pdf  = PDF::loadview('manager.staff.absensistaff_pdf',['data'=>$data,'idkaryawan'=>$idkaryawan,'departemen'=>$departemen])
            ->setPaper('A4','landscape');
            return $pdf->stream("REKAP ABSENSI BULAN ".$nbulan." "." DEPARTEMEN ".$departemen->nama_departemen.".pdf");
        }
        elseif($role == 3 && $row->jabatan = "Asisten Manajer")
            {
                if(isset($idkaryawan) && isset($bulan) && isset($tahun))
                {
                    $data = Absensi::with('karyawans','departemens')
                        ->where('id_karyawan', $idkaryawan)
                        ->where('id_departement',$middep->id_departement)
                        ->whereMonth('tanggal', $bulan)
                        ->whereYear('tanggal',$tahun)
                        ->get();
                    $departemen = Departemen::where('id',$middep->id_departement)->first();

                    $pdf  = PDF::loadview('manager.staff.absensistaff_pdf',['data'=>$data,'idkaryawan'=>$idkaryawan,'departemen'=>$departemen])
                    ->setPaper('A4','landscape');
        
                    return $pdf->stream("REKAP ABSENSI BULAN ".$nbulan." ".$data->first()->karyawans->nama." DEPARTEMEN ".$departemen->nama_departemen.".pdf");
                
                }else
                {
                    $pegawai = Karyawan::where('jabatan','Staff')->orWhere('jabatan','Asisten Manajer')
                        ->select('id as idkaryawan')
                        ->get();
                    $data = Absensi::where('id_departement', $middep->id_departement)
                        ->whereIn('id_karyawan',$pegawai->pluck('idkaryawan'))
                        ->get();
                    // $data = Absensi::where('id_departement',$middep->id_departement)->get();
                    $departemen = Departemen::where('id',$middep->id_departement)->first();
                }
                $pdf  = PDF::loadview('manager.staff.absensistaff_pdf',['data'=>$data,'idkaryawan'=>$idkaryawan,'departemen'=>$departemen])
                ->setPaper('A4','landscape');
        
                return $pdf->stream("REKAP ABSENSI BULAN ".$nbulan." DEPARTEMEN ".$departemen->nama_departemen.".pdf");
            }
            else{
                return redirect()->back();
            };

    }


    public function resignStaff(Request $request)
    {
        $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
        $karyawan = karyawan::where('id', Auth::user()->id_pegawai)->first();
        $karyawan1 = Karyawan::all();
        $idkaryawan = $request->id_karyawan;
        // dd($karyawan);
        $resign = Resign::all();
     
        $tes = Auth::user()->karyawan->departemen->nama_departemen;

        $manager_iddep = DB::table('karyawan')
        ->where('id','=',Auth::user()->id_pegawai)
        ->select('divisi')->first();
        
        $staff1= Resign::with('departemens','karyawan')
        ->where('departemen',$manager_iddep->divisi)
        ->orderByDesc('created_at')
        ->get();
        return view('manager\staff.resignStaff', compact('karyawan','karyawan1','resign','tes','staff1','row'));
    }

}

// public function cutiapproved(Request $request, $id)
// {
//     $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
//     $role = Auth::user()->role;
//     $cuti = Cuti::where('id',$id)->first();

//     $atasanpertama = DB::table('cuti')
//         ->join('karyawan', 'cuti.id_karyawan', '=', 'karyawan.id')
//         ->select('cuti.*', 'karyawan.atasan_pertama')
//         ->where('karyawan.atasan_pertama', '=',Auth::user()->id_pegawai)
//         ->first();

//     $atasankedua = DB::table('cuti')
//         ->join('karyawan', 'cuti.id_karyawan', '=', 'karyawan.id')
//         ->select('cuti.*','karyawan.atasan_kedua')
//         ->where('karyawan.atasan_kedua', '=', Auth::user()->id_pegawai)
//         ->first();
    
//     if($role == 3 && $row->jabatan = "Manager")
//     {
      
//         return Auth::user()->nama;
//         if($atasanpertama &&  $atasanpertama->atasan_pertama  == Auth::user()->id_pegawai)
//         {
          
//             $status = Status::find(2);
//             Cuti::where('id',$id)->update([
//                 'status' => $status->id,
//             ]);
//             $cuti = Cuti::where('id',$id)->first();
//             //ambil nama_atasan
//             $idatasan = DB::table('cuti')
//                 ->join('karyawan','cuti.id_karyawan','=','karyawan.id')
//                 ->select('karyawan.atasan_kedua as atasan_kedua')
//                 ->where('cuti.id',$cuti->id)
//                 ->first();
//             $atasan = Karyawan::where('id',$idatasan->atasan_kedua)
//                 ->select('email as email')
//                 ->first();
            
//             //ambil data karyawan
//             $tujuan = $atasan->email;
          
            
//             $data = [
//                 'subject'     =>'Notifikasi Permintaan Cuti',
//                 'id'          =>$cuti->id,
//                 'id_jeniscuti'=>$cuti->jeniscutis->jenis_cuti,
//                 'keperluan'   =>$cuti->keperluan,
//                 'tgl_mulai'   =>Carbon::parse($cuti->tgl_mulai)->format("d M Y"),
//                 'tgl_selesai' =>Carbon::parse($cuti->tgl_selesai)->format("d M Y"),
//                 'jml_cuti'    =>$cuti->jml_cuti,
//                 'status'      =>$status->name_status,
//                 'namakaryawan'=>$cuti->karyawans->nama,
//             ];
//             Mail::to($tujuan)->send(new CutiAtasan2Notification($data));
//             return redirect()->back()->withInput();
//         }
//         elseif($atasankedua &&  $atasankedua->atasan_kedua == Auth::user()->id_pegawai)
//         {
//             // dd($atasankaryawan->atasan_kedua);
//             $cuti = Cuti::where('id',$id)->first();
//             $jml_cuti = $cuti->jml_cuti;
//             $status = Status::find(7);
//             Cuti::where('id', $id)->update(
//                 ['status' => $status->id,]
//             );
    
//             $alokasicuti = Alokasicuti::where('id', $cuti->id_alokasi)
//                 ->where('id_karyawan', $cuti->id_karyawan)
//                 ->where('id_jeniscuti', $cuti->id_jeniscuti)
//                 ->where('id_settingalokasi', $cuti->id_settingalokasi)
//                 ->first();

//             $durasi_baru = $alokasicuti->durasi - $jml_cuti;

//             Alokasicuti::where('id', $alokasicuti->id)
//             ->update(
//                 ['durasi' => $durasi_baru]
//             );

//             //ambil data karyawan
//             $tujuan = 'akhiratunnisahasanah0917@gmail.com';
//             $data = [
//                 'subject'     =>'Notifikasi Cuti Disetujui',
//                 'id'          =>$cuti->id,
//                 'id_jeniscuti'=>$cuti->jeniscutis->jenis_cuti,
//                 'keperluan'   =>$cuti->keperluan,
//                 'tgl_mulai'   =>Carbon::parse($cuti->tgl_mulai)->format("d M Y"),
//                 'tgl_selesai' =>Carbon::parse($cuti->tgl_selesai)->format("d M Y"),
//                 'jml_cuti'    =>$cuti->jml_cuti,
//                 'status'      =>$cuti->name_status,
//             ];
//             Mail::to($tujuan)->send(new CutiApproveNotification($data));
//             return redirect()->back()->withInput();
//         }
//         else{
//             return redirect()->back();
//         }
//     }
//     elseif($role == 3 && $row->jabatan = "Asisten Manajer")
//     {
//         dd($atasanpertama->atasan_pertama);
//         if($atasanpertama &&  $atasanpertama->atasan_pertama  == Auth::user()->id_pegawai)
//         {
//             $status = Status::find(6);
//             Cuti::where('id',$id)->update([
//                 'status' => $status->id,
//              ]);
//             $cuti = Cuti::where('id',$id)->first();
//             //ambil nama_atasan
//             $idatasan = DB::table('cuti')
//                 ->join('karyawan','cuti.id_karyawan','=','karyawan.id')
//                 ->select('karyawan.atasan_kedua as atasan_kedua')
//                 ->where('cuti.id',$cuti->id)
//                 ->first();
//             $atasan = Karyawan::where('id',$idatasan->atasan_kedua)
//                 ->select('email as email')
//                 ->first();
//             dd($idatasan,$atasan);
                
//             //ambil data karyawan
//             $tujuan = $atasan->email;
                
//             $data = [
//                 'subject'     =>'Notifikasi Permintaan Cuti',
//                 'id'          =>$cuti->id,
//                 'id_jeniscuti'=>$cuti->jeniscutis->jenis_cuti,
//                 'keperluan'   =>$cuti->keperluan,
//                 'tgl_mulai'   =>Carbon::parse($cuti->tgl_mulai)->format("d M Y"),
//                 'tgl_selesai' =>Carbon::parse($cuti->tgl_selesai)->format("d M Y"),
//                 'jml_cuti'    =>$cuti->jml_cuti,
//                 'status'      =>$status->name_status,
//                 'namakaryawan'=>$cuti->karyawans->nama,
//             ];
//             Mail::to($tujuan)->send(new CutiAtasan2Notification($data));
//             // dd($data,$tujuan);
//             return redirect()->back()->withInput();
//         }
//     }
//     else{
//         return redirect()->back();
//     }   
// }


    // public function exportallpdf()
    // {
    //     $role = Auth::user()->role;
    //     //mengambil id_departemen user login
    //     $middep = DB::table('absensi')
    //         ->join('karyawan','absensi.id_departement','=','karyawan.divisi')
    //         ->where('absensi.id_karyawan','=',Auth::user()->id_pegawai)
    //         ->select('id_departement')->first();

    //     if($role == 3)
    //     {
    //         $data = Absensi::where('id_departement',$middep->id_departement)->get();
    //         $pdf  = PDF::loadview('manager.staff.absensistaff_pdf',['data',$data],compact('data'))
    //         ->setPaper('A4','landscape');

    //         return $pdf->stream('Report Absensi Staff Departemen.pdf');
    //     }
    //     elseif($role == 5)
    //     {
    //         $data = Absensi::with(['karyawans' => function($query) {
    //             $query->select('id,nama')->where('jabatan','=', 'Staff');
    //         }])->where('id_departement',$middep->id_departement)->get();
            
    //         $pdf  = PDF::loadview('manager.staff.absensistaff_pdf',['data',$data],compact('data'))
    //         ->setPaper('A4','landscape');

    //         return $pdf->stream('Report Absensi Staff Departemen.pdf');
    //     }
    //     else
    //     {
    //         return redirect()->back();
    //     }
       
    // }


      // public function exportallExcel()
    // {
    //     $role = Auth::user()->role;
    //     if($role == 3)
    //     {
    //         $middep = DB::table('absensi')
    //         ->join('karyawan','absensi.id_departement','=','karyawan.divisi')
    //         ->where('absensi.id_karyawan','=',Auth::user()->id_pegawai)
    //         ->select('id_departement')->first();
    
    //         $data = Absensi::with('karyawans','departemens')
    //         ->where('id_departement',$middep->id_departement)
    //         ->get();
    
    //         return Excel::download(new AbsensiDepartemenExport($data), 'data_absensi_departemen.xlsx');
    //     }
    //     elseif($role == 5)
    //     {
    //         $middep = DB::table('absensi')
    //         ->join('karyawan','absensi.id_departement','=','karyawan.divisi')
    //         ->where('absensi.id_karyawan','=',Auth::user()->id_pegawai)
    //         ->select('absensi.id_departement as id_departement')
    //         ->first();
    
    //         $data = Absensi::with('karyawans','departemens')
    //         ->where('id_departement',$middep->id_departement)
    //         ->get();
    
    //         return Excel::download(new AbsensiDepartemenExport($data), 'data_absensi_departemen.xlsx');
    //     }
    //     else
    //     {
    //         return redirect()->back();
    //     }
        
    // }

    //DATA STAFF
     //mengambil id_departemen manager
            // $manager_iddep = DB::table('karyawan')
            //     ->where('id','=',Auth::user()->id_pegawai)
            //     ->select('divisi')->first();
             //ambil data dengan id_departemen sama dengan manager
            // $staff= Karyawan::with('departemens')
            //     ->where('divisi',$manager_iddep->divisi)
            //     ->where('jabatan','!=','Manager')->get();



