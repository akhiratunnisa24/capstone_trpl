<?php

namespace App\Http\Controllers\manager;

use App\Models\Cuti;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

    public function dataStaff(Request $request)
    {
        // $staff = DB::table('karyawan')
        //         ->join('departemen','karyawan.divisi','=','departemen.id')
        //         ->where('karyawan.id', Auth::user()->id_pegawai)
        //         ->first();

        // $managerdepart = Karyawan::where('jabatan','=','Manager Teknologi Informasi')->where('divisi','=',3)->first();
        // $staff = DB::table('karyawan')->whereNotIn("id",$user)->get();

        $staff= Karyawan::where('divisi','=',3)->get();

        return view('manager.staff.dataStaff', compact('staff'));
    }

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
