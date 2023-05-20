<?php

namespace App\Http\Controllers\admin;

use App\Models\Departemen;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class DepartemenController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        $role = Auth::user()->role;
        if ($role == 1 || $role == 2) {

            $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
            $departemen = Departemen::orderBy('id', 'asc')->get();
            return view('admin.datamaster.departemen.index', compact('departemen', 'row'));
        } else {

            return redirect()->back();
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_departemen' => 'required',
        ]);
        $departemen = new Departemen;
        $departemen->nama_departemen = $request->nama_departemen;
        $departemen->save();

        return redirect()->back()->with('pesan','Data berhasil disimpan !');
    }

    public function update(Request $request, $id)
    {
        $role = Auth::user()->role;
        if ($role == 1 || $role == 2) 
        {
            $departemen = Departemen::find($id);
            $departemen->nama_departemen = $request->nama_departemen;
            $departemen->update();

            return redirect()->back()->with('pesan','Data berhasil diupdate !');
        }else{
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        $departemen = Departemen::find($id);
    
        // Cek data ke tabel "karyawan"
        $karyawan = Karyawan::where('divisi', $departemen->id)->first();
        if ($karyawan !== null) {
            return redirect()->back()->with('pesa', 'Divisi tidak dapat dihapus karena digunakan dalam tabel karyawan.');
        } else {
            $departemen->delete();
            return redirect()->back();
        }
    }

    // public function destroy($id)
    // {
    //     $departemen = Departemen::find($id);

    //     // Cek data ke tabel "karyawan"
    //     $karyawan = Karyawan::where('divisi', $departemen->id)->first();
    //     if ($karyawan !== null) {
    //         return response()->json(['status' => 'error', 'message' => 'Divisi tidak dapat dihapus karena digunakan dalam tabel karyawan.']);
    //     } else {
    //         $departemen->delete();
    //         return response()->json(['status' => 'success', 'message' => 'Data berhasil dihapus.']);
    //     }
    // }

}
