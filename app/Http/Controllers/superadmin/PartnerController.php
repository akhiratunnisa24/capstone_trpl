<?php

namespace App\Http\Controllers\superadmin;

use App\Models\Partner;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PartnerController extends Controller
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
        if (($role == 5)||$role == 7) {

            $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
            $partner = Partner::orderBy('id', 'asc')->get();
            return view('superadmin.partner.index', compact('partner', 'row'));
        } else {

            return redirect()->back()->with('error','Anda tidak memiliki hak akses');
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_partner' => 'required',
        ]);
        $nama_partner = $request->nama_partner;

        // Cek apakah data Partner sudah ada di dalam database
        $partner = Partner::where(function ($query) use ($nama_partner) {
            $query->whereRaw('LOWER(nama_partner) = ?', [strtolower($nama_partner)]);
        })->first();

        if ($partner) {
            // Jika data partner sudah ada, kembalikan pesan bahwa data sudah ada
            return redirect()->back()->with('error', 'Data Partner ' . $nama_partner . ' sudah ada !');
        } else {
            // Jika data Partner belum ada, simpan data baru
            $partner = new Partner;
            $partner->nama_partner = $nama_partner;
            $partner->save();

            return redirect()->back()->with('success', 'Data berhasil disimpan!');
        }
    }

    public function update(Request $request, $id)
    {
        $role = Auth::user()->role;
        if (($role == 5)||$role == 7)
        {
            $partner = Partner::find($id);
            $partner->nama_partner = $request->nama_partner;
            $partner->update();

            return redirect()->back()->with('success','Data berhasil diupdate !');
        }else{
            return redirect()->back()->with('error','Anda tidak memiliki hak akses');
        }
    }

    // public function destroy($id)
    // {
    //     $partner = Partner::find($id);

    //     // Cek data ke tabel "karyawan"
    //     $karyawan = Karyawan::where('Partner', $partner->id)->first();
    //     if ($karyawan !== null) {
    //         return redirect()->back()->with('error', 'Partner tidak dapat dihapus karena digunakan dalam tabel karyawan.');
    //     } else {
    //         $partner->delete();
    //         return redirect()->back()->with('success', 'Data Partner berhasil dihapus');
    //     }
    // }
}

