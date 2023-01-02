<?php

namespace App\Imports;

use Carbon\Carbon;
use App\Models\Alokasicuti;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

// class AlokasicutiImport implements ToModel,WithHeadingRow
class AlokasicutiImport implements ToModel
{
    public function startRow(): int
    {
        return 2;
    }

     /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public function model(array $row)
    {
        if(isset($row[0]) && isset($row[2]))
        {
            if(!Alokasicuti::where('id_karyawan',$row[0])->where('id_jeniscuti',$row[2])->exists())
            {
                $data = [
                    'id_karyawan'      => $row[0] ?? null,
                    'id_settingalokasi'=> $row[1] ?? null,
                    'id_jeniscuti'     => $row[2] ?? null,
                    'durasi'           => $row[3] ?? null,
                    'mode_alokasi'     => $row[4] ?? null,
                    'tgl_masuk'        => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[5])->format("Y-m-d") ?? null,
                    'tgl_sekarang'     => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[6])->format("Y-m-d") ?? null,
                    'aktif_dari'       => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[7])->format("Y-m-d") ?? null,
                    'sampai'           => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[8])->format("Y-m-d") ?? null,
                ];
                 Log::info($row[5]);

                //  dd($row[5],$row[6],$row[7],$row[8]);
                // dd($row[0],$row[1],$row[2],$row[3],$row[4],$row[5],$row[6],$row[7]);
                // dd(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[5])->format("Y-m-d")?? null,\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[6])->format("Y-m-d"),\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[7])->format("Y-m-d"), \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[8])->format("Y-m-d") ?? null);
                Alokasicuti::create($data);
            
            }else{
                Log::info('id pegawai dan tanggal absensi sudah ada');
            }
        } else{
             Log::info('Row 0 kosong');
        }
    }

      // public function model(array $row)
    // {
    //     //  dd($row);
    //     if(isset($row['id_karyawan']) && isset($row['id_jeniscuti']))
    //     {
    //         dd($row);
    //         if(!Alokasicuti::where('id_karyawan',$row['id_karyawan'])->where('id_jeniscuti',$row['id_jeniscuti'])->exists())
    //         {
    //             $data = [
    //                 'id_karyawan'      => $row['id_karyawan'] ?? null,
    //                 'id_settingalokasi'=> $row['id_settingalokasi'] ?? null,
    //                 'id_jeniscuti'     => $row['id_jeniscuti'] ?? null,
    //                 'durasi'           => $row['durasi'] ?? null,
    //                 'mode_alokasi'     => $row['mode_alokasi'] ?? null,
    //                 'tgl_masuk'        => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['tgl_masuk'])->format("Y-m-d") ?? null,
    //                 'tgl_sekarang'     => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['tgl_sekarang'])->format("Y-m-d") ?? null,
    //                 'aktif_dari'       => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['aktif_dari'])->format("Y-m-d") ?? null,
    //                 'sampai'           => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['sampai'])->format("Y-m-d") ?? null,
    //             ];
    //             // dd($data);
    //              Log::info($row[5]);


    //             //  dd($row[5],$row[6],$row[7],$row[8]);
    //             // dd($row[0],$row[1],$row[2],$row[3],$row[4],$row[5],$row[6],$row[7]);
    //             // dd(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[5])->format("Y-m-d")?? null,\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[6])->format("Y-m-d"),\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[7])->format("Y-m-d"), \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[8])->format("Y-m-d") ?? null);
    //             Alokasicuti::create($data);
            
    //         }else{
    //             Log::info('id pegawai dan tanggal absensi sudah ada');
    //         }
    //     } else{
    //          Log::info('Row ID Karyawan kosong');
    //     }
    // }
}
