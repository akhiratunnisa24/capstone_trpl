<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rpendidikan extends Model
{
    use HasFactory;

    protected $table = 'rpendidikan';

    protected $hidden = [
         
    ];

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 
        'id_pegawai', 
        'tingkat', 
        'nama_sekolah', 
        'kota', 
        'jurusan', 
        'tahun_lulus', 
        'jenis_pendidikan' );
    }
}

