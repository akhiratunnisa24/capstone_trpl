<?php

namespace App\Http\Controllers\admin;

use App\Models\Masterkpi;
use App\Models\Departemen;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MasterkpiController extends Controller
{
    public function index(Request $request)
    {
        //form create jobs
        $departemen = Departemen::all();
        //index
        $job = Masterkpi::all();

        return view('admin.kpi.masterkpi.index', compact('job','departemen'));
    }

    public function indikator(Request $request)
    {
        return view('admin.kpi.indicator.index');
    }
    
}
