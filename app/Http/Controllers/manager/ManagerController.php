<?php

namespace App\Http\Controllers\manager;

use PDF;
use Carbon\Carbon;
use App\Models\Cuti;
use App\Models\Izin;
use App\Models\Absensi;
use App\Models\Karyawan;
use App\Models\Resign;
use App\Models\Datareject;
use App\Models\Alokasicuti;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exports\AbsensiFilterExport;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use App\Mail\IzinApproveNotification;
use App\Exports\AbsensiDepartemenExport;

class ManagerController extends Controller
{
    public function dataStaff(Request $request)
    {
        $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
        //mengambil id_departemen manager
        $manager_iddep = DB::table('karyawan')
        ->where('id','=',Auth::user()->id_pegawai)
        ->select('divisi')->first();

        // dd( $manager_iddep);
        //ambil data dengan id_departemen sama dengan manager
        //$staff= Karyawan::where('divisi',$manager_iddep->divisi)->get();
        $staff= Karyawan::with('departemens')
        ->where('divisi',$manager_iddep->divisi)->get();

        return view('manager.staff.dataStaff', compact('staff','row'));
    }

    public function absensiStaff(Request $request)
    {
        $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
        //mengambil id_departemen manager
        $middep = DB::table('absensi')
        ->join('karyawan','absensi.id_departement','=','karyawan.divisi')
        ->where('absensi.id_karyawan','=',Auth::user()->id_pegawai)
        ->select('id_departement')->first();

        //saring data dengan id_departemen sama dengan manager secara keseluruhan
        //$absensi= Absensi::where('id_departement',$middep->id_departement)->get();

        //=================================
        //untuk filter nama karyawan
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

    public function cutiStaff(Request $request)
    {
        $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();

        $manag_depart = DB::table('karyawan')->where('id','=',Auth::user()->id_pegawai)
        ->select('divisi')->first();

        $tp = $request->query('tp',1);

        $cutistaff = DB::table('cuti')
            ->leftjoin('alokasicuti','cuti.id_jeniscuti','alokasicuti.id_jeniscuti')
            ->leftjoin('settingalokasi','cuti.id_jeniscuti','settingalokasi.id_jeniscuti')
            ->leftjoin('jeniscuti','cuti.id_jeniscuti','jeniscuti.id')
            ->leftjoin('karyawan','cuti.id_karyawan','karyawan.id')
            ->where('karyawan.divisi',$manag_depart->divisi)
            ->where('karyawan.jabatan','!=','Manager')
            ->select('cuti.*', 'jeniscuti.jenis_cuti', 'karyawan.nama')
            ->distinct()
            ->get();

        $izinstaff = DB::table('izin')
            ->leftjoin('karyawan','izin.id_karyawan','karyawan.id')
            ->leftjoin('jenisizin','izin.id_jenisizin','jenisizin.id')
            ->where('karyawan.divisi',$manag_depart->divisi)
            ->select('izin.*','karyawan.nama','jenisizin.jenis_izin')
            ->distinct()
            ->get();

        return view('manager.staff.cutiStaff', compact('cutistaff','row','tp','izinstaff'));
    }

    public function showCuti($id)
    {
        $cutiStaff = Cuti::findOrFail($id);

        return view('manager.staff.cutiStaff',compact('cutiStaff'));
    }

    public function cutiapproved(Request $request, $id)
    {
        $cuti = Cuti::where('id',$id)->first();

        $data = DB::table('cuti')
        ->join('alokasicuti', 'cuti.id_alokasi', '=', 'alokasicuti.id')
        ->join('settingalokasi', 'cuti.id_settingalokasi', '=', 'settingalokasi.id')
        ->where('settingalokasi.tipe_approval', 'Tidak Bertingkat')
        ->orWhere('settingalokasi.tipe_approval', 'Bertingkat')
        ->select('cuti.*','alokasicuti.*','settingalokasi.tipe_approval')
        ->first();

        // dd($data);

        if($data->tipe_approval == 'Tidak Bertingkat')
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

            return redirect()->back()->withInput();

        }else{
            $status = 'Disetujui Manager';
            Cuti::where('id',$id)->update([
                'status' => $status,
            ]);
            return redirect()->back()->withInput();
        }
        
    }

    public function cutireject($id)
    {
        $cuti = Cuti::where('id',$id)->first();
            $status = 'Ditolak';
            Cuti::where('id',$id)->update([
                'status' => $status,
            ]);
            return redirect()->back()->withInput();
    }

    public function showIzin($id)
    {
        $izin = Izin::findOrFail($id);
        $karyawan = Auth::user()->id_pegawai;
 
        return view('manager.staff.cutiStaff',compact('izin','karyawan',['tp'=>2]));
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
        $karyawan = DB::table('izin')
            ->join('karyawan','izin.id_karyawan','=','karyawan.id')
            ->where('izin.id',$izin->id)
            ->select('karyawan.email as email','karyawan.nama as nama')
            ->first(); 
        $tujuan = 'akhiratunnisahasanah0917@gmail.com';
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
        $datareject->id_izin = $iz->id_izin;
        $datareject->alasan  = $iz->alasan;
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
        $tujuan = 'akhiratunnisahasanah0917@gmail.com';
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

    public function exportallExcel()
    {
        $middep = DB::table('absensi')
        ->join('karyawan','absensi.id_departement','=','karyawan.divisi')
        ->where('absensi.id_karyawan','=',Auth::user()->id_pegawai)
        ->select('id_departement')->first();

        $data = Absensi::with('karyawans','departemens')
        ->where('id_departement',$middep->id_departement)
        ->get();

        return Excel::download(new AbsensiDepartemenExport($data), 'data_absensi_departemen.xlsx');
    }

    public function exportToExcel(Request $request)
    {
        //mengambil id_departemen manager
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
        }else{
            $data = Absensi::with('karyawans','departemens')->where('id_departement',$middep->id_departement)->get();
        };

        return Excel::download(new AbsensiFilterExport($data,$idkaryawan,$middep), "data_absensi_departemen{$idkaryawan}.xlsx");
    }

    public function exportallpdf()
    {
        //mengambil id_departemen manager
        $middep = DB::table('absensi')
        ->join('karyawan','absensi.id_departement','=','karyawan.divisi')
        ->where('absensi.id_karyawan','=',Auth::user()->id_pegawai)
        ->select('id_departement')->first();

        $data = Absensi::where('id_departement',$middep->id_departement)->get();
        $pdf  = PDF::loadview('manager.staff.absensistaff_pdf',['data',$data],compact('data'))
        ->setPaper('A4','landscape');

        return $pdf->stream('Report Absensi Staff Departemen.pdf');
    }

    public function exportpdf(Request $request)
    {
        //mengambil id_departemen manager
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

        // dd($idkaryawan,$bulan,$tahun );
    
        if(isset($idkaryawan) && isset($bulan) && isset($tahun))
        {
            $data = Absensi::where('id_karyawan', $idkaryawan)
            ->where('id_departement',$middep->id_departement)
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal',$tahun)
            ->get();
        }else{
            $data = Absensi::where('id_departement',$middep->id_departement)->get();
        }
        $pdf  = PDF::loadview('manager.staff.absensistaff_pdf',['data'=>$data,'idkaryawan'=>$idkaryawan])
        ->setPaper('A4','landscape');

        return $pdf->stream("Report Absensi_{$idkaryawan}.pdf");
    }

    public function resignStaff(Request $request)
    {
       
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

        return view('manager\staff.resignStaff', compact('karyawan','karyawan1','resign','tes','staff1'));
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

