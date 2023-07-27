<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class OrganisasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('setting_organisasi')->insert([
            'nama_perusahaan' => 'PT. Global Risk Management (GRM)',
            'email' => 'info@grm-risk.com',
            'alamat' => 'Graha GRM - Royal Spring Business Park No. 11 Jl. Raya Ragunan No. 29A. Kel. Jati Padang - Kec. Pasar Minggu Jakarta Selatan',
            'no_telp' => '(+62) 811-140-840-5',
            'kode_pos' => '12540',
            'logo' => '',
        ]);
    }
}
