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
        if ($role == 1) 
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
        dd($request->all());
        $data = $this->validate(request(), [
            'nama_perusahaan' => 'required',
            'logo' => 'required|image|mimes:jpeg,jpg,png',
            'email' => 'required',
            'no_telp' => 'required',
            'kode_pos' =>'required',
            ''
        ]);

        dd($data);
        $settingorganisasi = SettingOrganisasi::first();

        if ($request->has('logo'))
        {
            $settingorganisasi->nama_perusahaan = $request->nama_perusahaan;
            $settingorganisasi->email = $request->email;
            $settingorganisasi->alamat = $request->alamat;
            $settingorganisasi->no_telp = $request->no_telp;
            $settingorganisasi->kode_pos = $request->kode_pos;
           
            $fileFoto = $request->file('logo');
            $namaFile = '' . time() . $fileFoto->getClientOriginalName();
            $tujuan_upload = 'images';
            $fileFoto->move($tujuan_upload, $namaFile);

            $settingorganisasi->logo = $namaFile;

            dd($settingorganisasi);
        }
        else
        {
            $settingorganisasi->nama_perusahaan = $request->nama_perusahaan;
            $settingorganisasi->email = $request->email;
            $settingorganisasi->alamat = $request->alamat;
            $settingorganisasi->no_telp = $request->no_telp;
            $settingorganisasi->kode_pos = $request->kode_pos;
        }   

        $settingorganisasi->update();

        return redirect()->back();
    }
    
}
