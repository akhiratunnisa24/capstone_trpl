<?php

namespace App\Imports;

use Carbon\Carbon;
use App\Models\Partner;
use App\Models\Karyawan;
use App\Models\Kdarurat;
use App\Models\Keluarga;
use App\Models\Departemen;
use App\Models\Rpekerjaan;
use App\Models\Rpendidikan;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

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
        $partner = Auth::user()->partner;

        if (isset($row['nama']) && isset($row['tanggal_lahir'])) {

            $excelDateA = intval($row['tanggal_lahir']); // Convert to an integer (Excel serial number)
            $carbonDate = Carbon::createFromTimestamp(($excelDateA - 25569) * 86400)->format('Y-m-d');
            $tgl_lahir = $carbonDate;

            $excelDateB = intval($row['tanggal_masuk']); // Convert to an integer (Excel serial number)
            $carbonDate = Carbon::createFromTimestamp(($excelDateB - 25569) * 86400)->format('Y-m-d');
            $tgl_masuk = $carbonDate;

            $divisi = Departemen::whereRaw('LOWER(nama_departemen) = ?', [strtolower($row['divisi'])])->select('id')->first();
            $cek = !Karyawan::where('nik', $row['no_ktp'])->where('tgllahir',$tgl_lahir)->where('partner',$partner)->exists();
            if($cek)
            {
                $karyawan = [
                    'nip'           => $row['no_induk_karyawan'] ?? null,
                    'nik'           => $row['no_ktp'] ?? null,
                    'nama'          => $row['nama'] ?? null,
                    'tgllahir'      => $tgl_lahir,
                    'tempatlahir'   => $row['tempat_lahir'] ?? null,
                    'email'         => $row['e_mail'] ?? null,
                    'agama'         => null,
                    'gol_darah'     => null,
                    'jenis_kelamin' => $row['jenis_kelamin'] ?? null,
                    'alamat'        => $row['alamat'] ?? null,
                    'no_hp'         => $row['nomor_hp'] ?? null,
                    'status_karyawan'=> $row['status_karyawan'] ?? null,
                    'tipe_karyawan' => null,
                    'atasan_pertama'=>  $row['atasan_langsung'] ?? null,
                    'atasan_kedua'  =>  $row['atasan_kedua'] ?? null,
                    'no_kk'         =>  null,
                    'status_kerja'  =>  $row['status_kerja'] ?? null, 
                    'cuti_tahunan'  =>  null,
                    'divisi'        =>  $divisi ?? null,
                    'no_rek'        =>  $row['nomor_rekening'] ?? null,
                    'no_bpjs_kes'   => null,
                    'no_npwp'       => null,
                    'no_bpjs_ket'   => null,
                    'no_akdhk'      => null,
                    'no_program_pensiun' => null,
                    'no_program_askes' => null,
                    'nama_bank'     => $row['nama_bank'] ?? null,
                    'kontrak'       => null,
                    'jabatan'       => $row['level_jabatan'] ?? null,
                    'nama_jabatan'  => $row['jabatan'] ?? null,
                    'gaji'          => null,
                    'status_pernikahan' => $row['status_pernikahan'] ?? null,
                    'jumlah_anak'   => $row['jumlah_anak'] ?? null,
                    'tglmasuk'      => $tgl_masuk,
                    'tglkeluar'     => null,
                    'foto'          => null,
                    'partner'       => $partner,
                ];
               
                Karyawan::create($karyawan);
                // Keluarga::create($keluarga);
                // Kdarurat::create($kdarurat);
                // Rpendidikan::create($rpendidikan);
                // Rpekerjaan::create($rpekerjaan);
            } else {
                Log::info('id karyawan dan tanggal absensi sudah ada');
            }
        } else {
            Log::info('Row 1 kosong');
        }
    }
}

                // $keluarga = [
                //     'id_pegawai'       => $maxId + 1 ,
                //     'status_pernikahan'=> $row['status_pernikahan'] ?? null,
                //     'nama'             => $row['nama_keluarga'] ?? null,
                //     'tgllahir'         => Carbon::parse($row['tanggal_lahir_keluarga'])->format("Y-m-d"),
                //     'alamat'           => $row['alamat_keluarga'] ?? null,
                //     'pendidikan_terakhir' => $row['pendidikan_terakhir'] ?? null,
                //     'pekerjaan'        => $row['pekerjaan_keluarga'] ?? null,
                // ];

                // $kdarurat = [
                //     'id_pegawai'=> $maxId + 1 ,
                //     'nama'      => $row['nama_kdarurat'] ?? null,
                //     'alamat'    => $row['alamat_kdarurat'] ?? null,
                //     'no_hp'     => $row['no_hp_kdarurat'] ?? null,
                //     'hubungan'  => $row['hubungan'] ?? null,
                // ];

                // $rpendidikan = [
                //     'id_pegawai'           => $maxId + 1 ,
                //     'tingkat'              => $row['tingkat_pendidikan_formal'] ?? null,
                //     'nama_sekolah'         => $row['nama_sekolah_formal'] ?? null,
                //     'kota_pformal'         => $row['kota_pendidikan_formal'] ?? null,
                //     'kota_pnonformal'      => $row['kota_pendidikan_nonformal'] ?? null,
                //     'jurusan'              => $row['jurusan_pendidikan_formal'] ?? null,
                //     'tahun_lulus_formal'   => Carbon::parse($row['lulus_tahun_pformal'])->format("Y-m-d"),
                //     'tahun_lulus_nonformal'=> Carbon::parse($row['lulus_tahun_pnonformal'])->format("Y-m-d"),
                //     'jenis_pendidikan'     => $row['bidang_pnonformal'] ?? null,
                // ];

                // $rpekerjaan = [
                //     'id_pegawai'     => $maxId + 1 ,
                //     'nama_perusahaan'=> $row['nama_perusahaan'] ?? null,
                //     'alamat'         => $row['alamat_perusahaan'] ?? null,
                //     'jenis_usaha'    => $row['jenis_usaha'] ?? null,
                //     'jabatan'        => $row['jabatan_rpekerjaan'] ?? null,
                //     'nama_atasan'    => $row['nama_atasan_rpekerjaan'] ?? null,
                //     'nama_direktur'  => $row['nama_direktur_rpekerjaan'] ?? null,
                //     'lama_kerja'     => $row['lama_kerja'] ?? null,
                //     'alasan_berhenti'=> $row['alasan_berhenti'] ?? null,
                //     'gaji'           => $row['gaji_rpekerjaan'] ?? null,
                // ];

               
