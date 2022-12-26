<?php

namespace App\Imports;

use Carbon\Carbon;
use App\Models\Absensi;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;

class AbsensiImport implements ToModel
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
            if(!Absensi::where('id_karyawan',$row[0])->where('tanggal',Carbon::parse($row[2])->format("Y-m-d"))->exists())
            {
                $data = [
                    'id_karyawan'   => $row[0],
                    'nik'           => $row[1] ?? null,
                    'tanggal'       => Carbon::parse($row[2])->format("Y-m-d"),
                    'shift'         => $row[3] ?? null,
                    'jadwal_masuk'  => $row[4] ?? null,
                    'jadwal_pulang' => $row[5] ?? null,
                    'jam_masuk'     => $row[6] ?? null,
                    'jam_keluar'    => $row[7] ?? null,
                    'normal'        => $row[8] ?? null,
                    'riil'          => (Double) $row[9] ?? null,
                    'terlambat'     => $row[10] ?? null,
                    'plg_cepat'     => $row[11] ?? null,
                    'absent'        => $row[12] ?? null,
                    'lembur'        => $row[13] ?? null,
                    'jml_jamkerja'  => $row[14] ?? null,
                    'pengecualian'  => $row[15] ?? null,
                    'hci'           => $row[16] ?? null,
                    'hco'           => $row[17] ?? null,
                    'id_departement'=> $row[18] ?? null,
                    'h_normal'      => (Double) $row[19],
                    'ap'            => (Double) $row[20],
                    'hl'            => (Double) $row[21],
                    'jam_kerja'     => $row[22] ?? null,
                    'lemhanor'      => (Double) $row[23] ?? null,
                    'lemakpek'      => (Double) $row[24],
                    'lemhali'       => (Double) $row[25],
                ];
                //  dd($data,$row);
                //  dd($row[2]);
                // dd(Carbon::parse($row[2])->format("Y-m-d"));
                // Log::info($row[2] ?? null);
                // Log::info($row[3] ?? null);
                // Log::info($row[4] ?? null);
                Absensi::create($data);
            
            }else{
                Log::info('id karaywan dan tanggal absensi sudah ada');
            }
        } else{
             Log::info('Row 1 kosong');
        }
    }
}
