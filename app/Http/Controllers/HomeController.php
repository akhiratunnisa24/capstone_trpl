<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Cuti;
use App\Models\User;
use App\Models\Absensi;
use App\Models\Izin;
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

    public function registrasi(Request $data)
    {
        $karyawan = Karyawan::where('id', $data['id_pegawai'])->first();
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

        // Absen Terlambat Karyawan
        $absenTerlambatkaryawan = Absensi::where('id_karyawan', Auth::user()->id_pegawai,)->count('terlambat');
        // Absen Karyawan Hari Ini
        $absenKaryawan = Absensi::where('id_karyawan', Auth::user()->id_pegawai)->whereDay('created_at', '=', Carbon::now(),)->count('jam_masuk');

        // Absen Tidak Masuk
        $absenTidakmasuk = Absensi::where('id_karyawan', Auth::user()->id_pegawai)->whereMonth('created_at', '=', Carbon::now()->month)->count('jam_masuk');

        // Data Cuti dan Izin Hari ini 
        $dataIzinHariini = Izin::whereYear('created_at', '=', Carbon::now()->year)
            ->whereMonth('created_at', '=', Carbon::now()->month)
            ->whereDay('created_at', '=', Carbon::now())->count('jml_hari');
        $cutiHariini     = Cuti::whereYear('created_at', '=', Carbon::now()->year)
            ->whereMonth('created_at', '=', Carbon::now()->month)
            ->whereDay('created_at', '=', Carbon::now())->count('jml_cuti');
             // Total
        $cutidanizin     = $dataIzinHariini + $cutiHariini;
        // Data Cuti dan Izin Bulan ini 
        $dataIzinPerbulan   = Izin::whereYear('created_at', '=', Carbon::now()->year)
            ->whereMonth('created_at', '=', Carbon::now()->month)
            ->count('jml_hari');
        $cutiPerbulan       = Cuti::whereYear('created_at', '=', Carbon::now()->year)
            ->whereMonth('created_at', '=', Carbon::now()->month)
            ->count('jml_cuti');
             // Total
        $cutidanizinPerbulan    = $dataIzinPerbulan + $cutiPerbulan;
        // Data Cuti dan Izin Bulan Lalu
        $dataIzinbulanlalu   = Izin::whereYear('created_at', '=', Carbon::now()->year)
            ->whereMonth('created_at', '=', Carbon::now()->subMonth()->month)
            ->count('jml_hari');
        $cutibulanlalu       = Cuti::whereYear('created_at', '=', Carbon::now()->year)
            ->whereMonth('created_at', '=', Carbon::now()->subMonth()->month)
            ->count('jml_cuti');
            // Total
        $cutidanizibulanlalu    = $dataIzinbulanlalu + $cutibulanlalu;

        // Absen Hari Ini
        $absenHariini = Absensi::whereYear('tanggal', '=', Carbon::now()->year)
            ->whereMonth('tanggal', '=', Carbon::now()->month)
            ->whereDay('created_at', '=', Carbon::now())->count('jam_masuk');
        // Absen Bulan Ini
        $absenBulanini  = Absensi::whereYear('tanggal', '=', Carbon::now()->year)
            ->whereMonth('tanggal', '=', Carbon::now()->month)
            ->count('jam_masuk');
        // Absen Bulan Lalu
        $absenBulanlalu  = Absensi::whereYear('tanggal', '=', Carbon::now()->subMonth()->year)
        ->whereMonth('tanggal', '=', Carbon::now()->subMonth()->month)
        ->count('jam_masuk');

        // Absen Terlambat Hari Ini
        $absenTerlambatHariIni = Absensi::whereYear('tanggal', '=', Carbon::now()->year)
            ->whereMonth('tanggal', '=', Carbon::now()->month)
            ->whereDay('tanggal', '=', Carbon::now())
            ->whereTime('jam_masuk', '>', '08:00:00')
            ->count();
            // Absen Terlambat Bulan Ini
        $absenTerlambat = Absensi::whereYear('tanggal', '=', Carbon::now()->year)
            ->whereMonth('tanggal', '=', Carbon::now()->month)
            ->whereTime('jam_masuk', '>', '08:00:00')
            ->count();
            // Absen Terlambat Bulan Lalu
        $absenTerlambatbulanlalu = Absensi::whereYear('tanggal', '=', Carbon::now()->subMonth()->year)
            ->whereMonth('tanggal', '=', Carbon::now()->subMonth()->month)
            ->count('terlambat');

            // DATA KARYAWAN TIDAK MASUK

        //ambil jumlah Karyawan       
        $totalKaryawan = karyawan::count('id');

        // ambil jumlah karyawan yang sudah absen
        $totalabsen = DB::table('absensi')
                    ->whereYear('tanggal', '=', Carbon::now()->year)
                    ->whereMonth('tanggal', '=', Carbon::now()->month)
                    ->whereDay('tanggal', '=', Carbon::now())
                    ->count('id_karyawan');

        // jumlah karyawan yang belum absen / tidak masuk
        $totalTidakAbsenHariIni = $totalKaryawan - $totalabsen ;
        // dd($totalTidakAbsenHariIni);


        //ambil jumlah Karyawan absen tidak masuk perbulan     
        $totalKaryawanabsenperbulan = karyawan::pluck('id');

        // ambil jumlah karyawan yang sudah absen
        $totalabsenperbulan = DB::table('absensi')
                    ->whereYear('tanggal', '=', Carbon::now()->year)
                    ->whereMonth('tanggal', '=', Carbon::now()->month)    
                    // ->whereDay('created_at', '=', Carbon::now())    
                    ->whereNotIn("id_karyawan", $totalKaryawanabsenperbulan)
                    ->get();

        // DB::table(..)->select(..)->whereNotIn('book_price', [100,200])->get();

   



        $today =Carbon::now(); //Current Date and Time
        $firstDayofMonth = Carbon::parse($today)->firstOfMonth();
        $lastDayofMonth = Carbon::parse($today)->endOfMonth();

        $to = Carbon::parse($today);
        $weekDay = $firstDayofMonth->diffInWeekdays($to);
        //ambil jumlah Karyawan       
        $totalKaryawanPerbulan = $totalKaryawan * $weekDay ;
        // dd($totalKaryawanPerbulan);

        // ambil jumlah karyawan yang sudah absen
        $totalabsenPerbulan = DB::table('absensi')
                    ->whereYear('tanggal', '=', Carbon::now()->year)
                    ->whereMonth('tanggal', '=', Carbon::now()->month)
                    ->count('id_karyawan');

        // jumlah karyawan yang belum absen / tidak masuk
        $totalTidakAbsenPerbulan = $totalKaryawanPerbulan - $totalabsenPerbulan ;
        

        // $totalKaryawanabsenperbulan = Absensi::whereYear('tanggal', '=', Carbon::now()->year)
        // ->whereMonth('tanggal', '=', Carbon::now()->month)
        // ->whereDay('tanggal', '=', Carbon::now()->day)
        // ->pluck('id_karyawan')->implode(',');
        
        // $user_info = DB::table('usermetas')
        //          ->select('browser', DB::raw('count(*) as total'))
        //          ->groupBy('browser')
        //          ->get();

        //15,20,6,15,6,20,6

        // $totalabsenperbulan = DB::table('karyawan')
        // ->whereYear('created_at', '=', Carbon::now()->year)
        // ->whereMonth('created_at', '=', Carbon::now()->month)
        // // ->whereDay('created_at', '=', Carbon::now()->day)
        // ->select('id')
        // ->whereNotIn('id',[$totalKaryawanabsenperbulan])
        // ->count();

        // dd($totalabsenperbulan); 






        //     // Belum / Tidak Masuk Hari Ini
        // $tidakMasukHariIni = Absensi::whereYear('tanggal', '=', Carbon::now()->year)
        // ->whereMonth('tanggal', '=', Carbon::now()->month)
        // ->whereDay('tanggal', '=', Carbon::now())
        // ->whereTime('jam_masuk', '>', '08:00:00')
        // ->count();

        // $sudahAbsen = DB::table('users')
        //     ->join('absensi', 'users.id_pegawai', '=', 'absensi.id_karyawan')
        //     ->whereDay('absensi.created_at', '=', Carbon::now())
        //     ->count();

        $getLabel = cuti::select(DB::raw("SUM(jml_cuti) as jumlah"), DB::raw("MONTHNAME(tgl_mulai) as month_name"))
            ->whereYear('created_at', '=', Carbon::now()->year)
            ->where('status','=','Disetujui')
            ->groupBy(DB::raw('MONTHNAME(tgl_mulai)'))
            ->orderByDesc('month_name')
            ->pluck('jumlah', 'month_name');

        $getYear = cuti::select(DB::raw("SUM(jml_cuti) as jumlah"), DB::raw("YEAR(tgl_mulai) as month_name"))
            ->whereYear('created_at', '=', Carbon::now()->year)
            ->orderBy('tgl_mulai')
            ->pluck('jumlah', 'month_name');



        $labelBulan = $getLabel->keys();    
        $labelTahun = $getYear->keys();    
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
                'cutiPerbulan' => $cutiPerbulan,
                'cutiHariini' => $cutiHariini,
                'absenHariini' => $absenHariini,
                'absenBulanini' => $absenBulanini,
                'absenBulanlalu' => $absenBulanlalu,
                'absenTerlambat' => $absenTerlambat,
                'absenTerlambatbulanlalu' => $absenTerlambatbulanlalu,
                'data' => $data,
                'labelBulan' => $labelBulan,
                'absenTerlambatHariIni' => $absenTerlambatHariIni,
                'dataIzinHariini' => $dataIzinHariini,
                'cutidanizin' => $cutidanizin,
                'dataIzinPerbulan' => $dataIzinPerbulan,
                'cutidanizinPerbulan' => $cutidanizinPerbulan,
                'dataIzinbulanlalu' => $dataIzinbulanlalu,
                'cutibulanlalu' => $cutibulanlalu,
                'cutidanizibulanlalu' => $cutidanizibulanlalu,
                'labelTahun' => $labelTahun,
                'totalTidakAbsenHariIni' => $totalTidakAbsenHariIni,
                'totalTidakAbsenPerbulan' => $totalTidakAbsenPerbulan,

            ];
            return view('dashboard', $output);
        } elseif ($role == 2) {

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
        } else {

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
