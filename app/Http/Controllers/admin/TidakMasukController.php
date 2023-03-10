<?php

namespace App\Http\Controllers\admin;

use PDF;
use Carbon\Carbon;
use App\Models\Absensi;
use App\Models\Karyawan;
use App\Models\Tidakmasuk;
use Illuminate\Http\Request;
use App\Models\Settingabsensi;
use App\Exports\TidakmasukExport;
use Illuminate\Support\Facades\DB;
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
        $role = Auth::user()->role;
        
        if ($role == 1) {
            $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
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
           
             // $nottidakmasuk = Tidakmasuk::leftJoin('setting_absensi', 'tidakmasuk.status', '=', 'setting_absensi.status_tidakmasuk')
            //                 ->leftJoin('karyawan', 'tidakmasuk.id_pegawai', '=', 'karyawan.id')
            //                 ->where('tidakmasuk.status', '=', 'tanpa keterangan')
            //                 ->select('tidakmasuk.id_pegawai as id_pegawai','karyawan.nama as nama', 'setting_absensi.jumlah_tidakmasuk as jumlah', 'setting_absensi.sanksi_tidak_masuk as sanksi', DB::raw('COUNT(tidakmasuk.id_pegawai) as total'))
            //                 ->havingRaw('COUNT(tidakmasuk.id_pegawai) = CASE WHEN setting_absensi.sanksi_tidak_masuk = "Potong Gaji" THEN ' . $pg->jumlah_tidakmasuk . ' ELSE ' . $pct->jumlah_tidakmasuk . ' END')
            //                 ->groupBy('setting_absensi.jumlah_tidakmasuk', 'setting_absensi.sanksi_tidak_masuk', 'tidakmasuk.id_pegawai')
            //                 ->get();
            //
            $pg = Settingabsensi::where('sanksi_tidak_masuk', '=', 'Potong Gaji')->select('jumlah_tidakmasuk')->first();
            $pct = Settingabsensi::where('sanksi_tidak_masuk', '=', 'Potong Cuti Tahunan')->select('jumlah_tidakmasuk')->first();

            $potonggaji = Tidakmasuk::leftJoin('setting_absensi', 'tidakmasuk.status', '=', 'setting_absensi.status_tidakmasuk')
                ->leftJoin('karyawan', 'tidakmasuk.id_pegawai', '=', 'karyawan.id')
                ->where('tidakmasuk.status', '=', 'tanpa keterangan')
                ->select('tidakmasuk.id_pegawai as id_pegawai','karyawan.nama as nama', 'setting_absensi.jumlah_tidakmasuk as jumlah', 'setting_absensi.sanksi_tidak_masuk as sanksi', DB::raw('COUNT(tidakmasuk.id_pegawai) as total'))
                ->havingRaw('COUNT(tidakmasuk.id_pegawai) = CASE WHEN setting_absensi.sanksi_tidak_masuk = "Potong Gaji" THEN ' . $pg->jumlah_tidakmasuk . ' END')
                ->groupBy('setting_absensi.jumlah_tidakmasuk', 'setting_absensi.sanksi_tidak_masuk', 'tidakmasuk.id_pegawai')
                ->get();
            $jpg = $potonggaji->count();

            $potongcuti = Tidakmasuk::leftJoin('setting_absensi', 'tidakmasuk.status', '=', 'setting_absensi.status_tidakmasuk')
                ->leftJoin('karyawan', 'tidakmasuk.id_pegawai', '=', 'karyawan.id')
                ->where('tidakmasuk.status', '=', 'tanpa keterangan')
                ->select('tidakmasuk.id_pegawai as id_pegawai','karyawan.nama as nama', 'setting_absensi.jumlah_tidakmasuk as jumlah', 'setting_absensi.sanksi_tidak_masuk as sanksi', DB::raw('COUNT(tidakmasuk.id_pegawai) as total'))
                ->havingRaw('COUNT(tidakmasuk.id_pegawai) = CASE WHEN setting_absensi.sanksi_tidak_masuk = "Potong Cuti Tahunan" THEN ' . $pct->jumlah_tidakmasuk . ' END')
                ->groupBy('setting_absensi.jumlah_tidakmasuk', 'setting_absensi.sanksi_tidak_masuk', 'tidakmasuk.id_pegawai')
                ->get();
            $jpc = $potongcuti->count();

            // $terlambat = Absensi::leftJoin('setting_absensi', 'absensi.terlambat', '>', 'setting_absensi.toleransi_terlambat')
            //     ->leftJoin('karyawan', 'absensi.id_karyawan', '=', 'karyawan.id')
            //     ->select('absensi.id_karyawan as id_karyawan','karyawan.nama as nama', 'setting_absensi.jumlah_terlambat as jumlah', 'setting_absensi.sanksi_terlambat as sanksi', DB::raw('COUNT(absensi.id_karyawan) as total'))
            //     ->havingRaw('COUNT(absensi.id_karyawan) = CASE WHEN setting_absensi.sanksi_terlambat = "Teguran Biasa" END')
            //     ->groupBy('setting_absensi.jumlah_terlambat', 'setting_absensi.sanksi_terlambat', 'absensi.id_karyawan')
            //     ->get();
            // $jpc = $potongcuti->count();

            // dd($terlambat);
            // dd($potonggaji,$jpg, $potongcuti,$jpc);

            return view('admin.tidakmasuk.index',compact('tidakmasuk','karyawan','row','potonggaji','potongcuti','jpg','jpc'));
            
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
