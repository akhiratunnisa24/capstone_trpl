<?php

namespace App\Http\Controllers\manager;

use PDF;
use Carbon\Carbon;
use App\Models\Cuti;
use App\Models\Izin;
use App\Models\User;
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
use App\Models\SettingOrganisasi;
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
use App\Mail\CutiIzinTolakNotification;
use App\Exports\AbsensiDepartemenExport;

class ManagerController extends Controller
{
    public function dataStaff(Request $request)
    {
        $partner = Auth::user()->partner;
        $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
        $role = Auth::user()->role;

        if ($role == 3 && $row->jabatan == "Manager")
        {
            $staff = Karyawan::with('departemens')
                ->where(function ($query) use ($partner) {
                    $query->where('atasan_pertama', Auth::user()->id_pegawai)
                        ->orWhere('atasan_kedua', Auth::user()->id_pegawai);
                })
                ->where('partner', $partner)
                ->where('divisi', $row->divisi)
                ->get();

            return view('manager.staff.dataStaff', compact('staff','row','partner'));
        }
        elseif ($role == 3 && $row->jabatan == "Asistant Manager")
        {
            $staff = Karyawan::with('departemens')
                ->where('atasan_pertama', Auth::user()->id_pegawai)
                ->where('partner', $partner)
                ->where('divisi', $row->divisi)
                ->get();

            return view('manager.staff.dataStaff', compact('staff','row','partner'));
        }
        elseif ($role == 3 && $row->jabatan == "Direksi" || $role == 7) // Role 7 condition
        {
            $staff = Karyawan::where('partner', $partner)
                // ->where('divisi', $row->divisi)
                ->get();

            return view('manager.staff.dataStaff', compact('staff', 'row', 'partner'));
        }
        else {
            return redirect()->back()->with('error','Anda tidak memiliki hak akses');
        }


        // elseif($role == 1 && $row->jabatan == "Asistant Manager")
        // {
        //     $staff= Karyawan::with('departemens')
        //     ->where('atasan_pertama','=',Auth::user()->id_pegawai)->get();

        // return view('manager.staff.dataStaff', compact('staff','row'));
        // }

    }

    public function absensiStaff(Request $request)
    {
        $partner = Auth::user()->partner;
        $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
        $role = Auth::user()->role;

        //mengambil id_departemen user login
        $pegawai = Karyawan::where('jabatan','Staff')->orWhere('jabatan','Asistant Manager')
            ->orWhere('jabatan','Pelaksana')
            ->where('karyawan.atasan_pertama', Auth::user()->id_pegawai)
            ->orWhere('karyawan.atasan_kedua', Auth::user()->id_pegawai)
            ->select('id as idkaryawan')
            ->get();
        // return $pegawai;
        // return $role;
        if($role == 3 && $row->jabatan = "Manager")
        {
            // dd($row);
            $karyawan = Karyawan::with('departemens')
                ->where(function ($query) use ($partner) {
                    $query->where('atasan_pertama', Auth::user()->id_pegawai)
                        ->orWhere('atasan_kedua', Auth::user()->id_pegawai);
                })
                ->where('partner', $partner)
                ->where('divisi', $row->divisi)
                ->get();
                // dd($karyawan);
            $manager_iddep = DB::table('karyawan')->where('id','=',Auth::user()->id_pegawai)
                ->select('divisi')->first();
            // $karyawan= Karyawan::where('divisi',$manager_iddep->divisi)->get();
             //untuk filter data
            $idkaryawan = $request->id_karyawan;
            $bulan = $request->query('bulan',Carbon::now()->format('m'));
            $tahun = $request->query('tahun',Carbon::now()->format('Y'));

            //simpan session
            $request->session()->put('idkaryawan', $request->id_karyawan);
            $request->session()->put('bulan', $bulan);
            $request->session()->put('tahun', $tahun);

            //mengambil data sesuai dengan filter yang dipilih
            if($idkaryawan !== "Semua" && isset($idkaryawan) && isset($bulan) && isset($tahun))
            {
                $absensi = Absensi::with('karyawans','departemens')
                    ->where('id_karyawan', $idkaryawan)
                    ->whereMonth('tanggal', $bulan)
                    ->whereYear('tanggal',$tahun)
                    ->get();
            }
            elseif($idkaryawan == "Semua" && isset($bulan) && isset($tahun))
            {
                $absensi = Absensi::with('karyawans','departemens')
                    ->where('id_departement',$manager_iddep->divisi)
                    ->where('partner', Auth::user()->partner)
                    ->whereMonth('tanggal', $bulan)
                    ->whereYear('tanggal',$tahun)
                    ->get();
            }
            else
            {

                $absensi= Absensi::with('karyawans','departemens')
                    ->where('absensi.id_departement',$manager_iddep->divisi)
                    ->where('absensi.partner', Auth::user()->partner)
                    ->get();
            }

            return view('manager.staff.absensiStaff', compact('absensi','karyawan','row','role'));
            //menghapus filter data
            $request->session()->forget('id_karyawan');
            $request->session()->forget('bulan');
            $request->session()->forget('tahun');
        }
        elseif($role == 3 && $row->jabatan == "Asistant Manager")
        {
            $karyawan = Karyawan::with('departemens')
            ->where(function ($query) use ($partner) {
                $query->where('atasan_pertama', Auth::user()->id_pegawai)
                    ->orWhere('atasan_kedua', Auth::user()->id_pegawai);
            })
            ->where('partner', $partner)
            ->where('divisi', $row->divisi)
            ->get();

            $spv = DB::table('karyawan')->where('id','=',Auth::user()->id_pegawai)
            ->select('divisi')->first();
             //untuk filter data
            $idkaryawan = $request->id_karyawan;
            $bulan = $request->query('bulan',Carbon::now()->format('m'));
            $tahun = $request->query('tahun',Carbon::now()->format('Y'));

            //simpan session
            $request->session()->put('idkaryawan', $request->id_karyawan);
            $request->session()->put('bulan', $bulan);
            $request->session()->put('tahun', $tahun);

            //mengambil data sesuai dengan filter yang dipilih
            if($idkaryawan !== "Semua" && isset($idkaryawan) && isset($bulan) && isset($tahun))
            {
                $absensi = Absensi::with('karyawans','departemens')
                    ->where('id_karyawan', $idkaryawan)
                    ->whereMonth('tanggal', $bulan)
                    ->whereYear('tanggal',$tahun)
                    ->get();

            }
            elseif($idkaryawan == "Semua" && isset($bulan) && isset($tahun))
            {
                $absensi = Absensi::with('karyawans','departemens')
                    ->whereHas('karyawans', function ($query) use ($spv) {
                        $query->where('atasan_pertama', Auth::user()->id_pegawai);
                    })
                    ->where('id_departement',$spv->divisi)
                    ->where('partner', Auth::user()->partner)
                    ->whereMonth('tanggal', $bulan)
                    ->whereYear('tanggal',$tahun)
                    ->get();
            }
            else
            {
                $absensi = Absensi::with('karyawans', 'departemens')
                    ->whereHas('karyawans', function ($query) use ($spv) {
                        $query->where('atasan_pertama', Auth::user()->id_pegawai);
                    })
                    ->where('id_departement', $spv->divisi)
                    ->where('partner', Auth::user()->partner)
                    ->get();

            }
            return view('manager.staff.absensiStaff', compact('absensi','karyawan','row','role'));
            //menghapus filter data
            $request->session()->forget('id_karyawan');
            $request->session()->forget('bulan');
            $request->session()->forget('tahun');

        }
        else{
            return redirect()->back()->with('error','Anda tidak memiliki hak akses');
        }

        // elseif($role == 2 && $row->jabatan = "Asistant Manager")
        // {
        //     $spv = DB::table('karyawan')->where('id','=',Auth::user()->id_pegawai)
        //     ->select('divisi')->first();
        //     $karyawan= Karyawan::where('atasan_pertama',Auth::user()->id_pegawai)->get();

        //     //untuk filter data
        //     $idkaryawan = $request->id_karyawan;
        //     $bulan = $request->query('bulan',Carbon::now()->format('m'));
        //     $tahun = $request->query('tahun',Carbon::now()->format('Y'));

        //     //simpan session
        //     $request->session()->put('idkaryawan', $request->id_karyawan);
        //     $request->session()->put('bulan', $bulan);
        //     $request->session()->put('tahun', $tahun);

        //     //mengambil data sesuai dengan filter yang dipilih
        //     if(isset($idkaryawan) && isset($bulan) && isset($tahun))
        //     {
        //         $absensi = Absensi::with('karyawans','departemens')
        //             ->where('id_karyawan', $idkaryawan)
        //             ->whereMonth('tanggal', $bulan)
        //             ->whereYear('tanggal',$tahun)
        //             ->get();
        //     }else
        //     {
        //     //saring data dengan id_departemen sama dengan manager secara keseluruhan
        //         $absensi= Absensi::where('id_departement',$spv->divisi)->whereIn('id_karyawan',$pegawai->pluck('idkaryawan'))->get();
        //         // return $absensi;
        //     }
        //     return view('manager.staff.absensiStaff', compact('absensi','karyawan','row','role'));
        //     //menghapus filter data
        //     $request->session()->forget('id_karyawan');
        //     $request->session()->forget('bulan');
        //     $request->session()->forget('tahun');
        // }
    }

