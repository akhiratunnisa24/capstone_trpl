<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SettingHarilibur;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SettingHariliburSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SettingHarilibur::insert([
            'tanggal' =>'2023-01-01',
            'tipe' =>'Hari Libur Nasional',
            'keterangan' =>'Tahun Baru Masehi 2023',
        ]);
        SettingHarilibur::insert([
            'tanggal' =>'2023-01-22',
            'tipe' =>'Hari Libur Nasional',
            'keterangan' =>'Tahun Baru Imlek 2023',
        ]);
        SettingHarilibur::insert([
            'tanggal' =>'2023-02-18',
            'tipe' =>'Hari Libur Nasional',
            'keterangan' =>'Isra\' Mi\'raj Nabi Muhammad SAW',
        ]);
        SettingHarilibur::insert([
            'tanggal' =>'2023-03-22',
            'tipe' =>'Hari Libur Nasional',
            'keterangan' =>'Hari Suci Nyepi 2023',
        ]);
        SettingHarilibur::insert([
            'tanggal' =>'2023-04-07',
            'tipe' =>'Hari Libur Nasional',
            'keterangan' =>'Wafatnya Isa Almasih',
        ]);
        SettingHarilibur::insert([
            'tanggal' =>'2023-04-22',
            'tipe' =>'Hari Libur Nasional',
            'keterangan' =>'Hari Raya Idul Fitri 1444 H',
        ]);
        SettingHarilibur::insert([
            'tanggal' =>'2023-04-23',
             'tipe' =>'Hari Libur Nasional',
            'keterangan' =>'Hari Raya Idul Fitri 1444 H',
        ]);
        SettingHarilibur::insert([
            'tanggal' =>'2023-05-01',
             'tipe' =>'Hari Libur Nasional',
            'keterangan' =>'Hari Buruh 2023',
        ]);
        SettingHarilibur::insert([
            'tanggal' =>'2023-05-18',
             'tipe' =>'Hari Libur Nasional',
            'keterangan' =>'Kenaikan Isa Almasih',
        ]);
        SettingHarilibur::insert([
            'tanggal' =>'2023-06-01',
             'tipe' =>'Hari Libur Nasional',
            'keterangan' =>'Hari Lahir Pancasila 2023',
        ]);
        SettingHarilibur::insert([
            'tanggal' =>'2023-06-04',
             'tipe' =>'Hari Libur Nasional',
            'keterangan' =>'Hari Raya Waisak 2023',
        ]);
        SettingHarilibur::insert([
            'tanggal' =>'2023-06-29',
             'tipe' =>'Hari Libur Nasional',
            'keterangan' =>'Hari Raya Idul Adha',
        ]);
        SettingHarilibur::insert([
            'tanggal' =>'2023-07-19',
             'tipe' =>'Hari Libur Nasional',
            'keterangan' =>'Tahun Baru Islam 1445 H',
        ]);
        SettingHarilibur::insert([
            'tanggal' =>'2023-08-17',
             'tipe' =>'Hari Libur Nasional',
            'keterangan' =>'Hari Kemerdekaan RI ke-78 Tahun',
        ]);
        SettingHarilibur::insert([
            'tanggal' =>'2023-09-28',
            'tipe' =>'Hari Libur Nasional',
            'keterangan' =>'Maulid Nabi Muhammad SAW',
        ]);
        SettingHarilibur::insert([
            'tanggal' =>'2023-12-25',
            'tipe' =>'Hari Libur Nasional',
            'keterangan' =>'Hari Raya Natal 2023',
        ]);
        SettingHarilibur::insert([
            'tanggal' =>'2023-01-23',
            'tipe' =>'Cuti Bersama',
            'keterangan' =>'Cuti Bersama - Tahun Baru Imlek 2574 Kongzili',
        ]);
        SettingHarilibur::insert([
            'tanggal' =>'2023-03-23',
            'tipe' =>'Cuti Bersama',
            'keterangan' =>'Cuti Bersama - Hari Suci Nyepi Tahun Baru Saka 1945',
        ]);
        SettingHarilibur::insert([
            'tanggal' =>'2023-04-19',
            'tipe' =>'Cuti Bersama',
            'keterangan' =>'Cuti Bersama - Hari Raya Idul Fitri 1444 H',
        ]);
        SettingHarilibur::insert([
            'tanggal' =>'2023-04-20',
             'tipe' =>'Cuti Bersama',
            'keterangan' =>'Cuti Bersama - Hari Raya Idul Fitri 1444 H',
        ]);
        SettingHarilibur::insert([
            'tanggal' =>'2023-04-21',
            'tipe' =>'Cuti Bersama',
            'keterangan' =>'Cuti Bersama - Hari Raya Idul Fitri 1444 H',
        ]);
        SettingHarilibur::insert([
            'tanggal' =>'2023-04-24',
            'tipe' =>'Cuti Bersama',
            'keterangan' =>'Cuti Bersama - Hari Raya Idul Fitri 1444 H',
        ]);
        SettingHarilibur::insert([
            'tanggal' =>'2023-06-02',
            'tipe' =>'Cuti Bersama',
            'keterangan' =>'Cuti Bersama - Hari Raya Waisak 2023',
        ]);
        SettingHarilibur::insert([
            'tanggal' =>'2023-12-26',
            'tipe' =>'Cuti Bersama',
            'keterangan' =>'Cuti Bersama - Hari  Raya Natal 2023',
        ]);
        SettingHarilibur::insert([
            'tanggal' =>'2023-04-25',
            'tipe' =>'Cuti Bersama',
            'keterangan' =>'Cuti Bersama - Hari Raya Idul Fitri 1444 H',
        ]);
    }
}
