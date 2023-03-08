<?php

namespace App\Http\Controllers\admin;

use App\Models\Karyawan;
use App\Models\Sisacuti;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SisacutiController extends Controller
{
    public function index()
    {
        $role = Auth::user()->role;
        if ($role == 1) 
        {
            $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
            $sisacuti = Sisacuti::orderBy('id', 'asc')->get();

            return view('admin.sisacuti.index', compact('sisacuti','row'));

        } else {
    
            return redirect()->back();
        }
       
    }
    
}
