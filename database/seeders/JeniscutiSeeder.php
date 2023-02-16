<?php

namespace Database\Seeders;

use App\Models\Jeniscuti;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class JeniscutiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Jeniscuti::insert([
            'jenis_cuti' => "Cuti Tahunan",
        ]);
        Jeniscuti::insert([
            'jenis_cuti' => "Cuti Menikah",
        ]);
        Jeniscuti::insert([
            'jenis_cuti' => "Cuti Menikahkan Anak",
        ]);
        Jeniscuti::insert([
            'jenis_cuti' => "Cuti Keluarga Meninggal",
        ]);
        Jeniscuti::insert([
            'jenis_cuti' => "Cuti Keluarga Dalam Satu Rumah Meninggal",
        ]);
        Jeniscuti::insert([
            'jenis_cuti' => "Cuti Hamil/Melahirkan/Keguguran",
        ]);
        Jeniscuti::insert([
            'jenis_cuti' => "Cuti Lebaran",
        ]);

    }
}
