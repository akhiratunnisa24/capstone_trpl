<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
    public function index()
    {
        $role = Auth::user()->role;
        $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
        if ($role == 1){
            
            $output = [
                'row' => $row
            ];
            return view('dashboard', $output);
        }else{
            
            $output = [
                'row' => $row
            ];
            return view('karyawan.dashboardKaryawan', $output);
        }
        
        
    }
    public function cuti()
    {
        return view('cuti');
        
        
    }
}
