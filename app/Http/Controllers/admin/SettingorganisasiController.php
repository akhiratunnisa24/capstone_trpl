<?php

namespace App\Http\Controllers\admin;

use App\Models\Karyawan;
use Illuminate\Http\Request;
use App\Models\SettingOrganisasi;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SettingorganisasiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $role = Auth::user()->role;
        if ($role == 1 || $role == 2) 
        {
            $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
            $settingorganisasi = SettingOrganisasi::first();
            return view('admin.setting.index',compact('settingorganisasi','row'));
        }else
        {
            return redirect()->back();
        }
    }

    public function update(Request $request)
    {
        $data = $this->validate(request(), [
            'nama_perusahaan' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,jpg,png|max:2000',
            'email' => 'nullable|string',
            'no_telp' => 'nullable|string',
            'kode_pos' =>'nullable',
            'alamat' =>'nullable|string'
        ]);

        $settingorganisasi = SettingOrganisasi::first();
        $fotoLama = $settingorganisasi->logo;

        if ($fileFoto = $request->hasFile('logo'))
        {
            if($fotoLama !== null){
                $oldImage = public_path('images/'.$fotoLama);
                if(file_exists($oldImage)){
                    unlink($oldImage);
                }
            }

            $fileFoto = $request->file('logo');
            $namaFile = '' . time() . $fileFoto->getClientOriginalName();
            $tujuan_upload = 'images';
            $fileFoto->move($tujuan_upload, $namaFile);

            $settingorganisasi->logo = $namaFile;
        }
    
        $settingorganisasi->nama_perusahaan = $request->nama_perusahaan;
        $settingorganisasi->email = $request->email;
        $settingorganisasi->alamat = $request->alamat;
        $settingorganisasi->no_telp = $request->no_telp;
        $settingorganisasi->kode_pos = $request->kode_pos;

        $settingorganisasi->update();

        return redirect('/setting-organisasi')->with('pesan','Data Organisasi berhasil diperbaharui !');
    }
    
}
