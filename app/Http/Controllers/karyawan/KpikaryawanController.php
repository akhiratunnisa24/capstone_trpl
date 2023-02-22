<?php

namespace App\Http\Controllers\karyawan;

use App\Models\Departemen;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class KpikaryawanController extends Controller
{
    public function index(Request $request)
    {
        //form create jobs
        // $departemen = Departemen::all();
        //index
        // $master = Masterkpi::all();

        return view('karyawan.kpi.index');
    }
}
