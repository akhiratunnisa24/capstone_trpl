<?php

namespace App\Http\Controllers\karyawan;

use PDF;
use Carbon\Carbon;
use App\Models\Absensi;
use App\Models\Karyawan;
use App\Models\Departemen;
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
        $iduser = Auth::user()->id_pegawai;

        $absensi = Absensi::with('karyawans', 'departemens')
            ->where('id_karyawan', $iduser);


        $bulan = $request->query('bulan');
        $tahun = $request->query('tahun');

        if($bulan && $tahun)
        {
            $absensi = $absensi->whereMonth('tanggal', $bulan)
                ->whereYear('tanggal', $tahun);
        }

        $absensi = $absensi->get();

        // dd($absensi);

        // simpan session
        $request->session()->put('bulan', $bulan ?? Carbon::now()->format('m'));
        $request->session()->put('tahun', $tahun ?? Carbon::now()->format('Y'));
        // dd($absensi);
        return view('karyawan.absensi.history_absensi',compact('absensi','row'));
       
        $request->session()->forget('bulan');
        $request->session()->forget('tahun');
        //menghapus filter data
       
    }

    
    // public function index(Request $request)
    // {
    //     $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
    //      //$absensi = Absensi::latest()->where('id_karyawan',Auth::user()->id_pegawai)->orderBy('tanggal')->get();
    //     $iduser = Auth::user()->id_pegawai;

    //     $bulan = $request->query('bulan',Carbon::now()->format('m'));
    //     $tahun = $request->query('tahun',Carbon::now()->format('Y'));

    //     // simpan session
    //     $request->session()->put('bulan', $bulan);
    //     $request->session()->put('tahun', $tahun);

    //     $absensi = Absensi::where('id_karyawan', $iduser)->get();
    //     dd($absensi);
    //     if(isset($bulan) && isset($tahun))
    //     {
    //         $absensi = Absensi::with('karyawans','departemens')
    //             ->where('id_karyawan', $iduser)
    //             ->whereMonth('tanggal', $bulan)
    //             ->whereYear('tanggal',$tahun)
    //             ->get();
    //     }
    //     return view('karyawan.absensi.history_absensi',compact('absensi','row'));
        
    //     //menghapus filter data
    //     $request->session()->forget('bulan');
    //     $request->session()->forget('tahun');
    // }

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
         $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
        $iduser = Auth::user()->id_pegawai;

        $nama   = Karyawan::where('id','=', $iduser)->first();
      
        $data = Absensi::with('karyawans', 'departemens')
            ->where('id_karyawan', $iduser)->get();


        $bulan  = $request->query('bulan',Carbon::now()->format('m'));
        $tahun  = $request->query('tahun',Carbon::now()->format('Y'));

        // simpan session
        $bulan      = $request->session()->get('bulan');
        $tahun      = $request->session()->get('tahun');

        $namaBulan = Carbon::createFromDate(null, $bulan, null)->locale('id')->monthName;
        $nbulan    = $namaBulan . ' ' . $tahun;

        if(isset($bulan) && isset($tahun))
        {
           $data = Absensi::with('karyawans','departemens')
                ->where('id_karyawan', $iduser)
                ->whereMonth('tanggal', $bulan)
                ->whereYear('tanggal',$tahun)
                ->get();
        }
        $nama = Karyawan::where('id',$iduser)->first();
        $departemen = Departemen::where('id',$nama->divisi)->first();
        $pdf  = PDF::loadview('karyawan.absensi.absensistaff_pdf',['data'=>$data,'departemen'=>$departemen,'iduser'=>$iduser, 'nama'=> $nama, 'nbulan'=>$nbulan])
        ->setPaper('A4','landscape');

        return $pdf->stream("Report Absensi {$nama->nama} Bulan {$nbulan}.pdf");
    }
}
