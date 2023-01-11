<?php

namespace App\Http\Controllers\karyawan;

use App\Models\Absensi;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AbsensiKaryawanController extends Controller
{
    public function index()
    {
        $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
        // $historyabsensi = Absensi::where('id_karyawan',Auth::user()->id_pegawai)->get();
        $historyabsensi = Absensi::latest()->where('id_karyawan',Auth::user()->id_pegawai)->orderBy('tanggal')->get();
        return view('karyawan.absensi.history_absensi',compact('historyabsensi','row'));
    }

    public function show($id)
    {
        //
    }
}
