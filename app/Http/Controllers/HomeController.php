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
use Illuminate\Database\Eloquent\Builder;

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
            'email' => $data['emailKaryawan'],
            'password' => Hash::make($data['password']),
        );
        
        User::insert($data);
        return redirect('/karyawan')->with("sukses", "Berhasil di tambah");
    }

    public function index()
    {
        $role = Auth::user()->role;
        $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();

        











        // $cutiPerbulan = Cuti::where('id_jeniscuti',1)->whereMonth('tgl_mulai','12')->sum('jml_cuti');
        $cutiHariini     = Cuti::whereDay('created_at','=', Carbon::now())->sum('jml_cuti');
        $cutiPerbulan    = Cuti::whereMonth('created_at','=', Carbon::now()->month)->sum('jml_cuti');
        $cutiBulanlalu   = Cuti::whereMonth('created_at','=', Carbon::now()->subMonth()->month)->sum('jml_cuti');

        $absenHariini = Absensi::whereDay('created_at', '=', Carbon::now())->count('jam_masuk');

        $absenTerlambatHariIni = Absensi::whereDay('tanggal', '=', Carbon::now())
                        ->whereTime('jam_masuk', '>', '08:00:00')
                        ->count();
        $absenBulanini  = Absensi::whereYear('tanggal','=', Carbon::now()->year)
                        ->whereMonth('tanggal','=', Carbon::now()->month)
                        ->count('jam_masuk');
        $absenTerlambat = Absensi::whereYear('tanggal', '=', Carbon::now()->year)
                        ->whereMonth('tanggal', '=', Carbon::now()->month)
                        ->whereTime('jam_masuk', '>', '08:00:00')
                        ->count();
        $absenBulanlalu  = Absensi::whereYear('tanggal','=', Carbon::now()->subMonth()->year)
                        ->whereMonth('tanggal','=', Carbon::now()->subMonth()->month)
                        ->count('jam_masuk');
        $absenTerlambatbulanlalu = Absensi::whereYear('tanggal','=', Carbon::now()->subMonth()->year)
                        ->whereMonth('tanggal','=', Carbon::now()->subMonth()->month)
                        ->count('terlambat');
        $sudahAbsen = DB::table('users')
                        ->join('absensi', 'users.id_pegawai', '=', 'absensi.id_karyawan')
                        ->whereDay('absensi.created_at', '=', Carbon::now())
                        ->count();
        // $tidakAbsenHariIni = DB::table('users')
        //                 ->join('absensi', 'users.id_pegawai', '=', 'absensi.id_karyawan')
        //                 ->whereDay('absensi.tanggal', '!=', Carbon::now())
        //                 ->orWhereNull('absensi.tanggal')
        //                 ->count();

        //code lama
        // $time = Carbon::createFromFormat('H:i:s', '08:00:00')->format('g:iA');
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

        $getLabel = cuti::select(DB::raw("SUM(jml_cuti) as jumlah"), DB::raw("MONTHNAME(tgl_mulai) as month_name"))
                ->groupBy(DB::raw('MONTHNAME(tgl_mulai)'))
                ->pluck('jumlah', 'month_name');

        $labelBulan = $getLabel->keys();
        $data = $getLabel->values();

        // DASHBOARD KARYAWAN
        //=====================
        //absen masuk bulan lalu    
        $absenBulanlalu  = Absensi::where('id_karyawan', Auth::user()->id_pegawai)
            ->whereYear('tanggal','=', Carbon::now()->subMonth()->year)
            ->whereMonth('tanggal','=', Carbon::now()->subMonth()->month)
            ->count('jam_masuk');

        //absen terlambat bulan lalu
        $absenTerlambatbulanlalu = Absensi::where('id_karyawan', Auth::user()->id_pegawai)
            ->whereYear('tanggal','=', Carbon::now()->subMonth()->year)
            ->whereMonth('tanggal','=', Carbon::now()->subMonth()->month)
            ->count('terlambat');

        //Data alokasi cuti masing2 karyawan
        $alokasicuti = Alokasicuti::where('id_karyawan',Auth::user()->id_pegawai)->get();

        //untuk mencari sisa cuti karyawan
        $sisacuti = DB::table('alokasicuti')
            ->join('cuti','alokasicuti.id_jeniscuti','cuti.id_jeniscuti') 
            ->where('alokasicuti.id_karyawan',Auth::user()->id_pegawai)
            ->where('cuti.id_karyawan',Auth::user()->id_pegawai)
            ->where('cuti.status','=','Disetujui')
            ->selectraw('alokasicuti.durasi - cuti.jml_cuti as sisa, cuti.id_jeniscuti,cuti.jml_cuti')
            ->get();

        // Absen Terlambat Karyawan
        $absenTerlambatkaryawan = Absensi::where('id_karyawan', Auth::user()->id_pegawai)
            ->whereMonth('tanggal', '=', Carbon::now()->month)
            ->whereYear('tanggal', '=', Carbon::now()->year)
            ->count('terlambat');
        //  dd($absenTerlambatkaryawan);
        // Absen Karyawan Hari Ini
        $absenKaryawan = Absensi::where('id_karyawan',Auth::user()->id_pegawai)
            ->whereDay('created_at', '=', Carbon::now(), )
            ->count('jam_masuk');

        // Absen Tidak Masuk
        $absenTidakmasuk = Absensi::where('id_karyawan',Auth::user()->id_pegawai)
            ->whereMonth('created_at', '=', Carbon::now()->month)
            ->count('jam_masuk');
    
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
                'absenTerlambatHariIni' => $absenTerlambatHariIni,
                // 'tidakAbsenHariIni'=>  $tidakAbsenHariIni,
                //'absenTidakMasukBulanLalu' =>$absenTidakMasukBulanLalu,
            ];
            return view('dashboard', $output );

        }elseif ($role == 2){
            
            $output = [
                'row' => $row,
                'absenTerlambatkaryawan' => $absenTerlambatkaryawan,
                'absenKaryawan' => $absenKaryawan,
                'absenTidakmasuk' => $absenTidakmasuk,
                'alokasicuti' => $alokasicuti,
                'sisacuti' => $sisacuti,
                'absenBulanlalu'=> $absenBulanlalu,
                'absenTerlambatbulanlalu'=> $absenTerlambatbulanlalu,
            ];
            return view('karyawan.dashboardKaryawan', $output);
            
        }else{
                
            $output = [
                'row' => $row,
                'absenTerlambatkaryawan' => $absenTerlambatkaryawan,
                'absenKaryawan' => $absenKaryawan,
                'absenTidakmasuk' => $absenTidakmasuk,
                'alokasicuti' => $alokasicuti,
                'sisacuti' => $sisacuti,
                'absenBulanlalu'=> $absenBulanlalu,
                'absenTerlambatbulanlalu'=> $absenTerlambatbulanlalu,
            ];
            return view('karyawan.dashboardKaryawan', $output);
        }
    }
    
    public function cuti()
    {
        return view('cuti');
        
        
    }
}
