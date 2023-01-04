<?php

namespace App\Imports;

use Carbon\Carbon;
use App\Models\Absensi;
use Maatwebsite\Excel\Concerns\ToModel;

class AttendanceImport implements ToModel
{
    //UNTUK CSV
    public function startRow(): int
    {
        return 2;
    }

    public function getCsvSettings(): array
    {
        return [
            'delimiter' => ';'
        ];
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
                return new Absensi([
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
                    'absent'        => (String) $row[12] ?? null,
                    'lembur'        => $row[13] ?? null,
                    'jml_jamkerja'  => $row[14] ?? null,
                    'pengecualian'  => $row[15] ?? null,
                    'hci'           => $row[16] ?? null,
                    'hco'           => $row[17] ?? null,
                    'id_departement'=> $row[18] ?? null,
                    'h_normal'      => (Double) $row[19] ?? null,
                    'ap'            => (Double) $row[20] ?? null,
                    'hl'            => (Double) $row[21] ?? null,
                    'jam_kerja'     => $row[22] ?? null,
                    'lemhanor'      => (Double) $row[23] ?? null,
                    'lemakpek'      => (Double) $row[24] ?? null,
                    'lemhali'       => (Double) $row[25] ?? null,
                ]);

                dd($row);
            }
            // else{
            //     Log::info('id karyawan dan tanggal absensi sudah ada');
            // }
        }
        // else{
        //     Log::info('Row 0  dan 2 kosong');
        // }
    }
}
