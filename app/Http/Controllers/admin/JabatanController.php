<?php

namespace App\Http\Controllers\admin;

use App\Models\Cuti;
use App\Models\Izin;
use App\Models\Jabatan;
use App\Models\Karyawan;
use App\Models\Alokasicuti;
use App\Models\LevelJabatan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class JabatanController extends Controller
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
            $jabatan = Jabatan::orderBy('id', 'asc')->get();
            $leveljabatan = LevelJabatan::all();
            return view('admin.datamaster.jabatan.index', compact('jabatan', 'row','leveljabatan'));
        } else {
    
            return redirect()->back();
        }
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'nama_jabatan' => 'required',
        ]);

        $nama_jabatan = $request->nama_jabatan;

        $jabatan = Jabatan::where(function ($query) use ($nama_jabatan) {
            $query->whereRaw('LOWER(nama_jabatan) = ?', [strtolower($nama_jabatan)]);
        })->first();

        if ($jabatan) {
            // Jika data jabatan sudah ada, kembalikan pesan bahwa data sudah ada
            return redirect()->back()->with('pesa', 'Data ' . $nama_jabatan . ' sudah ada !');
        } else 
        {
            // Jika data jabatan belum ada, simpan data baru
            $jabatan = new Jabatan;
            $jabatan->nama_jabatan = $nama_jabatan;
            $jabatan->save();

            return redirect('/jabatan')->with('pesan', 'Data berhasil disimpan!');
        }
    }
    
    public function update(Request $request, $id)
    {
        $jabatan = Jabatan::find($id);
        $jbtnSebelum = $jabatan->nama_jabatan;

        $jabatan->nama_jabatan = $request->nama_jabatan;
        $jabatan->update();

        $jbtnSesudah = $jabatan->nama_jabatan;

        Karyawan::where('nama_jabatan',  $jbtnSebelum)
            ->update(['nama_jabatan' =>  $jbtnSesudah]);

        // Ambil data karyawan setelah pembaruan
        $karyawanSetelah = Karyawan::where('nama_jabatan', $jbtnSesudah)
            ->select('id', 'nama_jabatan')
            ->get();
        // dd($karyawanSetelah);

        foreach($karyawanSetelah as $karyawanSetelah)
        {
            Alokasicuti::where('id_karyawan', $karyawanSetelah->id)
            ->update(['jabatan' => $karyawanSetelah->nama_jabatan]);

            Cuti::where('id_karyawan', $karyawanSetelah->id)
                ->update(['jabatan' => $karyawanSetelah->nama_jabatan]);

            Izin::where('id_karyawan', $karyawanSetelah->id)
                ->update(['jabatan' => $karyawanSetelah->nama_jabatan]);
        }
        return redirect()->back()->with('pesan','Data berhasil diupdate !');
    }
    
    public function destroy($id)
    {
        $jabatan = Jabatan::find($id);
        $njabatan = $jabatan->nama_jabatan;

        // return $njabatan;

        $karyawan = Karyawan::where('nama_jabatan', $njabatan)->first();
        $alokasicuti = Alokasicuti::where('jabatan', $njabatan)->first();
        $cuti = Cuti::where('jabatan', $njabatan)->first();
        $izin = Izin::where('jabatan', $njabatan)->first();

        if ($karyawan !== null || $alokasicuti !== null || $cuti !== null || $izin !== null) {
            return redirect()->back()->with('pesa', 'Jabatan tidak dapat dihapus karena digunakan dalam tabel lainnya');
        } else {
            $jabatan->delete();
            return redirect()->back()->with('pesan', 'Jabatan berhasil dihapus');
        }
    }
    
}
