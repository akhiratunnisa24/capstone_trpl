<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skeputusan extends Model
{
    use HasFactory;

    protected $table = 'skeputusan';

    protected $fillable = [
        'id',
        'id_pegawai',
        'jenis_surat',
        'nomor_surat',
        'tglsurat',
        'tgl_mulai',
        'tgl_selesai',
        'gaji',
    ];

}
