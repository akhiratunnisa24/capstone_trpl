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
            'email' => 'adminn@gmail.com',
            'password' => bcrypt('password'),
            'role' => '1',
        ]);
        DB::table('users')->insert([
            'id_pegawai'=> '2',
            'name' => 'test',
            'email' => 'test@gmail.com',
            'password' => bcrypt('password'),
            'role' => '2',
        ]);
        
        
    }
}
