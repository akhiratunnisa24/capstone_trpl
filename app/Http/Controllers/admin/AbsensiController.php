<?php

namespace App\Http\Controllers\admin;

use PDF;
use Carbon\Carbon;
use App\Models\Absensi;
use App\Models\Karyawan;
use App\Models\Departemen;
use Illuminate\Http\Request;
use App\Exports\AbsensiExport;
use App\Imports\AbsensiImport;
use App\Imports\AttendanceImport;
use Illuminate\Support\Facades\DB;
use App\Exports\RekapabsensiExport;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;

class AbsensiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //semua data absensi
        $absensi = Absensi::latest()->orderBy('tanggal')->get();
        return view('admin.absensi.index',compact('absensi'));
    }

    public function create()
    {
        $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
        // $absensi=Absensi::where('id_user',Auth::user()->id)
        $absensi=Absensi::where('id_karyawan',Auth::user()->id_pegawai)
        ->whereDate('tanggal', Carbon::now()->format("Y-m-d"))
        ->first();//untuk memunculkan data absen pagi dengan pengecekan tanggal

        // dd($absensi);
        $jk =  Carbon::now()->format("H:i:s");
        return view('karyawan.absensi.absensi_karyawan',compact('absensi','jk','row'));
    }

    public function store(Request $request)
    {
        $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
        //ambil data karyawan dari tabel user dan pengecekan ke tabel karyawan
        $karyawan = Auth::user()->id_pegawai;
        //$depart = Karyawan::select('divisi')->where('id','=', Auth::user()->id_pegawai)->first();
        $depart = DB::table('karyawan')->join('departemen', 'karyawan.divisi','=','departemen.id')
                  ->where('karyawan.id','=',Auth::user()->id_pegawai)->first();

        // dd($depart);

        //mencari nilai keterlambatan karyawan
        $jdm = "08:00:00";
        $jm = Carbon::now()->format("H:i:s");
        $jmas= Carbon::parse($jm);
        $tl= $jmas->diff($jdm)->format("%H:%I:%S");

        //kalau pakai button, tidak perlu adanya validasi, yg memakai validasi adalah data yg diambil dengan menggunakan form
        $absensi = New Absensi;
        $absensi->id_karyawan  = $karyawan;
        $absensi->nik          = null;
        $absensi->tanggal      = Carbon::now()->format("Y-m-d");
        $absensi->shift        = 'NORMAL';
        $absensi->jadwal_masuk = $jdm;
        $absensi->jadwal_pulang= null;
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
        $jk = Carbon::now()->format("H:i:s"); //mendapatkan jam_keluar pada saat ini
        $aw=Carbon::parse($absensi->jam_masuk);//mendapatkan data jam masuk
        $ak=Carbon::parse($jk);//mendapatkan data jam keluar yang disimpan pada variabel $jk
        $diff=$aw->diff($ak)->format("%H:%I:%S");//mencari jumlah jam kerja pegawai pada hari itu yang nantinya disimpan ke dalam database

        //mencari value apakah pegawai pulang cepat
        $jdp = "17:00:00";
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
                // ->with('success','Comment Approved');
    }

    public function exportpdf()
    {
         //export data to pdf
         $data = Absensi::get();
         $pdf = PDF::loadview('admin.absensi.absensipdf',['data',$data],compact('data'))
         ->setPaper('A4','landscape');
         return $pdf->stream('absensi_report.pdf');

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
    }

    public function exportExcel(){
        return Excel::download(new AbsensiExport, 'data_absensi.xlsx');
    }

    public function importexcel(Request $request)
    {
        // notifikasi dengan session
		// Session::flash('sukses','Data Siswa Berhasil Diimport!');
        Excel::import(new AbsensiImport, request()->file('file'));
        return redirect()->back();
       
    }

    public function importcsv(Request $request)
    {
        Excel::import(new AttendanceImport, request()->file('file'));
        return redirect()->back()->with('success','Data Imported Successfully');
    }

    public function rekapabsensi(Request $request)
    {
        $karyawan = Karyawan::all();
        $idkaryawan = $request->id_karyawan;
        // dd($idkaryawan);

        $bulan = $request->query('bulan',Carbon::now()->format('m'));
        $tahun = $request->query('tahun',Carbon::now()->format('Y'));

        // simpan session
        $request->session()->put('idkaryawan', $request->id_karyawan);
        $request->session()->put('bulan', $bulan);
        $request->session()->put('tahun', $tahun);
    
        if(isset($idkaryawan) && isset($bulan) && isset($tahun))
        {
            $absensi = Absensi::where('id_karyawan', $idkaryawan)
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal',$tahun)
            ->get();
        }else
        {
            $absensi = Absensi::all();
        }
        return view('admin.absensi.rekapabsensi', compact('absensi','karyawan'));
    }

    public function rekapabsensipdf(Request $request)
    {
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
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal',$tahun)
            ->get();
        }else{
            $data = Absensi::all();
        }

        $pdf = PDF::loadview('admin.absensi.rekapabsensipdf',['data'=>$data, 'idkaryawan'=>$idkaryawan])
        ->setPaper('a4','landscape');
        return $pdf->stream("rekap_absensi_{$idkaryawan}.pdf");
    }

    public function rekapabsensiExcel(Request $request)
    {
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
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal',$tahun)
            ->get();
            // dd($data);
        }else{
            $data = Absensi::all();
        }
        return Excel::download(new RekapabsensiExport($data,$idkaryawan),'rekap_absensi_bulanan.xlsx');
        // return Excel::download(new RekapabsensiExport(['data'=>$data, 'idkaryawan'=>$idkaryawan]),'rekap_absensi_bulanan.xlsx');
        // return Excel::download(new RekapabsensiExport($request->$idkaryawan),'rekap_absensi_bulanan.xlsx');
    }

    public function destroy($id)
    {
        //
    }
}
