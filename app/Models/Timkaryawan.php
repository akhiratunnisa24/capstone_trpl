<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timkaryawan extends Model
{
    use HasFactory;
    protected $table = 'timkaryawan';

    protected $fillable = [
        'id','nik',
        'id_karyawan','divisi',
        'id_tim',
    ];

    public function departemens()
    {
        return $this->belongsTo(Departemen::class,'divisi','id');
    }

    public function tims()
    {
        return $this->belongsTo(Tim::class,'id_tim','id');
    }

    public function karyawans()
    {
        return $this->belongsTo(Karyawan::class, 'id_karyawan', 'id');
    }
}
