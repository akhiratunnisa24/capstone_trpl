<?php

namespace App\Http\Controllers\admin;

use App\Models\Karyawan;
use App\Models\LevelJabatan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LeveljabatanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(Request $request)
    {
        $role = Auth::user()->role;
        if ($role == 1) {
            $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();

            $leveljabatan = LevelJabatan::all();
            // dd($leveljabatan);

            return view('admin.datamaster.leveljabatan.index', compact('leveljabatan', 'row'));
        } else {
    
            return redirect()->back();
        }
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'nama_level' => 'required',
        ]);
        $leveljabatan = new LevelJabatan;
        $leveljabatan->nama_level = $request->nama_level;
        $leveljabatan->save();
    
        return redirect('/level-jabatan')->with('pesan','Data berhasil disimpan !');
    }
    
    public function update(Request $request, $id)
    {
        $leveljabatan = LevelJabatan::find($id);
        $leveljabatan->nama_level = $request->nama_level;
        $leveljabatan->update();
    
        return redirect()->back();
    }
    
    public function destroy($id)
    {
        $leveljabatan = LevelJabatan::find($id);

        if ($leveljabatan) {
            $leveljabatan->delete();
            return redirect()->back()->with('pesan', 'Data berhasil dihapus');
        } else {
            return redirect()->back()->with('error', 'Data tidak ditemukan atau telah dihapus');
        }
    }
}
