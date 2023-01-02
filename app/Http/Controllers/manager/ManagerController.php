<?php

namespace App\Http\Controllers\manager;

use PDF;
use Carbon\Carbon;
use App\Models\Cuti;
use App\Models\Karyawan;
use App\Models\Absensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ManagerController extends Controller
{
    // public function index(Request $request)
    // {
    //     $type = $request->query('type', 1);
    //     $cuti = Cuti::latest()->paginate(10);
        
    //     return view('manager.cuti.index', compact('cuti','izin','type'));
    // }

    public function dataStaff(Request $request)
    {
        //mengambil id_departemen manager
        $manager_iddep = DB::table('karyawan')->where('id','=',Auth::user()->id_pegawai)
        ->select('divisi')->first();

        // dd( $manager_iddep);
        //ambil data dengan id_departemen sama dengan manager
        $staff= Karyawan::where('divisi',$manager_iddep->divisi)->get();

        return view('manager.staff.dataStaff', compact('staff'));
    }

    public function absensiStaff(Request $request)
    {
        //mengambil id_departemen manager
        $middep = DB::table('absensi')
        ->join('karyawan','absensi.id_departement','=','karyawan.divisi')
        ->where('absensi.id_karyawan','=',Auth::user()->id_pegawai)
        ->select('id_departement')->first();

        //saring data dengan id_departemen sama dengan manager secara keseluruhan
        //$absensi= Absensi::where('id_departement',$middep->id_departement)->get();

        //=================================
        //untuk filter data karyawan
        $manager_iddep = DB::table('karyawan')->where('id','=',Auth::user()->id_pegawai)
                        ->select('divisi')->first();
        $karyawan= Karyawan::where('divisi',$manager_iddep->divisi)->get();

        $idkaryawan = $request->id_karyawan;
        $bulan = $request->query('bulan',Carbon::now()->format('m'));
        $tahun = $request->query('tahun',Carbon::now()->format('Y'));

        $request->session()->put('idkaryawan', $request->id_karyawan);
        $request->session()->put('bulan', $bulan);
        $request->session()->put('tahun', $tahun);

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
        return view('manager.staff.absensiStaff', compact('absensi','karyawan'));
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
        $pdf  = PDF::loadview('manager.staff.absensistaffid_pdf',['data'=>$data,'idkaryawan'=>$idkaryawan])
        ->setPaper('A4','landscape');

        return $pdf->stream("Report Absensi_{$idkaryawan}.pdf");
    }

    public function cutiapproved(Request $request, $id)
    {
        $cuti = Cuti::where('id',$id)->first();
        $status = 'Disetujui Manager';
        Cuti::where('id',$id)->update([
            'status' => $status,
        ]);
        return redirect()->back()->withInput();
    }
}
