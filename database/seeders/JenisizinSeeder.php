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
            'jenis_izin' => "Terlambat",
        ]);
        Jenisizin::insert([
            'jenis_izin' => "Pulang Cepat",
        ]);
        Jenisizin::insert([
            'jenis_izin' => "Sakit",
        ]);
    }
}
