<?php

namespace App\Http\Controllers\karyawan;

use PDF;
use Carbon\Carbon;
use App\Models\Absensi;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AbsensiPeroranganExport;

class AbsensiKaryawanController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    
    public function index(Request $request)
    {
        $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();

        // $historyabsensi = Absensi::latest()
        //     ->where('id_karyawan',Auth::user()->id_pegawai)
        //     ->orderBy('tanggal')
        //     ->get();
         //$absensi = Absensi::latest()->where('id_karyawan',Auth::user()->id_pegawai)->orderBy('tanggal')->get();
        $iduser = Auth::user()->id_pegawai;

        $bulan = $request->query('bulan',Carbon::now()->format('m'));
        $tahun = $request->query('tahun',Carbon::now()->format('Y'));

        // simpan session
        $request->session()->put('bulan', $bulan);
        $request->session()->put('tahun', $tahun);

        if(isset($bulan) && isset($tahun))
        {
            $absensi = Absensi::with('karyawans','departemens')->where('id_karyawan', $iduser)
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal',$tahun)
            ->get();
        }
        else
        {
            // $absensi = Absensi::latest()->where('id_karyawan',Auth::user()->id_pegawai)->get();
           
            // $absensi = Absensi::with('karyawans','departemens')->where('absensi.id_karyawan', $iduser)->get();
            // dd($absensi);
            $absensi = Absensi::all();
              // $absensi = Absensi::latest()->with('karyawans', 'departemens')->where('id_karyawan', $iduser)->get();
        }
        return view('karyawan.absensi.history_absensi',compact('absensi','row'));
        
        //menghapus filter data
        $request->session()->forget('bulan');
        $request->session()->forget('tahun');
    }

    public function absensiPeroranganExcel(Request $request)
    {
        $iduser = Auth::user()->id_pegawai;
        $nama   = Karyawan::where('id','=', $iduser)->first();
        $nbulan = $request->query('bulan',Carbon::now()->format('M Y'));

        $bulan  = $request->query('bulan',Carbon::now()->format('m'));
        $tahun  = $request->query('tahun',Carbon::now()->format('Y'));

        // simpan session
        $bulan      = $request->session()->get('bulan');
        $tahun      = $request->session()->get('tahun',);

    
        if(isset($bulan) && isset($tahun))
        {
            $data = Absensi::with('karyawans','departemens')
                ->where('id_karyawan', $iduser)
                ->whereMonth('tanggal', $bulan)
                ->whereYear('tanggal',$tahun)
                ->get();
            // dd($data);
        }else{
            $data = Absensi::with('karyawans', 'departemens')
                ->where('id_karyawan', $iduser)
                ->get();
        }
        return Excel::download(new AbsensiPeroranganExport($data, $iduser), "Rekap Absensi {$nama->nama} {$nbulan}.xlsx");
        //return Excel::download(new AbsensiPeroranganExport($data,$iduser),'Rekap Absensi Bulan' .$nama->nama. + $nbulan + '.xlsx');
    }

    public function absensiPeroranganPdf(Request $request)
    {
        $iduser = Auth::user()->id_pegawai;
        $nama   = Karyawan::where('id','=', $iduser)->first();
        $nbulan = $request->query('bulan',Carbon::now()->format('M Y'));

        $bulan  = $request->query('bulan',Carbon::now()->format('m'));
        $tahun  = $request->query('tahun',Carbon::now()->format('Y'));

        // simpan session
        $bulan      = $request->session()->get('bulan');
        $tahun      = $request->session()->get('tahun',);

        if(isset($bulan) && isset($tahun))
        {
            $data = Absensi::with('karyawans','departemens')
                ->where('id_karyawan', $iduser)
                ->whereMonth('tanggal', $bulan)
                ->whereYear('tanggal',$tahun)
                ->get();
            // dd($data);
        }else{
            $data = Absensi::with('karyawans', 'departemens')
                ->where('id_karyawan', $iduser)
                ->get();
        }
        $pdf  = PDF::loadview('karyawan.absensi.absensistaff_pdf',['data'=>$data,'iduser'=>$iduser])
        ->setPaper('A4','landscape');

        return $pdf->stream("Report Absensi {$nama->nama} Bulan {$nbulan}.pdf");
    }
}
