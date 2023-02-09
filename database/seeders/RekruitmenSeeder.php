<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class RekruitmenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('mrekruitmen')->insert([
            'nama_tahapan' => 'Penyerahan CV',
        ]);
        DB::table('mrekruitmen')->insert([
            'nama_tahapan' => 'Psikotest',
        ]);
        DB::table('mrekruitmen')->insert([
            'nama_tahapan' => 'Interview ke-1',
        ]);
        DB::table('mrekruitmen')->insert([
            'nama_tahapan' => 'Medical Check-Up',
        ]);
        DB::table('mrekruitmen')->insert([
            'nama_tahapan' => 'Interview ke-2',
        ]);
        // harus id 6
        DB::table('mrekruitmen')->insert([
            'nama_tahapan' => 'Diterima',
        ]);

    
    }
}
