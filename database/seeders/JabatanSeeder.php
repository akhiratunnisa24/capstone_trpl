<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Jabatan;

class JabatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Jabatan::insert([
            'nama_jabatan' => 'Direksi',
            
        ]);
        Jabatan::insert([
            'nama_jabatan' => 'Manager',
            
        ]);
        Jabatan::insert([
            'nama_jabatan' => 'Asistant Manager',
            
        ]);
        Jabatan::insert([
            'nama_jabatan' => 'Staff',
        ]);
    }
}
