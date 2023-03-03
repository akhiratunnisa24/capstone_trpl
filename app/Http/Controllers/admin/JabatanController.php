<?php

namespace App\Http\Controllers\admin;

use App\Models\Jabatan;
use App\Models\Karyawan;
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
        if ($role == 1) {
    
            $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
            $jabatan = Jabatan::orderBy('id', 'asc')->get();
            return view('admin.datamaster.jabatan.index', compact('jabatan', 'row'));
        } else {
    
            return redirect()->back();
        }
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'nama_jabatan' => 'required',
        ]);
        $jabatan = new Jabatan;
        $jabatan->nama_jabatan = $request->nama_jabatan;
        $jabatan->save();
    
        return redirect('/jabatan');
    }
    
    public function update(Request $request, $id)
    {
        $jabatan = Jabatan::find($id);
        $jabatan->nama_jabatan = $request->nama_jabatan;
        $jabatan->update();
    
        return redirect()->back();
    }
    
    public function destroy($id)
    {
        $jabatan = Jabatan::find($id);
        $jabatan->delete();
    
        return redirect('/jabatan');
    }
    
}
