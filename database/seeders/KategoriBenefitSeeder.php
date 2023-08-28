<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriBenefitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $kategoriBenefit = [
            [
                'id' => 1,
                'nama_kategori' => 'Gaji Pokok',
                'kode' => 'GP',
                'partner' => 0,
            ],
            [
                'id' => 2,
                'nama_kategori' => 'Gaji Kotor',
                'kode' => 'GK',
                'partner' => 0,
            ],
            [
                'id' => 3,
                'nama_kategori' => 'Gaji Bersih',
                'kode' => 'GB',
                'partner' => 0,
            ],
            [
                'id' => 4,
                'nama_kategori' => 'Tunjangan',
                'kode' => 'TUNJ',
                'partner' => 0,
            ],
            [
                'id' => 5,
                'nama_kategori' => 'Asuransi',
                'kode' => 'ASURANSI',
                'partner' => 0,
            ],
            [
                'id' => 6,
                'nama_kategori' => 'Potongan',
                'kode' => 'POTONGAN',
                'partner' => 0,
            ],
        ];

        DB::table('kategoribenefit')->insert($kategoriBenefit);

    }
}
