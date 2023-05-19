<?php

namespace App\Http\Controllers\admin;

use App\Models\Jeniscuti;
use App\Models\Jenisizin;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class JeniscutiController extends Controller
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
    
    public function index(Request $request)
    {
        $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
        $role = Auth::user()->role;        
        if ($role == 1 || $role == 2) 
        {

            $type = $request->query('type', 1);
            
            $jeniscuti = Jeniscuti::where('status','=',1)->get();
            $jenisizin = Jenisizin::all();
            return view('admin.kategori.index', compact('jeniscuti','jenisizin','type','row','role'));

        } else {
            
            return redirect()->back(); 
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis_cuti' => 'required',
            'status'     => 'required',
        ]);
        $jeniscuti = Jeniscuti::create($request->all());
        
        // dd($jeniscuti);
        return redirect()->back()->with('pesan','Data berhasil disimpan !');

    }

    public function show($id)
    {
        $jeniscuti = Jeniscuti::find($id);
        return view('admin.kategori.index',compact('jeniscuti'));
    }

    public function update(Request $request, $id)
    {
        $jeniscuti = Jeniscuti::find($id);
        $jeniscuti->update($request->all());

        return redirect()->back();
        
    }

    public function destroy($id)
    {
        $jeniscuti = Jeniscuti::find($id);
        $jeniscuti->delete();

        return redirect()->back();
    }
}
