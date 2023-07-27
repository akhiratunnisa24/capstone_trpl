<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rprestasi extends Model
{
    use HasFactory;

    protected $table = 'rprestasi';

    protected $fillable = [
        'id',
        'id_pegawai',
        'keterangan',
        'nama_instansi',
        'alamat',
        'no_surat',
        'tanggal_surat',
    ];
}
