<?php

namespace App\Http\Controllers\manager;

use App\Models\Tim;
use App\Models\Karyawan;
use App\Models\Departemen;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TugasKaryawanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
        $role = Auth::user()->role;  
        if($role == 3)
        {
            $tugas = Tim::where('divisi',$row->divisi)->get();
            $departemen = Departemen::where('id', $row->divisi)->first();
    
            return view('manager.tugas.indextugas', compact('departemen','tim','row','role'));
        }
        else{
            return redirect()->back();
        }
    }
}
