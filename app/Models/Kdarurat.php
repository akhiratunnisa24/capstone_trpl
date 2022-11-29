<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kdarurat extends Model
{
    use HasFactory;
    
    protected $table = 'kdarurat';

    protected $hidden = [
         
    ];

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 
        'id_pegawai', 
        'nama', 
        'alamat', 
        'no_hp', 
        'hubungan');
    }
    
}
