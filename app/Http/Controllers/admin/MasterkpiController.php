<?php

namespace App\Http\Controllers\admin;

use App\Models\Masterkpi;
use App\Models\Departemen;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use Illuminate\Support\Facades\Auth;


class MasterkpiController extends Controller
{
    public function index(Request $request)
    {
        $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
        //form create jobs
        $departemen = Departemen::all();
        //index
        $job = Masterkpi::all();

        return view('admin.kpi.masterkpi.index', compact('job','departemen','row'));
    }

    public function indikator(Request $request)
    {
        return view('admin.kpi.indicator.index');
    }
    
}
