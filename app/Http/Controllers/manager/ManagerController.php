<?php

namespace App\Http\Controllers\manager;

use PDF;
use Carbon\Carbon;
use App\Models\Cuti;
use App\Models\Izin;
use App\Models\Resign;
use App\Models\Absensi;
use App\Models\Karyawan;
use App\Models\Datareject;
use App\Models\Departemen;
use App\Models\Alokasicuti;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exports\AbsensiFilterExport;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use App\Mail\CutiApproveNotification;
use App\Mail\IzinApproveNotification;
use App\Exports\AbsensiDepartemenExport;

class ManagerController extends Controller
{
    public function dataStaff(Request $request)
    {
        $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
        $role = Auth::user()->role;        
        if ($role == 3) {
            //mengambil id_departemen manager
            $manager_iddep = DB::table('karyawan')
                ->where('id','=',Auth::user()->id_pegawai)
                ->select('divisi')->first();

            //ambil data dengan id_departemen sama dengan manager
            $staff= Karyawan::with('departemens')
                ->where('divisi',$manager_iddep->divisi)
                ->where('jabatan','!=','Manager')->get();

            return view('manager.staff.dataStaff', compact('staff','row'));
        }
        elseif($role == 5)
        {
            //mengambil id_departemen 
            $staff= Karyawan::with('departemens')
                ->where('atasan_pertama','=',Auth::user()->id_pegawai)->get();

            return view('manager.staff.dataStaff', compact('staff','row'));
        }else{
            return redirect()->back();
        };
    }

    public function absensiStaff(Request $request)
    {
        $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
        $role = Auth::user()->role;  

        //mengambil id_departemen user login
        $middep = DB::table('absensi')
            ->join('karyawan','absensi.id_departement','=','karyawan.divisi')
            ->where('absensi.id_karyawan','=',Auth::user()->id_pegawai)
            ->select('id_departement')->first();

        //saring data dengan id_departemen sama dengan manager secara keseluruhan
        //$absensi= Absensi::where('id_departement',$middep->id_departement)->get();
        //=================================
        //untuk filter nama karyawan
        if($role == 3) 
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
                $absensi = Absensi::where('id_karyawan', $idkaryawan)
                ->where('id_departement',$middep->id_departement)
                ->whereMonth('tanggal', $bulan)
                ->whereYear('tanggal',$tahun)
                ->get();
            }else
            {
            //saring data dengan id_departemen sama dengan manager secara keseluruhan
                $absensi= Absensi::where('id_departement',$middep->id_departement)->get();
            }
            return view('manager.staff.absensiStaff', compact('absensi','karyawan','row'));

