<?php

namespace App\Http\Controllers\admin;

use Carbon\Carbon;
use App\Models\Benefit;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use App\Models\Kategoribenefit;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class BenefitController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
        $role = Auth::user()->role;
        
        if ($role == 1 || $role == 6) {
            $benefit = Benefit::where('partner',Auth::user()->partner)->get();
            $kategori = Kategoribenefit::where('partner',Auth::user()->partner)->orWhere('partner',0)->get();
            return view('admin.datamaster.benefit.data.index',compact('kategori','benefit','row','role'));
        }
        else
        {
            return redirect()->back(); 
        }

    }

    public function store(Request $request)
    {
        //
    }

   
    public function show($id)
    {
        //
    }
  
    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
