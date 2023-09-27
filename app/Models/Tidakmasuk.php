<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tidakmasuk extends Model
{
    use HasFactory;

    protected $table = 'tidakmasuk';

    protected $fillable = [
        'id',
        'id_pegawai',
        'nama',
        'divisi ',
        'status ',
        'tanggal',
    ];

    public function karyawan()
    {
        return $this->hasMany(Karyawan::class, 'id_pegawai','id');
    }
    public function departemen()
    {
        return $this->belongsTo(Departemen::class, 'divisi', 'id');
    }
    public function karyawan2()
    {
        return $this->belongsTo(Karyawan::class, 'id_pegawai', 'id');
    }
}
