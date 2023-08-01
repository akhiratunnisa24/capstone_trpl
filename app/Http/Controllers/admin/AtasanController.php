<?php

namespace App\Http\Controllers\admin;

use App\Models\Atasan;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AtasanController extends Controller
{
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
            // $atasan = Atasan::all();
            $atasan = Karyawan::whereIn('jabatan', ['Asistant Manager','Manager','Direksi'])
                    ->where('partner',Auth::user()->partner)
                    ->get();
            return view('admin.datamaster.atasan.index', compact('atasan','row','role'));

        } else {
            
            return redirect()->back(); 
        }
    }

    public function store(Request $request)
    {
        // $jabatan = ["Asistant Manager", "Manager", "Direksi"];
        $karyawan = Karyawan::whereIn('jabatan', ['Asistant Manager','Manager','Direksi'])->get();
        foreach ($karyawan as $data) {
            $cek = Atasan::where('id_karyawan', $data->id)
                ->where('nik', $data->nip)
                ->where('level_jabatan', $data->jabatan)
                ->first();
            
            if (!$cek) {
                // dd($karyawan);
                $atasan = new Atasan;
                $atasan->id_karyawan = $data->id;
                $atasan->nik = $data->nip;
                $atasan->level_jabatan = $data->jabatan;
                $atasan->jabatan = $data->nama_jabatan;
        
                $atasan->save();

                $pesan = 'Data Atasan berhasil disimpan !';
            } else {
                // return $cek;
                $atasan = Atasan::where('id_karyawan', $data->id)
                    ->where('nik', $data->nip)
                    ->update([
                        'level_jabatan' => $data->jabatan,
                        'jabatan' => $data->nama_jabatan,
                    ]);
                $pesan = 'Data Atasan berhasil diupdate!';
            }
        }

        return redirect()->back()->with('pesan', $pesan);
    }

}
