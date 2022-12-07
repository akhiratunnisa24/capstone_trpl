<?php

namespace App\Http\Controllers\admin;

use App\Models\Jeniscuti;
use App\Models\Jenisizin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class JeniscutiController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->query('type', 1);
        
        $jeniscuti = Jeniscuti::latest()->paginate(10);
        $jenisizin = Jenisizin::latest()->paginate(10);
        return view('admin.kategori.index', compact('jeniscuti','jenisizin','type'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis_cuti' => 'required',
        ]);
        $jeniscuti = Jeniscuti::create($request->all());
        
        // dd($jeniscuti);
        return redirect('/kategori_cuti');

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

        return redirect('/kategori_cuti');
        
    }

    public function destroy($id)
    {
        //
    }
}
