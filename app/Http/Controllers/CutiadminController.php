<?php

namespace App\Http\Controllers;

use App\Models\Cuti;
use App\Models\Izin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CutiadminController extends Controller
{
   
    public function index(Request $request)
    {
        $type = $request->query('type', 1);
        $cuti = Cuti::latest()->paginate(10);
        $izin = Izin::latest()->paginate(10);
        return view('admin.cuti.index', compact('cuti','izin','type'));
    }

    public function show($id)
    {
        $cuti = Cuti::findOrFail($id);
        $karyawan = Auth::user()->karyawans->id;
 
        return view('admin.cuti.index',compact('cuti','karyawan'));
    }

    public function update(Request $request, $id)
    {
        $cuti = Cuti::where('id',$id)->first();
        $status = 'Disetujui';
        Cuti::where('id',$id)->update([
            'status' => $status,
        ]);
        return redirect()->back()->withInput();
    }

    public function tolak(Request $request, $id)
    {
        $cuti = Cuti::where('id',$id)->first();
        $status = 'Ditolak';
        Cuti::where('id',$id)->update([
            'status' => $status,
        ]);
        return redirect()->back()->withInput();
    }
}
