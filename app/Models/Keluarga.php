<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keluarga extends Model
{
    use HasFactory;
    
    protected $table = 'keluarga';

    protected $hidden = [
         
    ];

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 
        'id_pegawai', 
        'status_pernikahan', 
        'hubungan', 
        'nama', 
        'tgllahir', 
        'alamat', 
        'pendidikan_terakhir', 
        'pekerjaan');
    }
}
