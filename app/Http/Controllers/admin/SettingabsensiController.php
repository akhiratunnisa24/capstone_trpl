<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Models\Settingabsensi;
use App\Http\Controllers\Controller;

class SettingabsensiController extends Controller
{
    public function setting()
    {
        $settingabsensi = Settingabsensi::all();
        return view('admin.absensi.setting',compact('settingabsensi'));
    }
}
