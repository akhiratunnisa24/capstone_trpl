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

        return redirect('/departemen')->with('pesan','Data berhasil disimpan !');
    }

    public function update(Request $request, $id)
    {
        $departemen = Departemen::find($id);
        $departemen->nama_departemen = $request->nama_departemen;
        $departemen->update();

        return redirect()->back();
    }

    public function destroy($id)
    {
        $departemen = Departemen::find($id);
        $departemen->delete();

        return redirect('/departemen');
    }
}
