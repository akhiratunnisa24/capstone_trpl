<?php

namespace App\Imports;

use Carbon\Carbon;
use App\Models\Karyawan;
use App\Models\Kdarurat;
use App\Models\Keluarga;
use App\Models\Rpekerjaan;
use App\Models\Rpendidikan;
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
        $maxId = Karyawan::max('id');

        if (isset($row['nama']) && isset($row['tanggal_lahir'])) {
            if (!Karyawan::where('nama', $row['nama'])->where('tgllahir', Carbon::parse($row['tanggal_lahir'])->format("Y-m-d"))->exists()) {
                $karyawan = [
                    'nip'           => (Int) $row['nip'] ?? null,
                    'nik'       =>  $row['nik'] ?? null,
                    'nama'         => $row['nama'] ?? null,
                    'tgllahir'  => Carbon::parse($row['tanggal_lahir'])->format("Y-m-d"),
                    'email' => $row['email'] ?? null,
                    'agama'     => $row['agama'] ?? null,
                    'gol_darah'    => $row['golongan_darah'] ?? null,
                    'jenis_kelamin'        => $row['jenis_kelamin'] ?? null,
                    'alamat'          => $row['alamat'] ?? null,
                    'no_hp'     => $row['nomor_hp'] ?? null,
                    'status_karyawan'     => $row['status_karyawan'] ?? null,
                    'tipe_karyawan'        => $row['tipe_karyawan'] ?? null,
                    'manager'        => $row['manager'] ?? null,
                    'no_kk'  => (Int) $row['no_kk'] ?? null,
                    'status_kerja'  => $row['status_kerja'] ?? null,
                    'cuti_tahunan'           => (Int) $row['divisi'] ?? null,
                    'divisi'           => $row['divisi'] ?? null,
                    'no_rek' => (Int) $row['nomor_rekening'] ?? null,
                    'no_bpjs_kes'      => (Int)  $row['nomor_bpjs_kesehatan'],
                    'no_npwp'            => (Int)  $row['nomor_npwp'],
                    'no_bpjs_ket'            => (Int)  $row['nomor_bpjs_ketenagakerjaan'],
                    'kontrak'     => $row['kontrak'] ?? null,
                    'jabatan'      => $row['jabatan'] ?? null,
                    'gaji'      => $row['gaji'],
                    'tglmasuk'       => Carbon::parse($row['tanggal_masuk'])->format("Y-m-d"),
                    'tglkeluar'       => Carbon::parse($row['tanggal_keluar'])->format("Y-m-d"),
                ];

                $keluarga = [
                    'id_pegawai' => $maxId + 1 ,
                    'status_pernikahan'       => $row['status_pernikahan'] ?? null,
                    'nama'         => $row['nama_keluarga'] ?? null,
                    'tgllahir'  => Carbon::parse($row['tanggal_lahir_keluarga'])->format("Y-m-d"),
                    'alamat' => $row['alamat_keluarga'] ?? null,
                    'pendidikan_terakhir'     => $row['pendidikan_terakhir'] ?? null,
                    'pekerjaan'    => $row['pekerjaan_keluarga'] ?? null,
                ];

                $kdarurat = [
                    'id_pegawai' => $maxId + 1 ,
                    'nama'           => $row['nama_kdarurat'] ?? null,
                    'alamat'       => $row['alamat_kdarurat'] ?? null,
                    'no_hp'         => $row['no_hp_kdarurat'] ?? null,
                    'hubungan'  => $row['hubungan'] ?? null,
                ];

                $rpendidikan = [
                    'id_pegawai' => $maxId + 1 ,
                    'tingkat'           => $row['tingkat_pendidikan_formal'] ?? null,
                    'nama_sekolah'       => $row['nama_sekolah_formal'] ?? null,
                    'kota_pformal'         => $row['kota_pendidikan_formal'] ?? null,
                    'kota_pnonformal'         => $row['kota_pendidikan_nonformal'] ?? null,
                    'jurusan'  => $row['jurusan_pendidikan_formal'] ?? null,
                    'tahun_lulus_formal'  => Carbon::parse($row['lulus_tahun_pformal'])->format("Y-m-d"),
                    'tahun_lulus_nonformal'  => Carbon::parse($row['lulus_tahun_pnonformal'])->format("Y-m-d"),
                    'jenis_pendidikan'  => $row['bidang_pnonformal'] ?? null,
                ];

                $rpekerjaan = [
                    'id_pegawai' => $maxId + 1 ,
                    'nama_perusahaan'           => $row['nama_perusahaan'] ?? null,
                    'alamat'       => $row['alamat_perusahaan'] ?? null,
                    'jenis_usaha'         => $row['jenis_usaha'] ?? null,
                    'jabatan'         => $row['jabatan_rpekerjaan'] ?? null,
                    'nama_atasan'  => $row['nama_atasan_rpekerjaan'] ?? null,
                    'nama_direktur'  => $row['nama_direktur_rpekerjaan'] ?? null,
                    'lama_kerja'  => $row['lama_kerja'] ?? null,
                    'alasan_berhenti'  => $row['alasan_berhenti'] ?? null,
                    'gaji'  => $row['gaji_rpekerjaan'] ?? null,
                ];


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
