<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Cuti;
use App\Models\User;
use App\Models\Absensi;
use App\Models\Karyawan;
use App\Models\Alokasicuti;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
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

    public function registrasi(Request $data){
        $karyawan = Karyawan::where('id',$data['id_pegawai'])->first();
        $data = array(
            'role' => $data['role'],
            'id_pegawai' => $data['id_pegawai'],
            'name' => $karyawan['nama'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ); 
        User::insert($data);
        return redirect('/karyawan')->with("sukses", "Berhasil di tambah");
    }

    public function index()
    {
        $role = Auth::user()->role;
        $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();

        // Absen Terlambat Karyawan
        $absenTerlambatkaryawan = Absensi::where('id_karyawan', Auth::user()->id_pegawai, )->count('terlambat');
        // Absen Karyawan Hari Ini
        $absenKaryawan = Absensi::where('id_karyawan',Auth::user()->id_pegawai)->whereDay('created_at', '=', Carbon::now(), )->count('jam_masuk');

        // Absen Tidak Masuk
        $absenTidakmasuk = Absensi::where('id_karyawan',Auth::user()->id_pegawai)->whereMonth('created_at', '=', Carbon::now()->month)->count('jam_masuk');

        // $cutiPerbulan = Cuti::where('id_jeniscuti',1)->whereMonth('tgl_mulai','12')->sum('jml_cuti');
        $cutiHariini = Cuti::whereDay('created_at', '=', Carbon::now())->sum('jml_cuti');
        $cutiPerbulan = Cuti::whereMonth('created_at', '=', Carbon::now()->month)->sum('jml_cuti');
        $cutiBulanlalu = Cuti::whereMonth('created_at', '=', Carbon::now()->subMonth()->month)->sum('jml_cuti');

        $absenHariini = Absensi::whereDay('created_at', '=', Carbon::now())->count('jam_masuk');
        $absenBulanini = Absensi::whereMonth('created_at', '=', Carbon::now()->month)->count('jam_masuk');
        $absenBulanlalu = Absensi::whereMonth('created_at', '=', Carbon::now()->subMonth()->month)->count('jam_masuk');

        // $time = Carbon::createFromFormat('H:i:s', '08:00:00')->format('g:iA');
        $absenTerlambat = Absensi::whereDay('created_at', '=', Carbon::now())->count('terlambat');
        // $absenTerlambat = Absensi::whereDay('created_at', '>',  $time)->count('jam_masuk');
        $absenTerlambatbulanlalu = Absensi::whereMonth('created_at', '=', Carbon::now()->subMonth()->month)->count('terlambat');
        // $absenTidakmasuk = karyawan::whereDay('created_at', '=', Carbon::now())->whereNull('id_karyawan')->count('jam_masuk');

        // $label = ["Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"];
        // for($bulan=1;$bulan < 13;$bulan++){
        //     $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
        //     $chartuser     = collect(Cuti::SELECT("SELECT count('jml_cuti') AS jumlah from cuti where month(created_at)='$bulan'"))->first();
        //     $jumlah_user[] = $chartuser->jumlah;
        //     }

        
            // $users = Karyawan::select(DB::raw("COUNT(*) as count"), DB::raw("MONTHNAME(created_at) as month_name"))
            // $users = user::select(DB::raw("COUNT(*) as jumlah"), DB::raw("MONTHNAME(created_at) as month_name"))
                    // Karyawan::whereMonth('created_at', '=', Carbon::now()->month)->sum('cuti_tahunan');

                        // ->whereYear('created_at', date('Y'))
                        // ->groupBy(DB::raw('MONTHNAME(created_at)'))
                        // ->pluck('jumlah', 'month_name');

            // $labels = $users->keys();
            // $data2 = $users->values();
            // dd($data);

            $getLabel = cuti::select(DB::raw("SUM(jml_cuti) as jumlah"), DB::raw("MONTHNAME(created_at) as month_name"))
                ->groupBy(DB::raw('MONTHNAME(created_at)'))
                ->pluck('jumlah', 'month_name');

            $labelBulan = $getLabel->keys();
            $data = $getLabel->values();
// dd($data2);
            
// dd(date('d M Y', strtotime($labelBulan)));
// dd($labelBulan);    

        $alokasicuti = Alokasicuti::where('id_karyawan',Auth::user()->id_pegawai)->get();
        //sisa cuti
        // $jmlcuti    = Cuti::select('jml_cuti')->where('id_karyawan',Auth::user()->id_pegawai)->get();
        // $durasicuti = Alokasicuti::select('durasi')->where('id_karyawan',Auth::user()->id_pegawai)->get();

        $idkaryawan = Cuti::select('id_karyawan')->where('id_karyawan', Auth::user()->id_pegawai)->get();
        // $sisacuti =  DB::select('jml_cuti','durasi')->table('cuti')->join('alokasicuti')
        //             ->where('alokasicuti.id_karyawan','=',$idkaryawan);

        $sisacuti = DB::table('alokasicuti')->join('cuti', 'alokasicuti.id_karyawan', $idkaryawan) 
                    ->selectraw('alokasicuti.durasi - cuti.jml_cuti')
                    ->get(); 

        if ($role == 1){
            
            $output = [
                'row' => $row,
                'cutiPerbulan'=>$cutiPerbulan,
                'cutiHariini'=>$cutiHariini,
                'cutiBulanlalu' => $cutiBulanlalu,
                'absenHariini' => $absenHariini,
                'absenBulanini' => $absenBulanini,
                'absenBulanlalu' => $absenBulanlalu,
                'absenTerlambat' => $absenTerlambat,
                'absenTerlambatbulanlalu' => $absenTerlambatbulanlalu,
                'data' => $data,
                'labelBulan' =>$labelBulan,


            ];
            return view('dashboard', $output );

        }else{
            
            $output = [
                'row' => $row,
                'absenTerlambatkaryawan' => $absenTerlambatkaryawan,
                'absenKaryawan' => $absenKaryawan,
                'absenTidakmasuk' => $absenTidakmasuk,
                'alokasicuti' => $alokasicuti,
                'sisacuti' => $sisacuti,
            ];
            return view('karyawan.dashboardKaryawan', $output);
        }
    }
    
    public function cuti()
    {
        return view('cuti');
        
        
    }
}
