<?php

namespace Database\Seeders;

use App\Models\Jenisizin;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class JenisizinSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Jenisizin::insert([
            'jenis_izin' => "Sakit Dengan Surat Dokter",
            'code'       => "S"
        ]);
        Jenisizin::insert([
            'jenis_izin' => "Izin (Tidak Masuk Kerja/Haid/Tanpa Surat Keterangan Dokter)",
            'code'       => "I"
        ]);
        Jenisizin::insert([
            'jenis_izin' => "Tugas Luar Kantor",
            'code'       => "TL"
        ]);
        Jenisizin::insert([
            'jenis_izin' => "Dinas Luar Kota",
            'code'       => "DL"
        ]);
        Jenisizin::insert([
            'jenis_izin' => "Keperluan Lainnya",
            'code'       => "L"
        ]);
    }
}
