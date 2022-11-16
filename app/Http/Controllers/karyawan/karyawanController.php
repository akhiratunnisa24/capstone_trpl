<?php

namespace App\Http\Controllers\karyawan;

use App\Models\Karyawan;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class karyawanController extends Controller
{
    
    public function index()
    {
        
        $karyawan = karyawan::all()->sortByDesc('created_at');
        return view('karyawan.index', compact(['karyawan']));
    }


    public function create()
    {
       //
    }


    public function store(Request $request)
    {
        Karyawan::create($request->except(['_token', 'submit']));      
        return redirect('karyawan');
    }

  
    public function show($id)
    {
        $karyawan = karyawan::find($id);
        return view ('karyawan.show',[
            'karyawan' => $karyawan,
        ]);
    }    


    public function edit()
    {
        //
    }


    public function update(Request $request, $id )
    {
        $karyawan = karyawan::find($id);
      
        $karyawan->nik = $request->nik;
        $karyawan->nama = $request->nama;
        $karyawan->tgllahir = $request->tgllahir;
        $karyawan->email = $request->email;
        $karyawan->jenis_kelamin = $request->jenis_kelamin;
        $karyawan->alamat = $request->alamat;
        $karyawan->no_hp = $request->no_hp;
        $karyawan->status_karyawan = $request->status_karyawan;
        $karyawan->tipe_karyawan = $request->tipe_karyawan;
        $karyawan->tglmasuk = $request->tglmasuk;
        $karyawan->tglkeluar = $request->tglkeluar;

        $karyawan->save();  
        return redirect('karyawan');
    }

 
    public function destroy($id)
    {
        Karyawan::destroy($id);
        return redirect('karyawan');
    }
}

