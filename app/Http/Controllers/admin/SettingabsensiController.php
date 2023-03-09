<?php

namespace App\Http\Controllers\admin;

use App\Models\Karyawan;
use Illuminate\Http\Request;
use App\Models\Settingabsensi;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SettingabsensiController extends Controller
{
    public function setting()
    {
        $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
        $role = Auth::user()->role;        
        if ($role == 1) {
            $settingabsensi = Settingabsensi::all();
            return view('admin.absensi.setting',compact('settingabsensi','row'));
        }
        else
        {
           return redirect()->back(); 
        }
    }

    public function update(Request $request, $id)
    {
        $settingabsensi = Settingabsensi::find($id);
        $settingabsensi->update($request->all());

        return redirect()->back();
    }
}
