<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rorganisasi extends Model
{
    use HasFactory;

    protected $table = 'rorganisasi';

    protected $fillable = [
        'id',
        'id_pegawai',
        'nama_organisasi',
        'alamat',
        'tgl_mulai',
        'tgl_selesai',
        'jabatan',
        'nama_direktur',
        'no_sk',
    ];
}
