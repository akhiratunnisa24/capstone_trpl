<?php

namespace App\Http\Controllers\karyawan;

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
    
    public function index()
    {
        $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
        // $historyabsensi = Absensi::where('id_karyawan',Auth::user()->id_pegawai)->get();
        $historyabsensi = Absensi::latest()->where('id_karyawan',Auth::user()->id_pegawai)->orderBy('tanggal')->get();
        return view('karyawan.absensi.history_absensi',compact('historyabsensi','row'));
    }

    public function absensiPeroranganExcel(Request $request)
    {
        $idkaryawan = Auth::user()->id_pegawai;
        $bulan      = $request->query('bulan',Carbon::now()->format('m'));
        $tahun      = $request->query('tahun',Carbon::now()->format('Y'));

        // simpan session
        $idkaryawan = $request->session()->get('idkaryawan');
        $bulan      = $request->session()->get('bulan');
        $tahun      = $request->session()->get('tahun',);

    
        if(isset($idkaryawan) && isset($bulan) && isset($tahun))
        {
            $data = Absensi::with('karyawans','departemens')
            ->where('id_karyawan', $idkaryawan)
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal',$tahun)
            ->get();
            // dd($data);
        }else{
            $data = Absensi::with('karyawans','departemens')
            ->where('id_karyawan','=',$idkaryawan)
            ->get();
        }
        return Excel::download(new AbsensiPeroranganExport($data,$idkaryawan),'Rekap Absensi Perorangan Bulanan.xlsx');
    }
}
