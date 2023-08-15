<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kdarurat extends Model
{
    use HasFactory;
    
    protected $table = 'kdarurat';

    protected $fillable = [
        'id',
        'id_pegawai',
        'nama',
        'alamat',
        'hubungan',
    ];

    protected $hidden = [
         
    ];
    
    public function karyawan()
    {
        return $this->hasMany(Karyawan::class, 'id');
    }
}
