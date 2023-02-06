<?php

namespace App\Http\Controllers\admin;

use App\Models\Departemen;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
        $departemen = Departemen::orderBy('id','asc')->get();
        return view('admin.departemen.index', compact('departemen'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_departemen' => 'required',
        ]);
        $departemen = New Departemen;
        $departemen->nama_departemen = $request->nama_departemen;
        $departemen->save();
        
        return redirect('/departemen');

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
