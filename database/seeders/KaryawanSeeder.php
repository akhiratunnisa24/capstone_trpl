<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class KaryawanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // App\Models\Karyawan;
        \App\Models\Karyawan::create([
            
            'nama' => Str::random(20),
                            'tgllahir' => Str::random(20),
                            'jenis_kelamin' => Str::random(20),
                            'alamat' => Str::random(20),
                            'no_hp' => Str::random(20),
                            'email' => Str::random(20),
                            'agama' => str::random(20),
                            'nik' => Str::random(20),
                            'gol_darah' => Str::random(20),
                            'foto' => Str::random(20),
                            'jabatan' => Str::random(20),
                            'tglmasuk' => Str::random(20),
                            'created_at' => new \DateTime(),
                            'updated_at' => new \DateTime(),
    ]);

    }
}
