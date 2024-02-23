<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Jeniscuti;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SetcutiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
        $role = Auth::user()->role;
        if ($role == 1 || $role == 2)
        {
            $setcuti = Jeniscuti::where('partner',Auth::user()->partner)->get();
            // dd($setcuti);
             return view('admin.kategori.settingkategori', compact('setcuti','row','role'));
        }
         else {

            return redirect()->back()->with('error','Anda tidak memiliki hak akses');;
        }

    }


    public function update(Request $request, $id)
    {
        $setcuti = Jeniscuti::findOrFail($id);

        if ($request->status == 0) {
            $setcuti->status = 0;
            $setcuti->save();
        } else {
            $setcuti->status = 1;
            $setcuti->save();
        }

        return redirect()->back()->with('success', 'Kategori Cuti diaktifkan');
    }

}
