<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryJabatan extends Model
{
    use HasFactory;

    protected $table ='history_jabatan';
    protected $fillable = [
            'id_karyawan',
            'id_jabatan',
            'id_leveljabatan',
            'gaji_terakhir',
            'tanggal',
    ];

    public function karyawans()
    {
        return $this->belongsTo(Karyawan::class,'id_karyawan','id');
    }


    public function jabatans()
    {
        return $this->belongsTo(Jabatan::class,'id_jabatan','id');
    }

    public function leveljabatans()
    {
        return $this->belongsTo(LevelJabatan::class,'id_leveljabatan','id');
    }
}
