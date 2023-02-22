<?php

namespace App\Http\Controllers\manager;

use App\Models\Masterkpi;
use App\Models\Departemen;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class KpimanagerController extends Controller
{
    public function index(Request $request)
    {
        //form create jobs
        $departemen = Departemen::all();
        //index
        $master = Masterkpi::all();

        return view('manager.kpi.index', compact('master','departemen'));
    }

    public function data(Request $request)
    {
        return view('manager.kpi.datakpi');
    }

    public function show(Request $request,$id)
    {
        // $datakpi = Kpi::find($id);
        return view('manager.kpi.showdata');
    }
}
