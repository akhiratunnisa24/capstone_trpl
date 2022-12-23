<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CutiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Cuti::create([
            
                            'id' => 1,
                            'id_karyawan' => 2,
                            'id_jeniscuti' => Str::random(20),
                            'keperluan' => Str::random(20),
                            'tgl_mulai' => Str::random(20),
                            'tgl_selesai' => Str::random(20),
                            'jml_cuti' => str::random(20),
                            'status' => Str::random(20),
    ]);
    }
}