    public function cutiStaff(Request $request)
    {
        $partner = Auth::user()->partner;

        $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
        $role= Auth::user()->role;

        $atasan = DB::table('karyawan')->where('id','=',Auth::user()->id_pegawai)
            ->select('divisi')->first();

        $tp = $request->query('tp',1);

        $karyawan = Karyawan::with('departemens')
            ->where(function ($query) use ($partner) {
                $query->where('atasan_pertama', Auth::user()->id_pegawai)
                    ->orWhere('atasan_kedua', Auth::user()->id_pegawai);
            })
            ->where('partner', $partner)
            ->where('divisi', $row->divisi)
            ->get();
        $pegawai = Karyawan::with('departemens')
            ->where(function ($query) use ($partner) {
                $query->where('atasan_pertama', Auth::user()->id_pegawai)
                    ->orWhere('atasan_kedua', Auth::user()->id_pegawai);
            })
            ->where('partner', $partner)
            ->where('divisi', $row->divisi)
            ->get();

        if($role == 3 && $row->jabatan == "Manager")
        {
            if($request->id_karyawan)
            {
                // Filter Data Cuti
                $tp = $request->query('tp',1);
                $idkaryawan = $request->id_karyawan;
                $bulan = $request->query('bulan', Carbon::now()->format('m'));
                $tahun = $request->query('tahun', Carbon::now()->format('Y'));

                // simpan session
                $request->session()->put('idkaryawan', $request->id_karyawan);
                $request->session()->put('bulan', $bulan);
                $request->session()->put('tahun', $tahun);

                if ($idkaryawan !== "Semua" && isset($idkaryawan) && isset($bulan) && isset($tahun))
                {
                    $tp = $request->query('tp',1);
                    $cutistaff = DB::table('cuti')
                        ->leftjoin('jeniscuti','cuti.id_jeniscuti','jeniscuti.id')
                        ->leftjoin('karyawan','cuti.id_karyawan','karyawan.id')
                        ->leftjoin('alokasicuti','cuti.id_alokasi','alokasicuti.id')
                        ->leftjoin('settingalokasi','cuti.id_settingalokasi','settingalokasi.id')
                        ->leftjoin('statuses','cuti.status','statuses.id')
                        ->leftjoin('datareject','datareject.id_cuti','cuti.id')
                        ->leftjoin('departemen','cuti.departemen','departemen.id')
                        ->where(function($query){
                            $query->where('karyawan.atasan_pertama',Auth::user()->id_pegawai)
                            ->orWhere(function($query) {
                                $query->where('karyawan.atasan_kedua',Auth::user()->id_pegawai);
                            });
                        })
                        ->where('karyawan.partner',Auth::user()->partner)
                        ->where('cuti.id_karyawan', $idkaryawan)
                        ->whereMonth('cuti.tgl_mulai', $bulan)
                        ->whereYear('cuti.tgl_mulai', $tahun)
                        ->select('cuti.*', 'jeniscuti.jenis_cuti', 'karyawan.nama','karyawan.atasan_pertama','karyawan.atasan_kedua','statuses.name_status','datareject.alasan','departemen.nama_departemen')
                        ->distinct()
                        ->orderBy('cuti.id', 'desc')
                        ->get();
                    // dd($cutistaff);

                    $izinstaff = DB::table('izin')
                        ->leftjoin('karyawan','izin.id_karyawan','karyawan.id')
                        ->leftjoin('jenisizin','izin.id_jenisizin','jenisizin.id')
                        ->leftjoin('statuses','izin.status','=','statuses.id')
                        ->leftjoin('datareject','datareject.id_izin','=','izin.id')
                        ->leftjoin('departemen','izin.departemen','=','departemen.id')
                        ->where(function($query){
                            $query->where('karyawan.atasan_pertama',Auth::user()->id_pegawai)
                            ->orWhere(function($query){
                                $query->where('karyawan.atasan_kedua',Auth::user()->id_pegawai);
                            });
                        })
                        ->where('karyawan.partner',Auth::user()->partner)
                        ->select('izin.*','karyawan.nama','karyawan.atasan_pertama','karyawan.atasan_kedua','jenisizin.jenis_izin','statuses.name_status','datareject.alasan as alasan','departemen.nama_departemen')
                        ->distinct()
                        ->get();
                    return view('manager.staff.cutiStaff', compact('cutistaff','row','tp','izinstaff','karyawan','pegawai'));
                }elseif ($idkaryawan == "Semua" && isset($bulan) && isset($tahun))
                {
                    $tp = $request->query('tp',1);
                    $cutistaff = DB::table('cuti')
                        ->leftjoin('jeniscuti','cuti.id_jeniscuti','jeniscuti.id')
                        ->leftjoin('karyawan','cuti.id_karyawan','karyawan.id')
                        ->leftjoin('alokasicuti','cuti.id_alokasi','alokasicuti.id')
                        ->leftjoin('settingalokasi','cuti.id_settingalokasi','settingalokasi.id')
                        ->leftjoin('statuses','cuti.status','statuses.id')
                        ->leftjoin('datareject','datareject.id_cuti','cuti.id')
                        ->leftjoin('departemen','cuti.departemen','departemen.id')
                        ->where(function($query){
                            $query->where('karyawan.atasan_pertama',Auth::user()->id_pegawai)
                            ->orWhere(function($query) {
                                $query->where('karyawan.atasan_kedua',Auth::user()->id_pegawai);
                            });
                        })
                        ->where('karyawan.partner',Auth::user()->partner)
                        ->where('karyawan.divisi',$atasan->divisi)
                        ->whereMonth('cuti.tgl_mulai', $bulan)
                        ->whereYear('cuti.tgl_mulai', $tahun)
                        ->select('cuti.*', 'jeniscuti.jenis_cuti', 'karyawan.nama','karyawan.atasan_pertama','karyawan.atasan_kedua','statuses.name_status','datareject.alasan','departemen.nama_departemen')
                        ->distinct()
                        ->orderBy('cuti.id', 'desc')
                        ->get();
                    // dd($cutistaff);

                    $izinstaff = DB::table('izin')
                        ->leftjoin('karyawan','izin.id_karyawan','karyawan.id')
                        ->leftjoin('jenisizin','izin.id_jenisizin','jenisizin.id')
                        ->leftjoin('statuses','izin.status','=','statuses.id')
                        ->leftjoin('datareject','datareject.id_izin','=','izin.id')
                        ->leftjoin('departemen','izin.departemen','=','departemen.id')
                        ->where(function($query){
                            $query->where('karyawan.atasan_pertama',Auth::user()->id_pegawai)
                            ->orWhere(function($query){
                                $query->where('karyawan.atasan_kedua',Auth::user()->id_pegawai);
                            });
                        })
                        ->where('karyawan.partner',Auth::user()->partner)
                        ->select('izin.*','karyawan.nama','karyawan.atasan_pertama','karyawan.atasan_kedua','jenisizin.jenis_izin','statuses.name_status','datareject.alasan as alasan','departemen.nama_departemen')
                        ->distinct()
                        ->get();
                    return view('manager.staff.cutiStaff', compact('cutistaff','row','tp','izinstaff','karyawan','pegawai'));
                }
                 else
                {
                    $tp = $request->query('tp',1);
                    $cutistaff = DB::table('cuti')
                        ->leftjoin('alokasicuti', 'cuti.id_jeniscuti', 'alokasicuti.id_jeniscuti')
                        ->leftjoin('settingalokasi', 'cuti.id_jeniscuti', 'settingalokasi.id_jeniscuti')
                        ->leftjoin('jeniscuti', 'cuti.id_jeniscuti', 'jeniscuti.id')
                        ->leftjoin('karyawan', 'cuti.id_karyawan', 'karyawan.id')
                        ->leftjoin('statuses', 'cuti.status', 'statuses.id')
                        ->leftjoin('datareject', 'datareject.id_cuti','cuti.id')
                        ->leftjoin('departemen','cuti.departemen','departemen.id')
                        ->where(function($query){
                            $query->where('karyawan.atasan_pertama',Auth::user()->id_pegawai)
                            ->orWhere(function($query) {
                                $query->where('karyawan.atasan_kedua',Auth::user()->id_pegawai);
                            });
                        })
                        ->where('karyawan.partner',Auth::user()->partner)
                        ->select('cuti.*', 'jeniscuti.jenis_cuti', 'departemen.nama_departemen', 'karyawan.nama','statuses.name_status', 'karyawan.atasan_pertama', 'karyawan.atasan_kedua', 'datareject.alasan as alasan', 'datareject.id_cuti as id_cuti')
                        ->distinct()
                        ->orderBy('cuti.id', 'DESC')
                        ->get();
                    // dd($cutistaff);
                    $izinstaff = DB::table('izin')
                        ->leftjoin('karyawan','izin.id_karyawan','karyawan.id')
                        ->leftjoin('jenisizin','izin.id_jenisizin','jenisizin.id')
                        ->leftjoin('statuses','izin.status','=','statuses.id')
                        ->leftjoin('datareject','datareject.id_izin','=','izin.id')
                        ->leftjoin('departemen','izin.departemen','=','departemen.id')
                        ->where(function($query){
                            $query->where('karyawan.atasan_pertama',Auth::user()->id_pegawai)
                            ->orWhere(function($query){
                                $query->where('karyawan.atasan_kedua',Auth::user()->id_pegawai);
                            });
                        })
                        ->where('karyawan.partner',Auth::user()->partner)
                        ->select('izin.*','karyawan.nama','karyawan.atasan_pertama','karyawan.atasan_kedua','jenisizin.jenis_izin','statuses.name_status','datareject.alasan as alasan','departemen.nama_departemen')
                        ->distinct()
                        ->get();
                    return view('manager.staff.cutiStaff', compact('cutistaff','row','tp','izinstaff','karyawan','pegawai'));
                }

            }else
            {
                 // Filter Data Izin
                $idpegawai = $request->idpegawai;
                $month = $request->query('month', Carbon::now()->format('m'));
                $year = $request->query('year', Carbon::now()->format('Y'));

                 // simpan session
                $request->session()->put('idpegawai', $idpegawai);
                $request->session()->put('month', $month);
                $request->session()->put('year', $year);


                if($idpegawai !== "Semua" && isset($idpegawai) && isset($month) && isset($year))
                {
                    $tp = $request->query('tp',2);
                    $izinstaff = DB::table('izin')
                        ->leftjoin('karyawan','izin.id_karyawan','karyawan.id')
                        ->leftjoin('jenisizin','izin.id_jenisizin','jenisizin.id')
                        ->leftjoin('statuses','izin.status','=','statuses.id')
                        ->leftjoin('datareject','datareject.id_izin','=','izin.id')
                        ->leftjoin('departemen','izin.departemen','=','departemen.id')
                        ->where(function($query){
                            $query->where('karyawan.atasan_pertama',Auth::user()->id_pegawai)
                            ->orWhere(function($query){
                                $query->where('karyawan.atasan_kedua',Auth::user()->id_pegawai);
                            });
                        })
                        ->where('izin.id_karyawan', $idpegawai)
                        ->whereMonth('izin.tgl_mulai', $month)
                        ->whereYear('izin.tgl_mulai', $year)
                        ->select('izin.*','karyawan.nama','karyawan.atasan_pertama','karyawan.atasan_kedua','jenisizin.jenis_izin','statuses.name_status','datareject.alasan as alasan','departemen.nama_departemen')
                        ->distinct()
                        ->get();

                    $cutistaff = DB::table('cuti')
                        ->leftjoin('alokasicuti', 'cuti.id_jeniscuti', 'alokasicuti.id_jeniscuti')
                        ->leftjoin('settingalokasi', 'cuti.id_jeniscuti', 'settingalokasi.id_jeniscuti')
                        ->leftjoin('jeniscuti', 'cuti.id_jeniscuti', 'jeniscuti.id')
                        ->leftjoin('karyawan', 'cuti.id_karyawan', 'karyawan.id')
                        ->leftjoin('statuses', 'cuti.status', 'statuses.id')
                        ->leftjoin('datareject', 'datareject.id_cuti','cuti.id')
                        ->leftjoin('departemen','cuti.departemen','departemen.id')
                        ->where(function($query) {
                            $query->where('karyawan.atasan_pertama',Auth::user()->id_pegawai)
                            ->orWhere(function($query) {
                                $query->where('karyawan.atasan_kedua',Auth::user()->id_pegawai);
                            });
                        })
                        ->where('karyawan.partner',Auth::user()->partner)
                        ->select('cuti.*', 'jeniscuti.jenis_cuti', 'departemen.nama_departemen', 'karyawan.nama','statuses.name_status', 'karyawan.atasan_pertama', 'karyawan.atasan_kedua', 'datareject.alasan as alasan', 'datareject.id_cuti as id_cuti')
                        ->distinct()
                        ->orderBy('cuti.id', 'DESC')
                        ->get();
                    return view('manager.staff.cutiStaff', compact('cutistaff','row','tp','izinstaff','karyawan','pegawai'));
                }
                elseif($idpegawai == "Semua" && isset($month) && isset($year))
                {
                    $tp = $request->query('tp',2);
                    $izinstaff = DB::table('izin')
                        ->leftjoin('karyawan','izin.id_karyawan','karyawan.id')
                        ->leftjoin('jenisizin','izin.id_jenisizin','jenisizin.id')
                        ->leftjoin('statuses','izin.status','=','statuses.id')
                        ->leftjoin('datareject','datareject.id_izin','=','izin.id')
                        ->leftjoin('departemen','izin.departemen','=','departemen.id')
                        ->where(function($query){
                            $query->where('karyawan.atasan_pertama',Auth::user()->id_pegawai)
                            ->orWhere(function($query){
                                $query->where('karyawan.atasan_kedua',Auth::user()->id_pegawai);
                            });
                        })
                        ->whereMonth('izin.tgl_mulai', $month)
                        ->whereYear('izin.tgl_mulai', $year)
                        ->where('karyawan.partner',Auth::user()->partner)
                        ->where('karyawan.divisi',$row->divisi)
                        ->select('izin.*','karyawan.nama','karyawan.atasan_pertama','karyawan.atasan_kedua','jenisizin.jenis_izin','statuses.name_status','datareject.alasan as alasan','departemen.nama_departemen')
                        ->distinct()
                        ->get();

                    $cutistaff = DB::table('cuti')
                        ->leftjoin('alokasicuti', 'cuti.id_jeniscuti', 'alokasicuti.id_jeniscuti')
                        ->leftjoin('settingalokasi', 'cuti.id_jeniscuti', 'settingalokasi.id_jeniscuti')
                        ->leftjoin('jeniscuti', 'cuti.id_jeniscuti', 'jeniscuti.id')
                        ->leftjoin('karyawan', 'cuti.id_karyawan', 'karyawan.id')
                        ->leftjoin('statuses', 'cuti.status', 'statuses.id')
                        ->leftjoin('datareject', 'datareject.id_cuti','cuti.id')
                        ->leftjoin('departemen','cuti.departemen','departemen.id')
                        ->where(function($query) {
                            $query->where('karyawan.atasan_pertama',Auth::user()->id_pegawai)
                            ->orWhere(function($query) {
                                $query->where('karyawan.atasan_kedua',Auth::user()->id_pegawai);
                            });
                        })
                        ->where('karyawan.partner',Auth::user()->partner)
                        ->select('cuti.*', 'jeniscuti.jenis_cuti', 'departemen.nama_departemen', 'karyawan.nama','statuses.name_status', 'karyawan.atasan_pertama', 'karyawan.atasan_kedua', 'datareject.alasan as alasan', 'datareject.id_cuti as id_cuti')
                        ->distinct()
                        ->orderBy('cuti.id', 'DESC')
                        ->get();
                    return view('manager.staff.cutiStaff', compact('cutistaff','row','tp','izinstaff','karyawan','pegawai'));
                }
                else
                {
                    $cutistaff = DB::table('cuti')
                        ->leftjoin('alokasicuti', 'cuti.id_jeniscuti', 'alokasicuti.id_jeniscuti')
                        ->leftjoin('settingalokasi', 'cuti.id_jeniscuti', 'settingalokasi.id_jeniscuti')
                        ->leftjoin('jeniscuti', 'cuti.id_jeniscuti', 'jeniscuti.id')
                        ->leftjoin('karyawan', 'cuti.id_karyawan', 'karyawan.id')
                        ->leftjoin('statuses', 'cuti.status', 'statuses.id')
                        ->leftjoin('datareject', 'datareject.id_cuti','cuti.id')
                        ->leftjoin('departemen','cuti.departemen','departemen.id')
                        ->where(function($query) {
                            $query->where('karyawan.atasan_pertama',Auth::user()->id_pegawai)
                            ->orWhere(function($query) {
                                $query->where('karyawan.atasan_kedua',Auth::user()->id_pegawai);
                            });
                        })
                        ->where('karyawan.partner',Auth::user()->partner)
                        ->select('cuti.*', 'jeniscuti.jenis_cuti', 'departemen.nama_departemen', 'karyawan.nama','statuses.name_status', 'karyawan.atasan_pertama', 'karyawan.atasan_kedua', 'datareject.alasan as alasan', 'datareject.id_cuti as id_cuti')
                        ->distinct()
                        ->orderBy('cuti.id', 'DESC')
                        ->get();

                    $izinstaff = DB::table('izin')
                        ->leftjoin('karyawan','izin.id_karyawan','karyawan.id')
                        ->leftjoin('jenisizin','izin.id_jenisizin','jenisizin.id')
                        ->leftjoin('statuses','izin.status','=','statuses.id')
                        ->leftjoin('datareject','datareject.id_izin','=','izin.id')
                        ->leftjoin('departemen','izin.departemen','=','departemen.id')
                        ->where(function($query) {
                            $query->where('karyawan.atasan_pertama',Auth::user()->id_pegawai)
                            ->orWhere(function($query) {
                                $query->where('karyawan.atasan_kedua',Auth::user()->id_pegawai);
                            });
                        })
                        ->where('karyawan.partner',Auth::user()->partner)
                        ->select('izin.*','karyawan.nama','karyawan.atasan_pertama','karyawan.atasan_kedua','jenisizin.jenis_izin','statuses.name_status','datareject.alasan as alasan','departemen.nama_departemen')
                        ->distinct()
                        ->get();
                    return view('manager.staff.cutiStaff', compact('cutistaff','row','tp','izinstaff','karyawan','pegawai'));
                }
                //menghapus filter data
                $request->session()->forget('id_karyawan');
                $request->session()->forget('bulan');
                $request->session()->forget('tahun');

                $request->session()->forget('idpegawai');
                $request->session()->forget('month');
                $request->session()->forget('year');

            }
        }
        elseif(($role == 3 && $row->jabatan == "Direksi") || $role == 7)
        {
            $tp = $request->query('tp',1);
            if($request->id_karyawan)
            {
                // Filter Data Cuti
                $tp = $request->query('tp',1);
                $idkaryawan = $request->id_karyawan;
                $bulan = $request->query('bulan', Carbon::now()->format('m'));
                $tahun = $request->query('tahun', Carbon::now()->format('Y'));

                // simpan session
                $request->session()->put('idkaryawan', $request->id_karyawan);
                $request->session()->put('bulan', $bulan);
                $request->session()->put('tahun', $tahun);

                if (isset($idkaryawan) && isset($bulan) && isset($tahun))
                {
                    $tp = $request->query('tp',1);
                    $cutistaff = DB::table('cuti')
                        ->leftjoin('jeniscuti','cuti.id_jeniscuti','jeniscuti.id')
                        ->leftjoin('karyawan','cuti.id_karyawan','karyawan.id')
                        ->leftjoin('alokasicuti','cuti.id_alokasi','alokasicuti.id')
                        ->leftjoin('settingalokasi','cuti.id_settingalokasi','settingalokasi.id')
                        ->leftjoin('statuses','cuti.status','=','statuses.id')
                        ->leftjoin('datareject','datareject.id_cuti','=','cuti.id')
                        ->leftjoin('departemen','cuti.departemen','=','departemen.id')
                        ->where(function($query) {
                            $query->where('karyawan.atasan_pertama',Auth::user()->id_pegawai)
                            ->orWhere(function($query) {
                                $query->where('karyawan.atasan_kedua',Auth::user()->id_pegawai);
                            });
                        })
                        ->where('karyawan.partner',Auth::user()->partner)
                        ->where('cuti.id_karyawan', $idkaryawan)
                        ->whereMonth('cuti.tgl_mulai', $bulan)
                        ->whereYear('cuti.tgl_mulai', $tahun)
                        ->select('cuti.*', 'jeniscuti.jenis_cuti', 'karyawan.nama','karyawan.atasan_pertama','karyawan.atasan_kedua','statuses.name_status','datareject.alasan','departemen.nama_departemen')
                        ->distinct()
                        ->orderBy('cuti.id', 'desc')
                        ->get();
                    $izinstaff = DB::table('izin')
                        ->leftjoin('karyawan','izin.id_karyawan','karyawan.id')
                        ->leftjoin('jenisizin','izin.id_jenisizin','jenisizin.id')
                        ->leftjoin('statuses','izin.status','=','statuses.id')
                        ->leftjoin('datareject','datareject.id_izin','=','izin.id')
                        ->leftjoin('departemen','izin.departemen','=','departemen.id')
                        ->where(function($query) {
                            $query->where('karyawan.atasan_pertama',Auth::user()->id_pegawai)
                            ->orWhere(function($query) {
                                $query->where('karyawan.atasan_kedua',Auth::user()->id_pegawai);
                            });
                        })
                        ->where('karyawan.partner',Auth::user()->partner)
                        ->select('izin.*','karyawan.nama','karyawan.atasan_pertama','karyawan.atasan_kedua','jenisizin.jenis_izin','statuses.name_status','datareject.alasan as alasan_izin','departemen.nama_departemen')
                        ->distinct()
                        ->get();
                    return view('direktur.staff.index', compact('cutistaff','row','tp','izinstaff'));
                }
                else
                {
                        $tp = $request->query('tp',1);
                        $izinstaff = DB::table('izin')
                            ->leftjoin('karyawan','izin.id_karyawan','karyawan.id')
                            ->leftjoin('jenisizin','izin.id_jenisizin','jenisizin.id')
                            ->leftjoin('statuses','izin.status','=','statuses.id')
                            ->leftjoin('datareject','datareject.id_izin','=','izin.id')
                            ->leftjoin('departemen','izin.departemen','=','departemen.id')
                            ->where(function($query) {
                                $query->where('karyawan.atasan_pertama',Auth::user()->id_pegawai)
                                ->orWhere(function($query) {
                                    $query->where('karyawan.atasan_kedua',Auth::user()->id_pegawai);
                                });
                            })
                            ->where('karyawan.partner',Auth::user()->partner)
                            ->select('izin.*','karyawan.nama','karyawan.atasan_pertama','karyawan.atasan_kedua','jenisizin.jenis_izin','statuses.name_status','datareject.alasan as alasan_izin','departemen.nama_departemen')
                            ->distinct()
                            ->get();

                        $cutistaff = DB::table('cuti')
                            ->leftjoin('jeniscuti','cuti.id_jeniscuti','jeniscuti.id')
                            ->leftjoin('karyawan','cuti.id_karyawan','karyawan.id')
                            ->leftjoin('alokasicuti','cuti.id_alokasi','alokasicuti.id')
                            ->leftjoin('settingalokasi','cuti.id_settingalokasi','settingalokasi.id')
                            ->leftjoin('statuses','cuti.status','=','statuses.id')
                            ->leftjoin('datareject','datareject.id_cuti','=','cuti.id')
                            ->leftjoin('departemen','cuti.departemen','=','departemen.id')
                            ->where(function($query) {
                                $query->where('karyawan.atasan_pertama',Auth::user()->id_pegawai)
                                ->orWhere(function($query) {
                                    $query->where('karyawan.atasan_kedua',Auth::user()->id_pegawai);
                                });
                            })
                            ->where('karyawan.partner',Auth::user()->partner)
                            ->select('cuti.*', 'jeniscuti.jenis_cuti', 'karyawan.nama','karyawan.atasan_pertama','karyawan.atasan_kedua','statuses.name_status','datareject.alasan','departemen.nama_departemen')
                            ->distinct()
                            ->orderBy('cuti.id', 'desc')
                            ->get();
                        return view('direktur.staff.index', compact('cutistaff','row','tp','izinstaff'));
                }

                //menghapus filter data
                $request->session()->forget('id_karyawan');
                $request->session()->forget('bulan');
                $request->session()->forget('tahun');
            }
            else{
                // Filter Data Izin
                $idpegawai = $request->idpegawai;
                $month = $request->query('month', Carbon::now()->format('m'));
                $year = $request->query('year', Carbon::now()->format('Y'));

                // simpan session
                $request->session()->put('idpegawai', $idpegawai);
                $request->session()->put('month', $month);
                $request->session()->put('year', $year);

                if(isset($idpegawai) && isset($month) && isset($year))
                {
                    $tp = $request->query('tp',2);
                    $izinstaff = DB::table('izin')
                        ->leftjoin('karyawan','izin.id_karyawan','karyawan.id')
                        ->leftjoin('jenisizin','izin.id_jenisizin','jenisizin.id')
                        ->leftjoin('statuses','izin.status','=','statuses.id')
                        ->leftjoin('datareject','datareject.id_izin','=','izin.id')
                        ->leftjoin('departemen','izin.departemen','=','departemen.id')
                        ->where(function($query) {
                            $query->where('karyawan.atasan_pertama',Auth::user()->id_pegawai)
                            ->orWhere(function($query) {
                                $query->where('karyawan.atasan_kedua',Auth::user()->id_pegawai);
                            });
                        })
                        ->where('karyawan.partner',Auth::user()->partner)
                        ->where('izin.id_karyawan', $idpegawai)
                        ->whereMonth('izin.tgl_mulai', $month)
                        ->whereYear('izin.tgl_mulai', $year)
                        ->select('izin.*','karyawan.nama','karyawan.atasan_pertama','karyawan.atasan_kedua','jenisizin.jenis_izin','statuses.name_status','datareject.alasan as alasan_izin','departemen.nama_departemen')
                        ->distinct()
                        ->get();

                    $cutistaff = DB::table('cuti')
                        ->leftjoin('jeniscuti','cuti.id_jeniscuti','jeniscuti.id')
                        ->leftjoin('karyawan','cuti.id_karyawan','karyawan.id')
                        ->leftjoin('alokasicuti','cuti.id_alokasi','alokasicuti.id')
                        ->leftjoin('settingalokasi','cuti.id_settingalokasi','settingalokasi.id')
                        ->leftjoin('statuses','cuti.status','=','statuses.id')
                        ->leftjoin('datareject','datareject.id_cuti','=','cuti.id')
                        ->leftjoin('departemen','cuti.departemen','=','departemen.id')
                        ->where(function($query) {
                            $query->where('karyawan.atasan_pertama',Auth::user()->id_pegawai)
                            ->orWhere(function($query) {
                                $query->where('karyawan.atasan_kedua',Auth::user()->id_pegawai);
                            });
                        })
                        ->where('karyawan.partner',Auth::user()->partner)
                        ->select('cuti.*', 'jeniscuti.jenis_cuti', 'karyawan.nama','karyawan.atasan_pertama','karyawan.atasan_kedua','statuses.name_status','datareject.alasan','departemen.nama_departemen')
                        ->distinct()
                        ->orderBy('cuti.id', 'desc')
                        ->get();
                    return view('direktur.staff.index', compact('cutistaff','row','tp','izinstaff'));
                }
                else
                {
                    $izinstaff = DB::table('izin')
                        ->leftjoin('karyawan','izin.id_karyawan','karyawan.id')
                        ->leftjoin('jenisizin','izin.id_jenisizin','jenisizin.id')
                        ->leftjoin('statuses','izin.status','=','statuses.id')
                        ->leftjoin('datareject','datareject.id_izin','=','izin.id')
                        ->leftjoin('departemen','izin.departemen','=','departemen.id')
                        ->where(function($query) {
                            $query->where('karyawan.atasan_pertama',Auth::user()->id_pegawai)
                            ->orWhere(function($query) {
                                $query->where('karyawan.atasan_kedua',Auth::user()->id_pegawai);
                            });
                        })
                        ->where('karyawan.partner',Auth::user()->partner)
                        ->select('izin.*','karyawan.nama','karyawan.atasan_pertama','karyawan.atasan_kedua','jenisizin.jenis_izin','statuses.name_status','datareject.alasan as alasan_izin','departemen.nama_departemen')
                        ->distinct()
                        ->get();

                    $cutistaff = DB::table('cuti')
                        ->leftjoin('jeniscuti','cuti.id_jeniscuti','jeniscuti.id')
                        ->leftjoin('karyawan','cuti.id_karyawan','karyawan.id')
                        ->leftjoin('alokasicuti','cuti.id_alokasi','alokasicuti.id')
                        ->leftjoin('settingalokasi','cuti.id_settingalokasi','settingalokasi.id')
                        ->leftjoin('statuses','cuti.status','=','statuses.id')
                        ->leftjoin('datareject','datareject.id_cuti','=','cuti.id')
                        ->leftjoin('departemen','cuti.departemen','=','departemen.id')
                        ->where(function($query) {
                            $query->where('karyawan.atasan_pertama',Auth::user()->id_pegawai)
                            ->orWhere(function($query) {
                                $query->where('karyawan.atasan_kedua',Auth::user()->id_pegawai);
                            });
                        })
                        ->where('karyawan.partner',Auth::user()->partner)
                        ->select('cuti.*', 'jeniscuti.jenis_cuti', 'karyawan.nama','karyawan.atasan_pertama','karyawan.atasan_kedua','statuses.name_status','datareject.alasan','departemen.nama_departemen')
                        ->distinct()
                        ->orderBy('cuti.id', 'desc')
                        ->get();
                    return view('direktur.staff.index', compact('cutistaff','row','tp','izinstaff'));
                }

                //menghapus filter data
                $request->session()->forget('idpegawai');
                $request->session()->forget('month');
                $request->session()->forget('year');
            }
        }
        elseif($role == 3 && $row->jabatan == "Asistant Manager")
        {
            $tp = $request->query('tp',1);
            // Filter Data Cuti
            $idkaryawan = $request->id_karyawan;
            $bulan = $request->query('bulan', Carbon::now()->format('m'));
            $tahun = $request->query('tahun', Carbon::now()->format('Y'));

            // simpan session
            $request->session()->put('idkaryawan', $request->id_karyawan);
            $request->session()->put('bulan', $bulan);
            $request->session()->put('tahun', $tahun);

            if($request->id_karyawan)
            {
                $tp = $request->query('tp',1);
                if ($idkaryawan !== "Semua" && isset($idkaryawan) && isset($bulan) && isset($tahun))
                {
                    $tp = $request->query('tp',1);
                    $cutistaff = DB::table('cuti')
                        ->leftjoin('jeniscuti','cuti.id_jeniscuti','jeniscuti.id')
                        ->leftjoin('karyawan','cuti.id_karyawan','karyawan.id')
                        ->leftjoin('statuses','cuti.status','=','statuses.id')
                        ->leftjoin('departemen','cuti.departemen','=','departemen.id')
                        ->leftjoin('datareject','datareject.id_cuti','=','cuti.id')
                        ->where('karyawan.atasan_pertama',Auth::user()->id_pegawai)
                        ->where('cuti.id_karyawan', $idkaryawan)
                        ->whereMonth('cuti.tgl_mulai', $bulan)
                        ->whereYear('cuti.tgl_mulai', $tahun)
                        ->where('karyawan.partner',Auth::user()->partner)
                        ->select('cuti.*', 'jeniscuti.jenis_cuti', 'karyawan.nama','karyawan.atasan_pertama','datareject.alasan','karyawan.atasan_kedua','statuses.name_status','departemen.nama_departemen')
                        ->distinct()
                        ->orderBy('cuti.id', 'desc')
                        ->get();
                    $izinstaff = DB::table('izin')
                        ->leftjoin('karyawan','izin.id_karyawan','karyawan.id')
                        ->leftjoin('jenisizin','izin.id_jenisizin','jenisizin.id')
                        ->leftjoin('statuses','izin.status','=','statuses.id')
                        ->leftjoin('departemen','izin.departemen','=','departemen.id')
                        ->leftjoin('datareject','datareject.id_izin','=','izin.id')
                        ->where('karyawan.atasan_pertama',Auth::user()->id_pegawai)
                        ->where('karyawan.partner',Auth::user()->partner)
                        ->select('izin.*','karyawan.nama','jenisizin.jenis_izin','statuses.name_status','karyawan.atasan_pertama','karyawan.atasan_kedua','datareject.alasan','departemen.nama_departemen')
                        ->distinct()
                        ->get();
                    return view('manager.staff.cutiStaff', compact('cutistaff','row','tp','izinstaff','karyawan'));
                }
                elseif($idkaryawan == "Semua" && isset($bulan) && isset($tahun))
                {
                    $tp = $request->query('tp',1);
                    $cutistaff = DB::table('cuti')
                        ->leftjoin('jeniscuti','cuti.id_jeniscuti','jeniscuti.id')
                        ->leftjoin('karyawan','cuti.id_karyawan','karyawan.id')
                        ->leftjoin('statuses','cuti.status','=','statuses.id')
                        ->leftjoin('departemen','cuti.departemen','=','departemen.id')
                        ->leftjoin('datareject','datareject.id_cuti','=','cuti.id')
                        ->where('karyawan.atasan_pertama',Auth::user()->id_pegawai)
                        ->whereMonth('cuti.tgl_mulai', $bulan)
                        ->whereYear('cuti.tgl_mulai', $tahun)
                        ->where('karyawan.partner',Auth::user()->partner)
                        ->where('karyawan.divisi',$row->divisi)
                        ->select('cuti.*', 'jeniscuti.jenis_cuti', 'karyawan.nama','karyawan.atasan_pertama','datareject.alasan','karyawan.atasan_kedua','statuses.name_status','departemen.nama_departemen')
                        ->distinct()
                        ->orderBy('cuti.id', 'desc')
                        ->get();

                    $izinstaff = DB::table('izin')
                        ->leftjoin('karyawan','izin.id_karyawan','karyawan.id')
                        ->leftjoin('jenisizin','izin.id_jenisizin','jenisizin.id')
                        ->leftjoin('statuses','izin.status','=','statuses.id')
                        ->leftjoin('departemen','izin.departemen','=','departemen.id')
                        ->leftjoin('datareject','datareject.id_izin','=','izin.id')
                        ->where('karyawan.atasan_pertama',Auth::user()->id_pegawai)
                        ->where('karyawan.partner',Auth::user()->partner)
                        ->select('izin.*','karyawan.nama','jenisizin.jenis_izin','statuses.name_status','karyawan.atasan_pertama','karyawan.atasan_kedua','datareject.alasan','departemen.nama_departemen')
                        ->distinct()
                        ->get();

                    return view('manager.staff.cutiStaff', compact('cutistaff','row','tp','izinstaff','karyawan'));
                }
                else
                {
                    $tp = $request->query('tp',1);
                    $cutistaff = DB::table('cuti')
                        ->leftjoin('jeniscuti','cuti.id_jeniscuti','jeniscuti.id')
                        ->leftjoin('karyawan','cuti.id_karyawan','karyawan.id')
                        ->leftjoin('statuses','cuti.status','=','statuses.id')
                        ->leftjoin('departemen','cuti.departemen','=','departemen.id')
                        ->leftjoin('datareject','datareject.id_cuti','=','cuti.id')
                        ->where('karyawan.atasan_pertama',Auth::user()->id_pegawai)
                        ->where('karyawan.partner',Auth::user()->partner)
                        ->where('karyawan.divisi',$row->divisi)
                        ->select('cuti.*', 'jeniscuti.jenis_cuti', 'karyawan.nama','karyawan.atasan_pertama','karyawan.atasan_kedua','datareject.alasan','statuses.name_status','departemen.nama_departemen')
                        ->distinct()
                        ->orderBy('cuti.id', 'desc')
                        ->get();
                    $izinstaff = DB::table('izin')
                        ->leftjoin('karyawan','izin.id_karyawan','karyawan.id')
                        ->leftjoin('jenisizin','izin.id_jenisizin','jenisizin.id')
                        ->leftjoin('statuses','izin.status','=','statuses.id')
                        ->leftjoin('departemen','izin.departemen','=','departemen.id')
                        ->leftjoin('datareject','datareject.id_izin','=','izin.id')
                        ->where('karyawan.atasan_pertama',Auth::user()->id_pegawai)
                        ->where('karyawan.partner',Auth::user()->partner)
                        ->select('izin.*','karyawan.nama','jenisizin.jenis_izin','statuses.name_status','karyawan.atasan_pertama','karyawan.atasan_kedua','departemen.nama_departemen','datareject.alasan',)
                        ->distinct()
                        ->get();
                    return view('manager.staff.cutiStaff', compact('cutistaff','row','tp','izinstaff','karyawan'));
                }
                //menghapus filter data
                $request->session()->forget('id_karyawan');
                $request->session()->forget('bulan');
                $request->session()->forget('tahun');
            }
            else
            {
                $tp = $request->query('tp',2);
                // Filter Data Izin
                $idpegawai = $request->idpegawai;
                $month = $request->query('month', Carbon::now()->format('m'));
                $year = $request->query('year', Carbon::now()->format('Y'));

                // simpan session
                $request->session()->put('idpegawai', $idpegawai);
                $request->session()->put('month', $month);
                $request->session()->put('year', $year);

                if($idpegawai !== "Semua" && isset($idpegawai) && isset($month) && isset($year))
                {
                    $tp = $request->query('tp',2);
                    $izinstaff = DB::table('izin')
                        ->leftjoin('karyawan','izin.id_karyawan','karyawan.id')
                        ->leftjoin('jenisizin','izin.id_jenisizin','jenisizin.id')
                        ->leftjoin('statuses','izin.status','=','statuses.id')
                        ->leftjoin('departemen','izin.departemen','=','departemen.id')
                        ->leftjoin('datareject','datareject.id_izin','=','izin.id')
                        ->where('karyawan.atasan_pertama',Auth::user()->id_pegawai)
                        ->whereMonth('izin.tgl_mulai', $month)
                        ->whereYear('izin.tgl_mulai', $year)
                        ->select('izin.*','karyawan.nama','jenisizin.jenis_izin','statuses.name_status','karyawan.atasan_pertama','karyawan.atasan_kedua','departemen.nama_departemen','datareject.alasan',)
                        ->distinct()
                        ->get();
                    $cutistaff = DB::table('cuti')
                        ->leftjoin('jeniscuti','cuti.id_jeniscuti','jeniscuti.id')
                        ->leftjoin('karyawan','cuti.id_karyawan','karyawan.id')
                        ->leftjoin('statuses','cuti.status','=','statuses.id')
                        ->leftjoin('departemen','cuti.departemen','=','departemen.id')
                        ->leftjoin('datareject','datareject.id_cuti','=','cuti.id')
                        ->where('karyawan.atasan_pertama',Auth::user()->id_pegawai)
                        ->select('cuti.*', 'jeniscuti.jenis_cuti', 'karyawan.nama','karyawan.atasan_pertama','karyawan.atasan_kedua','datareject.alasan','statuses.name_status','departemen.nama_departemen')
                        ->distinct()
                        ->orderBy('cuti.id', 'desc')
                        ->get();
                    return view('manager.staff.cutiStaff', compact('cutistaff','row','tp','izinstaff','karyawan'));

                }elseif($idpegawai == "Semua" && isset($month) && isset($year))
                {
                    $izinstaff = DB::table('izin')
                        ->leftjoin('karyawan','izin.id_karyawan','karyawan.id')
                        ->leftjoin('jenisizin','izin.id_jenisizin','jenisizin.id')
                        ->leftjoin('statuses','izin.status','=','statuses.id')
                        ->leftjoin('departemen','izin.departemen','=','departemen.id')
                        ->leftjoin('datareject','datareject.id_izin','=','izin.id')
                        ->where('karyawan.atasan_pertama',Auth::user()->id_pegawai)
                        ->where('karyawan.divisi', $row->divisi)
                        ->where('karyawan.partner',Auth::user()->partner)
                        ->whereMonth('izin.tgl_mulai', $month)
                        ->whereYear('izin.tgl_mulai', $year)
                        ->select('izin.*','karyawan.nama','jenisizin.jenis_izin','statuses.name_status','karyawan.atasan_pertama','karyawan.atasan_kedua','departemen.nama_departemen','datareject.alasan',)
                        ->distinct()
                        ->get();

                    $cutistaff = DB::table('cuti')
                        ->leftjoin('jeniscuti','cuti.id_jeniscuti','jeniscuti.id')
                        ->leftjoin('karyawan','cuti.id_karyawan','karyawan.id')
                        ->leftjoin('statuses','cuti.status','=','statuses.id')
                        ->leftjoin('departemen','cuti.departemen','=','departemen.id')
                        ->leftjoin('datareject','datareject.id_cuti','=','cuti.id')
                        ->where('karyawan.atasan_pertama',Auth::user()->id_pegawai)
                        ->select('cuti.*', 'jeniscuti.jenis_cuti', 'karyawan.nama','karyawan.atasan_pertama','karyawan.atasan_kedua','datareject.alasan','statuses.name_status','departemen.nama_departemen')
                        ->distinct()
                        ->orderBy('cuti.id', 'desc')
                        ->get();
                    $tp = $request->query('tp',2);
                     return view('manager.staff.cutiStaff', compact('cutistaff','row','tp','izinstaff','karyawan'));
                }
                else
                {
                    $cutistaff = DB::table('cuti')
                        ->leftjoin('jeniscuti','cuti.id_jeniscuti','jeniscuti.id')
                        ->leftjoin('karyawan','cuti.id_karyawan','karyawan.id')
                        ->leftjoin('statuses','cuti.status','=','statuses.id')
                        ->leftjoin('departemen','cuti.departemen','=','departemen.id')
                        ->leftjoin('datareject','datareject.id_cuti','=','cuti.id')
                        ->where('karyawan.atasan_pertama',Auth::user()->id_pegawai)
                        ->where('karyawan.partner',Auth::user()->partner)
                        ->select('cuti.*', 'jeniscuti.jenis_cuti', 'karyawan.nama','karyawan.atasan_pertama','karyawan.atasan_kedua','datareject.alasan','statuses.name_status','departemen.nama_departemen')
                        ->distinct()
                        ->orderBy('cuti.id', 'desc')
                        ->get();

                    $izinstaff = DB::table('izin')
                        ->leftjoin('karyawan','izin.id_karyawan','karyawan.id')
                        ->leftjoin('jenisizin','izin.id_jenisizin','jenisizin.id')
                        ->leftjoin('statuses','izin.status','=','statuses.id')
                        ->leftjoin('departemen','izin.departemen','=','departemen.id')
                        ->leftjoin('datareject','datareject.id_izin','=','izin.id')
                        ->where('karyawan.atasan_pertama',Auth::user()->id_pegawai)
                        ->where('karyawan.partner',Auth::user()->partner)
                        ->where('karyawan.divisi', $row->divisi)
                        ->select('izin.*','karyawan.nama','jenisizin.jenis_izin','karyawan.atasan_pertama','karyawan.atasan_kedua','statuses.name_status','departemen.nama_departemen','datareject.alasan',)
                        ->distinct()
                        ->get();
                    return view('manager.staff.cutiStaff', compact('cutistaff','row','tp','izinstaff','karyawan'));
                }

            }

            //menghapus filter data
            $request->session()->forget('idpegawai');
            $request->session()->forget('month');
            $request->session()->forget('year');

        }
        else{
            return redirect()->back()->with('error','Anda tidak memiliki hak akses');
        }
    }

