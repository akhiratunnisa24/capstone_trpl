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
        $leveljabatan   = LevelJabatan::where('id',$strukturgaji->id)->first();
        $detailstruktur = DetailSalaryStructure::where('id_salary_structure', $strukturgaji->id)->get();
        
        foreach($detailstruktur as $detail)
        {
            $benefit    = Benefit::where('id',$detailstruktur->id_benefit)->first();
        }

        $karyawan = Karyawan::where('status_karyawan', $strukturgaji->status_karyawan)
            ->where('jabatan',$leveljabatan->nama_jabatan)
            ->where('partner',$strukturgaji->partner)
            ->get();

        foreach($karyawan as $data)
        {
            $check = Informasigaji::where('id_karyawan', $data->id)
                    ->where('partner',$strukturgaji->partner)
                    ->where('status_karyawan',$strukturgaji->status_karyawan)
                    ->where('id_level_jabatan',$strukturgaji->id_level_jabatan)
                    ->first();

            if(!$check)
            {
                $informasigaji = new Informasigaji();
                $informasigaji->id_karyawan     = $karyawan->id;
                $informasigaji->id_strukturgaji = $strukturgaji->id;
                $informasigaji->status_karyawan = $strukturgaji->status_karyawan;
                $informasigaji->id_level_jabatan= $strukturgaji->id_level_jabatan;
                $informasigaji->gaji_pokok      = $karyawan->gaji;
                $informasigaji->partner         = $strukturgaji->partner;

                $informasigaji->save();
            }
        }

    }
}
