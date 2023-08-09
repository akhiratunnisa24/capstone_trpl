<?php

namespace App\Http\Controllers\direktur;

use Carbon\Carbon;
use App\Models\Cuti;
use App\Models\Izin;
use App\Models\Status;
use App\Models\Absensi;
use App\Models\Karyawan;
use App\Models\Sisacuti;
use App\Models\Jeniscuti;
use App\Models\Jenisizin;
use App\Models\Datareject;
use App\Models\Alokasicuti;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\CutiApproveNotification;
use App\Mail\CutiAtasan2Notification;
use App\Mail\IzinApproveNotification;
use App\Mail\IzinAtasan2Notification;
use App\Mail\CutiIzinTolakNotification;

class DirekturController extends Controller
{
    public function index(Request $request)
    {
        $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
        $role = Auth::user()->role;
        $tipe = $request->query('tipe',1);
        $karyawan = Karyawan::where('atasan_pertama', Auth::user()->id_pegawai)->orWhere('atasan_kedua', Auth::user()->id_pegawai)->get();
        $pegawai = Karyawan::where('atasan_pertama', Auth::user()->id_pegawai)->orWhere('atasan_kedua', Auth::user()->id_pegawai)->get();

        if($row->jabatan == "Direksi" && $role == 3)
        {
          
            // return $row->jabatan;
            $id_user_login = Auth::user()->id_pegawai;
            if($request->id_karyawan)
            {
                $tipe = $request->query('tipe',1);
                $idkaryawan = $request->id_karyawan;
                $bulans = $request->query('bulans', Carbon::now()->format('m'));
                $tahuns = $request->query('tahuns', Carbon::now()->format('Y'));

                // simpan session
                $request->session()->put('idkaryawan', $request->id_karyawan);
                $request->session()->put('bulans', $bulans);
                $request->session()->put('tahuns', $tahuns);

                if (isset($idkaryawan) && isset($bulans) && isset($tahuns)) 
                {
                    $tipe = $request->query('tipe',1);
                    $cuti = DB::table('cuti')
                        ->leftjoin('jeniscuti','cuti.id_jeniscuti','jeniscuti.id')
                        ->leftjoin('karyawan','cuti.id_karyawan','karyawan.id')
                        ->leftjoin('alokasicuti','cuti.id_alokasi','alokasicuti.id')
                        ->leftjoin('settingalokasi','cuti.id_settingalokasi','settingalokasi.id')
                        ->leftjoin('statuses','cuti.status','statuses.id')
                        ->leftjoin('datareject','datareject.id_cuti','cuti.id')
                        ->leftjoin('departemen','cuti.departemen','departemen.id')
                        ->where(function($query) use ($row){
                            $query->where('karyawan.atasan_pertama',Auth::user()->id_pegawai)
                            ->orWhere(function($query) use ($row){
                                $query->where('karyawan.atasan_kedua',Auth::user()->id_pegawai);
                            });    
                        })
                        ->where('cuti.id_karyawan', $idkaryawan)
                        ->whereMonth('cuti.tgl_mulai', $bulans)
                        ->whereYear('cuti.tgl_mulai', $tahuns)
                        ->select('cuti.*', 'jeniscuti.jenis_cuti', 'karyawan.nama','karyawan.atasan_pertama','karyawan.atasan_kedua','statuses.name_status','datareject.alasan','departemen.nama_departemen')
                        ->distinct()
                        ->orderBy('cuti.id', 'desc')
                        ->get();

                    $izin = DB::table('izin')
                        ->leftjoin('karyawan','izin.id_karyawan','karyawan.id')
                        ->leftjoin('jenisizin','izin.id_jenisizin','jenisizin.id')
                        ->leftjoin('statuses','izin.status','=','statuses.id')
                        ->leftjoin('datareject','datareject.id_izin','=','izin.id')
                        ->leftjoin('departemen','izin.departemen','=','departemen.id')
                        ->where(function($query) use ($row){
                            $query->where('karyawan.atasan_pertama',Auth::user()->id_pegawai)
                            ->orWhere(function($query) use ($row){
                                $query->where('karyawan.atasan_kedua',Auth::user()->id_pegawai);
                            });    
                        })
                        ->select('izin.*','karyawan.nama','karyawan.atasan_pertama','karyawan.atasan_kedua','jenisizin.jenis_izin','statuses.name_status','datareject.alasan as alasan','departemen.nama_departemen')
                        ->distinct()
                        ->get();
                    return view('direktur.cuti.index', compact('cuti','row','tipe','izin','karyawan','pegawai'));
                } else
                {
                    $tipe = $request->query('tipe',1);
                    $cuti = DB::table('cuti')
                        ->leftjoin('alokasicuti', 'cuti.id_jeniscuti', 'alokasicuti.id_jeniscuti')
                        ->leftjoin('settingalokasi', 'cuti.id_jeniscuti', 'settingalokasi.id_jeniscuti')
                        ->leftjoin('jeniscuti', 'cuti.id_jeniscuti', 'jeniscuti.id')
                        ->leftjoin('karyawan', 'cuti.id_karyawan', 'karyawan.id')
                        ->leftjoin('statuses', 'cuti.status', 'statuses.id')
                        ->leftjoin('datareject', 'datareject.id_cuti','cuti.id')
                        ->leftjoin('departemen','cuti.departemen','departemen.id')
                        ->where(function($query) use ($row){
                            $query->where('karyawan.atasan_pertama',Auth::user()->id_pegawai)
                            ->orWhere(function($query) use ($row){
                                $query->where('karyawan.atasan_kedua',Auth::user()->id_pegawai);
                            });    
                        })
                        ->select('cuti.*', 'jeniscuti.jenis_cuti', 'departemen.nama_departemen', 'karyawan.nama','statuses.name_status', 'karyawan.atasan_pertama', 'karyawan.atasan_kedua', 'datareject.alasan as alasan', 'datareject.id_cuti as id_cuti')
                        ->distinct()
                        ->orderBy('cuti.id', 'DESC')
                        ->get();

                    $izin = DB::table('izin')
                        ->leftjoin('karyawan','izin.id_karyawan','karyawan.id')
                        ->leftjoin('jenisizin','izin.id_jenisizin','jenisizin.id')
                        ->leftjoin('statuses','izin.status','=','statuses.id')
                        ->leftjoin('datareject','datareject.id_izin','=','izin.id')
                        ->leftjoin('departemen','izin.departemen','=','departemen.id')
                        ->where(function($query) use ($row){
                            $query->where('karyawan.atasan_pertama',Auth::user()->id_pegawai)
                            ->orWhere(function($query) use ($row){
                                $query->where('karyawan.atasan_kedua',Auth::user()->id_pegawai);
                            });    
                        })
                        ->select('izin.*','karyawan.nama','karyawan.atasan_pertama','karyawan.atasan_kedua','jenisizin.jenis_izin','statuses.name_status','datareject.alasan as alasan','departemen.nama_departemen')
                        ->distinct()
                        ->get();
                    return view('direktur.cuti.index', compact('cuti','row','tipe','izin','karyawan','pegawai'));
                }

            }else
            {
                 // Filter Data Izin
                $idpegawai = $request->idpegawai;
                $months = $request->query('months', Carbon::now()->format('m'));
                $year = $request->query('year', Carbon::now()->format('Y'));
   
                 // simpan session
                $request->session()->put('idpegawai', $idpegawai);
                $request->session()->put('months', $months);
                $request->session()->put('year', $year);

                if(isset($idpegawai) && isset($months) && isset($year)) 
                {
                    $tipe = $request->query('tipe',2);
                    $izin = DB::table('izin')
                        ->leftjoin('karyawan','izin.id_karyawan','karyawan.id')
                        ->leftjoin('jenisizin','izin.id_jenisizin','jenisizin.id')
                        ->leftjoin('statuses','izin.status','=','statuses.id')
                        ->leftjoin('datareject','datareject.id_izin','=','izin.id')
                        ->leftjoin('departemen','izin.departemen','=','departemen.id')
                        ->where(function($query) use ($row){
                            $query->where('karyawan.atasan_pertama',Auth::user()->id_pegawai)
                            ->orWhere(function($query) use ($row){
                                $query->where('karyawan.atasan_kedua',Auth::user()->id_pegawai);
                            });    
                        })
                        ->where('izin.id_karyawan', $idpegawai)
                        ->whereMonth('izin.tgl_mulai', $months)
                        ->whereYear('izin.tgl_mulai', $year)
                        ->select('izin.*','karyawan.nama','karyawan.atasan_pertama','karyawan.atasan_kedua','jenisizin.jenis_izin','statuses.name_status','datareject.alasan as alasan','departemen.nama_departemen')
                        ->distinct()
                        ->get();

                    $cuti = DB::table('cuti')
                        ->leftjoin('alokasicuti', 'cuti.id_jeniscuti', 'alokasicuti.id_jeniscuti')
                        ->leftjoin('settingalokasi', 'cuti.id_jeniscuti', 'settingalokasi.id_jeniscuti')
                        ->leftjoin('jeniscuti', 'cuti.id_jeniscuti', 'jeniscuti.id')
                        ->leftjoin('karyawan', 'cuti.id_karyawan', 'karyawan.id')
                        ->leftjoin('statuses', 'cuti.status', 'statuses.id')
                        ->leftjoin('datareject', 'datareject.id_cuti','cuti.id')
                        ->leftjoin('departemen','cuti.departemen','departemen.id')
                        ->where(function($query) use ($row){
                            $query->where('karyawan.atasan_pertama',Auth::user()->id_pegawai)
                            ->orWhere(function($query) use ($row){
                                $query->where('karyawan.atasan_kedua',Auth::user()->id_pegawai);
                            });    
                        })
                        ->select('cuti.*', 'jeniscuti.jenis_cuti', 'departemen.nama_departemen', 'karyawan.nama','statuses.name_status', 'karyawan.atasan_pertama', 'karyawan.atasan_kedua', 'datareject.alasan as alasan', 'datareject.id_cuti as id_cuti')
                        ->distinct()
                        ->orderBy('cuti.id', 'DESC')
                        ->get();
                    return view('direktur.cuti.index', compact('cuti','row','tipe','izin','karyawan','pegawai'));
                }
                else
                {
                    $cuti = DB::table('cuti')
                        ->leftjoin('alokasicuti', 'cuti.id_jeniscuti', 'alokasicuti.id_jeniscuti')
                        ->leftjoin('settingalokasi', 'cuti.id_jeniscuti', 'settingalokasi.id_jeniscuti')
                        ->leftjoin('jeniscuti', 'cuti.id_jeniscuti', 'jeniscuti.id')
                        ->leftjoin('karyawan', 'cuti.id_karyawan', 'karyawan.id')
                        ->leftjoin('statuses', 'cuti.status', 'statuses.id')
                        ->leftjoin('datareject', 'datareject.id_cuti','cuti.id')
                        ->leftjoin('departemen','cuti.departemen','departemen.id')
                        ->where(function($query) use ($row){
                            $query->where('karyawan.atasan_pertama',Auth::user()->id_pegawai)
                            ->orWhere(function($query) use ($row){
                                $query->where('karyawan.atasan_kedua',Auth::user()->id_pegawai);
                            });    
                        })
                        ->select('cuti.*', 'jeniscuti.jenis_cuti', 'departemen.nama_departemen', 'karyawan.nama','statuses.name_status', 'karyawan.atasan_pertama', 'karyawan.atasan_kedua', 'datareject.alasan as alasan', 'datareject.id_cuti as id_cuti')
                        ->distinct()
                        ->orderBy('cuti.id', 'DESC')
                        ->get();

                    $izin = DB::table('izin')
                        ->leftjoin('karyawan','izin.id_karyawan','karyawan.id')
                        ->leftjoin('jenisizin','izin.id_jenisizin','jenisizin.id')
                        ->leftjoin('statuses','izin.status','=','statuses.id')
                        ->leftjoin('datareject','datareject.id_izin','=','izin.id')
                        ->leftjoin('departemen','izin.departemen','=','departemen.id')
                        ->where(function($query) use ($row){
                            $query->where('karyawan.atasan_pertama',Auth::user()->id_pegawai)
                            ->orWhere(function($query) use ($row){
                                $query->where('karyawan.atasan_kedua',Auth::user()->id_pegawai);
                            });    
                        })
                        ->select('izin.*','karyawan.nama','karyawan.atasan_pertama','karyawan.atasan_kedua','jenisizin.jenis_izin','statuses.name_status','datareject.alasan as alasan','departemen.nama_departemen')
                        ->distinct()
                        ->get();
                    return view('direktur.cuti.index', compact('cuti','row','tipe','izin','karyawan','pegawai'));
                }
                //menghapus filter data
                $request->session()->forget('id_karyawan');
                $request->session()->forget('bulans');
                $request->session()->forget('tahuns');

                $request->session()->forget('idpegawai');
                $request->session()->forget('months');
                $request->session()->forget('year');

            }
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
        $cuti = Cuti::where('id',$id)->first();
        $year = Carbon::now()->subYear()->year;

        $cekSisacuti = Sisacuti::join('cuti', 'cuti.id_jeniscuti', 'sisacuti.jenis_cuti')
            ->join('alokasicuti', 'sisacuti.id_alokasi', 'alokasicuti.id')
            ->where('cuti.id',$cuti->id)
            ->where('cuti.id_alokasi',$cuti->id_alokasi)
            ->where('sisacuti.id_alokasi',$cuti->id_alokasi)
            ->where('sisacuti.id_pegawai',$cuti->id_karyawan)
            ->exists();
        
            if ($cekSisacuti) 
            {
                if($row->jabatan == "Direksi" && $role == 3)
                {
                    $datacuti = DB::table('cuti')
                        ->leftjoin('settingalokasi', 'cuti.id_settingalokasi', '=', 'settingalokasi.id')
                        ->leftjoin('karyawan','cuti.id_karyawan','karyawan.id')
                        ->where('cuti.id',$cuti->id)
                        ->where('karyawan.atasan_pertama', Auth::user()->id_pegawai)
                        ->orWhere('karyawan.atasan_kedua',Auth::user()->id_pegawai)
                        ->select('cuti.*','karyawan.atasan_pertama','karyawan.atasan_kedua')
                        ->first();
    
                  //    return $datacuti;
                    if($datacuti && $datacuti->atasan_pertama == Auth::user()->id_pegawai  && $row->jabatan == "Manager")
                    {
                        // return $datacuti->atasan_pertama;
                        $status = Status::find(6);
                        Cuti::where('id',$id)->update([
                            'status' => $status->id,
                            'tgldisetujui_a' => Carbon::now()->format('Y-m-d H:i:s'),
                        ]);
                        $cuti = Cuti::where('id',$id)->first();
                        $jeniscuti = Jeniscuti::where('id',$cuti->id_jeniscuti)->first();
                        $jml_cuti = $cuti->sisacuti;
    
                        //KIRIM NOTIFIKASI EMAIL KE KARYAWAN DAN ATASAN 2
        
                        //ambil data karyawan
                        $emailkry = DB::table('cuti')->join('karyawan','cuti.id_karyawan','=','karyawan.id')
                            ->join('departemen','cuti.departemen','=','departemen.id')
                            ->where('cuti.id_karyawan','=',$datacuti->id_karyawan)
                            ->select('karyawan.email','karyawan.nama as nama','karyawan.atasan_kedua','departemen.nama_departemen')
                            ->first();
        
                        $atasan = NULL;

                        if($emailkry->atasan_kedua !== NULL)
                        {
                            $atasan = Karyawan::where('id',$emailkry->atasan_kedua)
                            ->select('email as email','nama as nama','nama_jabatan as jabatan')
                            ->first();
                        }
                        //atasan pertama
                        $atasan1 = Auth::user()->email;
        
                        //ambil data karyawan
                        $tujuan = $atasan->email ?? null;
                        $data = [
                            'subject'     =>'Notifikasi Approval Pertama Permohonan ' . $jeniscuti->jenis_cuti . ' #' . $cuti->id . ' ' . $emailkry->nama,
                            'noregistrasi'=>$cuti->id,
                            'title' =>  'NOTIFIKASI PERSETUJUAN PERTAMA FORMULIR CUTI KARYAWAN',
                            'subtitle' => '[PERSETUJUAN ATASAN]',
                            'tgl_permohonan' =>Carbon::parse($cuti->tgl_permohonan)->format("d/m/Y"),
                            'nik'         => $cuti->nik,
                            'jabatankaryawan' => $cuti->jabatan,
                            'departemen' => $emailkry->nama_departemen,
                            'id_jeniscuti'   => $jeniscuti->jenis_cuti,
                            'karyawan_email' =>$emailkry->email,
                            'namakaryawan'=>ucwords(strtolower($emailkry->nama)),
                            'id_jeniscuti'=>$cuti->jeniscutis->jenis_cuti,
                            'keperluan'   =>$cuti->keperluan,
                            'tgl_mulai'   =>Carbon::parse($cuti->tgl_mulai)->format("d/m/Y"),
                            'tgl_selesai' =>Carbon::parse($cuti->tgl_selesai)->format("d/m/Y"),
                            'tgldisetujuiatasan' => Carbon::parse($cuti->tgl_disetujui_a)->format("d/m/Y H:i"),
                            'jml_cuti'    =>$cuti->jml_cuti,
                            'status'      =>$status->name_status,
                            'jabatanatasan' => $atasan->jabatan
                        ];
                        if($atasan !== NULL){
                            $data['atasan2'] = $atasan->email;
                            $data['namaatasan2'] = $atasan->nama;
                        }
                        Mail::to($tujuan)->send(new CutiAtasan2Notification($data));
                        return redirect()->back()->withInput();
                    }
                    elseif($datacuti && $datacuti->atasan_kedua == Auth::user()->id_pegawai)
                    {
                        // return  Auth::user()->name;
                        $cuti = Cuti::where('id',$id)->first();
                        $jeniscuti = Jeniscuti::where('id',$cuti->id_jeniscuti)->first();
                        
                        $jml_cuti = $cuti->jml_cuti;
                        $status = Status::find(7);
                        Cuti::where('id', $id)->update(
                            ['status' => $status->id,
                            'tgldisetujui_b' => Carbon::now()->format('Y-m-d H:i:s'),
                            ]
                        );
                        $cut = Cuti::where('id',$id)->first();
                        $sisacuti = Sisacuti::where('jenis_cuti', $cuti->id_jeniscuti)
                            ->where('id_pegawai', $cuti->id_karyawan)
                            ->first();
        
                        $sisacuti_baru = $sisacuti->sisacuti - $jml_cuti;
        
                        Sisacuti::where('id', $sisacuti->id)
                        ->update(
                            ['sisa_cuti' => $sisacuti_baru]
                        );
    
                        $alokasicuti = Alokasicuti::where('id', $cut->id_alokasi)
                            ->where('id_karyawan', $cut->id_karyawan)
                            ->where('id_jeniscuti', $cut->id_jeniscuti)
                            ->where('id_settingalokasi', $cut->id_settingalokasi)
                            ->first();
    
    
                        Alokasicuti::where('id', $alokasicuti->id)
                        ->update(
                            ['durasi' => $jml_cuti]
                        );
        
                        //KIRIM EMAIL NOTIFIKASI DIKIRIM KE SEMUA ATASAN, HRD dan KARYAWAN
                        //ambil data karyawan
                        $emailkry = DB::table('cuti')->join('karyawan','cuti.id_karyawan','=','karyawan.id')
                            ->join('departemen','cuti.departemen','=','departemen.id') 
                            ->where('cuti.id_karyawan','=',$datacuti->id_karyawan)
                            ->select('karyawan.email','departemen.nama_departemen','karyawan.nama as nama','karyawan.atasan_pertama','karyawan.atasan_kedua')
                            ->first();
        
                        $atasan1 = Karyawan::where('id',$emailkry->atasan_pertama)
                            ->select('email as email','nama as nama','nama_jabatan as jabatan','divisi as departemen')
                            ->first();
                        
                        $atasan2 = NULL;
                        if($emailkry->atasan_kedua != NULL)
                        {
                            $atasan2 = Karyawan::where('id',$emailkry->atasan_kedua)
                                ->select('email as email','nama as nama','nama_jabatan as jabatan')
                                ->first();
                         }
        
                        // $tujuan = 'akhiratunnisahasanah0917@gmail.com';
                        $tujuan = $emailkry['email'];
                        $alasan = '';
                        
                        $data = [
                            'subject'     =>'Notifikasi Cuti Disetujui ' . $jeniscuti->jenis_cuti . ' #' . $cuti->id . ' ' . $emailkry->nama,
                            'noregistrasi'=>$cuti->id,
                            'title' =>  'NOTIFIKASI PERSETUJUAN FORMULIR CUTI KARYAWAN',
                            'subtitle' => '',
                            'tgl_permohonan' =>Carbon::parse($cut->tgl_permohonan)->format("d/m/Y"),
                            'nik'         => $cut->nik,
                            'jabatankaryawan' => $cut->jabatan,
                            'departemen' => $emailkry->nama_departemen,
                            'atasan1'     =>$atasan1->email,
                            'namaatasan1' =>$atasan1->nama,
                            'namakaryawan'=>ucwords(strtolower($emailkry->nama)),
                            'id_jeniscuti'=>$jeniscuti->jenis_cuti,
                            'keperluan'   =>$cut->keperluan,
                            'tgl_mulai'   =>Carbon::parse($cut->tgl_mulai)->format("d/m/Y"),
                            'tgl_selesai' =>Carbon::parse($cut->tgl_selesai)->format("d/m/Y"),
                            'tgldisetujuiatasan' =>Carbon::parse($cut->tgldisetujui_a)->format("d/m/Y H:i"),
                            'tgldisetujuipimpinan' => Carbon::parse($cut->tgldisetujui_b)->format("d/m/Y H:i"),
                            'jml_cuti'    =>$cut->jml_cuti,
                            'status'      =>$status->name_status,
                            'alasan'      =>$alasan,
                        ];
                        if($atasan2 !== NULL){
                            $data['atasan2'] = $atasan2->email;
                            $data['namaatasan2'] = Auth::user()->name;
                        }
                        Mail::to($tujuan)->send(new CutiApproveNotification($data));
                        // dd($data);
                        return redirect()->back()->withInput();
        
                    }
                    else{
                        return redirect()->back();
                    }
                       
                }
                else{
                    return redirect()->back();
                }
            }
            else
            {
                $cutis = Cuti::where('id',$id)->first();
                $datacuti = DB::table('cuti')
                    ->leftjoin('alokasicuti', 'cuti.id_alokasi', '=', 'alokasicuti.id')
                    ->leftjoin('karyawan','cuti.id_karyawan','=','karyawan.id')
                    ->select('cuti.*','alokasicuti.id as id_alokasi','karyawan.atasan_pertama','karyawan.atasan_kedua')
                    ->where('cuti.id',$cutis->id)
                    ->where('cuti.id_karyawan', $cutis->id_karyawan)
                    ->where('alokasicuti.id_karyawan',  $cutis->id_karyawan)
                    ->where(function ($query) {
                        $query->where('karyawan.atasan_pertama', Auth::user()->id_pegawai)
                            ->orWhere('karyawan.atasan_kedua', Auth::user()->id_pegawai);
                    })
                ->first();
                if($datacuti && $row->jabatan == "Direksi" && $role == 3)
                {
                        if($datacuti && $datacuti->atasan_pertama == Auth::user()->id_pegawai && $row->jabatan == "Manager")
                        {
                            // return $datacuti->atasan_pertama;
                            $status = Status::find(6);
                            Cuti::where('id',$id)->update([
                                'status' => $status->id,
                                'tgldisetujui_a' => Carbon::now()->format('Y-m-d H:i:s'),
                            ]);
                            $cuti = Cuti::where('id',$id)->first();
                           
                            $jeniscuti = Jeniscuti::where('id',$cuti->id_jeniscuti)->first();
            
                             //KIRIM NOTIFIKASI EMAIL KE KARYAWAN DAN ATASAN 2
            
                            //ambil data karyawan
                            $emailkry = DB::table('cuti')->join('karyawan','cuti.id_karyawan','=','karyawan.id')
                                ->join('departemen','cuti.departemen','=','departemen.id')
                                ->where('cuti.id_karyawan','=',$datacuti->id_karyawan)
                                ->select('karyawan.email','karyawan.nama as nama','karyawan.atasan_kedua','departemen.nama_departemen')
                                ->first();

                            $atasan = NULL;
                            if($emailkry->atasan_kedua !== NULL)
                            {
                                $atasan = Karyawan::where('id', $emailkry->atasan_kedua)
                                    ->select('email as email','nama as nama','nama_jabatan as nama_jabatan')
                                    ->first();
                            }
            
                            //ambil data karyawan
                            $tujuan = $atasan->email ?? null;
                            $data = [
                                'subject'     =>'Notifikasi Approval Pertama Permohonan ' . $jeniscuti->jenis_cuti . ' #' . $cuti->id . ' ' . $emailkry->nama,
                                'noregistrasi'=>$cuti->id,
                                'title' =>  'NOTIFIKASI PERSETUJUAN PERTAMA FORMULIR CUTI KARYAWAN',
                                'subtitle' => '[PERSETUJUAN ATASAN]',
                                'tgl_permohonan' =>Carbon::parse($cuti->tgl_permohonan)->format("d/m/Y"),
                                'nik'         => $cuti->nik,
                                'jabatankaryawan' => $cuti->jabatan,
                                'departemen' => $emailkry->nama_departemen,
                                'id_jeniscuti'   => $jeniscuti->jenis_cuti,
                                'karyawan_email' =>$emailkry->email,
                                'namakaryawan'=>ucwords(strtolower($emailkry->nama)),
                                'id_jeniscuti'=>$cuti->jeniscutis->jenis_cuti,
                                'keperluan'   =>$cuti->keperluan,
                                'tgl_mulai'   =>Carbon::parse($cuti->tgl_mulai)->format("d/m/Y"),
                                'tgl_selesai' =>Carbon::parse($cuti->tgl_selesai)->format("d/m/Y"),
                                'tgldisetujuiatasan' =>Carbon::parse($cuti->tgldisetujui_a)->format("d/m/Y H:i"),
                                'jml_cuti'    =>$cuti->jml_cuti,
                                'status'      =>$status->name_status,
                                
                            ];
                            if($atasan !== NULL){
                                $data['atasan2'] = $atasan->email;
                                $data['namaatasan2'] = $atasan->nama;
                                $data['jabatanatasan'] = $atasan->jabatan;
                            }
                            // dd($data);
                            Mail::to($tujuan)->send(new CutiAtasan2Notification($data));
                            return redirect()->back()->withInput();
                        }  
                        elseif($datacuti && $datacuti->atasan_kedua == Auth::user()->id_pegawai)
                        {
                            // dd($datacuti);
                            $cuti = Cuti::where('id',$id)->first();
                            $jeniscuti = Jeniscuti::where('id',$cuti->id_jeniscuti)->first();
                            $jml_cuti = $cuti->sisacuti;
                            // return $jml_cuti;
    
                            $status = Status::find(7);
                            Cuti::where('id', $id)->update(
                                ['status' => $status->id,
                                'tgldisetujui_b' => Carbon::now()->format('Y-m-d H:i:s'),
                                ]
                            );
    
                            $alokasicuti = Alokasicuti::where('id', $cuti->id_alokasi)
                                ->where('id_karyawan', $cuti->id_karyawan)
                                ->where('id_jeniscuti', $cuti->id_jeniscuti)
                                ->where('id_settingalokasi', $cuti->id_settingalokasi)
                                ->first();
            
                            Alokasicuti::where('id', $alokasicuti->id)
                            ->update(
                                ['durasi' => $jml_cuti]
                            );
        
                            //KIRIM EMAIL NOTIFIKASI DIKIRIM KE SEMUA ATASAN, HRD dan KARYAWAN
            
                            //ambil data karyawan
                            $emailkry = DB::table('cuti')->join('karyawan','cuti.id_karyawan','=','karyawan.id')
                                ->join('departemen','cuti.departemen','=','departemen.id') 
                                ->where('cuti.id_karyawan','=',$datacuti->id_karyawan)
                                ->select('karyawan.email','departemen.nama_departemen','karyawan.nama as nama','karyawan.atasan_pertama','karyawan.atasan_kedua')
                                ->first();
                            $atasan1 = Karyawan::where('id',$emailkry->atasan_pertama)
                                ->select('email as email','nama as nama','nama_jabatan as jabatan','divisi as departemen')
                                ->first();
                        
                            $atasan2 = NULL;
                            if($emailkry->atasan_kedua != NULL)
                            {
                                $atasan2 = Karyawan::where('id', $emailkry->atasan_kedua)
                                    ->select('email as email','nama as nama','nama_jabatan as jabatan')
                                    ->first();
                            }

                            $tujuan = $emailkry->email;
                            $alasan = '';
    
                            $data = [
                                'subject'     =>'Notifikasi Cuti Disetujui ' . $jeniscuti->jenis_cuti . ' #' . $cuti->id . ' ' . $emailkry->nama,
                                'noregistrasi'=>$cuti->id,
                                'title' =>  'NOTIFIKASI PERSETUJUAN FORMULIR CUTI KARYAWAN',
                                'subtitle' => '',
                                'tgl_permohonan' =>Carbon::parse($cuti->tgl_permohonan)->format("d/m/Y"),
                                'nik'         => $cuti->nik,
                                'jabatankaryawan' => $cuti->jabatan,
                                'departemen' => $emailkry->nama_departemen,
                                'atasan1'     =>$atasan1->email,
                                'namaatasan1' =>$atasan1->nama,
                                'namakaryawan'=>$emailkry->nama,
                                'id_jeniscuti'=>$jeniscuti->jenis_cuti,
                                'keperluan'   =>$cuti->keperluan,
                                'tgl_mulai'   =>Carbon::parse($cuti->tgl_mulai)->format("d/m/Y"),
                                'tgl_selesai' =>Carbon::parse($cuti->tgl_selesai)->format("d/m/Y"),
                                'jml_cuti'    =>$cuti->jml_cuti,
                                'tgldisetujuiatasan' =>Carbon::parse($cuti->tgldisetujui_a)->format("d/m/Y H:i"),
                                'tgldisetujuipimpinan' => Carbon::parse($cuti->tgldisetujui_b)->format("d/m/Y H:i"),
                                'status'      =>$status->name_status,
                                'alasan'      =>$alasan,
                            ];
                            if($atasan2 !== NULL){
                                $data['atasan2'] = $atasan2->email;
                                $data['namaatasan2'] = $atasan2->nama;
                            }
                          //    return $data;
                            Mail::to($tujuan)->send(new CutiApproveNotification($data));
                            // dd($data);
                            return redirect()->back()->with('pesan', 'Notifikasi Berhasil Dikirim');
                        }
                        else{
                            return redirect()->back();
                        }
                }
                else{
                    return redirect()->back();
                }
            }
    }

    public function leaverejected(Request $request, $id)
    {
        $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
        $role = Auth::user()->role;

        $cutis = Cuti::where('id',$id)->first();
        $datacuti = Cuti::leftjoin('karyawan','cuti.id_karyawan','=','karyawan.id')
            ->where('cuti.id', '=',$cutis->id)
            ->select('karyawan.atasan_pertama','karyawan.atasan_kedua')
            ->first();
        if($datacuti && $role == 3 && $row->jabatan == "Direksi")
        {
                if($datacuti && $datacuti->atasan_kedua == Auth::user()->id_pegawai)
                {
                    $status = Status::find(10);
                    Cuti::where('id',$id)->update([
                        'status' => $status->id,
                        'tglditolak' => Carbon::now()->format('Y-m-d H:i:s'),
                    ]);
                    $cuti = Cuti::where('id',$id)->first();
                    // return $cuti;
                    $datareject          = new Datareject;
                    $datareject->id_cuti = $cuti->id;
                    $datareject->id_izin = NULL;
                    $datareject->alasan  = $request->alasan;
                    $datareject->save();  
            
                    //----SEND EMAIL KE KARYAWAN DAN SEMUA ATASAN -------
                    //ambil nama jeniscuti
                    $ct = DB::table('cuti')
                        ->join('jeniscuti','cuti.id_jeniscuti','=','jeniscuti.id')
                        ->join('statuses','cuti.status','=','statuses.id')
                        ->where('cuti.id',$id)
                        ->select('cuti.*','jeniscuti.jenis_cuti as jenis_cuti','statuses.name_status')
                        ->first();
                    $alasan = Datareject::where('id_cuti',$cuti->id)->first();
                    //sementara tidak digunakan
                    $karyawan = DB::table('cuti')
                        ->join('karyawan','cuti.id_karyawan','=','karyawan.id')
                        ->join('departemen','cuti.departemen','=','departemen.id')
                        ->where('cuti.id',$cuti->id)
                        ->select('karyawan.email as email','karyawan.nama as nama','departemen.nama_departemen','karyawan.atasan_pertama','karyawan.atasan_kedua')
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
                        'subject'     => 'Notifikasi Permohonan Cuti Ditolak, Cuti ' . $ct->jenis_cuti . ' #' . $ct->id . ' ' . $karyawan->nama,
                        'noregistrasi'=>$cuti->id,
                        'title' =>  'NOTIFIKASI PERSETUJUAN FORMULIR CUTI KARYAWAN',
                        'subtitle' => '[ PENDING PIMPINAN ]',
                        'tgl_permohonan' =>Carbon::parse($cuti->tgl_permohonan)->format("d/m/Y"),
                        'nik'         => $cuti->nik,
                        'jabatankaryawan' => $cuti->jabatan,
                        'departemen' => $karyawan->nama_departemen,
                        'atasan1'     => $atasan1->email,
                        'namaatasan1' => $atasan1->nama,
                        'karyawan_email'=>$karyawan->email,
                        'kategori'=> $ct->jenis_cuti,
                        'keperluan'   => $ct->keperluan,
                        'namakaryawan'=> ucwords(strtolower($karyawan->nama)),
                        'tgl_mulai'   => Carbon::parse($ct->tgl_mulai)->format("d/m/Y"),
                        'tgl_selesai' => Carbon::parse($ct->tgl_selesai)->format("d/m/Y"),
                        'jml_cuti'    => $ct->jml_cuti,
                        'status'      => $ct->name_status,
                        'alasan'      =>$alasan->alasan,
                        'tgldisetujuiatasan' => Carbon::parse($ct->tgldisetujui_a)->format("d/m/Y H:i"),
                        'tglditolak' => Carbon::now()->format('d/m/Y H:i'),
                    ];
                    if($atasan2 !== NULL){
                        $data['atasan2'] = $atasan2->email;
                        $data['namaatasan2'] = $atasan2->nama;
                    }
                    // return $data;
                    Mail::to($tujuan)->send(new CutiIzinTolakNotification($data));
                    return redirect()->back();
                }
                elseif($datacuti && $datacuti->atasan_pertama == Auth::user()->id_pegawai)
                {
                    // return $datacuti;
                    $status = Status::find(9);
                    // return $status->id;
                    Cuti::where('id',$id)->update([
                        'status' => $status->id,
                        'tglditolak' => Carbon::now()->format('Y-m-d H:i:s'),
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
                    ->join('statuses','cuti.status','=','statuses.id')
                    ->where('cuti.id',$id)
                    ->select('cuti.*','jeniscuti.jenis_cuti as jenis_cuti','statuses.name_status')
                    ->first();
                    $alasan = Datareject::where('id_cuti',$cuti->id)->first();
                    //sementara tidak digunakan
                    $karyawan = DB::table('cuti')
                        ->join('karyawan','cuti.id_karyawan','=','karyawan.id')
                        ->join('departemen','cuti.departemen','=','departemen.id')
                        ->where('cuti.id',$cuti->id)
                        ->select('karyawan.email as email','karyawan.nama as nama','departemen.nama_departemen','karyawan.atasan_pertama','karyawan.atasan_kedua')
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
                    // dd($ct,$karyawan);
                    $data = [
                        'subject'     => 'Notifikasi Permohonan Cuti Ditolak, Cuti ' . $ct->jenis_cuti . ' #' . $ct->id . ' ' . $karyawan->nama,
                        'noregistrasi'=>$cuti->id,
                        'title' =>  'NOTIFIKASI PERSETUJUAN FORMULIR CUTI KARYAWAN',
                        'subtitle' => '[ PENDING ATASAN ]',
                        'tgl_permohonan' =>Carbon::parse($cuti->tgl_permohonan)->format("d/m/Y"),
                        'nik'         => $cuti->nik,
                        'jabatankaryawan' => $cuti->jabatan,
                        'departemen' => $karyawan->nama_departemen,
                        'atasan1'     => $atasan1->email,
                        'namaatasan1' => $atasan1->nama,
                        'karyawan_email'=>$karyawan->email,
                        'kategori'=> $ct->jenis_cuti,
                        'keperluan'   => $ct->keperluan,
                        'namakaryawan'=> ucwords(strtolower($karyawan->nama)),
                        'tgl_mulai'   => Carbon::parse($ct->tgl_mulai)->format("d/m/Y"),
                        'tgl_selesai' => Carbon::parse($ct->tgl_selesai)->format("d/m/Y"),
                        'jml_cuti'    => $ct->jml_cuti,
                        'status'      => $ct->name_status,
                        'alasan'      =>$alasan->alasan,
                        'tgldisetujuiatasan' => '-',
                        'tglditolak' => Carbon::now()->format('d/m/Y H:i'),
                    ];
                    if($atasan2 !== NULL){
                        $data['atasan2'] = $atasan2->email;
                        $data['namaatasan2'] = $atasan2->nama;
                    }
                    // return $data;
                    Mail::to($tujuan)->send(new CutiIzinTolakNotification($data));
                    return redirect()->back();
                    // return $data;
                }
                else{
                    return redirect()->back();
                }
        }
        else{
            return redirect()->back();
        }
 
    }

    public function izinApprove(Request $request, $id)
    {
        $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
        $role = Auth::user()->role;
        $izn = Izin::where('id',$id)->first();
        $izin = Izin::leftJoin('karyawan', 'izin.id_karyawan', '=', 'karyawan.id')
                ->where('izin.id_karyawan', '=', $izn->id_karyawan)
                ->where('karyawan.atasan_pertama', Auth::user()->id_pegawai)
                ->orWhere('karyawan.atasan_kedua',Auth::user()->id_pegawai)
                ->where('izin.id',$id)
                ->select('izin.*', 'karyawan.nama', 'karyawan.atasan_pertama', 'karyawan.atasan_kedua')
                ->first();

        // return $izin;
        if($row->jabatan == "Direksi" && $role == 3)
        {
            if($izin && $izin->atasan_pertama == Auth::user()->id_pegawai)
            {
                // return Auth::user()->role;
                $status = Status::find(6);

                Izin::where('id',$id)->update([
                    'status' => $status->id,
                    'tgl_setuju_a' => Carbon::now()->format('Y-m-d H:i:s'),
                ]);

                $izinn = Izin::where('id',$id)->first();
                $jenisizin = Jenisizin::where('id',$izinn->id_jenisizin)->first();

                //KIRIM NOTIFIKASI EMAIL KE KARYAWAN DAN ATASAN 2
                $emailkry = DB::table('izin')->join('karyawan','izin.id_karyawan','=','karyawan.id')
                    ->join('departemen','izin.departemen','=','departemen.id') 
                    ->where('izin.id_karyawan','=',$izinn->id_karyawan)
                    ->select('karyawan.email','karyawan.nama','karyawan.atasan_kedua','departemen.nama_departemen')
                    ->first();

                $atasan = null;
                if($emailkry->atasan_kedua !== NULL)
                {
                    $atasan = Karyawan::where('id', $emailkry->atasan_kedua)
                        ->select('email as email','nama as nama','jabatan')
                        ->first();
                }
                //atasan pertama
                $atasan1 = Auth::user()->email;
                $tujuan = $atasan->email ?? null;
                $data = [
                    'subject'     =>'Notifikasi Approval Pertama Izin '  . $jenisizin->jenis_izin . ' #' . $izinn->id . ' ' . $emailkry->nama,
                    'title' =>  'NOTIFIKASI PERSETUJUAN FORMULIR KETIDAKHADIRAN KARYAWAN',
                    'subtitle' => '[PERSETUJUAN ATASAN]',
                    'noregistrasi'=>$izinn->id,
                    'tgl_permohonan' =>Carbon::parse($izinn->tgl_permohonan)->format("d/m/Y"),
                    'nik'         => $izinn->nik,
                    'jabatankaryawan' => $izinn->jabatan,
                    'departemen' => $emailkry->nama_departemen,
                    'atasan1'     => $atasan1,
                    'karyawan_email'=>$emailkry->email,
                    'id_jenisizin'=> $jenisizin->jenis_izin,
                    'keperluan'   =>$izinn->keperluan,
                    'tgl_mulai'   =>Carbon::parse($izinn->tgl_mulai)->format("d/m/Y"),
                    'tgl_selesai' =>Carbon::parse($izinn->tgl_selesai)->format("d/m/Y"),
                    'jam_mulai'   =>Carbon::parse($izinn->jam_mulai)->format("H:i"),
                    'jam_selesai' =>Carbon::parse($izinn->jam_selesai)->format("H:i"),
                    'tgldisetujuiatasan' => Carbon::parse($izinn->tgl_setuju_a)->format("d/m/Y H:i"),
                    'jml_hari'    =>$izinn->jml_hari,
                    'jumlahjam'   =>$izinn->jml_jam,
                    'status'      =>$status->name_status,
                    'namakaryawan'=> $emailkry->nama,
                ];
                if($atasan !==NULL){
                    $data['namaatasan2'] = $atasan->nama;
                    $data['jabatanatasan'] = $atasan->jabatan;
                }
                // dd($data);
                Mail::to($tujuan)->send(new IzinAtasan2Notification($data));
                return redirect()->back()->withInput();
            } 
            elseif($izin && $izin->atasan_kedua == Auth::user()->id_pegawai)
            {
                // return Auth::user()->name;
                $status = Status::find(7);
        
                Izin::where('id',$id)->update([
                    'status' => $status->id,
                    'tgl_setuju_b' => Carbon::now()->format('Y-m-d H:i:s'),
                ]);

                $izinn = Izin::where('id',$id)->first();
                $jenisizin = Jenisizin::where('id',$izinn->id_jenisizin)->first();

                //KIRIM EMAIL NOTIFIKASI KE KARYAWAN< 2 tingkat atasna dan HRD.
                
                $emailkry = DB::table('izin')->join('karyawan','izin.id_karyawan','=','karyawan.id')
                    ->join('departemen','izin.departemen','=','departemen.id')
                    ->where('izin.id_karyawan','=',$izin->id_karyawan)
                    ->select('karyawan.email','karyawan.nama','departemen.nama_departemen','karyawan.atasan_pertama','karyawan.atasan_kedua')
                    ->first();

                $atasan1 = Karyawan::where('id',$emailkry->atasan_pertama)
                    ->select('email as email','nama as nama','nama_jabatan as jabatan','divisi as departemen')
                    ->first();
                
                //atasan kedua yg login
                $atasan2 = Auth::user()->email;
                $tujuan = $emailkry->email;

                $data = [
                    'subject'     =>'Notifikasi Izin Disetujui, Izin '  . $jenisizin->jenis_izin . ' #' . $izinn->id . ' ' . $emailkry->nama,
                    'noregistrasi'=>$izinn->id,
                    'title' =>  'NOTIFIKASI PERSETUJUAN FORMULIR IZIN KARYAWAN',
                    'subtitle' => '',
                    'tgl_permohonan' =>Carbon::parse($izinn->tgl_permohonan)->format("d/m/Y"),
                    'nik'         => $izinn->nik,
                    'jabatankaryawan' => $izinn->jabatan,
                    'departemen' => $emailkry->nama_departemen,
                    'karyawan_email'=>$emailkry->email,
                    'id_jenisizin'=>$jenisizin->jenis_izin,
                    'atasan1'     =>$atasan1->email,
                    'atasan2'     =>$atasan2,
                    'jenisizin'   =>$jenisizin->jenis_izin,
                    'keperluan'   =>$izinn->keperluan,
                    'tgl_mulai'   =>Carbon::parse($izinn->tgl_mulai)->format("d/m/Y"),
                    'tgl_selesai' =>Carbon::parse($izinn->tgl_selesai)->format("d/m/Y"),
                    'jam_mulai'   =>Carbon::parse($izinn->jam_mulai)->format("H:i"),
                    'jam_selesai' =>Carbon::parse($izinn->jam_selesai)->format("H:i"),
                    'tgldisetujuiatasan' => Carbon::parse($izinn->tgl_setuju_a)->format("d/m/Y H:i"),
                    'tgldisetujuipimpinan' => Carbon::parse($izinn->tgl_setuju_b)->format("d/m/Y H:i"),
                    'jml_hari'    =>$izinn->jml_hari,
                    'jumlahjam'   =>$izinn->jml_jam,
                    'status'      =>$status->name_status,
                    'namakaryawan'=>ucwords(strtolower($emailkry->nama)),
                    'jabatanatasan'=>$atasan1->jabatan,
                ];
                // return $data;
                Mail::to($tujuan)->send(new IzinApproveNotification($data));
                return redirect()->route('cuti.Staff',['tp'=>2]);
            } 
            else{
                return redirect()->back();
            }
        }
        else
        {
            return redirect()->back(); 
        }
        
    }

    public function izinRejected(Request $request, $id)
   {
        $iz = Izin::where('id',$id)->first();
        $dataizin = Izin::leftjoin('karyawan','izin.id_karyawan','=','karyawan.id')
            ->where('izin.id', '=',$iz->id)
            ->select('karyawan.atasan_pertama','karyawan.atasan_kedua')
            ->first();
        $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
        $role = Auth::user()->role;

        if($dataizin && $role == 3 && $row->jabatan == "Direksi")
        {
           
            if($dataizin->atasan_kedua == Auth::user()->id_pegawai)
            {
                $status = Status::find(10);
                Izin::where('id',$id)->update([
                    'status' => $status->id,
                    'tgl_ditolak' => Carbon::now()->format('Y-m-d H:i:s'),
                ]);
                $izz = Izin::where('id',$id)->first();
    
                $datareject          = new Datareject;
                $datareject->id_cuti = NULL;
                $datareject->id_izin = $izz->id;
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
                    ->join('departemen','izin.departemen', '=','departemen.id')
                    ->where('izin.id',$izin->id)
                    ->select('karyawan.email as email','karyawan.nama as nama','departemen.nama_departemen','karyawan.atasan_pertama','karyawan.atasan_kedua')
                    ->first(); 
                    
                $atasan2 = null;
                if($karyawan->atasan_kedua !== NULL)
                {
                    $atasan2 = Karyawan::where('id',$karyawan->atasan_kedua)
                        ->select('email as email','nama as nama','jabatan')
                        ->first();
                }

                $atasan1 = Karyawan::where('id',$karyawan->atasan_pertama)
                    ->select('email as email','nama as nama','jabatan')
                    ->first();
        
                $tujuan = $karyawan->email;
                $data = [
                    'subject'  =>'Notifikasi Permohonan Izin Ditolak, Izin ' . $izin->jenis_izin . ' #' . $izin->id . ' ' . $karyawan->nama,
                    'noregistrasi'=>$izin->id,
                    'tgl_permohonan' =>Carbon::parse($izin->tgl_permohonan)->format("d/m/Y"),
                    'title' =>  'NOTIFIKASI PERSETUJUAN FORMULIR IZIN KARYAWAN',
                    'subtitle' => '[ PENDING PIMPINAN ]',
                    'nik'         => $izin->nik,
                    'jabatankaryawan' => $izin->jabatan,
                    'departemen' => $karyawan->nama_departemen,
                    'atasan1'     => $atasan1->email,
                    'karyawan_email'=>$karyawan->email,
                    'id_jenisizin'=>$izin->jenis_izin,
                    'keperluan'   =>$izin->keperluan,
                    'tgl_mulai'   =>Carbon::parse($izin->tgl_mulai)->format("d/m/Y"),
                    'tgl_selesai' =>Carbon::parse($izin->tgl_selesai)->format("d/m/Y"),
                    'jam_mulai'   =>Carbon::parse($izin->jam_mulai)->format("H:i"),
                    'jam_selesai' =>Carbon::parse($izin->jam_selesai)->format("H:i"),
                    'status'   =>$status->name_status,
                    'jml_hari'    =>$izin->jml_hari,
                    'jumlahjam'   =>$izin->jml_jam,
                    'namakaryawan'=> ucwords(strtolower($karyawan->nama)),
                    'nama'        =>$karyawan->nama,
                    'kategori'   =>$izin->jenis_izin,
                    'alasan'      =>$alasan->alasan,
                    'tgldisetujuiatasan' => Carbon::parse($izin->tgl_setuju_a)->format("d/m/Y H:i"),
                    'tgldisetujuipimpinan' => '-',
                    'tglditolak' => Carbon::parse($izin->tgl_ditolak)->format("d/m/Y H:i"),
                ];
                if($atasan2 !== NULL){
                    $data['atasan2']= $atasan2->email;
                    $data['namaatasan2'] =$atasan2->nama;
                }
                // dd($data);
                Mail::to($tujuan)->send(new CutiIzinTolakNotification($data));
                return redirect()->back();
                
            }elseif($dataizin && $dataizin->atasan_pertama == Auth::user()->id_pegawai)
            {
                $status = Status::find(9);
                Izin::where('id',$id)->update([
                    'status' => $status->id,
                    'tgl_ditolak' => Carbon::now()->format('Y-m-d H:i:s'),
                ]);
                $izz = Izin::where('id',$id)->first();
    
                $datareject          = new Datareject;
                $datareject->id_cuti = NULL;
                $datareject->id_izin = $izz->id;
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
                    ->join('departemen','izin.departemen','=','departemen.id')
                    ->where('izin.id',$izin->id)
                    ->select('karyawan.email as email','departemen.nama_departemen','karyawan.nama as nama','karyawan.atasan_pertama','karyawan.atasan_kedua')
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
                    'subject'  =>'Notifikasi Permohonan Izin Ditolak, Izin ' . $izin->jenis_izin . ' #' . $izin->id . ' ' . $karyawan->nama,
                    'noregistrasi'=>$izin->id,
                    'tgl_permohonan' =>Carbon::parse($izin->tgl_permohonan)->format("d/m/Y"),
                    'title' =>  'NOTIFIKASI PERSETUJUAN FORMULIR IZIN KARYAWAN',
                    'subtitle' => '[ PENDING ATASAN ]',
                    'nik'         => $izin->nik,
                    'jabatankaryawan' => $izin->jabatan,
                    'departemen' => $karyawan->nama_departemen,
                    'atasan1'     => $atasan1->email,
                    'karyawan_email'=>$karyawan->email,
                    'id_jenisizin'=>$izin->jenis_izin,
                    'keperluan'   =>$izin->keperluan,
                    'tgl_mulai'   =>Carbon::parse($izin->tgl_mulai)->format("d/m/Y"),
                    'tgl_selesai' =>Carbon::parse($izin->tgl_selesai)->format("d/m/Y"),
                    'jam_mulai'   =>Carbon::parse($izin->jam_mulai)->format("H:i"),
                    'jam_selesai' =>Carbon::parse($izin->jam_selesai)->format("H:i"),
                    'status'   =>$status->name_status,
                    'jml_hari'    =>$izin->jml_hari,
                    'jumlahjam'   =>$izin->jml_jam,
                    'namakaryawan'=> ucwords(strtolower($karyawan->nama)),
                    'nama'        =>$karyawan->nama,
                    'kategori'   =>$izin->jenis_izin,
                    'alasan'      =>$alasan->alasan,
                    'tgldisetujuiatasan' => '-',
                    'tgldisetujuipimpinan' => '-',
                    'tglditolak' => Carbon::now()->format('d/m/Y H:i'),
                ];
                if($atasan2 !== NULL)
                {
                    $data['atasan2'] = $atasan2->email;
                    $data['namaatasan2'] = $atasan2->nama;
                }
                Mail::to($tujuan)->send(new CutiIzinTolakNotification($data));
                return redirect()->route('cuti.Staff',['type'=>2])->withInput();
                
            }else{
                return redirect()->back();
            }


        }else{
            return redirect()->back();
        }
   }
}
