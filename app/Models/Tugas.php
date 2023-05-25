<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tugas extends Model
{
    use HasFactory;

    protected $table = 'tugas';

    protected $fillable = [
        'id',
        'tim_id',
        'nik',
        'id_karyawan',
        'judul',
        'deskripsi',
        'tgl_mulai',
        'tgl_deadline',
        'status',
        'komentar',
        'keterangan',
        'divisi'
    ];

    public function departemens()
    {
        return $this->belongsTo(Departemen::class,'divisi','id');
    }

    public function tims()
    {
        return $this->belongsTo(Tim::class,'tim_id','id');
    }

    public function karyawans()
    {
        return $this->belongsTo(Karyawan::class, 'id_karyawan', 'id');
    }

    public function timkaryawans()
    {
        return $this->belongsTo(Timkaryawan::class, 'id_timkry', 'id');
    }
}
