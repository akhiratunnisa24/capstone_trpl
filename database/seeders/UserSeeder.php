<?php

namespace Database\Seeders;


use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'id_pegawai'=> '1',
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin'),
            'role' => '1',
            'status_akun' => '1',
        ]);
        DB::table('karyawan')->insert([
            'id' => '1',
            'email' => 'admin@gmail.com',
            'jenis_kelamin' => 'L',
        ]);
        DB::table('kdarurat')->insert([
            'id_pegawai' => '1',
        ]);
        DB::table('keluarga')->insert([
            'id_pegawai' => '1',
        ]);
        DB::table('rpekerjaan')->insert([
            'id_pegawai' => '1',
        ]);
        DB::table('rpendidikan')->insert([
            'id_pegawai' => '1',
        ]);
        

        DB::table('users')->insert([
            'id_pegawai'=> '2',
            'name' => 'test',
            'email' => 'test@gmail.com',
            'password' => Hash::make('password'),
            'role' => '2',
            'status_akun' => '1',
        ]);
        DB::table('karyawan')->insert([
            'id' => '2',
            'email' => 'test@gmail.com',
            'jenis_kelamin' => 'P',
        ]);
        DB::table('kdarurat')->insert([
            'id_pegawai' => '2',
        ]);
        DB::table('keluarga')->insert([
            'id_pegawai' => '2',
        ]);
        DB::table('rpekerjaan')->insert([
            'id_pegawai' => '2',
        ]);
        DB::table('rpendidikan')->insert([
            'id_pegawai' => '2',
        ]);
        
        
    }
}
