<?php

namespace App\Http\Controllers\manager;

use PDF;
use Carbon\Carbon;
use App\Models\Cuti;
use App\Models\Absensi;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exports\AbsensiFilterExport;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AbsensiDepartemenExport;

class ManagerController extends Controller
{
    public function dataStaff(Request $request)
    {
        //mengambil id_departemen manager
        $manager_iddep = DB::table('karyawan')
        ->where('id','=',Auth::user()->id_pegawai)
        ->select('divisi')->first();

        // dd( $manager_iddep);
        //ambil data dengan id_departemen sama dengan manager
        //$staff= Karyawan::where('divisi',$manager_iddep->divisi)->get();
        $staff= Karyawan::with('departemens')
        ->where('divisi',$manager_iddep->divisi)->get();

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
        return view('manager.staff.absensiStaff', compact('absensi','karyawan'));
    }

    public function cutiStaff(Request $request)
    {
        $manag_depart = DB::table('karyawan')->where('id','=',Auth::user()->id_pegawai)
        ->select('divisi')->first();

        $cutistaff = DB::table('cuti')
        ->leftjoin('alokasicuti','cuti.id_jeniscuti','alokasicuti.id_jeniscuti')
        ->leftjoin('settingalokasi','cuti.id_jeniscuti','settingalokasi.id_jeniscuti')
        ->leftjoin('jeniscuti','cuti.id_jeniscuti','jeniscuti.id')
        ->leftjoin('karyawan','cuti.id_karyawan','karyawan.id')
        ->where('settingalokasi.departemen',$manag_depart->divisi)
        ->select('cuti.*', 'jeniscuti.jenis_cuti', 'karyawan.nama','settingalokasi.mode_alokasi')
        ->distinct()
        ->get();

        return view('manager.staff.cutiStaff', compact('cutistaff'));
    }

    public function showCuti($id)
    {
        $cutiStaff = Cuti::findOrFail($id);

        return view('manager.staff.cutiStaff',compact('cutiStaff'));
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

    public function exportallExcel()
    {
        $middep = DB::table('absensi')
        ->join('karyawan','absensi.id_departement','=','karyawan.divisi')
        ->where('absensi.id_karyawan','=',Auth::user()->id_pegawai)
        ->select('id_departement')->first();

        $data = Absensi::where('id_departement',$middep->id_departement)->get();

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
            $data = Absensi::where('id_karyawan', $idkaryawan)
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal',$tahun)
            ->where('id_departement',$middep->id_departement)
            ->get();
            // dd($data);
        }else{
            $data = Absensi::where('id_departement',$middep->id_departement)->get();
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
        $pdf  = PDF::loadview('manager.staff.absensistaffid_pdf',['data'=>$data,'idkaryawan'=>$idkaryawan])
        ->setPaper('A4','landscape');

        return $pdf->stream("Report Absensi_{$idkaryawan}.pdf");
    }

}
