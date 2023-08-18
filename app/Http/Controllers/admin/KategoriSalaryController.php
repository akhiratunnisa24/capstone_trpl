<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class KategoriSalaryController extends Controller
{
    public function index()
    {
        return view('admin.datamaster.salary.kategori.index');
    }

}
