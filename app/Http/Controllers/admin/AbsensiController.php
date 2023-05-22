<?php

namespace App\Http\Controllers\admin;

use PDF;
use Carbon\Carbon;
use App\Models\Jadwal;
use App\Models\Absensi;
use App\Models\Karyawan;
use App\Models\Departemen;
use App\Models\Tidakmasuk;
use Illuminate\Http\Request;
use App\Exports\AbsensiExport;
use App\Imports\AbsensiImport;
use App\Imports\AttendanceImport;
use Illuminate\Support\Facades\DB;
use App\Exports\RekapabsensiExport;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Illuminate\Support\Facades\Validator;

class AbsensiController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
        $role = Auth::user()->role;
        
        if ($role == 1 || $role == 2 ) {
            //filter data
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
                $absensi = Absensi::with('karyawans','departemens')->where('id_karyawan', $idkaryawan)
                ->whereMonth('tanggal', $bulan)
                ->whereYear('tanggal',$tahun)
                ->get();
            }else
            {
                $absensi = Absensi::with('karyawans','departemens')
                ->orderBy('tanggal','desc')
                ->get();
            }
            return view('admin.absensi.index',compact('absensi','karyawan','row','role'));
        
            //menghapus filter data
            $request->session()->forget('id_karyawan');
            $request->session()->forget('bulan');
            $request->session()->forget('tahun');

        }elseif(($role == 1) || $role == 2)
        {
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
                $absensi = Absensi::with('karyawans','departemens')->where('id_karyawan', $idkaryawan)
                ->whereMonth('tanggal', $bulan)
                ->whereYear('tanggal',$tahun)
                ->get();
            }else
            {
                $absensi = Absensi::with('karyawans','departemens')
                ->orderBy('tanggal','desc')
                ->get();
            }
            return view('admin.absensi.index',compact('absensi','karyawan','row','role'));
        
            //menghapus filter data
            $request->session()->forget('id_karyawan');
            $request->session()->forget('bulan');
            $request->session()->forget('tahun');
        }
        else
         {
        
            return redirect()->back(); 
        }
    }

    public function create()
    {
        $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
        // $absensi=Absensi::where('id_user',Auth::user()->id)
        $absensi=Absensi::where('id_karyawan',Auth::user()->id_pegawai)
            ->whereDate('tanggal', Carbon::now()->format("Y-m-d"))
            ->first();//untuk memunculkan data absen pagi dengan pengecekan tanggal

        $jadwalkaryawan = Jadwal::join('shift','jadwal.id_shift','shift.id')
            ->where('jadwal.id_pegawai',Auth::user()->id_pegawai)
            ->whereDate('jadwal.tanggal', Carbon::now()->format("Y-m-d"))
            ->select('jadwal.*','shift.id as idshift','shift.nama_shift')
            ->first();

        $tidakmasuk=Tidakmasuk::where('id_pegawai',Auth::user()->id_pegawai)
            ->whereDate('tanggal', Carbon::now()->format("Y-m-d"))
            ->first();//untuk memunculkan data absen pagi dengan pengecekan tanggal
        $status = Tidakmasuk::where('id_pegawai', Auth::user()->id_pegawai)->first();

        // dd($status);
        // $jk =  Carbon::now()->format("H:i:s");
        return view('karyawan.absensi.absensi_karyawan',compact('absensi','row','status','jadwalkaryawan'));
    }

    public function store(Request $request)
    {
        $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
        //ambil data karyawan dari tabel user dan pengecekan ke tabel karyawan
        $karyawan = Auth::user()->id_pegawai;
        //$depart = Karyawan::select('divisi')->where('id','=', Auth::user()->id_pegawai)->first();
        $depart = DB::table('karyawan')->join('departemen', 'karyawan.divisi','=','departemen.id')
                  ->where('karyawan.id','=',Auth::user()->id_pegawai)->first();
        
        $jadwalkaryawan = Jadwal::join('shift','jadwal.id_shift','shift.id')
            ->where('jadwal.id_pegawai',Auth::user()->id_pegawai)
            ->whereDate('jadwal.tanggal', Carbon::now()->format("Y-m-d"))
            ->select('jadwal.*','shift.id as idshift','shift.nama_shift')
            ->first();

        // dd($depart);

        //mencari nilai keterlambatan karyawan
        // $jdm = '08:00:00';
        // $jdm = Carbon::createFromFormat('H:i:s', '08:00:00');
        $jdm= $jadwalkaryawan->jadwal_masuk;
        $jm = Carbon::now()->format("H:i:s");
        $jmas= Carbon::parse($jm);
        $tl= $jmas->diff($jdm)->format("%H:%I:%S");

        //kalau pakai button, tidak perlu adanya validasi, yg memakai validasi adalah data yg diambil dengan menggunakan form
        $absensi = New Absensi;
        $absensi->id_karyawan  = $karyawan;
        $absensi->nik          = null;
        $absensi->tanggal      = Carbon::now()->format("Y-m-d");
        $absensi->shift        = $jadwalkaryawan->nama_shift;
        $absensi->jadwal_masuk = $jdm;
        // $absensi->jadwal_masuk = $jadwalkaryawan->jadwal_masuk;
        $absensi->jadwal_pulang= $jadwalkaryawan->jadwal_pulang;
        $absensi->jam_masuk    = $jmas;
        $absensi->jam_keluar   = null;
        $absensi->normal       = '1';
        $absensi->riil         = '0';
        $absensi->terlambat    = $tl;
        $absensi->plg_cepat    = null;
        $absensi->absent       = null;
        $absensi->lembur       = null;
        $absensi->jml_jamkerja = null;
        $absensi->pengecualian = null;
        $absensi->hci          = 'True';
        $absensi->hco          = 'True';
        $absensi->id_departement= $depart->divisi;
        $absensi->h_normal     = 0;
        $absensi->ap           = 0;
        $absensi->hl           = 0;
        $absensi->jam_kerja    = $tl;
        $absensi->lemhanor     = 0;
        $absensi->lemakpek     = 0;
        $absensi->lemhali      = 0;

        $absensi->save();
        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        $absensi = Absensi::where('id',$id)->first(); //mendapatkan data absensi berdasarkan id masing2 user
        //mencari jumlah kehadiran
        $jadwalkaryawan = Jadwal::join('shift','jadwal.id_shift','shift.id')
            ->where('jadwal.id_pegawai',Auth::user()->id_pegawai)
            ->whereDate('jadwal.tanggal', Carbon::now()->format("Y-m-d"))
            ->select('jadwal.*','shift.id as idshift','shift.nama_shift')
            ->first();

        $jk = Carbon::now()->format("H:i:s"); //mendapatkan jam_keluar pada saat ini
        $aw=Carbon::parse($absensi->jam_masuk);//mendapatkan data jam masuk
        $ak=Carbon::parse($jk);//mendapatkan data jam keluar yang disimpan pada variabel $jk
        $diff=$aw->diff($ak)->format("%H:%I:%S");//mencari jumlah jam kerja pegawai pada hari itu yang nantinya disimpan ke dalam database

       

        //mencari value apakah pegawai pulang cepat
        // $jdp = "17:00:00";
        $jdp = $jadwalkaryawan->jadwal_pulang;
        $jdplg= Carbon::parse($jdp);
        $jp = $ak;//jadwal pulang sama nilainya dengan $ak
        $plcpt= $jdplg->diff($jp)->format("%H:%I:%S");//value untuk pulang cepat

        //update data abbsensi
        Absensi::where('id',$id)->update([
            'jadwal_pulang' => $jdp,
            'jam_keluar' => $jk,
            'jam_kerja' =>$diff,
            'plg_cepat' =>$plcpt,
        ]);

        return redirect()->back()->withInput();
    }

    // public function exportpdf()
    // {
    //      //export data to pdf
    //      $data = Absensi::get();
    //      $pdf = PDF::loadview('admin.absensi.absensipdf',['data',$data],compact('data'))
    //      ->setPaper('A4','landscape');
    //      return $pdf->stream('absensi_report.pdf');

        //mencari jumlah jam kerja harian yang ditampilkan ke dalam pdf secara manual
        //    foreach($data as $key => $value){
        //jika jam keluar isinya null atau tidak ada
        //     $data[$key]['diff'] = null;
            //jika jam_masuk dan jam_keluar ada data
        //     if($value->jam_masuk != null && $value->jam_keluar != null ){
        //         $aw=Carbon::parse($value->jam_masuk);
        //         $ak=Carbon::parse($value->jam_keluar);
        //         $diff=$aw->diff($ak)->format("%H:%I:%S");
        //         $data[$key]['diff'] = $diff;
        //     }   

    //     }
        // dd($data->toArray());
    // }

    // public function exportExcel()
    // {
    //     return Excel::download(new AbsensiExport, 'data_absensi.xlsx');
    // }

    public function importexcel(Request $request)
    {
       
        try {
            $file = $request->file('file');
            $import = new AbsensiImport();
            Excel::import($import, $file);
            
            $jumlahdatadiimport = $import->getJumlahDataDiimport();//SUDAH BENAR 12
            $jumlahdata         = $import->getJumlahData(); //SUDAH BENAR 22
            $jumlahimporttidakmasuk =$import->getDataImportTidakMasuk(); //SUDAH BENAR 1
            $datatidakbisadiimport  = $import->getDatatTidakBisaDiimport(); // 9

            $pesan = 'Jumlah Data yang berhasil diimport : ' . $jumlahdatadiimport . '\n' .
                     'Jumlah Data diimport ke Tidak Masuk: ' . $jumlahimporttidakmasuk . '\n' .
                     'Jumlah Data tidak bisa diimport    : ' . $datatidakbisadiimport . '\n' .
                     'Jumlah Data Keseluruhan            : ' . $jumlahdata;
           
            $pesan = nl2br(html_entity_decode($pesan));
            return redirect()->back()->with('pesan', $pesan);       
            //return redirect()->back()->with('pesan', nl2br('Data Absensi yang berhasil diimport: ' . $jumlahdatadiimport .'\n' . 'Data diimport ke database Tidak Masuk: ' . $jumlahimporttidakmasuk . '\n' . 'Jumlah Data tidak bisa diimport: ' . $datatidakbisadiimport . '\n'. 'Jumlah Data Keseluruhan : ' . $jumlahdata));

            //return redirect()->back()->with('pesan', 'Data Absensi yang berhasil diimport: ' . $jumlahdatadiimport .'<br>' . 'Data diimport ke database Tidak Masuk: ' . $jumlahimporttidakmasuk . '<br>' . 'Jumlah Data tidak bisa diimport: ' . $datatidakbisadiimport . '<br>'. 'Jumlah Data Keseluruhan : ' . $jumlahdata);
            
        } catch (\Throwable $th) {
            // Tangani jika terjadi kesalahan
            return redirect()->back()->with('pesa', 'Terjadi kesalahan saat mengimport data dari Excel.');
        }
    }


    public function importcsv(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:csv|max:2048'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        }

        try {
            $import = new AbsensiImport();
            Excel::import($import, $request->file('file'));

            // Gabungkan pesan-pesan dalam satu variabel
            $pesan = 'Data Imported Successfully<br>';
            $pesan .= 'Jumlah Data: ' . $import->getJumlahData() . '<br>';
            $pesan .= 'Jumlah Data Diimport: ' . $import->getJumlahDataDiimport() . '<br>';
            $pesan .= 'Data Import Tidak Masuk: ' . $import->getDataImportTidakMasuk() . '<br>';
            $pesan .= 'Data Tidak Bisa Diimport: ' . $import->getDatatTidakBisaDiimport();

            return redirect()->back()->with('pesan', $pesan);
        } catch (\Throwable $th) {
            // Tangani jika terjadi kesalahan
            return redirect()->back()->with('pesa', 'Terjadi kesalahan saat mengimport data absensi.');
        }
    }
    // public function importcsv(Request $request)
    // {
    //     Excel::import(new AttendanceImport, request()->file('file'));
    //     return redirect()->back()->with('success','Data Imported Successfully');
    // }

    public function rekapabsensipdf(Request $request)
    {
        $nbulan = $request->query('bulan',Carbon::now()->format('M Y'));

        $idkaryawan = $request->id_karyawan;
        $bulan      = $request->query('bulan',Carbon::now()->format('m'));
        $tahun      = $request->query('tahun',Carbon::now()->format('Y'));

        // simpan session
        $idkaryawan = $request->session()->get('idkaryawan');
        $bulan      = $request->session()->get('bulan');
        $tahun      = $request->session()->get('tahun');

        $namaBulan = Carbon::createFromDate(null, $bulan, null)->locale('id')->monthName;
        $nbulan    = $namaBulan . ' ' . $tahun;

        // dd($idkaryawan,$bulan,$tahun );
    
        if(isset($idkaryawan) && isset($bulan) && isset($tahun))
        {
            $data = Absensi::where('id_karyawan', $idkaryawan)
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal',$tahun)
            ->get();
        }else{
            $data = Absensi::with('departemens','karyawans')->get();
        }
        $pdf = PDF::loadview('admin.absensi.rekapabsensipdf',['data'=>$data, 'idkaryawan'=>$idkaryawan,'nbulan'=>$nbulan])
        ->setPaper('a4','landscape');
        return $pdf->stream("Rekap Absensi Bulan ".$nbulan." ".$data->first()->karyawans->nama.".pdf");
    }

    public function rekapabsensiExcel(Request $request)
    {
        $nbulan = $request->query('bulan',Carbon::now()->format('M Y'));

        $idkaryawan = $request->id_karyawan;
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
            ->get();
        }
        return Excel::download(new RekapabsensiExport($data,$idkaryawan),"Rekap Absensi Bulan ".$nbulan." ".$data->first()->karyawans->nama.".xlsx");
    }

    public function storeTidakmasuk(Request $data)
    {
        $karyawan = Karyawan::where('id', Auth::user()->id_pegawai)->first();
        $status = Tidakmasuk::where('id', Auth::user()->id_pegawai)->first();
        $depart = DB::table('karyawan')->join('departemen', 'karyawan.divisi','=','departemen.id')
                  ->where('karyawan.id','=',Auth::user()->id_pegawai)->first();
 
        $tidakmasuk = array(
            'id_pegawai' => $karyawan->id,
            'nama' => $karyawan->nama,
            'divisi' => $karyawan->divisi,
            'status' => $data->post('status'),
            'tanggal' => Carbon::now()->format("Y-m-d"),
        );

        $absensi = array(
            'id_karyawan' => $karyawan->id,
            'tanggal' => Carbon::now()->format("Y-m-d"),
            'shift' => 'NORMAL' ,
            'jadwal_masuk' => '08:00:00' ,
            'jadwal_pulang' => '17:00:00' ,
            'normal' => '1' ,
            'riil' => '0' ,
            'absent' => 'True' ,
            'hci' => 'True' ,
            'hco' => 'True' ,
            'h_normal' => 0,
            'ap' => 0,
            'hl' => 0,
            'lemhanor' => 0,
            'lemakpek' => 0,
            'lemhali' => 0,
        );
        // dd($absensi); 

        Tidakmasuk::insert($tidakmasuk);
        Absensi::insert($absensi);

        return redirect()->back();
    }

}
