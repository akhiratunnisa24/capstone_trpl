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
            'nama_tahapan' => 'Data Curriculum Vitae (CV)',
            'status' => 'hidden',
        ]);
        DB::table('mrekruitmen')->insert([
            'nama_tahapan' => 'Test Psikotest',
            'status' => 'Aktif',

        ]);
        DB::table('mrekruitmen')->insert([
            'nama_tahapan' => 'Test Asuransi Umum',
            'status' => 'Aktif',

        ]);
        DB::table('mrekruitmen')->insert([
            'nama_tahapan' => 'Test Asuransi Syariah',
            'status' => 'Aktif',

        ]);
        DB::table('mrekruitmen')->insert([
            'nama_tahapan' => 'Test Pengetahuan Umum & Teknis',
            'status' => 'Aktif',

        ]);
        DB::table('mrekruitmen')->insert([
            'nama_tahapan' => 'Wawancara Tahap 1 (HRD)',
            'status' => 'Aktif',

        ]);
        DB::table('mrekruitmen')->insert([
            'nama_tahapan' => 'Wawancara Tahap 2 (Atasan Karyawan / Pimpinan Unit Kerja)',
            'status' => 'Aktif',

        ]);
        DB::table('mrekruitmen')->insert([
            'nama_tahapan' => 'Wawancara Tahap 3 (Direksi)',
            'status' => 'Aktif',

        ]);
        DB::table('mrekruitmen')->insert([
            'nama_tahapan' => 'Wawancara Tahap 4 (Wakil Direktur Utama)',
            'status' => 'Aktif',

        ]);
        DB::table('mrekruitmen')->insert([
            'nama_tahapan' => 'Wawancara Tahap 5 (Direktur Utama)',
            'status' => 'Aktif',

        ]);
        DB::table('mrekruitmen')->insert([
            'nama_tahapan' => 'Test Kesehatan',
            'status' => 'Aktif',

        ]);
        DB::table('mrekruitmen')->insert([
            'nama_tahapan' => 'Pengumuman Hasil Seleksi',
            'status' => 'Aktif',

        ]);
        DB::table('mrekruitmen')->insert([
            'nama_tahapan' => 'Penempatan Tenaga Kerja',
            'status' => 'Aktif',

        ]);
        // harus id 6
        DB::table('mrekruitmen')->insert([
            'nama_tahapan' => 'Diterima',
            'status' => 'hidden',

        ]);

    
    }
}
