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
use App\Models\SettingOrganisasi;
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
        
        if ($role == 1 || $role == 2) {
            $karyawan = Karyawan::where('partner',Auth::user()->partner)->orderBy('nama','asc')->get();
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
                ->join('karyawan','tidakmasuk.id_pegawai','=','karyawan.id')
                ->where('karyawan.partner',Auth::user()->partner)
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
        
        if ($role == 1 || $role == 2) {
            $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
              // $nottidakmasuk = Tidakmasuk::leftJoin('setting_absensi', 'tidakmasuk.status', '=', 'setting_absensi.status_tidakmasuk')
            //                 ->leftJoin('karyawan', 'tidakmasuk.id_pegawai', '=', 'karyawan.id')
            //                 ->where('tidakmasuk.status', '=', 'tanpa keterangan')
            //                 ->select('tidakmasuk.id_pegawai as id_pegawai','karyawan.nama as nama', 'setting_absensi.jumlah_tidakmasuk as jumlah', 'setting_absensi.sanksi_tidak_masuk as sanksi', DB::raw('COUNT(tidakmasuk.id_pegawai) as total'))
            //                 ->havingRaw('COUNT(tidakmasuk.id_pegawai) = CASE WHEN setting_absensi.sanksi_tidak_masuk = "Potong Uang Transportasi" THEN ' . $pg->jumlah_tidakmasuk . ' ELSE ' . $pct->jumlah_tidakmasuk . ' END')
            //                 ->groupBy('setting_absensi.jumlah_tidakmasuk', 'setting_absensi.sanksi_tidak_masuk', 'tidakmasuk.id_pegawai')
            //                 ->get();
            //
            $pg = Settingabsensi::where('sanksi_tidak_masuk', '=', 'Potong Uang Transportasi')
                ->where('partner',Auth::user()->partner)
                ->select('jumlah_tidakmasuk','partner')
                ->first();

            if($pg)
            {
                $potongtransport = Tidakmasuk::leftJoin('setting_absensi', 'tidakmasuk.status', '=', 'setting_absensi.status_tidakmasuk')
                    ->leftJoin('karyawan', 'tidakmasuk.id_pegawai', '=', 'karyawan.id')
                    ->where('tidakmasuk.status', '=', 'tanpa keterangan')
                    ->where('karyawan.partner',Auth::user()->partner)
                    ->where('setting_absensi.partner',Auth::user()->partner)
                    ->whereMonth('tidakmasuk.tanggal', '=', Carbon::now()->month)
                    ->select('tidakmasuk.id_pegawai as id_pegawai','karyawan.nama as nama', 'setting_absensi.jumlah_tidakmasuk as jumlah', 'setting_absensi.sanksi_tidak_masuk as sanksi', DB::raw('COUNT(tidakmasuk.id_pegawai) as total'))
                    ->havingRaw('COUNT(tidakmasuk.id_pegawai) = CASE WHEN setting_absensi.sanksi_tidak_masuk = "Potong Uang Transportasi" THEN ' . $pg->jumlah_tidakmasuk . ' END')
                    ->groupBy('setting_absensi.jumlah_tidakmasuk', 'setting_absensi.sanksi_tidak_masuk', 'tidakmasuk.id_pegawai')
                    ->get();
                $jpg = $potongtransport->count();
            }else
            {
                $potongtransport = collect();
                $jpg = 0;
            }

            $pct = Settingabsensi::where('sanksi_tidak_masuk', '=', 'Potong Uang Makan')
                ->where('partner',Auth::user()->partner)
                ->select('jumlah_tidakmasuk','partner','sanksi_tidak_masuk')
                ->first();

            if($pct)
            {
                $potonguangmakan = Tidakmasuk::leftJoin('setting_absensi', 'tidakmasuk.status', '=', 'setting_absensi.status_tidakmasuk')
                    ->leftJoin('karyawan', 'tidakmasuk.id_pegawai', '=', 'karyawan.id')
                    ->where('tidakmasuk.status', '=', 'tanpa keterangan')
                    ->where('karyawan.partner',Auth::user()->partner)
                    ->where('setting_absensi.partner',$pct->partner)
                    ->whereMonth('tidakmasuk.tanggal', '=', Carbon::now()->month)
                    ->havingRaw('COUNT(tidakmasuk.id_pegawai) = CASE WHEN setting_absensi.sanksi_tidak_masuk = "Potong Uang Makan" THEN ' . $pct->jumlah_tidakmasuk . ' END')
                    ->select('tidakmasuk.id_pegawai as id_pegawai','karyawan.nama as nama','tidakmasuk.status as keterangan','setting_absensi.jumlah_tidakmasuk as jumlah', 'setting_absensi.sanksi_tidak_masuk as sanksi', DB::raw('COUNT(tidakmasuk.id_pegawai) as total'))
                    ->groupBy('setting_absensi.jumlah_tidakmasuk', 'setting_absensi.sanksi_tidak_masuk', 'tidakmasuk.id_pegawai','tidakmasuk.status')
                    ->get();

                $jpc = $potonguangmakan->count();
            }else
            {
                $potonguangmakan = collect();
                $jpc = 0;
            }

            // dd($jumter);

            return view('admin.tidakmasuk.show',compact('potongtransport','potonguangmakan','jpc','jpg','row'));
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
                ->where('karyawan.partner',Auth::user()->partner)
                ->groupBy('setting_absensi.jumlah_terlambat', 'setting_absensi.sanksi_terlambat', 'absensi.id_karyawan')
                ->get();
            $jumter = $terlambat->count();
            $telat = Absensi::leftJoin('setting_absensi', 'absensi.terlambat', '>', 'setting_absensi.toleransi_terlambat')
                ->leftJoin('karyawan', 'absensi.id_karyawan', '=', 'karyawan.id')
                ->select('absensi.id_karyawan as id_karyawan','karyawan.nama as nama', 'setting_absensi.jumlah_terlambat as jumlah', 'setting_absensi.sanksi_terlambat as sanksi', DB::raw('COUNT(absensi.id_karyawan) as total'))
                ->havingRaw('COUNT(absensi.id_karyawan) = CASE WHEN setting_absensi.sanksi_terlambat = "SP Pertama" THEN ' . $sp1->jumlah_terlambat . ' END')
                ->whereYear('absensi.tanggal', '=', Carbon::now()->subMonth()->year)->whereMonth('absensi.tanggal', '=',Carbon::now()->subMonth()->month)
                ->where('karyawan.partner',Auth::user()->partner)
                ->groupBy('setting_absensi.jumlah_terlambat', 'setting_absensi.sanksi_terlambat', 'absensi.id_karyawan')
                ->get();
            $jumtel = $telat->count();
            $datatelat = Absensi::leftJoin('setting_absensi', 'absensi.terlambat', '>', 'setting_absensi.toleransi_terlambat')
                ->leftJoin('karyawan', 'absensi.id_karyawan', '=', 'karyawan.id')
                ->select('absensi.id_karyawan as id_karyawan','karyawan.nama as nama', 'setting_absensi.jumlah_terlambat as jumlah', 'setting_absensi.sanksi_terlambat as sanksi', DB::raw('COUNT(absensi.id_karyawan) as total'))
                ->havingRaw('COUNT(absensi.id_karyawan) = CASE WHEN setting_absensi.sanksi_terlambat = "SP Pertama" THEN ' . $sp2->jumlah_terlambat . ' END')
                ->whereYear('absensi.tanggal', '=', Carbon::now()->subMonth()->year)->whereMonth('absensi.tanggal', '=',Carbon::now()->subMonth()->month)
                ->where('karyawan.partner',Auth::user()->partner)
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

    public function showTerlambat($id)
    {
        $role = Auth::user()->role;
        
        if ($role == 1) 
        {
            $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();

            $tb = Settingabsensi::where('sanksi_terlambat', '=', 'Teguran Biasa')->select('jumlah_terlambat')->first();
            $sp1a = Settingabsensi::where('sanksi_terlambat', '=', 'SP Pertama')->select('jumlah_terlambat')->first();
            $sp2a = Settingabsensi::where('sanksi_terlambat', '=', 'SP Kedua')->select('jumlah_terlambat')->first();
            $sp3a = Settingabsensi::where('sanksi_terlambat', '=', 'SP Ketiga')->select('jumlah_terlambat')->first();

            //teguran biasa
            $terlambat = Absensi::leftJoin('setting_absensi', 'absensi.terlambat', '>', 'setting_absensi.toleransi_terlambat')
                ->leftJoin('karyawan', 'absensi.id_karyawan', '=', 'karyawan.id')
                ->select('absensi.id_karyawan as id_karyawan')
                ->havingRaw('COUNT(absensi.id_karyawan) = CASE WHEN setting_absensi.sanksi_terlambat = "Teguran Biasa" THEN ' . $tb->jumlah_terlambat . ' END')
                ->whereYear('absensi.tanggal', '=', Carbon::now()->subMonth()->year)->whereMonth('absensi.tanggal', '=',Carbon::now()->subMonth()->month)
                ->groupBy('setting_absensi.jumlah_terlambat', 'setting_absensi.sanksi_terlambat', 'absensi.id_karyawan')
                ->get();
            $tel = $terlambat->count();
            $idkaryawan = null;
            if($terlambat && $tel > 0){
                foreach($terlambat as $terlambat){
                    $idkaryawan = $terlambat->id_karyawan;
                }
            }
            $teguranbiasa = Absensi::with('departemens','karyawans')
                ->where('id_karyawan','=',$idkaryawan)
                ->whereMonth('tanggal', '=',Carbon::now()->subMonth()->month)
                ->whereYear('tanggal', '=', Carbon::now()->subMonth()->year)
                ->get();

            //sp1
            $idk = null;
            $telat = Absensi::leftJoin('setting_absensi', 'absensi.terlambat', '>', 'setting_absensi.toleransi_terlambat')
                ->leftJoin('karyawan', 'absensi.id_karyawan', '=', 'karyawan.id')
                ->select('absensi.id_karyawan as id_karyawan')
                ->havingRaw('COUNT(absensi.id_karyawan) = CASE WHEN setting_absensi.sanksi_terlambat = "SP Pertama" THEN ' . $sp1a->jumlah_terlambat . ' END')
                ->whereYear('absensi.tanggal', '=', Carbon::now()->subMonth()->year)->whereMonth('absensi.tanggal', '=',Carbon::now()->subMonth()->month)
                ->groupBy('setting_absensi.jumlah_terlambat', 'setting_absensi.sanksi_terlambat', 'absensi.id_karyawan')
                ->get();
            $jumtel = $telat->count();

            if($telat && $jumtel > 0){
                foreach($telat as $tel){
                    $idk = $tel->id_karyawan;
                }
            }
            
            $sp1 = Absensi::with('departemens','karyawans')
                ->where('id_karyawan','=',$idk)
                ->whereMonth('tanggal', '=',Carbon::now()->subMonth()->month)
                ->whereYear('tanggal', '=', Carbon::now()->subMonth()->year)
                ->get();
            
            //sp2
            $idkar = null;
            $datatelat = Absensi::leftJoin('setting_absensi', 'absensi.terlambat', '>', 'setting_absensi.toleransi_terlambat')
                ->leftJoin('karyawan', 'absensi.id_karyawan', '=', 'karyawan.id')
                ->select('absensi.id_karyawan as id_karyawan')
                ->havingRaw('COUNT(absensi.id_karyawan) = CASE WHEN setting_absensi.sanksi_terlambat = "SP Pertama" THEN ' . $sp2a->jumlah_terlambat . ' END')
                ->whereYear('absensi.tanggal', '=', Carbon::now()->subMonth()->year)->whereMonth('absensi.tanggal', '=',Carbon::now()->subMonth()->month)
                ->groupBy('setting_absensi.jumlah_terlambat', 'setting_absensi.sanksi_terlambat', 'absensi.id_karyawan')
                ->get();

            $jumdat = $datatelat->count();

            if($datatelat && $jumdat > 0)
            {
                foreach($datatelat as $telat){
                    $idkar = $telat->id_karyawan;
                }
                
            }
            
            $sp2 = Absensi::with('departemens','karyawans')
                ->where('id_karyawan','=',$idkar)
                ->whereMonth('tanggal', '=',Carbon::now()->subMonth()->month)
                ->whereYear('tanggal', '=', Carbon::now()->subMonth()->year)
                ->get();

            return view('admin.absensi.showTerlambat', compact('teguranbiasa','sp1','sp2','row'));
        }else
        {
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
                ->orderBy('tanggal','desc')
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

        if ($tidakmasuk->isEmpty()) 
        {
            return redirect()->back()->with('pesa','Tidak Ada Data.');
        } else {
            $setorganisasi = SettingOrganisasi::where('partner', Auth::user()->partner)->first();
            $pdf = PDF::loadview('admin.tidakmasuk.dataTidakMasukPdf',['tidakmasuk'=>$tidakmasuk, 'idkaryawan'=>$idkaryawan,'setorganisasi'=> $setorganisasi])
            ->setPaper('a4','landscape');
            $pdfName = "Data Absensi Tidak Masuk Bulan ".$nbulan." ".$tidakmasuk->first()->nama.".pdf";
            return $pdf->stream($pdfName);
        }
        
        // if ($tidakmasuk->first()) {
        //     $pdfName = "Data Absensi Tidak Masuk Bulan ".$nbulan." ".$tidakmasuk->first()->nama.".pdf";
        // } else {
        //     $pdfName = "Data Absensi Tidak Masuk.pdf";
        // }
        // $setorganisasi = SettingOrganisasi::find(1);
        // $pdf = PDF::loadview('admin.tidakmasuk.dataTidakMasukPdf',['tidakmasuk'=>$tidakmasuk, 'idkaryawan'=>$idkaryawan,'setorganisasi'=> $setorganisasi])
        // ->setPaper('a4','landscape');

        // return $pdf->stream($pdfName);

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

        if ($data->isEmpty()) {
            // Jika $data kosong, berikan nilai default untuk $nama
            // $nama = 'Data Kosong';
            return redirect()->back()->with('pesa','Tidak ditemukan data yang sesuai filter data.');
        } else {
            // Jika $data tidak kosong, ambil nama dari elemen pertama
            $nama = $data->first()->nama;
            return Excel::download(new TidakmasukExport($data,$idkaryawan),"Data Absensi Tidak Masuk ".$data->first()->nama.".xlsx");
        }
        
    }
}
