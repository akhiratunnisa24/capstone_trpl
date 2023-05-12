<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tugas extends Model
{
    use HasFactory;

    protected $table = 'tidakmasuk';

    protected $fillable = [
        'id',
        'tim_id',
        'nik',
        'id_karyawan',
        'judul',
        'deskripsi',
        'tgl_mulai',
        'tgl_deadline',
        'status',
        'komentar',
        'keterangan'
    ];
}
