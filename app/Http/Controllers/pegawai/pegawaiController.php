<?php

namespace App\Http\Controllers\pegawai;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class pegawaiController extends Controller
{
    public function index()
    {
        return view('pegawai.index');
        
        $va = $request->get('va');
    }
}
