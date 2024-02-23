<?php

namespace App\Http\Controllers\superadmin;

use App\Models\Partner;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use App\Models\SettingOrganisasi;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SettingorganisasiSAController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $role = Auth::user()->role;
        if($role == 5 || $role == 7)
        {
            $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
            $settingorganisasi = SettingOrganisasi::all();
            $existingPartnerIds = $settingorganisasi->pluck('partner');
            $partner = Partner::whereNotIn('id', $existingPartnerIds)->get();
            return view('superadmin.setting.index',compact('partner','settingorganisasi','row'));
        }
        else
        {
            return redirect()->back()->with('error','Anda tidak memiliki hak akses');
        }
    }

    public function store(Request $request)
    {
        $data = $this->validate(request(), [
            'nama_perusahaan' => 'required|string',
            'logo' => 'required|image|mimes:jpeg,jpg,png|max:2000',
            'email' => 'required|string',
            'no_telp' => 'required|string',
            'kode_pos' =>'required',
            'alamat' =>'required|string',
            'partner' => 'required',
        ]);

        $settingorganisasi = new SettingOrganisasi;

        if ($request->hasFile('logo'))
        {
            $fileFoto = $request->file('logo');
            $namaFile = '' . time() . $fileFoto->getClientOriginalName();
            $tujuan_upload = 'images';
            $fileFoto->move($tujuan_upload, $namaFile);

            $settingorganisasi->logo = $namaFile;
        }

        $settingorganisasi->nama_perusahaan = $request->nama_perusahaan;
        $settingorganisasi->email    = $request->email;
        $settingorganisasi->alamat   = $request->alamat;
        $settingorganisasi->no_telp  = $request->no_telp;
        $settingorganisasi->kode_pos = $request->kode_pos;
        $settingorganisasi->partner  = $request->partner;

        $settingorganisasi->save();

        return redirect()->back()->with('success','Data Organisasi berhasil disimpan !');
    }

    public function update(Request $request,$id)
    {
        $data = $this->validate(request(), [
            'nama_perusahaan' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,jpg,png|max:2000',
            'email' => 'nullable|string',
            'no_telp' => 'nullable|string',
            'kode_pos' =>'nullable',
            'alamat' =>'nullable|string'
        ]);

        $settingorganisasi = SettingOrganisasi::find($id);
        $fotoLama = $settingorganisasi->logo;

        if ($fileFoto = $request->hasFile('logo'))
        {
            if($fotoLama !== ""){
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
        $settingorganisasi->partner = Auth::user()->partner;

        // dd($settingorganisasi);
        $settingorganisasi->update();

        return redirect()->back()->with('success','Data Organisasi berhasil diperbaharui !');
    }

    public function destroy($id)
    {

    }
}
