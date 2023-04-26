<?php

namespace App\Http\Controllers\admin;

use PDF;
use Exception;
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
        $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
        
        if ($role == 1 || $role == 2 && $row->jabatan = "Asisten Manajer") {
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

            return view('admin.tidakmasuk.index',compact('tidakmasuk','karyawan','row','role'));
            
            //menghapus filter data
            $request->session()->forget('id_karyawan');
            $request->session()->forget('bulan');
            $request->session()->forget('tahun');
        } 
        else {
        
            return redirect()->back(); 
        }
    }

    public function tampil(Request $request)
    {
        $role = Auth::user()->role;
        
        if ($role == 1) {
            $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
              // $nottidakmasuk = Tidakmasuk::leftJoin('setting_absensi', 'tidakmasuk.status', '=', 'setting_absensi.status_tidakmasuk')
            //                 ->leftJoin('karyawan', 'tidakmasuk.id_pegawai', '=', 'karyawan.id')
            //                 ->where('tidakmasuk.status', '=', 'tanpa keterangan')
            //                 ->select('tidakmasuk.id_pegawai as id_pegawai','karyawan.nama as nama', 'setting_absensi.jumlah_tidakmasuk as jumlah', 'setting_absensi.sanksi_tidak_masuk as sanksi', DB::raw('COUNT(tidakmasuk.id_pegawai) as total'))
            //                 ->havingRaw('COUNT(tidakmasuk.id_pegawai) = CASE WHEN setting_absensi.sanksi_tidak_masuk = "Potong Uang Transportasi" THEN ' . $pg->jumlah_tidakmasuk . ' ELSE ' . $pct->jumlah_tidakmasuk . ' END')
            //                 ->groupBy('setting_absensi.jumlah_tidakmasuk', 'setting_absensi.sanksi_tidak_masuk', 'tidakmasuk.id_pegawai')
            //                 ->get();
            //
            $pg = Settingabsensi::where('sanksi_tidak_masuk', '=', 'Potong Uang Transportasi')->select('jumlah_tidakmasuk')->first();
            $pct = Settingabsensi::where('sanksi_tidak_masuk', '=', 'Potong Uang Makan')->select('jumlah_tidakmasuk')->first();

            $potongtransport = Tidakmasuk::leftJoin('setting_absensi', 'tidakmasuk.status', '=', 'setting_absensi.status_tidakmasuk')
                ->leftJoin('karyawan', 'tidakmasuk.id_pegawai', '=', 'karyawan.id')
                ->where('tidakmasuk.status', '=', 'tanpa keterangan')
                ->select('tidakmasuk.id_pegawai as id_pegawai','karyawan.nama as nama', 'setting_absensi.jumlah_tidakmasuk as jumlah', 'setting_absensi.sanksi_tidak_masuk as sanksi', DB::raw('COUNT(tidakmasuk.id_pegawai) as total'))
                ->havingRaw('COUNT(tidakmasuk.id_pegawai) = CASE WHEN setting_absensi.sanksi_tidak_masuk = "Potong Uang Transportasi" THEN ' . $pg->jumlah_tidakmasuk . ' END')
                ->groupBy('setting_absensi.jumlah_tidakmasuk', 'setting_absensi.sanksi_tidak_masuk', 'tidakmasuk.id_pegawai')
                ->get();
            $jpg = $potongtransport->count();

            $potonguangmakan = Tidakmasuk::leftJoin('setting_absensi', 'tidakmasuk.status', '=', 'setting_absensi.status_tidakmasuk')
                ->leftJoin('karyawan', 'tidakmasuk.id_pegawai', '=', 'karyawan.id')
                ->where('tidakmasuk.status', '=', 'tanpa keterangan')
                ->select('tidakmasuk.id_pegawai as id_pegawai','karyawan.nama as nama','tidakmasuk.status as keterangan','setting_absensi.jumlah_tidakmasuk as jumlah', 'setting_absensi.sanksi_tidak_masuk as sanksi', DB::raw('COUNT(tidakmasuk.id_pegawai) as total'))
                ->havingRaw('COUNT(tidakmasuk.id_pegawai) = CASE WHEN setting_absensi.sanksi_tidak_masuk = "Potong Uang Makan" THEN ' . $pct->jumlah_tidakmasuk . ' END')
                ->groupBy('setting_absensi.jumlah_tidakmasuk', 'setting_absensi.sanksi_tidak_masuk', 'tidakmasuk.id_pegawai','tidakmasuk.status')
                ->get();
            $jpc = $potonguangmakan->count();

    
            //data karyawan terlambat
            $tb = Settingabsensi::where('sanksi_terlambat', '=', 'Teguran Biasa')->select('jumlah_terlambat')->first();
            $sp1 = Settingabsensi::where('sanksi_terlambat', '=', 'SP Pertama')->select('jumlah_terlambat')->first();
            $sp2 = Settingabsensi::where('sanksi_terlambat', '=', 'SP Kedua')->select('jumlah_terlambat')->first();
            $sp3 = Settingabsensi::where('sanksi_terlambat', '=', 'SP Ketiga')->select('jumlah_terlambat')->first();
            $terlambat = Absensi::leftJoin('setting_absensi', 'absensi.terlambat', '>', 'setting_absensi.toleransi_terlambat')
                ->leftJoin('karyawan', 'absensi.id_karyawan', '=', 'karyawan.id')
                ->select('absensi.id_karyawan as id_karyawan','karyawan.nama as nama', 'setting_absensi.jumlah_terlambat as jumlah', 'setting_absensi.sanksi_terlambat as sanksi', DB::raw('COUNT(absensi.id_karyawan) as total'))
                ->havingRaw('COUNT(absensi.id_karyawan) = CASE WHEN setting_absensi.sanksi_terlambat = "Teguran Biasa" THEN ' . $tb->jumlah_terlambat . ' END')
                ->whereYear('absensi.tanggal', '=', Carbon::now()->subMonth()->year)->whereMonth('absensi.tanggal', '=',Carbon::now()->subMonth()->month)
                ->groupBy('setting_absensi.jumlah_terlambat', 'setting_absensi.sanksi_terlambat', 'absensi.id_karyawan')
                ->get();
            $jumter = $terlambat->count();
            $telat = Absensi::leftJoin('setting_absensi', 'absensi.terlambat', '>', 'setting_absensi.toleransi_terlambat')
                ->leftJoin('karyawan', 'absensi.id_karyawan', '=', 'karyawan.id')
                ->select('absensi.id_karyawan as id_karyawan','karyawan.nama as nama', 'setting_absensi.jumlah_terlambat as jumlah', 'setting_absensi.sanksi_terlambat as sanksi', DB::raw('COUNT(absensi.id_karyawan) as total'))
                ->havingRaw('COUNT(absensi.id_karyawan) = CASE WHEN setting_absensi.sanksi_terlambat = "SP Pertama" THEN ' . $sp1->jumlah_terlambat . ' END')
                ->whereYear('absensi.tanggal', '=', Carbon::now()->subMonth()->year)->whereMonth('absensi.tanggal', '=',Carbon::now()->subMonth()->month)
                ->groupBy('setting_absensi.jumlah_terlambat', 'setting_absensi.sanksi_terlambat', 'absensi.id_karyawan')
                ->get();
            $jumtel = $telat->count();
            $datatelat = Absensi::leftJoin('setting_absensi', 'absensi.terlambat', '>', 'setting_absensi.toleransi_terlambat')
                ->leftJoin('karyawan', 'absensi.id_karyawan', '=', 'karyawan.id')
                ->select('absensi.id_karyawan as id_karyawan','karyawan.nama as nama', 'setting_absensi.jumlah_terlambat as jumlah', 'setting_absensi.sanksi_terlambat as sanksi', DB::raw('COUNT(absensi.id_karyawan) as total'))
                ->havingRaw('COUNT(absensi.id_karyawan) = CASE WHEN setting_absensi.sanksi_terlambat = "SP Pertama" THEN ' . $sp2->jumlah_terlambat . ' END')
                ->whereYear('absensi.tanggal', '=', Carbon::now()->subMonth()->year)->whereMonth('absensi.tanggal', '=',Carbon::now()->subMonth()->month)
                ->groupBy('setting_absensi.jumlah_terlambat', 'setting_absensi.sanksi_terlambat', 'absensi.id_karyawan')
                ->get();
            $jumdat = $datatelat->count();

            // dd($jumter);

            return view('admin.tidakmasuk.show',compact('potongtransport','potonguangmakan','jpc','jpg','terlambat','telat','datatelat','jumdat','jumter','jumtel','row'));
        }
        else{
            return redirect()->back();
        }
    }

    public function tampilTerlambat(Request $request)
    {
        $role = Auth::user()->role;
        
        if ($role == 1) {
            $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();

            $tb = Settingabsensi::where('sanksi_terlambat', '=', 'Teguran Biasa')->select('jumlah_terlambat')->first();
            $sp1 = Settingabsensi::where('sanksi_terlambat', '=', 'SP Pertama')->select('jumlah_terlambat')->first();
            $sp2 = Settingabsensi::where('sanksi_terlambat', '=', 'SP Kedua')->select('jumlah_terlambat')->first();
            $sp3 = Settingabsensi::where('sanksi_terlambat', '=', 'SP Ketiga')->select('jumlah_terlambat')->first();
            $terlambat = Absensi::leftJoin('setting_absensi', 'absensi.terlambat', '>', 'setting_absensi.toleransi_terlambat')
                ->leftJoin('karyawan', 'absensi.id_karyawan', '=', 'karyawan.id')
                ->select('absensi.id_karyawan as id_karyawan','karyawan.nama as nama', 'setting_absensi.jumlah_terlambat as jumlah', 'setting_absensi.sanksi_terlambat as sanksi', DB::raw('COUNT(absensi.id_karyawan) as total'))
                ->havingRaw('COUNT(absensi.id_karyawan) = CASE WHEN setting_absensi.sanksi_terlambat = "Teguran Biasa" THEN ' . $tb->jumlah_terlambat . ' END')
                ->whereYear('absensi.tanggal', '=', Carbon::now()->subMonth()->year)->whereMonth('absensi.tanggal', '=',Carbon::now()->subMonth()->month)
                ->groupBy('setting_absensi.jumlah_terlambat', 'setting_absensi.sanksi_terlambat', 'absensi.id_karyawan')
                ->get();
            $jumter = $terlambat->count();
            $telat = Absensi::leftJoin('setting_absensi', 'absensi.terlambat', '>', 'setting_absensi.toleransi_terlambat')
                ->leftJoin('karyawan', 'absensi.id_karyawan', '=', 'karyawan.id')
                ->select('absensi.id_karyawan as id_karyawan','karyawan.nama as nama', 'setting_absensi.jumlah_terlambat as jumlah', 'setting_absensi.sanksi_terlambat as sanksi', DB::raw('COUNT(absensi.id_karyawan) as total'))
                ->havingRaw('COUNT(absensi.id_karyawan) = CASE WHEN setting_absensi.sanksi_terlambat = "SP Pertama" THEN ' . $sp1->jumlah_terlambat . ' END')
                ->whereYear('absensi.tanggal', '=', Carbon::now()->subMonth()->year)->whereMonth('absensi.tanggal', '=',Carbon::now()->subMonth()->month)
                ->groupBy('setting_absensi.jumlah_terlambat', 'setting_absensi.sanksi_terlambat', 'absensi.id_karyawan')
                ->get();
            $jumtel = $telat->count();
            $datatelat = Absensi::leftJoin('setting_absensi', 'absensi.terlambat', '>', 'setting_absensi.toleransi_terlambat')
                ->leftJoin('karyawan', 'absensi.id_karyawan', '=', 'karyawan.id')
                ->select('absensi.id_karyawan as id_karyawan','karyawan.nama as nama', 'setting_absensi.jumlah_terlambat as jumlah', 'setting_absensi.sanksi_terlambat as sanksi', DB::raw('COUNT(absensi.id_karyawan) as total'))
                ->havingRaw('COUNT(absensi.id_karyawan) = CASE WHEN setting_absensi.sanksi_terlambat = "SP Pertama" THEN ' . $sp2->jumlah_terlambat . ' END')
                ->whereYear('absensi.tanggal', '=', Carbon::now()->subMonth()->year)->whereMonth('absensi.tanggal', '=',Carbon::now()->subMonth()->month)
                ->groupBy('setting_absensi.jumlah_terlambat', 'setting_absensi.sanksi_terlambat', 'absensi.id_karyawan')
                ->get();
            $jumdat = $datatelat->count();

            // dd($jumter);

            return view('admin.tidakmasuk.showterlambat',compact('terlambat','telat','datatelat','jumdat','jumter','jumtel','row'));
        }
        else{
            return redirect()->back();
        }
    }

    public function show($id)
    {
        $role = Auth::user()->role;
        
        if ($role == 1) 
        {
            $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
            $tidakmasuk = Tidakmasuk::with('departemen')
                ->where('tidakmasuk.id_pegawai',$id)
                ->where('tidakmasuk.status','=','tanpa keterangan')
                ->orderBy('id_pegawai','desc')
                ->get();

            // $tb = Settingabsensi::where('sanksi_terlambat', '=', 'Teguran Biasa')->select('jumlah_terlambat')->first();
            // $sp1 = Settingabsensi::where('sanksi_terlambat', '=', 'SP Pertama')->select('jumlah_terlambat')->first();
            // $sp2 = Settingabsensi::where('sanksi_terlambat', '=', 'SP Kedua')->select('jumlah_terlambat')->first();
            // $sp3 = Settingabsensi::where('sanksi_terlambat', '=', 'SP Ketiga')->select('jumlah_terlambat')->first();

            // $absensi = Absensi::leftJoin('setting_absensi', 'absensi.terlambat', '>', 'setting_absensi.toleransi_terlambat')
            //     ->leftJoin('karyawan', 'absensi.id_karyawan', '=', 'karyawan.id')
            //     ->select('absensi.id_karyawan as id_karyawan', 'absensi.tanggal as tanggal','absensi.terlambat as terlambat','karyawan.nama as nama')
            //     ->where('absensi.id_karyawan',$id)
            //     ->whereYear('absensi.tanggal', '=', Carbon::now()->subMonth()->year)
            //     ->whereMonth('absensi.tanggal', '=', Carbon::now()->subMonth()->month)
            //     ->get();
        
            $absensi = Absensi::leftJoin('setting_absensi', 'absensi.terlambat', '>', 'setting_absensi.toleransi_terlambat')
                ->leftJoin('karyawan', 'absensi.id_karyawan', '=', 'karyawan.id')
                ->select('absensi.id_karyawan as id_karyawan', 'absensi.tanggal as tanggal','absensi.terlambat as terlambat','karyawan.nama as nama')
                ->where('absensi.id_karyawan',$id)
                ->whereYear('absensi.tanggal', '=', Carbon::now()->subMonth()->year)
                ->whereMonth('absensi.tanggal', '=', Carbon::now()->subMonth()->month)
                ->whereRaw('WEEKDAY(absensi.tanggal) = 0')
                ->get();


            return view('admin.tidakmasuk.showpotongcuti', compact('tidakmasuk','absensi','row'));
        }
        else{
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