            //menghapus filter data
            $request->session()->forget('id_karyawan');
            $request->session()->forget('bulan');
            $request->session()->forget('tahun');
        }
        elseif($role == 5)
        {
            $spv = DB::table('karyawan')->where('id','=',Auth::user()->id_pegawai)
                ->select('divisi')->first();
            $karyawan= Karyawan::where('divisi',$spv->divisi)
                ->where('jabatan','=','Staff')
                ->orWhere('jabatan','=','Supervisor')
                ->get();
            // $karyawan= Karyawan::where('atasan_pertama',Auth::user()->id_pegawai)->get();

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
                $absensi = Absensi::with(['karyawans' => function($query) {
                    $query->select('nama')->where('jabatan', 'Staff');
                }])
                ->where('id_karyawan', $idkaryawan)
                ->where('id_departement',$middep->id_departement)
                ->whereMonth('tanggal', $bulan)
                ->whereYear('tanggal',$tahun)
                ->get();
            }else
            {
            //saring data dengan id_departemen sama dengan manager secara keseluruhan
                $pegawai = Karyawan::where('jabatan','Staff')->orWhere('jabatan','Supervisor')
                    ->select('id as idkaryawan')
                    ->get();
                // dd($karyawan);
                $absensi = Absensi::where('id_departement', $middep->id_departement)
                    ->whereIn('id_karyawan',$pegawai->pluck('idkaryawan'))
                    ->get();

                // $absensi = Absensi::where('id_departement', $middep->id_departement)
                //     ->where('id_karyawan',$karyawan->idkaryawan)->get();
                // dd($absensi);
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

        $alasan = DB::table('datareject')
            ->join('izin','datareject.id_izin','=','izin.id')
            ->select('datareject.alasan as alasan','datareject.id_izin as id_izin')
            ->first();
        $alasancuti = DB::table('datareject')
            ->join('cuti','datareject.id_cuti','=','cuti.id')
            ->select('datareject.alasan as alasan_cuti','datareject.id_cuti as id_cuti')
            ->first();

        if($role == 3)
        {
            $cutistaff = DB::table('cuti')
                ->leftjoin('jeniscuti','cuti.id_jeniscuti','jeniscuti.id')
                ->leftjoin('karyawan','cuti.id_karyawan','karyawan.id')
                ->where('karyawan.atasan_pertama',Auth::user()->id_pegawai)
                ->orWhere('karyawan.atasan_kedua',Auth::user()->id_pegawai)
                ->select('cuti.*', 'jeniscuti.jenis_cuti', 'karyawan.nama')
                ->distinct()
                ->get();

            $izinstaff = DB::table('izin')
                ->leftjoin('karyawan','izin.id_karyawan','karyawan.id')
                ->leftjoin('jenisizin','izin.id_jenisizin','jenisizin.id')
                ->where('karyawan.atasan_pertama',Auth::user()->id_pegawai)
                ->select('izin.*','karyawan.nama','jenisizin.jenis_izin')
                ->distinct()
                ->get();
                
            return view('manager.staff.cutiStaff', compact('cutistaff','row','tp','izinstaff','alasan','alasancuti'));
        }
        elseif($role == 5)
        {
            $cutistaff = DB::table('cuti')
                ->leftjoin('jeniscuti','cuti.id_jeniscuti','jeniscuti.id')
                ->leftjoin('karyawan','cuti.id_karyawan','karyawan.id')
                ->where('karyawan.atasan_pertama',Auth::user()->id_pegawai)
                ->select('cuti.*', 'jeniscuti.jenis_cuti', 'karyawan.nama')
                ->distinct()
                ->get();

            $izinstaff = DB::table('izin')
                ->leftjoin('karyawan','izin.id_karyawan','karyawan.id')
                ->leftjoin('jenisizin','izin.id_jenisizin','jenisizin.id')
                ->where('karyawan.atasan_pertama',Auth::user()->id_pegawai)
                ->select('izin.*','karyawan.nama','jenisizin.jenis_izin')
                ->distinct()
                ->get();

            return view('manager.staff.cutiStaff', compact('cutistaff','row','tp','izinstaff','alasan','alasancuti'));
        }
        else{
            return redirect()->back();
        }
    }

    public function cutiapproved(Request $request, $id)
    {
        $cuti = Cuti::where('id',$id)->first();
        $role = Auth::user()->role;

        //ambil tipe approval cuti
        $datacuti = DB::table('cuti')
            ->join('alokasicuti', 'cuti.id_alokasi', '=', 'alokasicuti.id')
            ->join('settingalokasi', 'cuti.id_settingalokasi', '=', 'settingalokasi.id')
            ->where('settingalokasi.tipe_approval', 'Tidak Bertingkat')
            ->orWhere('settingalokasi.tipe_approval', 'Bertingkat')
            ->select('cuti.*','alokasicuti.*','settingalokasi.tipe_approval')
            ->first();

        // dd($data);
        if($role == 3)
        {
            if($datacuti->tipe_approval == 'Tidak Bertingkat')
            {
                $jml_cuti = $cuti->jml_cuti;
                Cuti::where('id', $id)->update(
                    ['status' => 'Disetujui']
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

                //ambil data karyawan
                $tujuan = 'akhiratunnisahasanah0917@gmail.com';
                $data = [
                    'subject'     =>'Notifikasi Cuti Disetujui',
                    'id'          =>$cuti->id,
                    'id_jeniscuti'=>$cuti->jeniscutis->jenis_cuti,
                    'keperluan'   =>$cuti->keperluan,
                    'tgl_mulai'   =>Carbon::parse($cuti->tgl_mulai)->format("d M Y"),
                    'tgl_selesai' =>Carbon::parse($cuti->tgl_selesai)->format("d M Y"),
                    'jml_cuti'    =>$cuti->jml_cuti,
                    'status'      =>$cuti->status,
                ];
                Mail::to($tujuan)->send(new CutiApproveNotification($data));
                return redirect()->back()->withInput();

            }else{
                $status = 'Disetujui Manager';
                Cuti::where('id',$id)->update([
                    'status' => $status,
                ]);
                //ambil nama_atasan
                $idatasan = DB::table('cuti')
                    ->join('karyawan','cuti.id_karyawan','=','karyawan.id')
                    ->select('karyawan.atasan_kedua as atasan_kedua')
                    ->first();
                $atasan = Karyawan::where('id',$idatasan->atasan_kedua)
                    ->select('email as email')
                    ->first();
                
                //ambil data karyawan
                $tujuan = $atasan->email;
                // $tujuan = 'akhiratunnisahasanah0917@gmail.com';
                // dd($idatasan,$atasan->email,$tujuan);
                
                $data = [
                    'subject'     =>'Notifikasi Cuti Disetujui',
                    'id'          =>$cuti->id,
                    'id_jeniscuti'=>$cuti->jeniscutis->jenis_cuti,
                    'keperluan'   =>$cuti->keperluan,
                    'tgl_mulai'   =>Carbon::parse($cuti->tgl_mulai)->format("d M Y"),
                    'tgl_selesai' =>Carbon::parse($cuti->tgl_selesai)->format("d M Y"),
                    'jml_cuti'    =>$cuti->jml_cuti,
                    'status'      =>$cuti->status,
                ];
                Mail::to($tujuan)->send(new CutiApproveNotification($data));
                return redirect()->back()->withInput();
            }
        }
        elseif($role == 5)
        {
            if($datacuti->tipe_approval == 'Tidak Bertingkat')
            {
                $jml_cuti = $cuti->jml_cuti;
                Cuti::where('id', $id)->update(
                    ['status' => 'Disetujui']
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

                
                //ambil data karyawan
                // $tujuan = Auth::user()->email;
                $tujuan = 'akhiratunnisahasanah0917@gmail.com';
                $data = [
                    'subject'     =>'Notifikasi Cuti Disetujui',
                    'id'          =>$cuti->id,
                    'id_jeniscuti'=>$cuti->jeniscutis->jenis_cuti,
                    'keperluan'   =>$cuti->keperluan,
                    'tgl_mulai'   =>Carbon::parse($cuti->tgl_mulai)->format("d M Y"),
                    'tgl_selesai' =>Carbon::parse($cuti->tgl_selesai)->format("d M Y"),
                    'jml_cuti'    =>$cuti->jml_cuti,
                    'status'      =>$cuti->status,
                ];
                return redirect()->back()->withInput();

            }else{
                $status = 'Disetujui Supervisor';
                Cuti::where('id',$id)->update([
                    'status' => $status,
                ]);
                return redirect()->back()->withInput();
            }
        }
        else{
            return redirect()->back();
        }   
    }

    public function cutireject(Request $request, $id)
    {
        $status = 'Ditolak';
        Cuti::where('id',$id)->update([
            'status' => $status,
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
            ->where('cuti.id',$id)
            ->select('cuti.*','jeniscuti.jenis_cuti as jenis_cuti')
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
            'status'      =>$ct->status,
        ];
        Mail::to($tujuan)->send(new CutiApproveNotification($data));
        return redirect()->back()->withInput();
    }

    public function izinApproved(Request $request, $id)
    {
        // $izin = Izin::where('id',$id)->first();
        $status = 'Disetujui';
        Izin::where('id',$id)->update([
            'status' => $status,
        ]);

        $izin = DB::table('izin')
            ->join('jenisizin','izin.id_jenisizin','=','jenisizin.id')
            ->where('izin.id',$id)
            ->select('izin.*','jenisizin.jenis_izin as jenis_izin')
            ->first();
        
        //ambil data karyawan 
        $karyawan = DB::table('izin')
            ->join('karyawan','izin.id_karyawan','=','karyawan.id')
            ->where('izin.id',$izin->id)
            ->select('karyawan.email as email','karyawan.nama as nama')
            ->first(); 
        $tujuan = $karyawan->email;
        //$tujuan = 'akhiratunnisahasanah0917@gmail.com';
        $data = [
            'title'    =>$izin->id,
            'subject'  =>'Notifikasi Izin',
            'id'       =>$izin->id,
            'nama'     =>$karyawan->nama,
            'jenisizin'=>$izin->jenis_izin,
            'tgl_mulai'=>$izin->tgl_mulai,
            'status'   =>$izin->status,
        ];
        Mail::to($tujuan)->send(new IzinApproveNotification($data));
        return redirect()->route('cuti.Staff',['tp'=>2]);
    }

    public function izinReject(Request $request, $id)
    {
        $status = 'Ditolak';
        Izin::where('id',$id)->update([
            'status' => $status,
        ]);

        $iz = Izin::where('id',$id)->first();

        $datareject          = new Datareject;
        $datareject->id_cuti = NULL;
        $datareject->id_izin = $iz->id;
        $datareject->alasan  = $request->alasan;
        $datareject->save();   

        $izin = DB::table('izin')
            ->join('jenisizin','izin.id_jenisizin','=','jenisizin.id')
            ->where('izin.id',$id)
            ->select('izin.*','jenisizin.jenis_izin as jenis_izin')
            ->first();
        $karyawan = DB::table('izin')
            ->join('karyawan','izin.id_karyawan','=','karyawan.id')
            ->where('izin.id',$izin->id)
            ->select('karyawan.email as email','karyawan.nama as nama')
            ->first(); 
        //$tujuan = 'akhiratunnisahasanah0917@gmail.com';
        $tujuan = $karyawan->email;
        $data = [
            'title'    =>$izin->id,
            'subject'  =>'Notifikasi Izin',
            'id'       =>$izin->id,
            'nama'     =>$karyawan->nama,
            'jenisizin'=>$izin->jenis_izin,
            'tgl_mulai'=>$izin->tgl_mulai,
            'status'   =>$izin->status,
        ];
        Mail::to($tujuan)->send(new IzinApproveNotification($data));
        return redirect()->route('cuti.Staff',['type'=>2])->withInput();
    }

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

    //export excel data by filter di bagian manager 
    //DIGUNAKAN
    public function exportToExcel(Request $request)
    {
        $role = Auth::user()->role;
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
        $tahun      = $request->session()->get('tahun');

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
        }else{
            $data = Absensi::with('karyawans','departemens')
                ->where('id_departement',$middep->id_departement)
                ->get();
            $departemen = Departemen::where('id',$middep->id_departement)->first();
        };
        return Excel::download(new AbsensiFilterExport($data,$idkaryawan,$middep), 
            "REKAP ABSENSI BULAN ".$nbulan." ".$data->first()->karyawans->nama." DEPARTEMEN ".$departemen->nama_departemen.".xlsx");
    }

    //DIGUNAKAN
    public function exportpdf(Request $request)
    {
        //mengambil id_departemen manager
        $middep = DB::table('absensi')
        ->join('karyawan','absensi.id_departement','=','karyawan.divisi')
        ->where('absensi.id_karyawan','=',Auth::user()->id_pegawai)
        ->select('id_departement')->first();
        $nbulan = $request->query('bulan',Carbon::now()->format('M Y'));

        $idkaryawan = $request->id_karyawan;
        $bulan      = $request->query('bulan',Carbon::now()->format('m'));
        $tahun      = $request->query('tahun',Carbon::now()->format('Y'));

        // simpan session
        $idkaryawan = $request->session()->get('idkaryawan');
        $bulan      = $request->session()->get('bulan');
        $tahun      = $request->session()->get('tahun',);

        // dd($idkaryawan,$bulan,$tahun );
    
        if(isset($idkaryawan) && isset($bulan) && isset($tahun))
        {
            $data = Absensi::where('id_karyawan', $idkaryawan)
                ->where('id_departement',$middep->id_departement)
                ->whereMonth('tanggal', $bulan)
                ->whereYear('tanggal',$tahun)
                ->get();
            $departemen = Departemen::where('id',$middep->id_departement)->first();
        }else
        {
            $data = Absensi::where('id_departement',$middep->id_departement)->get();
            $departemen = Departemen::where('id',$middep->id_departement)->first();
        }
        $pdf  = PDF::loadview('manager.staff.absensistaff_pdf',['data'=>$data,'idkaryawan'=>$idkaryawan])
        ->setPaper('A4','landscape');

        return $pdf->stream("REKAP ABSENSI BULAN ".$nbulan." ".$data->first()->karyawans->nama." DEPARTEMEN ".$departemen->nama_departemen.".pdf");
    }

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

        // dd( $manager_iddep);
        //ambil data dengan id_departemen sama dengan manager
        //$staff= Karyawan::where('divisi',$manager_iddep->divisi)->get();
        $staff1= Resign::with('departemens','karyawan')
        ->where('departemen',$manager_iddep->divisi)->get();
        
        
    // $namdiv = $tes->departemen->nama_departemen;

        return view('manager\staff.resignStaff', compact('karyawan','karyawan1','resign','tes','staff1','row'));
    }

}
 // $data = DB::table('cuti')
        // ->join('alokasicuti','cuti.id_alokasi','alokasicuti.id')
        // ->join('settingalokasi','cuti.id_settingalokasi','settingalokasi.id')
        // ->where('cuti.id_settingalokasi','alokasicuti.id_settingalokasi')
        // ->where('cuti.id_jeniscuti','alokasicuti.id_jeniscuti')
        // ->where('settingalokasi.tipe_approval','Tidak Bertingkat')
        // ->select('cuti.*','alokasicuti.*','settingalokasi.tipe_approval')
        // ->first();

   // public function showCuti($id)
    // {
    //     $cutiStaff = Cuti::findOrFail($id);

    //     return view('manager.staff.cutiStaff',compact('cutiStaff'));
    // }

    
    // public function showIzin($id)
    // {
    //     $izin = Izin::findOrFail($id);
    //     $karyawan = Auth::user()->id_pegawai;
    //     // $alasan = DB::table('datareject')
    //     //     ->join('izin','datareject.id_izin','=','izin.id')
    //     //     ->where('datareject.id_izin',$id)
    //     //     ->select('datareject.alasan as alasan','datareject.id_izin as id_izin')
    //     //     ->first();
    //     $alasan = Datareject::where('id_izin','=',$id);
    //     dd($alasan->id_izin);
    
    //     return view('manager.staff.cutiStaff',compact('izin','karyawan','alasan',['tp'=>2]));
    // }

