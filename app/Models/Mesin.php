<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mesin extends Model
{
    use HasFactory;

    protected $table = 'mesin';

    protected $fillable = [
        'id',
        'id_pegawai',
        'nik',
        'departemen',
        'pin',
    ];

    public function departemens()
    {
        return $this->belongsTo(Departemen::class,'divisi','id');
    }

    public function karyawans()
    {
        return $this->belongsTo(Karyawan::class, 'id_karyawan', 'id');
    }
}
