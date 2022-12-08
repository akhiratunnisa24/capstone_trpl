<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

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
        $totalCuti = Karyawan::all()->sum('cuti_tahunan');

        if ($role == 1){
            
            $output = [
                'row' => $row,
                'totalCuti' => $totalCuti
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
