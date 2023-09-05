<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Informasigaji extends Model
{
    use HasFactory;

    protected $table = 'informasi_gaji';
    protected $fillable = [
                            'id_karyawan',
                            'id_strukturgaji',
                            'status_karyawan',
                            'level_jabatan',
                            'gaji_pokok',
                            'partner'
                        ];

    public function partners()
    {
        return $this->belongsTo(Partner::class,'partner','id');
    }

    public function karyawans()
    {
        return $this->belongsTo(Karyawan::class,'id_karyawan','id');
    }

    public function strukturgajis()
    {
        return $this->belongsTo(SalaryStructure::class,'id_strukturgaji','id');
    }

    public function leveljabatans()
    {
        return $this->belongsTo(LevelJabatan::class,'level_jabatan','id');
    }

    public function detailinformasigajis()
    {
        return $this->hasMany(Detailinformasigaji::class, 'id_informasigaji','id');
    }

    public function penggajians()
    {
        return $this->hasMany(Penggajian::class, 'id_informasigaji','id');
    }
}
