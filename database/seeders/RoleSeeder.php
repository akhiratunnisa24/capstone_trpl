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
        ]);
        // id 2
        DB::table('role')->insert([
            'role' => 'HRD Staff',
        ]);
        // id 3
        DB::table('role')->insert([
            'role' => 'Manager',
        ]);
        // id 4
        DB::table('role')->insert([
            'role' => 'Staff',
        ]);
        // id 5
        DB::table('role')->insert([
            'role' => 'Admin',
        ]);
    }
}
