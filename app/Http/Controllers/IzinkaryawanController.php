<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Izin;
use App\Models\Jenisizin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IzinkaryawanController extends Controller
{
    public function index()
    {
        return view('karyawan.cuti.index', compact('izin','jenisizin','cuti','jeniscuti','karyawan'));
    }

    public function store(Request $request)
    {
        $karyawan = Auth::user()->karyawans->id;
        // dd($request->all());
        if($request->id_jenisizin == 1 || $request->id_jenisizin == 2)
        {
            $validate = $request->validate([
                'id_karyawan'  => 'required',
                'id_jenisizin' => 'required',
                'keperluan'    => 'required',
                'tgl_mulai'    => 'required',
                'jam_mulai'    => 'required',
                'jam_selesai'  => 'required',
            ]);
            // dd($validate);
            $izin = New Izin;
            $izin->id_karyawan = $karyawan;
            $izin->id_jenisizin= $request->id_jenisizin;
            $izin->keperluan   = $request->keperluan;
            $izin->tgl_mulai   = Carbon::parse($request->tgl_mulai)->format("Y-m-d");
            $izin->tgl_selesai = Carbon::parse($request->tgl_selesai)->format("Y-m-d") ?? NULL;
            $izin->jam_mulai   = $request->jam_mulai;
            $izin->jam_selesai = $request->jam_selesai;
            $izin->jml_hari    =  $request->jml_hari ?? NULL;

            $jammulai  = Carbon::parse($request->jam_mulai);
            $jamselesai= Carbon::parse($request->jam_selesai);
            $time_range= $jamselesai->diff($jammulai)->format("%H:%I");

            $izin->jml_jam     = $time_range;
            $izin->status      = 'Pending';
            $izin->save();

            // dd($izin);
            return redirect()->back()->withInput();

        }else{
            $validate = $request->validate([
                'id_karyawan'  => 'required',
                'id_jenisizin' => 'required',
                'keperluan'    => 'required',
                'tgl_mulai'    => 'required',
                'tgl_selesai'  => 'required',
                'jml_hari'     => 'required',
            ]);
            //  dd($validate);
    
            $izin = New Izin;
            $izin->id_karyawan = $karyawan;
            $izin->id_jenisizin= $request->id_jenisizin;
            $izin->keperluan   = $request->keperluan;
            $izin->tgl_mulai   = Carbon::parse($request->tgl_mulai)->format("Y-m-d");
            $izin->tgl_selesai = Carbon::parse($request->tgl_selesai)->format("Y-m-d");
            $izin->jam_mulai   = $request->jam_mulai ?? NULL;
            $izin->jam_selesai = $request->jam_selesai ?? NULL;
            $izin->jml_hari    = $request->jml_hari;
            $izin->jml_jam     = $request->jml_jam ?? NULL;
            $izin->status      = 'Pending';
            // dd($izin);
            $izin->save();
            
            return redirect()->back()->withInput();
        }     
    }

    public function show($id)
    {
        $izin = Izin::findOrFail($id);
        $karyawan = Auth::user()->karyawans->id;

        return view('karyawan.kategori.index',compact('cuti','karyawan'));
    }

}