    public function cutiapproved(Request $request, $id)
    {
        $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
        $role = Auth::user()->role;
        // dd($row->jabatan);
        $cuti = Cuti::where('id',$id)->first();
        // return $cuti;
        $year = Carbon::now()->subYear()->year;

        // $cekSisacuti = Sisacuti::leftJoin('cuti', 'cuti.id_jeniscuti', 'sisacuti.jenis_cuti')
        //   ->select('cuti.id as id_cuti','cuti.jml_cuti','cuti.tgl_mulai', 'cuti.tgl_selesai','sisacuti.*')
        //     ->where('cuti.id',$cuti->id)
        //     ->where('sisacuti.id_pegawai',$cuti->id_karyawan)
        //     ->first();
        $cekSisacuti = Sisacuti::join('cuti', 'cuti.id_jeniscuti', 'sisacuti.jenis_cuti')
            ->join('alokasicuti', 'sisacuti.id_alokasi', 'alokasicuti.id')
            ->where('cuti.id',$cuti->id)
            ->where('cuti.id_alokasi',$cuti->id_alokasi)
            ->where('sisacuti.id_alokasi',$cuti->id_alokasi)
            ->where('sisacuti.id_pegawai',$cuti->id_karyawan)
            ->exists();
        // return $cekSisacuti;
        // dd($cekSisacuti);
        // return $cekSisacuti;
        if ($cekSisacuti)
        {
            // dd($row->jabatan);
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

                    // $alokasicuti = Alokasicuti::where('id', $cuti->id_alokasi)
                    //     ->where('id_karyawan', $cuti->id_karyawan)
                    //     ->where('id_jeniscuti', $cuti->id_jeniscuti)
                    //     ->where('id_settingalokasi', $cuti->id_settingalokasi)
                    //     ->first();

                    // Alokasicuti::where('id', $alokasicuti->id)
                    // ->update(
                    //     ['durasi' => $jml_cuti]
                    // );

                    //KIRIM NOTIFIKASI EMAIL KE KARYAWAN DAN ATASAN 2

                    //ambil data karyawan
                    $emailkry = DB::table('cuti')->join('karyawan','cuti.id_karyawan','=','karyawan.id')
                        ->join('departemen','cuti.departemen','=','departemen.id')
                        ->where('cuti.id_karyawan','=',$datacuti->id_karyawan)
                        ->select('karyawan.email','karyawan.nama as nama','karyawan.atasan_kedua','departemen.nama_departemen')
                        ->first();

                    $atasan = Karyawan::where('id',$emailkry->atasan_kedua)
                        ->select('email as email','nama as nama','nama_jabatan as jabatan')
                        ->first();

                    //atasan pertama
                    $atasan1 = Auth::user()->email;

                    //ambil data karyawan
                    $tujuan = $atasan->email;
                    $data = [
                        'subject'     =>'Notifikasi Approval Pertama Permohonan ' . $jeniscuti->jenis_cuti . ' #' . $cuti->id . ' ' . $emailkry->nama,
                        'noregistrasi'=>$cuti->id,
                        'title' =>  'NOTIFIKASI PERSETUJUAN PERTAMA FORMULIR CUTI KARYAWAN',
                        'subtitle' => '[PERSETUJUAN ATASAN]',
                        'tgl_permohonan' =>Carbon::parse($cuti->tgl_permohonan)->format("d/m/Y"),
                        'nik'         => $cuti->nik,
                        'jabatankaryawan' => $cuti->jabatan,
                        'departemen' => $emailkry->nama_departemen,
                        'atasan2'     => $atasan->email,
                        'namaatasan2' => $atasan->nama,
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
                    Mail::to($tujuan)->send(new CutiAtasan2Notification($data));
                    return redirect()->back()->withInput()->with('success', 'Permintaan ' . $jeniscuti->jenis_cuti . ' dari ' . ucwords(strtolower($emailkry->nama)) . ' disetujui');
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
                        ->select('karyawan.email','karyawan.partner','departemen.nama_departemen','karyawan.nama as nama','karyawan.atasan_pertama','karyawan.atasan_kedua')
                        ->first();

                    $atasan1 = Karyawan::where('id',$emailkry->atasan_pertama)
                        ->select('email as email','nama as nama','nama_jabatan as jabatan','divisi as departemen')
                        ->first();

                    //atasan yang login
                    $atasan2 = Auth::user()->email;

                    // $tujuan = 'akhiratunnisahasanah0917@gmail.com';
                    $partner = $emailkry->partner;
                    $hrdmanager = User::where('partner',$partner)->where('role',1)->first();
                    if($hrdmanager !== null){
                        $hrdmng = Karyawan::where('id',$hrdmanager->id_pegawai)->first();
                        $hrdmng = $hrdmng->email;
                    }

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
                        'atasan2'     =>$atasan2,
                        'namaatasan1' =>$atasan1->nama,
                        'namaatasan2' =>Auth::user()->name,
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

                    if($hrdmng !== null)
                    {
                        $data['hrdmanager'] = $hrdmng;
                    }

                    $hrdstaff   = User::where('partner',$partner)->where('role',2)->first();
                    $data['hrdstaff'] = null;
                    if($hrdstaff !== null){
                        $hrdstf = Karyawan::where('id',$hrdstaff->id_pegawai)->first();
                        $hrdstf = $hrdstf->email;

                        if($hrdstf !== null)
                        {
                            $data['hrdstaff'] = $hrdstf;
                        }
                    }

                    Mail::to($tujuan)->send(new CutiApproveNotification($data));
                    // dd($data);
                    return redirect()->back()->withInput()->with('success', 'Permintaan ' . $jeniscuti->jenis_cuti . ' dari ' . ucwords(strtolower($emailkry->nama)) . ' disetujui');

                }
                else{
                    return redirect()->back()->with('error','Anda tidak memiliki hak akses');
                }

            }
            elseif($role == 3 && $row->jabatan == "Asistant Manager")
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
                            'tgldisetujui_a' => Carbon::now()->format('Y-m-d H:i:s'),
                        ]);
                        $cuti = Cuti::where('id',$id)->first();
                        $jeniscuti = Jeniscuti::where('id',$cuti->id_jeniscuti)->first();

                        //email karyawan
                        $emailkry = DB::table('cuti')->join('karyawan','cuti.id_karyawan','=','karyawan.id')
                            ->join('departemen','cuti.departemen','=','departemen.id')
                            ->where('cuti.id_karyawan','=',$dacuti->id_karyawan)
                            ->select('karyawan.email','karyawan.nama','karyawan.atasan_kedua','departemen.nama_departemen')
                            ->first();

                        $atasan2 = Karyawan::where('id', $emailkry->atasan_kedua)
                            ->select('email as email','nama as nama','nama_jabatan as jabatan')
                            ->first();

                        $tujuan = $atasan2->email;
                        $data = [
                            'subject'     =>'Notifikasi Approval Pertama Permohonan ' . $jeniscuti->jenis_cuti . ' #' . $cuti->id . ' ' . $emailkry->nama,
                            'noregistrasi'=>$cuti->id,
                            'title' =>  'NOTIFIKASI PERSETUJUAN PERTAMA FORMULIR CUTI KARYAWAN',
                            'subtitle' => '[PERSETUJUAN ATASAN]',
                            'tgl_permohonan' =>Carbon::parse($cuti->tgl_permohonan)->format("d/m/Y"),
                            'nik'         => $cuti->nik,
                            'jabatankaryawan' => $cuti->jabatan,
                            'departemen' => $emailkry->nama_departemen,
                            'atasan2'     => $atasan2->email,
                            'namaatasan2' => $atasan2->nama,
                            'jeniscuti'   => $jeniscuti->jenis_cuti,
                            'karyawan_email' =>$emailkry->email,
                            'namakaryawan'=>ucwords(strtolower($emailkry->nama)),
                            'id_jeniscuti'=>$cuti->jeniscutis->jenis_cuti,
                            'keperluan'   =>$cuti->keperluan,
                            'tgl_mulai'   =>Carbon::parse($cuti->tgl_mulai)->format("d/m/Y"),
                            'tgl_selesai' =>Carbon::parse($cuti->tgl_selesai)->format("d/m/Y"),
                            'tgldisetujuiatasan' =>Carbon::parse($cuti->tgldisetujui_a)->format("d/m/Y H:i"),
                            'jml_cuti'    =>$cuti->jml_cuti,
                            'status'      =>$status->name_status,
                            'jabatanatasan' => $atasan2->jabatan
                        ];
                        Mail::to($tujuan)->send(new CutiAtasan2Notification($data));
                        return redirect()->back()->withInput()->with('success', 'Permintaan ' . $jeniscuti->jenis_cuti . ' dari ' . ucwords(strtolower($emailkry->nama)) . ' disetujui');
                    }else{
                        return redirect()->back()->with('error','Anda tidak memiliki hak akses');
                    }
            }
            elseif($role == 1 && $row->jabatan == "Asistant Manager")
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
                            'tgldisetujui_a' => Carbon::now()->format('Y-m-d H:i:s'),
                        ]);
                        $cuti = Cuti::where('id',$id)->first();
                        $jeniscuti = Jeniscuti::where('id',$cuti->id_jeniscuti)->first();

                        //email karyawan
                        $emailkry = DB::table('cuti')->join('karyawan','cuti.id_karyawan','=','karyawan.id')
                            ->join('departemen','cuti.departemen','=','departemen.id')
                            ->where('cuti.id_karyawan','=',$dacuti->id_karyawan)
                            ->select('karyawan.email','karyawan.nama','karyawan.atasan_kedua','departemen.nama_departemen')
                            ->first();

                        $atasan2 = Karyawan::where('id', $emailkry->atasan_kedua)
                            ->select('email as email','nama as nama','nama_jabatan as jabatan')
                            ->first();

                        $tujuan = $atasan2->email;
                        $data = [
                            'subject'     =>'Notifikasi Approval Pertama Permohonan ' . $jeniscuti->jenis_cuti . ' #' . $cuti->id . ' ' . $emailkry->nama,
                            'noregistrasi'=>$cuti->id,
                            'title' =>  'NOTIFIKASI PERSETUJUAN PERTAMA FORMULIR CUTI KARYAWAN',
                            'subtitle' => '[PERSETUJUAN ATASAN]',
                            'tgl_permohonan' =>Carbon::parse($cuti->tgl_permohonan)->format("d/m/Y"),
                            'nik'         => $cuti->nik,
                            'jabatankaryawan' => $cuti->jabatan,
                            'departemen' => $emailkry->nama_departemen,
                            'atasan2'     => $atasan2->email,
                            'namaatasan2' => $atasan2->nama,
                            'jeniscuti'   => $jeniscuti->jenis_cuti,
                            'karyawan_email' =>$emailkry->email,
                            'namakaryawan'=>ucwords(strtolower($emailkry->nama)),
                            'id_jeniscuti'=>$cuti->jeniscutis->jenis_cuti,
                            'keperluan'   =>$cuti->keperluan,
                            'tgl_mulai'   =>Carbon::parse($cuti->tgl_mulai)->format("d/m/Y"),
                            'tgl_selesai' =>Carbon::parse($cuti->tgl_selesai)->format("d/m/Y"),
                            'tgldisetujuiatasan' => Carbon::parse($cuti->tgldisetujui_a)->format("d/m/Y H:i"),
                            'jml_cuti'    =>$cuti->jml_cuti,
                            'status'      =>$status->name_status,
                            'jabatanatasan' => $atasan2->jabatan
                        ];
                        Mail::to($tujuan)->send(new CutiAtasan2Notification($data));
                        return redirect()->back()->withInput()->with('success', 'Permintaan ' . $jeniscuti->jenis_cuti . ' dari ' . ucwords(strtolower($emailkry->nama)) . ' disetujui');
                    }else{
                        return redirect()->back()->with('error','Anda tidak memiliki hak akses');
                    }
            }
            else{
                return redirect()->back()->with('error','Anda tidak memiliki hak akses');
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
            // dd($datacuti);
            if($datacuti && $row->jabatan == "Manager" && $role == 3)
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

                        $atasan = Karyawan::where('id', $emailkry->atasan_kedua)
                            ->select('email as email','nama as nama','nama_jabatan as jabatan')
                            ->first();

                        //ambil data karyawan
                        $tujuan = $atasan->email;
                        $data = [
                            'subject'     =>'Notifikasi Approval Pertama Permohonan ' . $jeniscuti->jenis_cuti . ' #' . $cuti->id . ' ' . $emailkry->nama,
                            'noregistrasi'=>$cuti->id,
                            'title' =>  'NOTIFIKASI PERSETUJUAN PERTAMA FORMULIR CUTI KARYAWAN',
                            'subtitle' => '[PERSETUJUAN ATASAN]',
                            'tgl_permohonan' =>Carbon::parse($cuti->tgl_permohonan)->format("d/m/Y"),
                            'nik'         => $cuti->nik,
                            'jabatankaryawan' => $cuti->jabatan,
                            'departemen' => $emailkry->nama_departemen,
                            'atasan2'     => $atasan->email,
                            'namaatasan2' => $atasan->nama,
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
                            'jabatanatasan' => $atasan->jabatan
                        ];
                        Mail::to($tujuan)->send(new CutiAtasan2Notification($data));
                        return redirect()->back()->withInput()->with('success', 'Permintaan ' . $jeniscuti->jenis_cuti . ' dari ' . ucwords(strtolower($emailkry->nama)) . ' disetujui');
                    }
                    elseif($datacuti && $datacuti->atasan_kedua == Auth::user()->id_pegawai)
                    {
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
                            ->select('karyawan.email','karyawan.partner','departemen.nama_departemen','karyawan.nama as nama','karyawan.atasan_pertama','karyawan.atasan_kedua')
                            ->first();
                        $atasan1 = Karyawan::where('id',$emailkry->atasan_pertama)
                            ->select('email as email','nama as nama','nama_jabatan as jabatan','divisi as departemen')
                            ->first();

                        //atasan yang login
                        $atasan2 = Auth::user()->email;

                        $partner = $emailkry->partner;
                        $hrdmanager = User::where('partner',$partner)->where('role',1)->first();
                        if($hrdmanager !== null){
                            $hrdmng = Karyawan::where('id',$hrdmanager->id_pegawai)->first();
                            $hrdmng = $hrdmng->email;
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
                            'atasan2'     =>$atasan2,
                            'namaatasan1' =>$atasan1->nama,
                            'namaatasan2' =>Auth::user()->name,
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

                        if($hrdmng !== null)
                        {
                            $data['hrdmanager'] = $hrdmng;
                        }

                        $hrdstaff   = User::where('partner',$partner)->where('role',2)->first();
                        $data['hrdstaff'] = null;
                        if($hrdstaff !== null){
                            $hrdstf = Karyawan::where('id',$hrdstaff->id_pegawai)->first();
                            $hrdstf = $hrdstf->email;
                            if($hrdstf !== null)
                            {
                                $data['hrdstaff'] = $hrdstf;
                            }
                        }

                        Mail::to($tujuan)->send(new CutiApproveNotification($data));
                        return redirect()->back()->withInput()->with('success', 'Permintaan ' . $jeniscuti->jenis_cuti . ' dari ' . ucwords(strtolower($emailkry->nama)) . ' disetujui');
                    }
                    else{
                        return redirect()->back()->with('error','Anda tidak memiliki hak akses');
                    }
            }
            elseif($datacuti && $role == 3 && $row->jabatan == "Asistant Manager")
            {
                if($datacuti->atasan_pertama == Auth::user()->id_pegawai)
                {
                    $status = Status::find(6);
                    Cuti::where('id',$id)->update([
                        'tgldisetujui_a' => Carbon::now()->format('Y-m-d H:i:s'),
                        'status' => $status->id,
                    ]);
                    $cuti = Cuti::where('id',$id)->first();
                    $jeniscuti = Jeniscuti::where('id',$cuti->id_jeniscuti)->first();

                    //email karyawan
                    $emailkry = DB::table('cuti')->join('karyawan','cuti.id_karyawan','=','karyawan.id')
                        ->join('departemen','cuti.departemen','=','departemen.id')
                        ->where('cuti.id_karyawan','=',$cuti->id_karyawan)
                        ->select('karyawan.email','karyawan.nama','karyawan.atasan_kedua','departemen.nama_departemen')
                        ->first();

                    $atasan2 = Karyawan::where('id',$emailkry->atasan_kedua)
                        ->select('email as email','nama as nama','nama_jabatan as jabatan')
                        ->first();

                    //ambil email atasan pertama
                    $atasan1 = Auth::user()->email;

                    $tujuan = $atasan2->email;

                    $data = [
                        'subject'     =>'Notifikasi Approval Pertama Permohonan ' . $jeniscuti->jenis_cuti . ' #' . $cuti->id . ' ' . $emailkry->nama,
                        'noregistrasi'=>$cuti->id,
                        'title' =>  'NOTIFIKASI PERSETUJUAN PERTAMA FORMULIR CUTI KARYAWAN',
                        'subtitle' => '[PERSETUJUAN ATASAN]',
                        'tgl_permohonan' =>Carbon::parse($cuti->tgl_permohonan)->format("d/m/Y"),
                        'nik'         => $cuti->nik,
                        'jabatankaryawan' => $cuti->jabatan,
                        'departemen' => $emailkry->nama_departemen,
                        'atasan2'     => $atasan2->email,
                        'namaatasan2' => $atasan2->nama,
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
                        'jabatanatasan' => $atasan2->jabatan
                    ];

                    Mail::to($tujuan)->send(new CutiAtasan2Notification($data));

                    return redirect()->back()->withInput()->with('success', 'Permintaan ' . $jeniscuti->jenis_cuti . ' dari ' . ucwords(strtolower($emailkry->nama)) . ' disetujui');
                }
                else{
                    return redirect()->back()->with('error','Anda tidak memiliki hak akses');
                }

            }else{
                return redirect()->back()->with('error','Anda tidak memiliki hak akses');
            }
        }
    }

    public function cutireject(Request $request, $id)
    {
        $cutis = Cuti::where('id',$id)->first();
        $datacuti = Cuti::leftjoin('karyawan','cuti.id_karyawan','=','karyawan.id')
            ->where('cuti.id', '=',$cutis->id)
            ->select('karyawan.atasan_pertama','karyawan.atasan_kedua')
            ->first();

        // dd($datacuti,$datacut);
        $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
        $role = Auth::user()->role;
        // return $row->jabatan;

        if($datacuti && $role == 3 && $row->jabatan == "Asistant Manager")
        {
            if($datacuti && $datacuti->atasan_pertama == Auth::user()->id_pegawai)
            {
                // return $datacuti;
                $status = Status::find(9);
                // return $status->name_status;
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
                    ->select('karyawan.email as email','karyawan.partner','karyawan.nama as nama','departemen.nama_departemen','karyawan.atasan_pertama','karyawan.atasan_kedua')
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

                $partner = $karyawan->partner;

                $hrdmanager = User::where('partner',$partner)->where('role',1)->first();
                if($hrdmanager !== null){
                    $hrdmng = Karyawan::where('id',$hrdmanager->id_pegawai)->first();
                    $hrdmng = $hrdmng->email;
                }

                $tujuan = $karyawan->email;
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
                    'tgldisetujuipimpinan' => '-',
                    'tglditolak' => Carbon::now()->format('d/m/Y H:i'),
                ];
                if($atasan2 !== NULL){
                    $data['atasan2'] = $atasan2->email;
                    $data['namaatasan2'] = $atasan2->nama;
                }
                // dd($data);
                if($hrdmng !== null)
                {
                    $data['hrdmanager'] = $hrdmng;
                }

                $hrdstaff   = User::where('partner',$partner)->where('role',2)->first();
                $data['hrdstaff'] = null;
                if($hrdstaff !== null){
                    $hrdstf = Karyawan::where('id',$hrdstaff->id_pegawai)->first();
                    $hrdstf = $hrdstf->email;
                    if($hrdstf !== null)
                    {
                        $data['hrdstaff'] = $hrdstf;
                    }
                }

                Mail::to($tujuan)->send(new CutiIzinTolakNotification($data));
                return redirect()->back()->with('success', 'Permintaan ' . $ct->jenis_cuti . ' dari ' . ucwords(strtolower($karyawan->nama)) . ' ditolak');
            }else{
                return redirect()->back()->with('error','Anda tidak memiliki hak akses');
            }
        }
        elseif($datacuti && $role == 1 && $row->jabatan == "Asistant Manager")
        {
            // if($datacuti && $datacuti->atasan_pertama == Auth::user()->id_pegawai)
            // {
                // return $datacuti;
                $status = Status::find(9);
                // return $status->name_status;
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
                    ->select('karyawan.email as email','karyawan.partner','karyawan.nama as nama','departemen.nama_departemen','karyawan.atasan_pertama','karyawan.atasan_kedua')
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

                $partner = $karyawan->partner;

                $hrdmanager = User::where('partner',$partner)->where('role',1)->first();
                if($hrdmanager !== null){
                    $hrdmng = Karyawan::where('id',$hrdmanager->id_pegawai)->first();
                    $hrdmng = $hrdmng->email;
                }


                $tujuan = $karyawan->email;
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
                    'tgldisetujuipimpinan' => '-',
                    'tglditolak' => Carbon::now()->format('d/m/Y H:i'),
                ];
                if($atasan2 !== NULL){
                    $data['atasan2'] = $atasan2->email;
                    $data['namaatasan2'] = $atasan2->nama;
                }

                if($hrdmng !== null)
                {
                    $data['hrdmanager'] = $hrdmng;
                }

                $hrdstaff   = User::where('partner',$partner)->where('role',2)->first();
                $data['hrdstaff'] = null;
                if($hrdstaff !== null){
                    $hrdstf = Karyawan::where('id',$hrdstaff->id_pegawai)->first();
                    $hrdstf = $hrdstf->email;
                    if($hrdstf !== null)
                    {
                        $data['hrdstaff'] = $hrdstf;
                    }
                }

                // dd($data);
                Mail::to($tujuan)->send(new CutiIzinTolakNotification($data));
                // return $data;
            // }else{
                return redirect()->back()->with('success', 'Permintaan ' . $ct->jenis_cuti . ' dari ' . ucwords(strtolower($karyawan->nama)) . ' ditolak');
            // }
        }
        else if($datacuti && $role == 3 && $row->jabatan == "Manager")
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
                    ->select('karyawan.email as email','karyawan.partner','karyawan.nama as nama','departemen.nama_departemen','karyawan.atasan_pertama','karyawan.atasan_kedua')
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

                $partner = $karyawan->partner;

                $hrdmanager = User::where('partner',$partner)->where('role',1)->first();
                if($hrdmanager !== null){
                    $hrdmng = Karyawan::where('id',$hrdmanager->id_pegawai)->first();
                    $hrdmng = $hrdmng->email;
                }

                $tujuan = $karyawan->email;
                $data = [
                    'subject'     => 'Notifikasi Permohonan Cuti Ditolak, Cuti ' . $ct->jenis_cuti . ' #' . $ct->id . ' ' . $karyawan->nama,
                    'noregistrasi'=>$cuti->id,
                    'title' =>  'NOTIFIKASI PERSETUJUAN FORMULIR CUTI KARYAWAN',
                    'subtitle' => '[PENDING PIMPINAN UNIT KERJA ]',
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
                if($hrdmng !== null)
                {
                    $data['hrdmanager'] = $hrdmng;
                }

                $hrdstaff   = User::where('partner',$partner)->where('role',2)->first();
                $data['hrdstaff'] = null;
                if($hrdstaff !== null){
                    $hrdstf = Karyawan::where('id',$hrdstaff->id_pegawai)->first();
                    $hrdstf = $hrdstf->email;
                    if($hrdstf !== null)
                    {
                        $data['hrdstaff'] = $hrdstf;
                    }
                }

                Mail::to($tujuan)->send(new CutiIzinTolakNotification($data));
                return redirect()->back()->with('success', 'Permintaan ' . $ct->jenis_cuti . ' dari ' . ucwords(strtolower($karyawan->nama)) . ' ditolak');
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
                    ->select('karyawan.email as email','karyawan.partner','karyawan.nama as nama','departemen.nama_departemen','karyawan.atasan_pertama','karyawan.atasan_kedua')
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

                $partner = $karyawan->partner;

                $hrdmanager = User::where('partner',$partner)->where('role',1)->first();
                if($hrdmanager !== null){
                    $hrdmng = Karyawan::where('id',$hrdmanager->id_pegawai)->first();
                    $hrdmng = $hrdmng->email;
                }

                $tujuan = $karyawan->email;
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

                if($hrdmng !== null)
                {
                    $data['hrdmanager'] = $hrdmng;
                }

                $hrdstaff   = User::where('partner',$partner)->where('role',2)->first();
                $data['hrdstaff'] = null;
                if($hrdstaff !== null){
                    $hrdstf = Karyawan::where('id',$hrdstaff->id_pegawai)->first();
                    $hrdstf = $hrdstf->email;
                    if($hrdstf !== null)
                    {
                        $data['hrdstaff'] = $hrdstf;
                    }
                }
                // return $data;
                Mail::to($tujuan)->send(new CutiIzinTolakNotification($data));
                return redirect()->back()->with('success', 'Permintaan ' . $ct->jenis_cuti . ' dari ' . ucwords(strtolower($karyawan->nama)) . ' ditolak');

            }
            else{
                return redirect()->back()->with('error','Anda tidak memiliki hak akses');
            }
        }
        else{
            return redirect()->back()->with('error','Anda tidak memiliki hak akses');
        }
    }

    public function izinApproved(Request $request, $id)
    {
        $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
        $role = Auth::user()->role;
        $izn = Izin::where('id',$id)->first();
        // return $izn;
        // $izin = Izin::leftJoin('karyawan', 'izin.id_karyawan', '=', 'karyawan.id')
        // ->where(function($query) use ($izn) {
        //     $query->where('izin.id_jenisizin', '=', $izn->id_jenisizin)
        //         ->where('izin.id_karyawan', '=', $izn->id_karyawan)
        //         ->where('izin.id', $izn->id);
        // })
        // ->where(function($query)  {
        //     $query->where('karyawan.atasan_pertama', '=', $row->id)
        //         ->orWhere('karyawan.atasan_kedua', '=', $row->id);
        // })
        // ->select('izin.*', 'karyawan.nama', 'karyawan.atasan_pertama', 'karyawan.atasan_kedua')
        // ->first();
        $izin = Izin::leftJoin('karyawan', 'izin.id_karyawan', '=', 'karyawan.id')
                ->where('izin.id_karyawan', '=', $izn->id_karyawan)
                ->where('karyawan.atasan_pertama', Auth::user()->id_pegawai)
                ->orWhere('karyawan.atasan_kedua',Auth::user()->id_pegawai)
                ->where('izin.id',$id)
                ->select('izin.*', 'karyawan.nama', 'karyawan.atasan_pertama', 'karyawan.atasan_kedua')
                ->first();

        // return $izin;
        if($row->jabatan == "Manager" && $role == 3)
        {
            if($izin && $izin->atasan_pertama == Auth::user()->id_pegawai)
            {
                // return Auth::user()->role;
                $status = Status::find(6);

                // return $status;
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
                Mail::to($tujuan)->send(new IzinAtasan2Notification($data));
                return redirect()->back()->withInput()->with('success','Permintaan ' . $jenisizin->jenis_izin . ' dari ' . ucwords(strtolower($emailkry->nama)) . ' disetujui');
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
                    ->select('karyawan.email','karyawan.partner','karyawan.nama','departemen.nama_departemen','karyawan.atasan_pertama','karyawan.atasan_kedua')
                    ->first();

                $atasan1 = Karyawan::where('id',$emailkry->atasan_pertama)
                    ->select('email as email','nama as nama','nama_jabatan as jabatan','divisi as departemen')
                    ->first();

                //atasan kedua yg login
                $atasan2 = Auth::user()->email;
                $tujuan = $emailkry->email;

                $partner = $emailkry->partner;
                $hrdmanager = User::where('partner',$partner)->where('role',1)->first();
                if($hrdmanager !== null){
                    $hrdmng = Karyawan::where('id',$hrdmanager->id_pegawai)->first();
                    $hrdmng = $hrdmng->email;
                }

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
                    'namaatasan2' =>$atasan1->nama,
                    'jabatanatasan'=>$atasan1->jabatan,
                ];
                // return $data;
                if($hrdmng !== null)
                {
                    $data['hrdmanager'] = $hrdmng;
                }

                $hrdstaff   = User::where('partner',$partner)->where('role',2)->first();
                $data['hrdstaff'] = null;
                if($hrdstaff !== null){
                    $hrdstf = Karyawan::where('id',$hrdstaff->id_pegawai)->first();
                    $hrdstf = $hrdstf->email;
                    if($hrdstf !== null)
                    {
                        $data['hrdstaff'] = $hrdstf;
                    }
                }

                Mail::to($tujuan)->send(new IzinApproveNotification($data));

                return redirect()->route('cuti_Staff',['tp'=>2])->with('success','Permintaan ' . $jenisizin->jenis_izin . ' dari ' . ucwords(strtolower($emailkry->nama)) . ' disetujui');
            }
            else{
                return redirect()->back()->with('error','Anda tidak memiliki hak akses');
            }
        }
        elseif($role == 3 && $row->jabatan == "Asistant Manager")
        {
            if($izin && $izin->atasan_pertama == Auth::user()->id_pegawai)
            {
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

                $atasan = Karyawan::where('id', $emailkry->atasan_kedua)
                    ->select('email as email','nama as nama','jabatan')
                    ->first();

                //atasan pertama
                $atasan1 = Auth::user()->email;
                $tujuan = $atasan->email;
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
                    'namaatasan2' =>$atasan->nama,
                    'jabatanatasan'=>$atasan->jabatan,
                ];
                Mail::to($tujuan)->send(new IzinAtasan2Notification($data));
                // return redirect()->back()->withInput();
                return redirect()->back()->withInput()->with('success','Permintaan ' . $jenisizin->jenis_izin . ' dari ' . ucwords(strtolower($emailkry->nama)) . ' disetujui');
            }
            else
            {
                return redirect()->back()->with('error','Anda tidak memiliki hak akses');
            }
        }
        elseif($role == 1 && $row->jabatan == "Asistant Manager")
        {
            if($izin && $izin->atasan_pertama == Auth::user()->id_pegawai)
            {
                // dd($izin->atasan_pertama, Auth::user()->id_pegawai);
                $status = Status::find(6);

                Izin::where('id',$id)->update([
                    'status' => $status->id,
                    'tgl_setuju_a' => Carbon::now()->format('Y-m-d H:i:s'),
                ]);

                $izinn = Izin::where('id',$id)->first();
                $jenisizin = Jenisizin::where('id',$izinn->id_jenisizin)->first();

                //KIRIM NOTIFIKASI EMAIL KE ATASAN 2 dan karyawan
                $emailkry = DB::table('izin')->join('karyawan','izin.id_karyawan','=','karyawan.id')
                    ->join('departemen','izin.departemen','=','departemen.id')
                    ->where('izin.id_karyawan','=',$izinn->id_karyawan)
                    ->select('karyawan.email','karyawan.nama','karyawan.atasan_pertama','karyawan.atasan_kedua','departemen.nama_departemen')
                    ->first();
                // return $emailkry;
                $atasan = Karyawan::where('id',$emailkry->atasan_kedua)
                    ->select('email as email','nama as nama','jabatan')
                    ->first();

                //atasan pertama
                $atasan1 = Auth::user()->email;
                $tujuan = $atasan->email;


                $data = [
                    'subject'     =>'Notifikasi Approval Pertama Permohonan Izin ' . $jenisizin->jenis_izin . ' #' . $izinn->id . ' ' . $emailkry->nama,
                    'noregistrasi'=>$izinn->id,
                    'title' =>  'NOTIFIKASI PERSETUJUAN FORMULIR KETIDAKHADIRAN KARYAWAN',
                    'subtitle' => '[PERSETUJUAN ATASAN]',
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
                    'tgldisetujuiatasan' =>Carbon::parse($izinn->tgl_setuju_a)->format('d/m/Y H:i'),
                    'jml_hari'    =>$izinn->jml_hari,
                    'jumlahjam'   =>$izinn->jml_jam,
                    'status'      =>$status->name_status,
                    'namakaryawan'=> $emailkry->nama,
                    'namaatasan2' =>$atasan->nama,
                    'jabatanatasan'=>$atasan->jabatan,
                ];
                // return $data;
                Mail::to($tujuan)->send(new IzinAtasan2Notification($data));
                // return $data;
                // return redirect()->back()->withInput();
                return redirect()->back()->withInput()->with('success','Permintaan ' . $jenisizin->jenis_izin . ' dari ' . ucwords(strtolower($emailkry->nama)) . ' disetujui');
            }
            else
            {
                return redirect()->back()->with('error','Anda tidak memiliki hak akses');
            }
        }
        else
        {
            return redirect()->back()->with('error','Anda tidak memiliki hak akses');
        }

    }

    public function izinReject(Request $request, $id)
    {

        $iz = Izin::where('id',$id)->first();
        $dataizin = Izin::leftjoin('karyawan','izin.id_karyawan','=','karyawan.id')
            ->where('izin.id', '=',$iz->id)
            ->select('karyawan.atasan_pertama','karyawan.atasan_kedua')
            ->first();
        $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
        $role = Auth::user()->role;

        if($dataizin && $row->jabatan == "Asistant Manager" && $role == 3)
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
                ->join('departemen','izin.departemen','=','departemen.id')
                ->join('karyawan','izin.id_karyawan','=','karyawan.id')
                ->where('izin.id',$izin->id)
                ->select('karyawan.email as email','karyawan.partner','departemen.nama_departemen','karyawan.nama as nama','karyawan.atasan_pertama','karyawan.atasan_kedua')
                ->first();
            $atasan2 = Karyawan::where('id',$karyawan->atasan_kedua)
                ->select('email as email','nama as nama','jabatan')
                ->first();
            $atasan1 = Karyawan::where('id',$karyawan->atasan_pertama)
                ->select('email as email','nama as nama','jabatan')
                ->first();

            $partner = $karyawan->partner;

            $hrdmanager = User::where('partner',$partner)->where('role',1)->first();
            if($hrdmanager !== null){
                $hrdmng = Karyawan::where('id',$hrdmanager->id_pegawai)->first();
                $hrdmng = $hrdmng->email;
            }

            $tujuan = $karyawan->email;
            $data = [
                'subject'  =>'Notifikasi Permohonan Izin Ditolak, Izin ' . $izin->jenis_izin . ' #' . $izin->id . ' ' . $karyawan->nama,
                'noregistrasi'=>$izin->id,
                'title' =>  'NOTIFIKASI PERSETUJUAN FORMULIR IZIN KARYAWAN',
                'subtitle' => '[ PENDING ATASAN ]',
                'tgl_permohonan' =>Carbon::parse($izin->tgl_permohonan)->format("d/m/Y"),
                'nik'         => $izin->nik,
                'jabatankaryawan' => $izin->jabatan,
                'departemen' => $karyawan->nama_departemen,
                'atasan1'     => $atasan1->email,
                'atasan2'     => $atasan2->email,
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
                'namaatasan2' =>$atasan2->nama,
                'nama'        =>$karyawan->nama,
                'kategori'   =>$izin->jenis_izin,
                'alasan'      =>$alasan->alasan,
                'tgldisetujuiatasan' => '-',
                'tgldisetujuipimpinan' => '-',
                'tglditolak' => Carbon::now()->format('d/m/Y H:i'),
            ];
            if($hrdmng !== null)
            {
                $data['hrdmanager'] = $hrdmng;
            }

            $hrdstaff   = User::where('partner',$partner)->where('role',2)->first();
            $data['hrdstaff'] = null;
            if($hrdstaff !== null){
                $hrdstf = Karyawan::where('id',$hrdstaff->id_pegawai)->first();
                $hrdstf = $hrdstf->email;
                if($hrdstf !== null)
                {
                    $data['hrdstaff'] = $hrdstf;
                }
            }

            Mail::to($tujuan)->send(new CutiIzinTolakNotification($data));
            return redirect()->back()->with('success', 'Permintaan ' . $izin->jenis_izin . ' dari ' . ucwords(strtolower($karyawan->nama)) . ' ditolak');
            // return redirect()->route('cuti_Staff',['type'=>2])->withInput();

        }
        elseif($dataizin && $role == 1 && $row->jabatan == "Asistant Manager")
        {
            $status = Status::find(9);
            Izin::where('id',$id)->update([
                'status' => $status->id,
                'tgl_ditolak' => Carbon::now()->format('Y-m-d H:i:s'),
            ]);
            $izz = Izin::where('id',$id)->first();
            // dd($izz);

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
                ->join('departemen','izin.departemen','=','departemen.id')
                ->join('karyawan','izin.id_karyawan','=','karyawan.id')
                ->where('izin.id',$izin->id)
                ->select('karyawan.email as email','karyawan.partner','departemen.nama_departemen','karyawan.nama as nama','karyawan.atasan_pertama','karyawan.atasan_kedua')
                ->first();
            $atasan2 = Karyawan::where('id',$karyawan->atasan_kedua)
                ->select('email as email','nama as nama','jabatan')
                ->first();
            $atasan1 = Karyawan::where('id',$karyawan->atasan_pertama)
                ->select('email as email','nama as nama','jabatan')
                ->first();

            $tujuan = $karyawan->email;
            $partner = $karyawan->partner;

            $hrdmanager = User::where('partner',$partner)->where('role',1)->first();
            if($hrdmanager !== null){
                $hrdmng = Karyawan::where('id',$hrdmanager->id_pegawai)->first();
                $hrdmng = $hrdmng->email;
            }


            $data = [
                'subject'  =>'Notifikasi Permohonan Izin Ditolak, Izin ' . $izin->jenis_izin . ' #' . $izin->id . ' ' . $karyawan->nama,
                'noregistrasi'=>$izin->id,
                'title' =>  'NOTIFIKASI PERSETUJUAN FORMULIR IZIN KARYAWAN',
                'subtitle' => '[ PENDING ATASAN ]',
                'tgl_permohonan' =>Carbon::parse($izin->tgl_permohonan)->format("d/m/Y"),
                'nik'         => $izin->nik,
                'jabatankaryawan' => $izin->jabatan,
                'departemen' => $karyawan->nama_departemen,
                'atasan1'     => $atasan1->email,
                'atasan2'     => $atasan2->email,
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
                'namaatasan2' =>$atasan2->nama,
                'nama'        =>$karyawan->nama,
                'kategori'   =>$izin->jenis_izin,
                'alasan'      =>$alasan->alasan,
                'tgldisetujuiatasan' => '-',
                'tgldisetujuipimpinan' => '-',
                'tglditolak' => Carbon::now()->format('d/m/Y H:i'),
            ];

            if($hrdmng !== null)
            {
                $data['hrdmanager'] = $hrdmng;
            }

            $hrdstaff   = User::where('partner',$partner)->where('role',2)->first();
            $data['hrdstaff'] = null;
            if($hrdstaff !== null){
                $hrdstf = Karyawan::where('id',$hrdstaff->id_pegawai)->first();
                $hrdstf = $hrdstf->email;
                if($hrdstf !== null)
                {
                    $data['hrdstaff'] = $hrdstf;
                }
            }
            Mail::to($tujuan)->send(new CutiIzinTolakNotification($data));
            return redirect()->back()->with('success', 'Permintaan ' . $izin->jenis_izin . ' dari ' . ucwords(strtolower($karyawan->nama)) . ' ditolak');
            // return redirect()->route('cuti_Staff',['type'=>2])->withInput();

        }
        elseif($dataizin && $role == 3 && $row->jabatan == "Manager")
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
                    ->select('karyawan.email as email','karyawan.partner','karyawan.nama as nama','departemen.nama_departemen','karyawan.atasan_pertama','karyawan.atasan_kedua')
                    ->first();
                $atasan2 = Karyawan::where('id',$karyawan->atasan_kedua)
                    ->select('email as email','nama as nama','jabatan')
                    ->first();
                $atasan1 = Karyawan::where('id',$karyawan->atasan_pertama)
                    ->select('email as email','nama as nama','jabatan')
                    ->first();

                $tujuan = $karyawan->email;

                $partner = $karyawan->partner;

                $hrdmanager = User::where('partner',$partner)->where('role',1)->first();
                if($hrdmanager !== null){
                    $hrdmng = Karyawan::where('id',$hrdmanager->id_pegawai)->first();
                    $hrdmng = $hrdmng->email;
                }

                $data = [
                    'subject'  =>'Notifikasi Permohonan Izin Ditolak, Izin ' . $izin->jenis_izin . ' #' . $izin->id . ' ' . $karyawan->nama,
                    'noregistrasi'=>$izin->id,
                    'tgl_permohonan' =>Carbon::parse($izin->tgl_permohonan)->format("d/m/Y"),
                    'title' =>  'NOTIFIKASI PERSETUJUAN FORMULIR IZIN KARYAWAN',
                    'subtitle' => '[ PENDING PIMPINAN UNIT KERJA ]',
                    'nik'         => $izin->nik,
                    'jabatankaryawan' => $izin->jabatan,
                    'departemen' => $karyawan->nama_departemen,
                    'atasan1'     => $atasan1->email,
                    'atasan2'     => $atasan2->email,
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
                    'namaatasan2' =>$atasan2->nama,
                    'nama'        =>$karyawan->nama,
                    'kategori'   =>$izin->jenis_izin,
                    'alasan'      =>$alasan->alasan,
                    'tgldisetujuiatasan' => Carbon::parse($izin->tgl_setuju_a)->format("d/m/Y H:i"),
                    'tgldisetujuipimpinan' => '-',
                    'tglditolak' => Carbon::parse($izin->tgl_ditolak)->format("d/m/Y H:i"),
                ];
                // dd($data);
                if($hrdmng !== null)
                {
                    $data['hrdmanager'] = $hrdmng;
                }

                $hrdstaff   = User::where('partner',$partner)->where('role',2)->first();
                $data['hrdstaff'] = null;
                if($hrdstaff !== null){
                    $hrdstf = Karyawan::where('id',$hrdstaff->id_pegawai)->first();
                    $hrdstf = $hrdstf->email;
                    if($hrdstf !== null)
                    {
                        $data['hrdstaff'] = $hrdstf;
                    }
                }


                Mail::to($tujuan)->send(new CutiIzinTolakNotification($data));
                return redirect()->back()->with('success', 'Permintaan ' . $izin->jenis_izin . ' dari ' . ucwords(strtolower($karyawan->nama)) . ' ditolak');

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
                    ->select('karyawan.email as email','karyawan.partner','departemen.nama_departemen','karyawan.nama as nama','karyawan.atasan_pertama','karyawan.atasan_kedua')
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

                $partner = $karyawan->partner;

                $hrdmanager = User::where('partner',$partner)->where('role',1)->first();
                if($hrdmanager !== null){
                    $hrdmng = Karyawan::where('id',$hrdmanager->id_pegawai)->first();
                    $hrdmng = $hrdmng->email;
                }

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

                if($hrdmng !== null)
                {
                    $data['hrdmanager'] = $hrdmng;
                }

                $hrdstaff   = User::where('partner',$partner)->where('role',2)->first();
                $data['hrdstaff'] = null;
                if($hrdstaff !== null){
                    $hrdstf = Karyawan::where('id',$hrdstaff->id_pegawai)->first();
                    $hrdstf = $hrdstf->email;
                    if($hrdstf !== null)
                    {
                        $data['hrdstaff'] = $hrdstf;
                    }
                }

                Mail::to($tujuan)->send(new CutiIzinTolakNotification($data));
                return redirect()->back()->with('success', 'Permintaan ' . $izin->jenis_izin . ' dari ' . ucwords(strtolower($karyawan->nama)) . ' ditolak');
                // return redirect()->route('cuti_Staff',['type'=>2])->withInput();

            }else{
                return redirect()->back()->with('error','Anda tidak memiliki hak akses');
            }


        }else{
            return redirect()->back()->with('error','Anda tidak memiliki hak akses');
        }
    }

    //EXPORT DATA absensi PEGAWAI DEPARTEMEN
    //export excel data by filter di bagian manager
    //DIGUNAKAN
    public function exportToExcel(Request $request)
    {
        $partner = Auth::user()->partner;
        $role = Auth::user()->role;
        $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
        //mengambil id_departemen user
        $middep = DB::table('karyawan')->where('id','=',Auth::user()->id_pegawai)
                ->select('divisi')->first();

        $idkaryawan = $request->id_karyawan;
        $bulan      = $request->query('bulan',Carbon::now()->format('m'));
        $tahun      = $request->query('tahun',Carbon::now()->format('Y'));

        // simpan session
        $idkaryawan = $request->session()->get('idkaryawan');
        $bulan      = $request->session()->get('bulan');
        $tahun      = $request->session()->get('tahun');

        $namaBulan = Carbon::createFromDate(null, $bulan, null)->locale('id')->monthName;

        // $bulan = $request->query('bulan', Carbon::now()->format('m'));
        // $tahun = $request->query('tahun', Carbon::now()->format('Y'));

        // Menentukan nama bulan berdasarkan nilai bulan yang diberikan

        if ($role == 3 && $row->jabatan == "Manager")
        {
            if($idkaryawan !== "Semua" && isset($idkaryawan) && isset($bulan) && isset($tahun))
            {
                $data = Absensi::with('karyawans','departemens')
                    ->where('id_karyawan', $idkaryawan)
                    ->whereMonth('tanggal', $bulan)
                    ->whereYear('tanggal',$tahun)
                    ->orderBy('tanggal','asc')
                    ->get();
                // dd($data);


                $departemen = Departemen::where('id',$middep->divisi)->first();

                if ($data->isEmpty())
                {
                    return redirect()->back()->with('error','Tidak Ada Data');
                } else {
                    $nbulan = \Carbon\Carbon::parse($data->first()->tanggal)->format('M Y');
                    return Excel::download(new AbsensiFilterExport($data,$idkaryawan,$middep), "Rekap Absensi Bulan ".$nbulan." ". ucwords(strtolower($data->first()->karyawans->nama)) ." Departemen ". ucwords(strtolower($departemen->nama_departemen)) .".xlsx");
                }

            }elseif($idkaryawan == "Semua" && isset($bulan) && isset($tahun))
            {
                $data = Absensi::with('karyawans','departemens')
                    ->where('id_departement',$middep->divisi)
                    ->where('partner', Auth::user()->partner)
                    ->whereMonth('tanggal', $bulan)
                    ->whereYear('tanggal',$tahun)
                    ->orderBy('id_karyawan','asc')
                    ->get();
                // dd($data);

                $departemen = Departemen::where('id',$middep->divisi)->first();

                if ($data->isEmpty())
                {
                    return redirect()->back()->with('error','Tidak Ada Data');
                } else {
                    $departemen = Departemen::where('id',$middep->divisi)->first();
                    $nbulan    = $namaBulan . ' ' . $tahun;
                    return Excel::download(new AbsensiFilterExport($data,$idkaryawan,$middep), "Rekap Absensi Departemen ". ucwords(strtolower($departemen->nama_departemen)) . " ". $nbulan .".xlsx");
                }

            }
            else{
                $data = Absensi::with('karyawans','departemens')
                    ->where('id_departement',$middep->divisi)
                    ->where('partner', $partner)
                    ->orderBy('id_karyawan','asc')
                    ->get();
                if ($data->isEmpty())
                {
                    return redirect()->back()->with('error','Tidak Ada Data');
                } else {
                    $departemen = Departemen::where('id',$middep->divisi)->first();
                    return Excel::download(new AbsensiFilterExport($data,$idkaryawan,$middep), "Rekap Absensi Departemen ". ucwords(strtolower($departemen->nama_departemen)) .".xlsx");
                }

            };
        }
        elseif ($role == 3 && $row->jabatan == "Asistant Manager")
            {
                if($idkaryawan !== "Semua" && isset($idkaryawan) && isset($bulan) && isset($tahun))
                {
                    $data = Absensi::with('karyawans','departemens')
                        ->where('id_karyawan', $idkaryawan)
                        ->where('id_departement',$middep->divisi)
                        ->whereMonth('tanggal', $bulan)
                        ->whereYear('tanggal',$tahun)
                        ->where('partner', $partner)
                        ->orderBy('tanggal','asc')
                        ->get();
                    // dd($data);
                    $departemen = Departemen::where('id',$middep->divisi)->first();

                    if ($data->isEmpty())
                    {
                        return redirect()->back()->with('error','Tidak Ada Data');
                    } else {
                        $nbulan = \Carbon\Carbon::parse($data->first()->tanggal)->format('M Y');
                        return Excel::download(new AbsensiFilterExport($data,$idkaryawan,$middep),
                        "Rekap Absensi Bulan ".$nbulan." ". ucwords(strtolower($data->first()->karyawans->nama)) ." Departemen ". ucwords(strtolower($departemen->nama_departemen)) .".xlsx");
                    }

                }elseif($idkaryawan == "Semua" && isset($bulan) && isset($tahun))
                {
                    $data = Absensi::with('karyawans','departemens')
                        ->whereHas('karyawans', function ($query) use ($row) {
                            $query->where('atasan_pertama', $row->id);
                        })
                        ->where('id_departement',$middep->divisi)
                        ->whereMonth('tanggal', $bulan)
                        ->whereYear('tanggal',$tahun)
                        ->where('partner', $partner)
                        ->orderBy('id_karyawan','asc')
                        ->get();
                    // dd($data);
                    $departemen = Departemen::where('id',$middep->divisi)->first();

                    if ($data->isEmpty())
                    {
                        return redirect()->back()->with('error','Tidak Ada Data');
                    } else {
                        $nbulan = \Carbon\Carbon::parse($data->first()->tanggal)->format('M Y');
                        return Excel::download(new AbsensiFilterExport($data,$idkaryawan,$middep),
                        "Rekap Absensi Bulan ".$nbulan." " . "Departemen ". ucwords(strtolower($departemen->nama_departemen)) .".xlsx");
                    }

                }
                else{
                    $pegawai = Karyawan::where('jabatan','Staff')->orWhere('jabatan','Asistant Manager')
                        ->select('id as idkaryawan')
                        ->get();

                    $data = Absensi::where('id_departement', $middep->divisi)
                        ->whereIn('id_karyawan',$pegawai->pluck('idkaryawan'))
                        ->where('partner', $partner)
                        ->orderBy('id_karyawan','asc')
                        ->get();
                    $departemen = Departemen::where('id',$middep->divisi)->first();

                    if ($data->isEmpty())
                    {
                        return redirect()->back()->with('error','Tidak Ada Data');
                    } else {
                        return Excel::download(new AbsensiFilterExport($data,$idkaryawan,$middep), "Rekap Absensi Departemen ".ucwords(strtolower($departemen->nama_departemen)) .".xlsx");
                    }
                };
            }
            else
                {
                    return redirect()->back()->with('error','Anda tidak memiliki hak akses');
                }
    }

    //DIGUNAKAN
    public function exportpdf(Request $request)
    {
        $role = Auth::user()->role;
        $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();

        //mengambil id_departemen user
        $middep = DB::table('karyawan')->where('id','=',Auth::user()->id_pegawai)
                ->select('divisi')->first();

        $idkaryawan = $request->id_karyawan;
        $bulan      = $request->query('bulan',Carbon::now()->format('m'));
        $tahun      = $request->query('tahun',Carbon::now()->format('Y'));


        // simpan session
        $idkaryawan = $request->session()->get('idkaryawan');
        $bulan      = $request->session()->get('bulan');
        $tahun      = $request->session()->get('tahun');

        // $namaBulan = Carbon::createFromDate(null, $bulan, null)->locale('id')->monthName;
        // $nbulan    = $namaBulan . ' ' . $tahun;

        $setorganisasi = SettingOrganisasi::where('partner', Auth::user()->partner)->first();
        if($role == 3 && $row->jabatan == "Manager")
        {
            if($idkaryawan !== "Semua" && isset($idkaryawan) && isset($bulan) && isset($tahun))
            {
                $data = Absensi::where('id_karyawan', $idkaryawan)
                    ->where('id_departement',$middep->divisi)
                    ->whereMonth('tanggal', $bulan)
                    ->whereYear('tanggal',$tahun)
                    ->orderBy('tanggal', 'asc')
                    ->get();
                $departemen = Departemen::where('id',$middep->divisi)->first();
                $nama = Karyawan::where('id',$idkaryawan)->first();

                if ($data->isEmpty())
                {
                    return redirect()->back()->with('error','Tidak Ada Data');
                } else {
                    $nbulan = \Carbon\Carbon::parse($data->first()->tanggal)->format('M Y');
                    $pdfName = "Rekap Absensi Bulan ".$nbulan." " . ucwords(strtolower($data->first()->karyawans->nama)) . " Departemen ". ucwords(strtolower($departemen->nama_departemen)) .".pdf";
                    $pdf  = PDF::loadview('manager.staff.absensistaff_pdf',['data'=>$data,'idkaryawan'=>$idkaryawan,'nama' => $nama,'departemen'=>$departemen, 'nbulan'=>$nbulan,'setorganisasi' => $setorganisasi])
                                    ->setPaper('A4','landscape');
                    return $pdf->stream($pdfName);
                }

            }
            elseif($idkaryawan == "Semua" && isset($bulan) && isset($tahun))
            {
                $data = Absensi::with('karyawans','departemens')
                    ->where('id_departement',$middep->divisi)
                    ->where('partner', Auth::user()->partner)
                    ->whereMonth('tanggal', $bulan)
                    ->whereYear('tanggal',$tahun)
                    ->orderBy('id_karyawan','asc')
                    ->get();

                $departemen = Departemen::where('id',$middep->divisi)->first();
                $nama = "";
                if ($data->isEmpty())
                {
                    return redirect()->back()->with('error','Tidak Ada Data');
                } else {
                    $nbulan = \Carbon\Carbon::parse($data->first()->tanggal)->format('M Y');
                    $pdfName = "Rekap Absensi Departemen ".ucwords(strtolower($departemen->nama_departemen)). " ". "Bulan ".$nbulan .".pdf";
                    $departemen = Departemen::where('id',$middep->divisi)->first();
                    $pdf  = PDF::loadview('manager.staff.absensistaff_pdf',['data'=>$data,'idkaryawan'=>$idkaryawan,'nama' => $nama,'departemen'=>$departemen,'nbulan'=>$nbulan,'setorganisasi' => $setorganisasi])
                    ->setPaper('A4','landscape');
                    return $pdf->stream($pdfName);
                }

            }else
            {
                $data = Absensi::with('karyawans','departemens')
                    ->where('id_departement',$middep->divisi)
                    ->where('partner', Auth::user()->partner)
                    ->orderBy('id_karyawan','asc')
                    ->get();
                $nama = "";
                $departemen = Departemen::where('id',$middep->divisi)->first();

                if ($data->isEmpty())
                {
                    return redirect()->back()->with('error','Tidak Ada Data');
                } else {
                    $nbulan = "-";
                    $pdfName = "Rekap Absensi Departemen ".ucwords(strtolower($departemen->nama_departemen)) .".pdf";
                    $departemen = Departemen::where('id',$middep->divisi)->first();
                    $pdf  = PDF::loadview('manager.staff.absensistaff_pdf',['data'=>$data,'idkaryawan'=>$idkaryawan,'nama' => $nama,'departemen'=>$departemen,'nbulan'=>$nbulan,'setorganisasi' => $setorganisasi])
                    ->setPaper('A4','landscape');
                    return $pdf->stream($pdfName);
                }
            }

        }
        elseif($role == 3 && $row->jabatan == "Asistant Manager")
            {
                if($idkaryawan !== "Semua" && isset($idkaryawan) && isset($bulan) && isset($tahun))
                {
                    $data = Absensi::with('karyawans','departemens')
                        ->where('id_karyawan', $idkaryawan)
                        ->where('id_departement',$middep->divisi)
                        ->whereMonth('tanggal', $bulan)
                        ->whereYear('tanggal',$tahun)
                        ->orderBy('tanggal', 'asc')
                        ->get();
                    $departemen = Departemen::where('id',$middep->divisi)->first();
                    $nama = Karyawan::where('id',$idkaryawan)->first();

                    if ($data->isEmpty())
                    {
                        return redirect()->back()->with('error','Tidak Ada Data');
                    } else {
                        $nbulan = \Carbon\Carbon::parse($data->first()->tanggal)->format('M Y');
                        $pdfName = "Rekap Absensi Bulan ".$nbulan." " . ucwords(strtolower($data->first()->karyawans->nama)) . " Departemen ". ucwords(strtolower($departemen->nama_departemen)) .".pdf";
                        $pdf  = PDF::loadview('manager.staff.absensistaff_pdf',['data'=>$data,'idkaryawan'=>$idkaryawan,'nama' => $nama,'departemen'=>$departemen, 'nbulan'=>$nbulan,'setorganisasi' => $setorganisasi])
                                        ->setPaper('A4','landscape');
                        return $pdf->stream($pdfName);
                    }

                }elseif($idkaryawan == "Semua" && isset($bulan) && isset($tahun))
                {
                    $data = Absensi::with('karyawans','departemens')
                        ->whereHas('karyawans', function ($query) use ($row) {
                            $query->where('atasan_pertama', Auth::user()->id_pegawai);
                        })
                        ->where('id_departement',$middep->divisi)
                        ->where('partner', Auth::user()->partner)
                        ->whereMonth('tanggal', $bulan)
                        ->whereYear('tanggal',$tahun)
                        ->orderBy('id_karyawan','asc')
                        ->get();
                    $departemen = Departemen::where('id',$middep->divisi)->first();
                    $nama = "";
                    if ($data->isEmpty())
                    {
                        return redirect()->back()->with('error','Tidak Ada Data');
                    } else {
                        $nbulan = \Carbon\Carbon::parse($data->first()->tanggal)->format('M Y');
                        $pdfName = "Rekap Absensi Bulan ".$nbulan. " Departemen ".ucwords(strtolower($departemen->nama_departemen)) .".pdf";
                        $departemen = Departemen::where('id',$middep->divisi)->first();
                        $pdf  = PDF::loadview('manager.staff.absensistaff_pdf',['data'=>$data,'idkaryawan'=>$idkaryawan,'nama' => $nama,'departemen'=>$departemen,'nbulan'=>$nbulan,'setorganisasi' => $setorganisasi])
                        ->setPaper('A4','landscape');
                        return $pdf->stream($pdfName);
                    }
                }
                else
                {
                    $pegawai = Karyawan::where('jabatan','Staff')->orWhere('jabatan','Asistant Manager')
                        ->select('id as idkaryawan')
                        ->get();

                    $data = Absensi::where('id_departement', $middep->divisi)
                        ->whereIn('id_karyawan',$pegawai->pluck('idkaryawan'))
                        ->where('partner', Auth::user()->partner)
                        ->orderBy('id_karyawan','asc')
                        ->get();
                     $nama = Karyawan::where('id',$idkaryawan)->first();
                    // $data = Absensi::where('id_departement',$middep->divisi)->get();
                    $departemen = Departemen::where('id',$middep->divisi)->first();

                    if ($data->isEmpty())
                    {
                        return redirect()->back()->with('error','Tidak Ada Data');
                    } else {
                        $nbulan = "-";
                        $pdfName = "Rekap Absensi Departemen ".ucwords(strtolower($departemen->nama_departemen)) .".pdf";
                        $departemen = Departemen::where('id',$middep->divisi)->first();
                        $pdf  = PDF::loadview('manager.staff.absensistaff_pdf',['data'=>$data,'idkaryawan'=>$idkaryawan,'nama' => $nama,'departemen'=>$departemen,'nbulan'=>$nbulan,'setorganisasi' => $setorganisasi])
                        ->setPaper('A4','landscape');
                        return $pdf->stream($pdfName);
                    }

                }
            }
            else{
                return redirect()->back()->with('error','Anda tidak memiliki hak akses');
            };
    }


    public function resignStaff(Request $request)
    {
        $partner = Auth::user()->partner;
        $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
        $karyawan = Karyawan::where('id', Auth::user()->id_pegawai)->first();
        $manager_iddep = DB::table('karyawan')
        ->where('id','=',Auth::user()->id_pegawai)
        ->select('divisi')->first();

        // $karyawan1 = Karyawan::where('partner', $partner)
        // ->where('divisi', $manager_iddep->divisi)
        // ->get();
        $karyawan1 = Karyawan::where('status_kerja', 'Aktif')
        ->where('partner', Auth::user()->partner)
        ->where('divisi', $manager_iddep->divisi)
        ->whereNotIn('id', function($query) {
            $query->select('id_karyawan')->from('resign');
        })->get();
        $idkaryawan = $request->id_karyawan;
        $resign = Resign::all();

        $tes = Auth::user()->karyawan->departemen->nama_departemen;

        // $staff1 = Resign::with('departemens','karyawan')
        //     ->where('departemen', $manager_iddep->divisi)
        //     ->where('karyawan.partner',Auth::user()->partner)
        //     ->orderByDesc('created_at')
        //     ->get();

            $staff1 = Resign::join('karyawan', 'resign.id_karyawan','karyawan.id')
            ->where('resign.departemen', $manager_iddep->divisi)
            ->where('karyawan.partner',Auth::user()->partner)
            ->select('resign.*')
            ->orderBy('resign.created_at', 'desc')
            ->get();

        return view('manager.staff.resignStaff', compact('karyawan','karyawan1','resign','tes','staff1','row','partner'));
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

//     if($role == 3 && $row->jabatan == "Manager")
//     {

//         return Auth::user()->nama;
//         if($atasanpertama &&  $atasanpertama->atasan_pertama  == Auth::user()->id_pegawai)
//         {

//             $status = Status::find(6);
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
//                 'subject'     =>'Notifikasi Permohonan Cuti',
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
//     elseif($role == 3 && $row->jabatan == "Asistant Manager")
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
//                 'subject'     =>'Notifikasi Permohonan Cuti',
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
    //         $data = Absensi::where('id_departement',$middep->divisi)->get();
    //         $pdf  = PDF::loadview('manager.staff.absensistaff_pdf',['data',$data],compact('data'))
    //         ->setPaper('A4','landscape');

    //         return $pdf->stream('Report Absensi Staff Departemen.pdf');
    //     }
    //     elseif($role == 5)
    //     {
    //         $data = Absensi::with(['karyawans' => function($query) {
    //             $query->select('id,nama')->where('jabatan','=', 'Staff');
    //         }])->where('id_departement',$middep->divisi)->get();

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
    //         ->where('id_departement',$middep->divisi)
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
    //         ->where('id_departement',$middep->divisi)
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



