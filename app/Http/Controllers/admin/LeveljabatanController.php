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

            return redirect()->back()->with('error','Anda tidak memiliki hak akses');
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_level' => 'required',
        ]);

        $nama_level = $request->nama_level;

        // Cek apakah data level jabatan sudah ada di dalam database
        $leveljabatan = LevelJabatan::where(function ($query) use ($nama_level) {
                            $query->whereRaw('LOWER(nama_level) = ?', [strtolower($nama_level)]);
                        })->first();

        if ($leveljabatan) {
            // Jika data level jabatan sudah ada, kembalikan pesan bahwa data sudah ada
            return redirect()->back()->with('error', 'Data ' . $nama_level . ' sudah ada !');
        } else {
            // Jika data level jabatan belum ada, simpan data baru
            $leveljabatan = new LevelJabatan;
            $leveljabatan->nama_level = $nama_level;
            $leveljabatan->save();

            return redirect('/level-jabatan')->with('success', 'Data berhasil disimpan!');
        }

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

        return redirect()->back()->with('success','Data berhasil diupdate !');
    }

    public function destroy($id)
    {
        $leveljabatan = LevelJabatan::find($id);

        $karyawan = Karyawan::where('jabatan', $leveljabatan->nama_level)->exists();

        if (!$karyawan) {
            $leveljabatan = LevelJabatan::find($id);
            $leveljabatan->delete();
            return redirect()->back()->with('success', 'Level Jabatan berhasil dihapus');
        } else {
            return redirect()->back()->with('error', 'Level Jabatan tidak dapat dihapus karena digunakan dalam tabel karyawan.');
        }

    }
}
