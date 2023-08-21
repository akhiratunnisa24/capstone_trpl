<?php

namespace App\Http\Controllers\admin;

use App\Models\Benefit;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class BenefitkaryawanController extends Controller
{
    public function index()
    {
        $strukturgaji = Benefit::where('partner',Auth::user()->partner);
        $detailstruktur = Detailstruktur::where('id_strukturgaji',$strukturgaji->id);
        $benefitkaryawan = 
        return view('admin.benefit.karyawan.index', compact('strukturgaji','detailstruktur'));
    }
}
