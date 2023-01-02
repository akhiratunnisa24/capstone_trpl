<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keluarga extends Model
{
    use HasFactory;
    
    protected $table = 'keluarga';

    protected $fillable = [
        'id',
        'id_pegawai',
        'hubungan',
        'status_pernikahan',
        'nama',
        'tgllahir',
        'alamat',
        'pendidikan_terakhir',
        'pekerjaan',
    ];

    protected $hidden = [
         
    ];

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'id_pegawai', 'id');
    }
}
