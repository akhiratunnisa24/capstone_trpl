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


    public function edit($id)
    {
        $karyawan = karyawan::findOrFail($id);

        return view('karyawan.edit')->with([
            'karyawan' => $karyawan,
        ]);
    }


    public function update(Request $request, $id )
    {
        $karyawan = karyawan::find($id);
      
        $karyawan->nip = $request->nip;
        $karyawan->nik = $request->nik;
        $karyawan->no_kk = $request->no_kk;
        $karyawan->nama = $request->nama;
        $karyawan->tgllahir = $request->tgllahir;
        $karyawan->email = $request->email;
        $karyawan->jenis_kelamin = $request->jenis_kelamin;
        $karyawan->alamat = $request->alamat;
        $karyawan->no_hp = $request->no_hp;
        $karyawan->status_karyawan = $request->status_karyawan;
        $karyawan->status_kerja = $request->status_kerja;
        $karyawan->tipe_karyawan = $request->tipe_karyawan;
        $karyawan->tglmasuk = $request->tglmasuk;
        $karyawan->no_npwp = $request->no_npwp;
        $karyawan->divisi = $request->divisi;
        $karyawan->no_rek = $request->no_rek;
        $karyawan->no_bpjs_kes = $request->no_bpjs_kes;
        $karyawan->no_bpjs_ket = $request->no_bpjs_ket;
        $karyawan->kontrak = $request->kontrak;
        $karyawan->tglkeluar = $request->tglkeluar;
        $karyawan->jabatan = $request->jabatan;
        $karyawan->gaji = $request->gaji;

        $karyawan->save();  
        return redirect('karyawan');
    }

 
    public function destroy($id)
    {
        Karyawan::destroy($id);
        return redirect('karyawan');
    }
}

