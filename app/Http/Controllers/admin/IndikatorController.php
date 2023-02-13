<?php

namespace App\Http\Controllers\admin;

use App\Models\Indicatorkpi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndikatorController extends Controller
{
    public function index(Request $request)
    {
        $kpi = Indicatorkpi::all();

        return view('admin.kpi.indicator.index', compact('job'));
    }
}
