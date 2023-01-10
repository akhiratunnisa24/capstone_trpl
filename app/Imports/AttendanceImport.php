<?php

namespace App\Imports;

use Carbon\Carbon;
use App\Models\Absensi;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AttendanceImport implements ToModel,WithHeadingRow
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
        if(isset($row['id']) && isset($row['tanggal']))
        {
            if(!Absensi::where('id_karyawan',$row['id'])->where('tanggal',Carbon::parse($row['tanggal'])->format("Y-m-d"))->exists())
            {
                $departement_map = [
                    'KONVENSIONAL' => 1,
                    'KEUANGAN' => 2,
                    'TEKNOLOGI INFORMASI' => 3,
                    'HUMAN RESOURCE' => 4,
                ];
                $data = [
                    'id_karyawan'   => $row['id'],
                    'nik'           => $row['nik'] ?? null,
                    'tanggal'       => Carbon::parse($row['tanggal'])->format("Y-m-d"),
                    'shift'         => $row['jam_kerja'] ?? null,
                    'jadwal_masuk'  => $row['jam_masuk'] ?? null,
                    'jadwal_pulang' => $row['jam_pulang'] ?? null,
                    'jam_masuk'     => $row['scan_masuk'] ?? null,
                    'jam_keluar'    => $row['scan_pulang'] ?? null,
                    'normal'        => $row['normal'] ?? null,
                    'riil'          => (Double) $row['riil'] ?? null,
                    'terlambat'     => $row['terlambat'] ?? null,
                    'plg_cepat'     => $row['plg_cepat'] ?? null,
                    'absent'        => $row['absent'] ?? null,
                    'lembur'        => $row['lembur'] ?? null,
                    'jml_jamkerja'  => $row['jml_jam_kerja'] ?? null,
                    'pengecualian'  => $row['pengecualian'] ?? null,
                    'hci'           => $row['harus_cin'],
                    'hco'           => (String) $row['harus_cout'],
                    'id_departement'=> $departement_map[$row['departemen']] ?? null,
                    'h_normal'      => (Double) $row['hari_normal']?? null,
                    'ap'            => (Double) $row['akhir_pekan']?? null,
                    'hl'            => (Double) $row['hari_libur']?? null,
                    'jam_kerja'     => $row['jml_kehadiran'] ?? null,
                    'lemhanor'      => (Double) $row['lembur_hari_normal'] ?? null,
                    'lemakpek'      => (Double) $row['lembur_akhir_pekan'] ?? null,
                    'lemhali'       => (Double) $row['lembur_hari_libur'] ?? null,
                ];
                Absensi::create($data);
            }else
            {
                Log::info('id karaywan dan tanggal absensi sudah ada');
            }
        }else
        {
            Log::info('Row 1 kosong');
        }
    }
    //    public function model(array $row)
    // {
    //     if(isset($row[0]) && isset($row[2])) 
    //     {
    //         if(!Absensi::where('id_karyawan',$row[0])->where('tanggal',Carbon::parse($row[2])->format("Y-m-d"))->exists())
    //         {
    //             return new Absensi([
    //                 'id_karyawan'   => $row[0],
    //                 'nik'           => $row[1] ?? null,
    //                 'tanggal'       => Carbon::parse($row[2])->format("Y-m-d"),
    //                 'shift'         => $row[3] ?? null,
    //                 'jadwal_masuk'  => $row[4] ?? null,
    //                 'jadwal_pulang' => $row[5] ?? null,
    //                 'jam_masuk'     => $row[6] ?? null,
    //                 'jam_keluar'    => $row[7] ?? null,
    //                 'normal'        => $row[8] ?? null,
    //                 'riil'          => (Double) $row[9] ?? null,
    //                 'terlambat'     => $row[10] ?? null,
    //                 'plg_cepat'     => $row[11] ?? null,
    //                 'absent'        => (String) $row[12] ?? null,
    //                 'lembur'        => $row[13] ?? null,
    //                 'jml_jamkerja'  => $row[14] ?? null,
    //                 'pengecualian'  => $row[15] ?? null,
    //                 'hci'           => $row[16] ?? null,
    //                 'hco'           => $row[17] ?? null,
    //                 'id_departement'=> $row[18] ?? null,
    //                 'h_normal'      => (Double) $row[19] ?? null,
    //                 'ap'            => (Double) $row[20] ?? null,
    //                 'hl'            => (Double) $row[21] ?? null,
    //                 'jam_kerja'     => $row[22] ?? null,
    //                 'lemhanor'      => (Double) $row[23] ?? null,
    //                 'lemakpek'      => (Double) $row[24] ?? null,
    //                 'lemhali'       => (Double) $row[25] ?? null,
    //             ]);

    //             dd($row);
    //         }
    //         // else{
    //         //     Log::info('id karyawan dan tanggal absensi sudah ada');
    //         // }
    //     }
    //     // else{
    //     //     Log::info('Row 0  dan 2 kosong');
    //     // }
    // }
}
