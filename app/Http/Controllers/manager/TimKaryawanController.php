<?php

namespace App\Http\Controllers\manager;

use App\Models\Tim;
use App\Models\Karyawan;
use App\Models\Departemen;
use App\Models\Timkaryawan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TimKaryawanController extends Controller
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
    
            return view('manager.tugas.index', compact('departemen','tim','row','role'));
        }
        else{
            return redirect()->back();
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'divisi' => 'required',
            'namatim' => 'required',
            'deskripsi' => 'required',
        ]);
        $tim = new Tim;
        $tim->divisi = $request->divisi;
        $tim->namatim = $request->namatim;
        $tim->deskripsi = $request->deskripsi;

        $tim->save();
    
        return redirect()->back()->with('pesan','Data Tim berhasil ditambahkan !');

    }

    public function update(Request $request, $id)
    {
        $tim = Tim::find($id);
        $tim->update($request->all());

        return redirect()->back();
        
    }

    public function destroy($id)
    {
        $tim = Tim::find($id);
        $tim->delete();

        return redirect()->back();
    }


    //tim kontroller
    public function indexs(Request $request)
    {
        $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
        $role = Auth::user()->role;  
        if($role == 3)
        {
            $timkaryawan = Timkaryawan::where('divisi', $row->divisi)->get();
            $tim         = Tim::where('divisi', $row->divisi)->get();
            $departemen = Departemen::where('id', $row->divisi)->first();
            $karyawan   = Karyawan::where('divisi',$row->divisi)->get();
    
            return view('manager.tugas.indexs', compact('tim','departemen','timkaryawan','row','role','karyawan'));
        }
        else{
            return redirect()->back();
        }
    }

    public function getNik(Request $request)
    {
        try {
            $getNik = Karyawan::select('nip')
                ->where('id', '=', $request->id_karyawan)->first();

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
    
    
    // public function updates(Request $request, $id)
    // {
    //     $timkaryawan = Timkaryawan::find($id);
    //     $timkaryawan->update($request->all());

    //     return redirect()->back();
        
    // }

    public function destroys($id)
    {
        $timkaryawan = Timkaryawan::find($id);
        $timkaryawan->delete();

        return redirect()->back();
    }
}
