<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Settingabsensi;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SettingabsensiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Settingabsensi::insert([
            'toleransi_terlambat' =>Carbon::createFromTime(00, 15, 0),
            'jumlah_terlambat' =>2,
            'sanksi_terlambat' =>'Teguran Biasa',
            'jumlah_tidakmasuk'=>NULL,
            'status_tidakmasuk'=>NULL, 
            'sanksi_tidak_masuk'=>NULL,
        ]);
        Settingabsensi::insert([
            'toleransi_terlambat' =>Carbon::createFromTime(00, 15, 0),
            'jumlah_terlambat' =>3,
            'sanksi_terlambat' =>'SP Pertama',
            'jumlah_tidakmasuk'=>NULL,
            'status_tidakmasuk'=>NULL, 
            'sanksi_tidak_masuk'=>NULL,
        ]);
        Settingabsensi::insert([
            'toleransi_terlambat' =>Carbon::createFromTime(00, 15, 0),
            'jumlah_terlambat' =>4,
            'sanksi_terlambat' =>'SP Kedua',
            'jumlah_tidakmasuk'=>NULL,
            'status_tidakmasuk'=>NULL, 
            'sanksi_tidak_masuk'=>NULL,
        ]);
        Settingabsensi::insert([
            'toleransi_terlambat' =>Carbon::createFromTime(00, 15, 0),
            'jumlah_terlambat' =>5,
            'sanksi_terlambat' =>'SP Ketiga',
            'jumlah_tidakmasuk'=>NULL,
            'status_tidakmasuk'=>NULL, 
            'sanksi_tidak_masuk'=>NULL,
        ]);
        Settingabsensi::insert([
            'toleransi_terlambat' =>NULL,
            'jumlah_terlambat' =>NULL,
            'sanksi_terlambat' =>NULL,
            'jumlah_tidakmasuk'=>5,
            'status_tidakmasuk'=>'tanpa keterangan', 
            'sanksi_tidak_masuk'=>'Potong Uang Transportasi',
        ]);
        Settingabsensi::insert([
            'toleransi_terlambat' =>NULL,
            'jumlah_terlambat' =>NULL,
            'sanksi_terlambat' =>NULL,
            'jumlah_tidakmasuk'=>3,
            'status_tidakmasuk'=>'tanpa keterangan', 
            'sanksi_tidak_masuk'=>"Potong Uang Makan",
        ]);
    }
}
