<?php

namespace App\Http\Controllers\admin;

use Carbon\Carbon;
use App\Models\Karyawan;
use App\Models\Informasi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class InformasiController extends Controller
{
    public function index(Request $request)
    {
        $role = Auth::user()->role;
        if ($role == 1 || $role == 2) {

            $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
            $informasi = Informasi::where('partner', Auth::user()->partner)->orderBy('id', 'asc')->get();
            return view('admin.datamaster.informasi.index', compact('informasi', 'row'));
        } else {

            return redirect()->back();
        }
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'judul'             => 'required',
            'konten'            => 'required',
            'tanggal_aktif'     => 'required',
        ]);

        $informasi = new Informasi;
        $informasi->judul = $request->judul;
        $informasi->konten= $request->konten;
        $informasi->tanggal_aktif    = Carbon::createFromFormat('d/m/Y', $request->tanggal_aktif)->format('Y-m-d');
        $informasi->tanggal_berakhir = Carbon::createFromFormat('d/m/Y', $request->tanggal_berakhir)->format('Y-m-d');
        $informasi->partner = $request->partner;
        $informasi->save();

        return redirect()->back()->with('pesan', 'Data berhasil disimpan!');
    }

    public function update(Request $request, $id)
    {
        $informasi = Informasi::find($id);

        $informasi->judul = $request->judul;
        $informasi->konten= $request->konten;
        $informasi->tanggal_aktif    = Carbon::createFromFormat('d/m/Y', $request->tanggal_aktif)->format('Y-m-d');
        $informasi->tanggal_berakhir = Carbon::createFromFormat('d/m/Y', $request->tanggal_berakhir)->format('Y-m-d');
        // dd($informasi);
        $informasi->update();
    
        return redirect()->back()->with('pesan','Data berhasil diupdate !');
    }
    
    // public function destroy($id)
    // {
    //     $informasi = Informasi::find($id);

    //     $karyawan = Karyawan::where('jabatan', $leveljabatan->nama_level)->exists();

    //     if (!$karyawan) {
    //         $leveljabatan = LevelJabatan::find($id);
    //         $leveljabatan->delete();
    //         return redirect()->back()->with('pesan', 'Level Jabatan berhasil dihapus');
    //     } else {
    //         return redirect()->back()->with('pesa', 'Level Jabatan tidak dapat dihapus karena digunakan dalam tabel karyawan.');
    //     }

    // }
}
