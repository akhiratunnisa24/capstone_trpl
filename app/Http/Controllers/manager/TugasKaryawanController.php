<?php

namespace App\Http\Controllers\manager;

use App\Models\Tim;
use App\Models\Tugas;
use App\Models\Karyawan;
use App\Models\Departemen;
use App\Models\Timkaryawan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TugasKaryawanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
        $role = Auth::user()->role;  
        if($role == 3)
        {
            $tim = Tim::where('divisi',$row->divisi)->get();
            $departemen = Departemen::where('id', $row->divisi)->first();
            $tugas = Tugas::where('divisi',$row->divisi)->get();
    
            return view('manager.tugas.indextugas', compact('departemen','tugas','tim','row','role'));
        }
        else{
            return redirect()->back();
        }
    }

    public function getNik(Request $request)
    {
        try {
            $getNik = Karyawan::where('id',$request->id_karyawan)->first();
            if (!$getNik) {
                throw new \Exception('Data not found');
            }
            return response()->json($getNik, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getTim(Request $request)
    {
        try {
            $getTim = Timkaryawan::with('karyawans','departemens')->where('id_tim',$request->tim_id)->get();
            if (!$getTim) {
                throw new \Exception('Data not found');
            }
            return response()->json($getTim, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function stores(Request $request)
    {
        $request->validate([
            'id_tim' => 'required',
            'id_karyawan' => 'required',
            'divisi' => 'required',
        ]);
    
        // Melakukan pengecekan untuk memastikan data tidak terduplikasi
        $timkaryawan = Timkaryawan::firstOrNew([
            'id_tim' => $request->id_tim,
            'id_karyawan' => $request->id_karyawan,
            'divisi' => $request->divisi,
        ]);
    
        if (!$timkaryawan->exists) {
            $timkaryawan->save();
            return redirect()->back()->with('pesan', 'Data Tim berhasil ditambahkan!');
        }
    
        return redirect()->back()->with('pesa', 'Data Tim sudah ada!');
    }
    
}
