<?php

namespace App\Http\Controllers\admin;

use App\Models\Benefit;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use App\Models\Kategoribenefit;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class KategoriBenefitController extends Controller
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
        if ($role == 1 || $role == 6)
        {
            $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
            $kategori = Kategoribenefit::where('partner', Auth::user()->partner)->orWhere('partner', 0)->orderBy('id', 'asc')->get();
            return view('admin.benefit.kategori.index', compact('kategori', 'row','role'));
        } elseif ($role == 5)
        {

            $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
            $kategori = Kategoribenefit::orderBy('id', 'asc')->get();
            return view('admin.benefit.kategori.index', compact('kategori', 'row','role'));
        }
        else {

            return redirect()->back()->with('error','Anda tidak memiliki hak akses');
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required',
            'kode' => 'required',
        ]);
        $nama_kategori = $request->nama_kategori;
        $partner = $request->partner;

        $benefit = Kategoribenefit::where(function ($query) use ($nama_kategori, $partner) {
            $query->whereRaw('LOWER(nama_kategori) = ?', [strtolower($nama_kategori)]);
            $query->where('partner', $partner);
        })->first();

        if ($benefit) {
            return redirect()->back()->with('error', 'Data Kategori Benefit ' . $nama_kategori . ' sudah ada !');
        } else {
            // Jika data benefit belum ada, simpan data baru
            $benefit = new Kategoribenefit;
            $benefit->nama_kategori = $nama_kategori;
            $benefit->kode          = $request->kode;
            $benefit->partner       = $partner;
            $benefit->save();

            return redirect()->back()->with('success', 'Data berhasil disimpan!');
        }
    }

    public function update(Request $request, $id)
    {
        $role = Auth::user()->role;
        if ($role == 1 || $role == 2)
        {
            $benefit = Kategoribenefit::find($id);
            $benefit->nama_kategori = $request->nama_kategori;
            $benefit->kode = $request->kode;
            $benefit->update();

            return redirect()->back()->with('success','Data berhasil diupdate !');
        }else{
            return redirect()->back()->with('error','Anda tidak memiliki hak akses');
        }
    }

    public function destroy($id)
    {
        $kbenefit = Kategoribenefit::find($id);

        // Cek data ke tabel "karyawan"
        $benefit = Benefit::where('kategori', $kbenefit->id)->first();
        if ($benefit !== null) {
            return redirect()->back()->with('error', 'Kategori Benefit tidak dapat dihapus karena digunakan dalam tabel karyawan.');
        } else
        {
            if ($benefit)
            {
                $benefit->delete();
            }
            return redirect()->back()->with('success', 'Data Kategori Benefit berhasil dihapus');
        }
    }
}
