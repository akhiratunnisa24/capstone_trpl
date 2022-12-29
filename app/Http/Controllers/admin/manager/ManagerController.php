<?php

namespace App\Http\Controllers\manager;

use App\Models\Cuti;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ManagerController extends Controller
{
    // public function index(Request $request)
    // {
    //     $type = $request->query('type', 1);
    //     $cuti = Cuti::latest()->paginate(10);
        
    //     return view('manager.cuti.index', compact('cuti','izin','type'));
    // }

    // public function show($id)
    // {
    //     $cuti = Cuti::findOrFail($id);
    //     $karyawan = Auth::user()->id_pegawai;
 
    //     return view('manager.cuti.index',compact('cuti','karyawan'));
    // }

    public function cutiapproved(Request $request, $id)
    {
        $cuti = Cuti::where('id',$id)->first();
        $status = 'Disetujui Manager';
        Cuti::where('id',$id)->update([
            'status' => $status,
        ]);
        return redirect()->back()->withInput();
    }
}
