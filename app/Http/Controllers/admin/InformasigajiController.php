<?php

namespace App\Http\Controllers\admin;

use App\Models\Benefit;
use App\Models\Karyawan;
use App\Models\LevelJabatan;
use Illuminate\Http\Request;
use App\Models\Informasigaji;
use App\Models\SalaryStructure;
use App\Models\Detailinformasigaji;
use App\Http\Controllers\Controller;
use App\Models\DetailSalaryStructure;

class InformasigajiController extends Controller
{
    public function store(Request $request,$id)
    {
        $strukturgaji   = SalaryStructure::find($id);
        $leveljabatan   = LevelJabatan::where('id',$strukturgaji->id_level_jabatan)->first();

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

                $informasigaji = Informasigaji::where('id_karyawan',$data->id)->first();
                $detailstruktur = DetailSalaryStructure::where('id_salary_structure', $strukturgaji->id)->get();

                foreach($detailstruktur as $detail)
                {
                    $benefit  = Benefit::where('id',$detail->id_benefit)->get();

    
                    $check = Detailinformasigaji::where('id_karyawan', $data->id)
                            ->where('id_informasigaji',$informasigaji->id)
                            ->where('partner',$data->partner)
                            ->first();
                    dd($informasigaji,$strukturgaji,$detailstruktur,$check);
                }
            }else
            {
                $informasigaji = Informasigaji::where('id_karyawan',$data->id)->first();
                $detailstruktur = DetailSalaryStructure::where('id_salary_structure', $strukturgaji->id)->get();

                foreach($detailstruktur as $detail)
                {
                    $benefit  = Benefit::where('id',$detail->id_benefit)->get();

                    $cek = Detailinformasigaji::where('id_karyawan', $data->id)
                            ->where('id_informasigaji',$informasigaji->id)
                            ->where('partner',$data->partner)
                            ->first();
                    if(!$cek)
                    {
                        $detailinformasi = new Detailinformasigaji();
                        $detailinformasi->id_karyawan     = $informasigaji->id_karyawan;
                        $detailinformasi->id_informasigaji= $informasigaji->id;
                        $detailinformasi->id_struktur     = $informasigaji->id;
                        $detailinformasi->id_benefit      = $benefit->id;
                        $detailinformasi->siklus_bayar    = $strukturgaji->id_level_jabatan;
                        $detailinformasi->gaji_pokok      = $data->gaji;
                        $detailinformasi->partner         = $strukturgaji->partner;
                
                        $informasigaji->save();
                    }
                   
                }
            }

            
        }

        return redirect()->back()->with('pesan','Data Informasi Gaji berhasil dibuat');

    }
}
