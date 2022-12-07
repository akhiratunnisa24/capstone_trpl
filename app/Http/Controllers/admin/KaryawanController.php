<?php

namespace App\Http\Controllers\admin;

use App\Models\Karyawan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class KaryawanController extends Controller
{
    public function index()
    {
        $karyawan = Karyawan::latest()->paginate(10);
        return view('admin.karyawan.index',compact('karyawan'))
        ->with('i', (request()->input('page', 1) - 1) * 5);
        
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
}


