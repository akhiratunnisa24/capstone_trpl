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
            'jenis_cuti' => "Cuti Bersalin",
        ]);
        Jeniscuti::insert([
            'jenis_cuti' => "Cuti Keguguran",
        ]);
        Jeniscuti::insert([
            'jenis_cuti' => "Cuti Besar",
        ]);
        Jeniscuti::insert([
            'jenis_cuti' => "Cuti Diluar Tanggungan Perusahaan",
        ]);
    }
}
