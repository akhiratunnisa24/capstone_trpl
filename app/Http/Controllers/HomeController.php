<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Cuti;
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

        if ($role == 1){
            
            $output = [
                'row' => $row,
                'cutiPerbulan'=>$cutiPerbulan,
                'cutiBulanlalu' => $cutiBulanlalu

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
