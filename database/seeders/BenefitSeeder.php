<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BenefitSeeder extends Seeder
{
    public function run()
    {
        $benefit = [
            [
                'id' => 1,
                'nama_benefit' => 'Gaji Pokok',
                'id_kategori' => 1,
                'kode' => 'Gp',
                'aktif' => 'Aktif',
                'dikenakan_pajak' => null,
                'kelas_pajak' => null,
                'muncul_dipenggajian' => 'Ya',
                'siklus_pembayaran' => 'Bulan',
                'urutan' => null,
                'tipe' => 'Komponen Tetap',
                'gaji_minimum' => null,
                'gaji_maksimum' => null,
                'jumlah' => 1,
                'besaran_bulanan' => 0,
                'besaran_mingguan' => null,
                'besaran_harian' => null,
                'besaran_jam' => null,
                'besaran' => null, 
                'dibayarkan oleh' => null,
                'partner' => 0,
            ],
            [
                'id' => 2,
                'nama_benefit' => 'Gaji Kotor',
                'id_kategori' => 2,
                'kode' => 'Gk',
                'aktif' => 'Aktif',
                'dikenakan_pajak' => null,
                'kelas_pajak' => null,
                'muncul_dipenggajian' => 'Ya',
                'siklus_pembayaran' => 'Bulan',
                'urutan' => null,
                'tipe' => 'Komponen Tetap',
                'gaji_minimum' => null,
                'gaji_maksimum' => null,
                'jumlah' => 1,
                'besaran_bulanan' => 0,
                'besaran_mingguan' => null,
                'besaran_harian' => null,
                'besaran_jam' => null,
                'besaran' => null, 
                'dibayarkan oleh' => null,
                'partner' => 0,
            ],
            [
                 'id' => 3,
                'nama_benefit' => 'Gaji Bersih',
                'id_kategori' => 3,
                'kode' => 'Gb',
                'aktif' => 'Aktif',
                'dikenakan_pajak' => null,
                'kelas_pajak' => null,
                'muncul_dipenggajian' => 'Ya',
                'siklus_pembayaran' => 'Bulan',
                'urutan' => null,
                'tipe' => 'Komponen Tetap',
                'gaji_minimum' => null,
                'gaji_maksimum' => null,
                'jumlah' => 1,
                'besaran_bulanan' => 0,
                'besaran_mingguan' => null,
                'besaran_harian' => null,
                'besaran_jam' => null,
                'besaran' => null, 
                'dibayarkan oleh' => null,
                'partner' => 0,
            ],
        ];

        DB::table('benefit')->insert($benefit);

    }
}
