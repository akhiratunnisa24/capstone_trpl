<?php

namespace Database\Seeders;

use App\Models\Departemen;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DepartemenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Departemen::insert([
            'nama_departemen' => "KOMISARIS",
        ]);
        Departemen::insert([
            'nama_departemen' => "DIREKSI",
        ]);
        Departemen::insert([
            'nama_departemen' => "CORPORATE SECRETARY",
        ]);
        Departemen::insert([
            'nama_departemen' => "INTERNAL AUDITOR",
        ]);
        Departemen::insert([
            'nama_departemen' => "RISK MANAGEMENT COMMITTE",
        ]);
        Departemen::insert([
            'nama_departemen' => "ANTI MONEY LAUNDERING & COUNTER FOT",
        ]);
        Departemen::insert([
            'nama_departemen' => "GENERAL MANAGER",
        ]);
        Departemen::insert([
            'nama_departemen' => "BUSINESS SUPPORT & ANALYST",
        ]);
        Departemen::insert([
            'nama_departemen' => "NETWORKING & CUSTOMER RELATIONSHIP",
        ]);
        Departemen::insert([
            'nama_departemen' => "BROKING SERVICES",
        ]);
        Departemen::insert([
            'nama_departemen' => "CLAIM SERVICES",
        ]);
        Departemen::insert([
            'nama_departemen' => "PRODUCT DEVELOPMENT",
        ]);
        Departemen::insert([
            'nama_departemen' => "FINANCE & ACCOUNTING",
        ]);
        Departemen::insert([
            'nama_departemen' => "HR, GA, LEGAL, COMPLIANCE & POLICY",
        ]);
        Departemen::insert([
            'nama_departemen' => "INFORMATION TECHNOLOGY",
        ]);
    }
}
