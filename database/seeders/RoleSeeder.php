<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // id 1
        DB::table('role')->insert([
            'role' => 'HRD Manager',
            'status' => '1',
        ]);
        // id 2
        DB::table('role')->insert([
            'role' => 'HRD Staff',
            'status' => '2',
        ]);
        // id 3
        DB::table('role')->insert([
            'role' => 'Manager',
            'status' => '1',
        ]);
        // id 4
        DB::table('role')->insert([
            'role' => 'Staff',
            'status' => '1',
        ]);
        // id 5
        DB::table('role')->insert([
            'role' => 'Admin',
            'status' => '1',
        ]);
    }
}
