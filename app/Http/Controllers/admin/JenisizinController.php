<?php

namespace App\Http\Controllers\admin;

use App\Models\Jenisizin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class JenisizinController extends Controller
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
    
    public function store(Request $request)
    {
        $request->validate([
            'jenis_izin' => 'required',
        ]);
        $jenisizin = Jenisizin::create($request->all());
        
        // dd($jenisizin);
        return redirect()->route('kategori.index', ['type'=>2]);
    }

    public function show($id)
    {
        $jenisizin = Jenisizin::find($id);
        return view('admin.kategori.index',compact('jenisizin',['type'=>2]));
    }

    public function update(Request $request, $id)
    {
        $jenisizin = Jenisizin::find($id);

        $jenisizin->jenis_izin = $request->jenis_izin;
        $jenisizin->save(); 

        return redirect()->route('kategori.index', ['type'=>2]);
    }

    public function destroy($id)
    {
        $jenisizin = Jenisizin::find($id);
        $jenisizin->delete();

        return redirect('/kategori_cuti');
    }
}
