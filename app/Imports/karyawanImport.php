<?php

namespace App\Imports;

use Carbon\Carbon;
use App\Models\Karyawan;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;

class karyawanImport implements ToModel
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
        if(isset($row[2]) && isset($row[3]))
        {
            if(!Karyawan::where('nama',$row[2])->where('tgllahir',Carbon::parse($row[3])->format("Y-m-d"))->exists())
            {
                $karyawan = [
                    'nip'           => $row[0] ?? null,
                    'nik'       =>  $row[1] ?? null,
                    'nama'         => $row[2] ?? null,
                    'tgllahir'  => Carbon::parse($row[3])->format("Y-m-d"),
                    'email' => $row[4] ?? null,
                    'agama'     => $row[5] ?? null,
                    'gol_darah'    => $row[6] ?? null,
                    'jenis_kelamin'        => $row[7] ?? null,
                    'alamat'          => $row[8] ?? null,
                    'no_hp'     => $row[9] ?? null,
                    'status_karyawan'     => $row[10] ?? null,
                    'tipe_karyawan'        => $row[11] ?? null,
                    'manager'        => $row[12] ?? null,
                    'no_kk'  => $row[13] ?? null,
                    'status_kerja'  => $row[14] ?? null,
                    'cuti_tahunan'           => $row[15] ?? null,
                    'divisi'           => $row[16] ?? null,
                    'no_rek'=> $row[17] ?? null,
                    'no_bpjs_kes'      => (Double) $row[18],
                    'no_npwp'            => (Double) $row[19],
                    'no_bpjs_ket'            => (Double) $row[20],
                    'kontrak'     => $row[21] ?? null,
                    'jabatan'      => $row[22] ?? null,
                    'gaji'      => (Double) $row[23],
                    'tglmasuk'       => Carbon::parse($row[24])->format("Y-m-d"),
                    'tglkeluar'       => Carbon::parse($row[25])->format("Y-m-d"),
                ];

                // $keluarga = [
                //     'id_pegawai'   => $row[0],
                //     'hubungan'           => $row[1] ?? null,
                //     'status_pernikahan'       => $row[2] ?? null,
                //     'nama'         => $row[3] ?? null,
                //     'tgllahir'  => Carbon::parse($row[4])->format("Y-m-d"),
                //     'alamat' => $row[5] ?? null,
                //     'pendidikan_terakhir'     => $row[6] ?? null,
                //     'pekerjaan'    => $row[7] ?? null,
                // ];

                // $kdarurat = [
                //     'id_pegawai'   => $row[0],
                //     'nama'           => $row[1] ?? null,
                //     'alamat'       => $row[2] ?? null,
                //     'no_hp'         => $row[3] ?? null,
                //     'hubungan'  => $row[4] ?? null,
                // ];
                
                // $rpendidikan = [
                //     'id_pegawai'   => $row[0],
                //     'tingkat'           => $row[1] ?? null,
                //     'nama_sekolah'       => $row[2] ?? null,
                //     'kota_pformal'         => $row[3] ?? null,
                //     'kota_pnonformal'         => $row[4] ?? null,
                //     'jurusan'  => $row[5] ?? null,
                //     'tahun_lulus_formal'  => Carbon::parse($row[6])->format("Y-m-d"),
                //     'tahun_lulus_nonformal'  => Carbon::parse($row[7])->format("Y-m-d"),
                //     'jenis_pendidikan'  => $row[8] ?? null,
                // ];

                // $rpekerjaan = [
                //     'id_pegawai'   => $row[0],
                //     'nama_perusahaan'           => $row[1] ?? null,
                //     'alamat'       => $row[2] ?? null,
                //     'jenis_usaha'         => $row[3] ?? null,
                //     'jabatan'         => $row[4] ?? null,
                //     'nama_atasan'  => $row[5] ?? null,
                //     'nama_direktur'  => $row[6] ?? null,
                //     'lama_kerja'  => $row[7] ?? null,
                //     'alasan_berhenti'  => $row[8] ?? null,
                //     'gaji'  => $row[9] ?? null,
                // ];


                Karyawan::create($karyawan);
                Keluarga::create($keluarga);
                Kdarurat::create($kdarurat);
                Rpendidikan::create($rpendidikan);
                Rpekerjaan::create($rpekerjaan);
            
            }else{
                Log::info('id karyawan dan tanggal absensi sudah ada');
            }
        } else{
             Log::info('Row 1 kosong');
        }
    }

    // public function collection(Collection $rows)
    // {
    //     foreach ($rows as $index => $row) {
    //         Karyawan::create([
    //             'id' => $row['id'],
    //             'nip' => $row['nip'],
    //             'nik' => $row['nik'],
    //             'nama' => $row['nama'],
    //             'tgllahir' => $row['tgllahir'],
    //             'email' => $row['email'],
    //             'agama' => $row['agama'],
    //             'gol_darah' => $row['gol_darah'],
    //             'jenis_kelamin' => $row['jenis_kelamin'],
    //             'alamat' => $row['alamat'],
    //             'no_hp' => $row['no_hp'],
    //             'status_karyawan' => $row['status_karyawan'],
    //             'tipe_karyawan' => $row['tipe_karyawan'],
    //             'manager' => $row['manager'],
    //             'no_kk' => $row['no_kk'],
    //             'status_kerja' => $row['status_kerja'],
    //             'cuti_tahunan' => $row['cuti_tahunan'],
    //             'divisi' => $row['divisi'],
    //             'no_rek' => $row['no_rek'],
    //             'no_bpjs_kes' => $row['no_bpjs_kes'],
    //             'no_npwp' => $row['no_npwp'],
    //             'no_bpjs_ket' => $row['no_bpjs_ket'],
    //             'kontrak' => $row['kontrak'],
    //             'jabatan' => $row['jabatan'],
    //             'gaji' => $row['gaji'],
    //             'tglmasuk' => $row['tglmasuk'],
    //             'tglkeluar' => $row['tglkeluar'],
    //         ]);
    //     }
    // }
}
