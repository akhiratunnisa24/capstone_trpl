<?php

namespace App\Http\Controllers\admin;

use App\Models\Jobs;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class JobsController extends Controller
{
    public function index(Request $request)
    {
        $job = Jobs::all();

        return view('admin.kpi.job.index', compact('job'));
    }
    
}
