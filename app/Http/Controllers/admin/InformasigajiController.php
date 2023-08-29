<?php

namespace App\Http\Controllers\admin;

use App\Models\Benefit;
use App\Models\Karyawan;
use App\Models\LevelJabatan;
use Illuminate\Http\Request;
use App\Models\Informasigaji;
use App\Models\SalaryStructure;
use App\Http\Controllers\Controller;
use App\Models\DetailSalaryStructure;

class InformasigajiController extends Controller
{
    public function store(Request $request,$id)
    {
        $strukturgaji   = SalaryStructure::find($id);
        $leveljabatan   = LevelJabatan::where('id',$strukturgaji->id_level_jabatan)->first();
        $detailstruktur = DetailSalaryStructure::where('id_salary_structure', $strukturgaji->id)->get();

        foreach($detailstruktur as $detail)
        {
            $benefit  = Benefit::where('id',$detail->id_benefit)->get();
        }

        $karyawan = Karyawan::where('status_karyawan', $strukturgaji->status_karyawan)
            ->where('jabatan',$leveljabatan->nama_level)
            ->where('partner',$strukturgaji->partner)
            ->get();
        // dd($strukturgaji,$leveljabatan,$detailstruktur,$benefit,$karyawan);
        foreach($karyawan as $data)
        {
            $check = Informasigaji::where('id_karyawan', $data->id)
                    ->where('partner',$strukturgaji->partner)
                    ->where('status_karyawan',$strukturgaji->status_karyawan)
                    ->where('level_jabatan',$strukturgaji->id_level_jabatan)
                    ->first();
            // return $karyawan;
            if(!$check)
            {
                $informasigaji = new Informasigaji();
                $informasigaji->id_karyawan     = $data->id;
                $informasigaji->id_strukturgaji = $strukturgaji->id;
                $informasigaji->status_karyawan = $strukturgaji->status_karyawan;
                $informasigaji->level_jabatan   = $strukturgaji->id_level_jabatan;
                $informasigaji->gaji_pokok      = $data->gaji;
                $informasigaji->partner         = $strukturgaji->partner;

                $informasigaji->save();
            }
        }

        return redirect()->back()->with('pesan','Data Informasi Gaji berhasil dibuat');

    }
}
