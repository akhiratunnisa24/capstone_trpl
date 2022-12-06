<?php

namespace App\Http\Controllers\alokasi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AlokasicutiController extends Controller
{
    public function index()
    {
        return view('admin.settingcuti.alokasi_index');
    }
}
