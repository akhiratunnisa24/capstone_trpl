<?php

namespace Database\Seeders;

use App\Models\Departemen;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DepartemenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Departemen::insert([
            'nama_departemen' => "KONVENSIONAL",
        ]);
        Departemen::insert([
            'nama_departemen' => "KEUANGAN",
        ]);
        Departemen::insert([
            'nama_departemen' => "TEKNOLOGI INFORMASI",
        ]);
        Departemen::insert([
            'nama_departemen' => "HUMAN RESOURCE",
        ]);
    }
}
