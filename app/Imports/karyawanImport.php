<?php

namespace App\Imports;

use Carbon\Carbon;
use App\Models\Karyawan;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;

class karyawanImport implements ToModel, WithHeadingRow
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
        if (isset($row[2]) && isset($row[3])) {
            if (!Karyawan::where('nama', $row[2])->where('tgllahir', Carbon::parse($row[3])->format("Y-m-d"))->exists()) {
                $karyawan = [
                    'nip'             => $row['nip'] ?? null,
                    'nik'             =>  $row['nik'] ?? null,
                    'nama'            => $row['nama'] ?? null,
                    'tgllahir'        => Carbon::parse($row['tanggal_lahir'])->format("Y-m-d"),
                    'email'           => $row['email'] ?? null,
                    'agama'           => $row['agama'] ?? null,
                    'gol_darah'       => $row['golongan_darah'] ?? null,
                    'jenis_kelamin'   => $row['jenis_kelamin'] ?? null,
                    'alamat'          => $row['alamat'] ?? null,
                    'no_hp'           => $row['nomor_hp'] ?? null,
                    'status_karyawan' => $row['status_karyawan'] ?? null,
                    'tipe_karyawan'   => $row['tipe_karyawan'] ?? null,
                    'manager'         => $row['manager'] ?? null,
                    'no_kk'           => $row['no_kk'] ?? null,
                    'status_kerja'    => $row['status_kerja'] ?? null,
                    'cuti_tahunan'    => $row['divisi'] ?? null,
                    'divisi'          => $row['divisi'] ?? null,
                    'no_rek'          => $row['nomor_rekening'] ?? null,
                    'no_bpjs_kes'     => (Integer) $row['nomor_bpjs_kesehatan'],
                    'no_npwp'         => (Integer) $row['nomor_npwp'],
                    'no_bpjs_ket'     => (Integer) $row['nomor_bpjs_ketenagakerjaan'],
                    'kontrak'         => $row['kontrak'] ?? null,
                    'jabatan'         => $row['jabatan'] ?? null,
                    'gaji'            => (Integer) $row['gaji'],
                    'tglmasuk'        => Carbon::parse($row['tanggal_masuk'])->format("Y-m-d"),
                    'tglkeluar'       => Carbon::parse($row['tanggal_keluar'])->format("Y-m-d"),
                ];

                $keluarga = [
                    'id_pegawai'         => $row[0],
                    'hubungan'           => $row[1] ?? null,
                    'status_pernikahan'  => $row[2] ?? null,
                    'nama'               => $row[3] ?? null,
                    'tgllahir'           => Carbon::parse($row[4])->format("Y-m-d"),
                    'alamat'             => $row[5] ?? null,
                    'pendidikan_terakhir'=> $row[6] ?? null,
                    'pekerjaan'          => $row[7] ?? null,
                ];

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
            } else {
                Log::info('id karyawan dan tanggal absensi sudah ada');
            }
        } else {
            Log::info('Row 1 kosong');
        }
    }
}
