<?php

namespace App\Imports;

use Carbon\Carbon;
use App\Models\Alokasicuti;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;

class AlokasicutiImport implements ToModel
{
    public function startRow(): int
    {
        return 2;
    }

    public function model(array $row)
    {
        if(isset($row[0]) && isset($row[2]))
        {
            if(!Alokasicuti::where('id_pegawai',$row[0])->where('id_jeniscuti',$row[2])->exists())
            {
                $data = [
                    'id_pegawai'       => $row[0] ?? null,
                    'id_settingalokasi'=> $row[1] ?? null,
                    'id_jeniscuti'     => $row[2] ?? null,
                    'durasi'           => $row[3] ?? null,
                    'mode_alokasi'     => $row[4] ?? null,
                    'tgl_masuk'        => Carbon::parse($row[5])->format("Y-m-d"),
                    'tgl_sekarang'     => Carbon::parse($row[6])->format("Y-m-d"),
                    'aktif_dari'       => $row[7] ?? null,
                    'sampai'           => $row[8] ?? null,
                ];
                //  dd($data,$row);
                //  dd($row[2]);
                // dd(Carbon::parse($row[2])->format("Y-m-d"));
                // Log::info($row[2] ?? null);
                // Log::info($row[3] ?? null);
                // Log::info($row[4] ?? null);
                Alokasicuti::create($data);
            
            }else{
                Log::info('id pegawai dan tanggal absensi sudah ada');
            }
        } else{
             Log::info('Row 1 kosong');
        }
    }
}
