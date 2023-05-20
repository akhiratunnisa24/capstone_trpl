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
        if ($role == 1 || $role == 2) {
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
        $levelsebelum =  $leveljabatan->nama_level;

        $leveljabatan->nama_level = $request->nama_level;
        $leveljabatan->update();

        $levelSesudah = $leveljabatan->nama_level;

        Karyawan::where('jabatan',  $levelsebelum)
            ->update(['jabatan' =>  $levelSesudah]);
    
        return redirect()->back()->with('pesan','Data berhasil diupdate !');
    }
    
    public function destroy($id)
    {
        $leveljabatan = LevelJabatan::find($id);
        $level = $leveljabatan->nama_level;

        $karyawan = Karyawan::where('jabatan', $level)->first();

        if ($leveljabatan) {
            $leveljabatan->delete();
            return redirect()->back()->with('pesan', 'Data berhasil dihapus');
        }elseif($karyawan !== null)
        {
            return redirect()->back()->with('pesa', 'Level Jabatan tidak dapat dihapus karena digunakan dalam tabel lainnya');
        }
        else {
            return redirect()->back()->with('error', 'Data tidak ditemukan atau telah dihapus');
        }
    }
}
