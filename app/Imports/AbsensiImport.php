<?php

namespace App\Imports;

use Carbon\Carbon;
use App\Models\Absensi;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AbsensiImport implements ToModel,WithHeadingRow
{
    //untuk excel
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
        if(isset($row['id']) && isset($row['tanggal']))
        {
            if(!Absensi::where('id_karyawan',$row['id'])->where('tanggal',Carbon::parse($row['tanggal'])->format("Y-m-d"))->exists())
            {
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
                    'id_departement'=> $row['departemen'] ?? null,
                    'h_normal'      => (Double) $row['hari_normal']?? null,
                    'ap'            => (Double) $row['akhir_pekan']?? null,
                    'hl'            => (Double) $row['hari_libur']?? null,
                    'jam_kerja'     => $row['jml_kehadiran'] ?? null,
                    'lemhanor'      => (Double) $row['lembur_hari_normal'] ?? null,
                    'lemakpek'      => (Double) $row['lembur_akhir_pekan'] ?? null,
                    'lemhali'       => (Double) $row['lembur_hari_libur'] ?? null,
                ];
                //  dd($data,$row);
                //  dd($row[2]);
                // dd(Carbon::parse($row[2])->format("Y-m-d"));
                // Log::info($row[2] ?? null);
                // Log::info($row[3] ?? null);
                // Log::info($row[4] ?? null);
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
}
