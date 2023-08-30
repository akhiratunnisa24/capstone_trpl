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
use Illuminate\Support\Facades\Auth;
use App\Models\DetailSalaryStructure;

class InformasigajiController extends Controller
{
    public function store(Request $request,$id)
    {
        $strukturgaji   = SalaryStructure::find($id);
        // return $strukturgaji;
        $leveljabatan   = LevelJabatan::where('id',$strukturgaji->id_level_jabatan)->first();

        $karyawan = Karyawan::where('status_karyawan', $strukturgaji->status_karyawan)
            ->where('jabatan',$leveljabatan->nama_level)
            ->where('partner',$strukturgaji->partner)
            ->get();
        // dd($strukturgaji,$leveljabatan,$detailstruktur,$benefit,$karyawan);
        foreach($karyawan as $data)
        {
            $check = Informasigaji::where('id_karyawan', $data->id)
                    ->where('partner',$data->partner)
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
                $details = [];
                foreach($detailstruktur as $detail)
                {
                    $benefit  = Benefit::where('id',$detail->id_benefit)->first();

                    $check = Detailinformasigaji::where('id_karyawan', $data->id)
                            ->where('id_informasigaji',$informasigaji->id)
                            ->where('id_struktur',$strukturgaji->id)
                            ->where('id_benefit',$detail->id_benefit)
                            ->where('partner',$data->partner)
                            ->exists();
                    // dd($check);
                   
                    if(!$check)
                    {
                        $nominal = null;
                        if($benefit->id == 1)
                        {
                            $nominal = $informasigaji->gaji_pokok;
                        }else
                        {
                            if($benefit->siklus_pembayaran == "Bulan")
                            {
                                $nominal      = $benefit->besaran_bulanan;
                            }else if($benefit->siklus_pembayaran == "Minggu")
                            {
                                $nominal      = $benefit->besaran_mingguan;
                            }else if($benefit->siklus_pembayaran == "Hari")
                            {
                                $nominal      = $benefit->besaran_harian;
                            }else if($benefit->siklus_pembayaran == "Jam")
                            {
                                $nominal      = $benefit->besaran_jam;
                            }else if($benefit->siklus_pembayaran == "Bonus")
                            {
                                $nominal      = $benefit->besaran;
                            }else
                            {
                                $nominal      = $benefit->besaran;
                            }
                        }
                               
                        $details[] = [
                            'id_karyawan'      =>$informasigaji->id_karyawan,
                            'id_informasigaji' =>$informasigaji->id,
                            'id_struktur'      =>$informasigaji->id_strukturgaji,
                            'id_benefit'       =>$benefit->id,
                            'siklus_bayar'     =>$benefit->siklus_pembayaran,
                            'partner'          =>Auth::user()->partner,
                            'nominal'          =>$nominal,
                        ];
                    }
                   
                }
                Detailinformasigaji::insert($details);
            }
            else
            {
                $informasigaji = Informasigaji::where('id_karyawan',$data->id)->first();
                $detailstruktur = DetailSalaryStructure::where('id_salary_structure', $strukturgaji->id)->get();

                $details = [];
                foreach($detailstruktur as $detail)
                {
                    $benefit  = Benefit::where('id',$detail->id_benefit)->first();

                    $check = Detailinformasigaji::where('id_karyawan', $data->id)
                            ->where('id_informasigaji',$informasigaji->id)
                            ->where('id_struktur',$strukturgaji->id)
                            ->where('id_benefit',$detail->id_benefit)
                            ->where('partner',$data->partner)
                            ->exists();
                    // dd($check);
                   
                    if(!$check)
                    {
                        $nominal = null;
                        if($benefit->id == 1)
                        {
                            $nominal = $informasigaji->gaji_pokok;
                        }else
                        {
                            if($benefit->siklus_pembayaran == "Bulan")
                            {
                                $nominal      = $benefit->besaran_bulanan;
                            }else if($benefit->siklus_pembayaran == "Minggu")
                            {
                                $nominal      = $benefit->besaran_mingguan;
                            }else if($benefit->siklus_pembayaran == "Hari")
                            {
                                $nominal      = $benefit->besaran_harian;
                            }else if($benefit->siklus_pembayaran == "Jam")
                            {
                                $nominal      = $benefit->besaran_jam;
                            }else if($benefit->siklus_pembayaran == "Bonus")
                            {
                                $nominal      = $benefit->besaran;
                            }else
                            {
                                $nominal      = $benefit->besaran;
                            }
                        }
                               
                        $details[] = [
                            'id_karyawan'      =>$informasigaji->id_karyawan,
                            'id_informasigaji' =>$informasigaji->id,
                            'id_struktur'      =>$informasigaji->id_strukturgaji,
                            'id_benefit'       =>$benefit->id,
                            'siklus_bayar'     =>$benefit->siklus_pembayaran,
                            'partner'          =>Auth::user()->partner,
                            'nominal'          =>$nominal,
                        ];
                    }
                   
                }
                Detailinformasigaji::insert($details);
            }  
        }
        return redirect()->back()->with('pesan','Data Informasi Gaji berhasil dibuat');

    }
}
