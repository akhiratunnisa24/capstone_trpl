<?php

namespace App\Http\Controllers\admin;

use App\Models\Izin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class IzinAdminController extends Controller
{
    public function show($id)
    {
        $izin = Izin::findOrFail($id);
        $karyawan = Auth::user()->id_pegawai;
 
        return view('admin.cuti.index',compact('izin','karyawan',['type'=>2]));
    }

    public function approved(Request $request, $id)
    {
        $izin = Izin::where('id',$id)->first();
        $status = 'Disetujui';
        Izin::where('id',$id)->update([
            'status' => $status,
        ]);
        return redirect()->route('permintaancuti.index',['type'=>2]);
    }

    public function reject(Request $request, $id)
    {
        $izin = Izin::where('id',$id)->first();
        $status = 'Ditolak';
        Izin::where('id',$id)->update([
            'status' => $status,
        ]);
        return redirect()->route('permintaancuti.index',['type'=>2])->withInput();
    }
}
