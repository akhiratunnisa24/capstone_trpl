<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Status;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Status::insert([
            'name_status' => 'Pending',
            
        ]);
        Status::insert([
            'name_status' => 'Disetujui Manager',
            
        ]);
        Status::insert([
            'name_status' => 'Disetujui',
            
        ]);
        Status::insert([
            'name_status' => 'Ditolak',
            
        ]);
    }
}
