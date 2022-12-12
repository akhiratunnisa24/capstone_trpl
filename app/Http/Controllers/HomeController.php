<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Cuti;
use App\Models\Absensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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
        // $cutiPerbulan = Cuti::where('id_jeniscuti',1)->whereMonth('tgl_mulai','12')->sum('jml_cuti');
        $cutiPerbulan = Cuti::whereMonth('created_at', '=', Carbon::now()->month)->sum('jml_cuti');
        $cutiBulanlalu = Cuti::whereMonth('created_at', '=', Carbon::now()->subMonth()->month)->sum('jml_cuti');

        $absenHariini = Absensi::whereDay('created_at', '=', Carbon::now())->count('jam_masuk');
        $absenBulanlalu = Absensi::whereMonth('created_at', '=', Carbon::now()->subMonth()->month)->count('jam_masuk');

        // $time = Carbon::createFromFormat('H:i:s', '08:00:00')->format('g:iA');
        $absenTerlambat = Absensi::whereDay('created_at', '=', Carbon::now())->count('terlambat');
        // $absenTerlambat = Absensi::whereDay('created_at', '>',  $time)->count('jam_masuk');
        $absenTerlambatbulanlalu = Absensi::whereMonth('created_at', '=', Carbon::now()->subMonth()->month)->count('terlambat');

        $absenTidakmasuk = karyawan::whereDay('created_at', '=', Carbon::now())->whereNull('id_karyawan')->count('jam_masuk');

        

        if ($role == 1){
            
            $output = [
                'row' => $row,
                'cutiPerbulan'=>$cutiPerbulan,
                'cutiBulanlalu' => $cutiBulanlalu,
                'absenHariini' => $absenHariini,
                'absenBulanlalu' => $absenBulanlalu,
                'absenTerlambat' => $absenTerlambat,
                'absenTerlambatbulanlalu' => $absenTerlambatbulanlalu,
                'absenTidakmasuk' => $absenTidakmasuk


            ];
            return view('dashboard', $output);

        }else{
            
            $output = [
                'row' => $row,
            ];
            return view('karyawan.dashboardKaryawan', $output);
        }
    }
    
    public function cuti()
    {
        return view('cuti');
        
        
    }
}
