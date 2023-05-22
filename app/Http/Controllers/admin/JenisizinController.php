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
            'code' => 'required',
        ]);
        $jenisizin = $request->jenis_izin;
        $jenisizin = Jenisizin::whereRaw('LOWER(jenis_izin) = ?', [strtolower($jenisizin)])->first();

        if ($jenisizin) {
            // Jika data jenis izin sudah ada, kembalikan pesan bahwa data sudah ada
            return redirect()->route('kategori.index', ['type'=>2])->with('pesa','Data sudah ada !');
        } else {
            // Jika data jenis izin belum ada, simpan data baru
            $jenisizin= Jenisizin::create($request->all());

            return redirect()->route('kategori.index', ['type'=>2])->with('pesan','Data berhasil disimpan !');
        }
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
        $jenisizin->code = $request->code;
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
