<?php

namespace App\Http\Controllers\admin;

use PDF;
use Carbon\Carbon;
use App\Models\Karyawan;
use App\Models\Tidakmasuk;
use Illuminate\Http\Request;
use App\Exports\TidakmasukExport;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class TidakMasukController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
        $role = Auth::user()->role;
        
        if ($role == 1) {
            $karyawan = Karyawan::all();
            $idkaryawan = $request->id_karyawan;

            $bulan = $request->query('bulan',Carbon::now()->format('m'));
            $tahun = $request->query('tahun',Carbon::now()->format('Y'));

            // simpan session
            $request->session()->put('idkaryawan', $request->id_karyawan);
            $request->session()->put('bulan', $bulan);
            $request->session()->put('tahun', $tahun);

            if(isset($idkaryawan) && isset($bulan) && isset($tahun))
            {
                $tidakmasuk = Tidakmasuk::with('departemen')->where('id_pegawai', $idkaryawan)
                ->whereMonth('tanggal', $bulan)
                ->whereYear('tanggal',$tahun)
                ->get();
            }else
            {
                $tidakmasuk = Tidakmasuk::with('departemen')
                ->orderBy('tanggal','desc')
                ->get();
            }
            return view('admin.tidakmasuk.index',compact('tidakmasuk','karyawan','row'));
            
            //menghapus filter data
            $request->session()->forget('id_karyawan');
            $request->session()->forget('bulan');
            $request->session()->forget('tahun');
        } 
        else {
        
            return redirect()->back(); 
        }
    }

    public function tidakMasukPdf(Request $request)
    {
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
            $tidakmasuk = Tidakmasuk::with('departemen')->where('id_pegawai', $idkaryawan)
                ->whereMonth('tanggal', $bulan)
                ->whereYear('tanggal',$tahun)
                ->get();
        }else
        {
            $tidakmasuk = Tidakmasuk::with('departemen')->orderBy('tanggal','desc')->get();
        }
        

        $pdf = PDF::loadview('admin.tidakmasuk.dataTidakMasukPdf',['tidakmasuk'=>$tidakmasuk, 'idkaryawan'=>$idkaryawan])
        ->setPaper('a4','landscape');
        return $pdf->stream("Data Absensi Tidak Masuk Bulan ".$nbulan." ".$tidakmasuk->first()->nama.".pdf");

    }

    public function tidakMasukExcel(Request $request)
    {

        $idkaryawan = $request->id_karyawan;
        $bulan      = $request->query('bulan',Carbon::now()->format('m'));
        $tahun      = $request->query('tahun',Carbon::now()->format('Y'));

        // simpan session
        $idkaryawan = $request->session()->get('idkaryawan');
        $bulan      = $request->session()->get('bulan');
        $tahun      = $request->session()->get('tahun',);

        if(isset($idkaryawan) && isset($bulan) && isset($tahun))
        {
            $data = Tidakmasuk::with('departemen')->where('id_pegawai', $idkaryawan)
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal',$tahun)
            ->get();
        }else
        {
            $data = Tidakmasuk::with('departemen')->orderBy('tanggal','desc')->get();
        }
        return Excel::download(new TidakmasukExport($data,$idkaryawan),"Data Absensi Tidak Masuk ".$data->first()->nama.".xlsx");
    }
}
