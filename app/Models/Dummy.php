<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dummy extends Model
{
    use HasFactory;
    protected $table ='absensidummy';
    protected $fillable = [
        'noid',
        'nama',
        'tanggal',
        'jam_masuk',
        'jam_pulang',
        'scan_masuk',
        'scan_keluar',
        'terlambat',
        'plg_cpt',
        'lembur',
        'jam_kerja',
        'jml_hadir',
    ];
}
