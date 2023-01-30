<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rekruitmen extends Model
{
    use HasFactory;

    protected $table = 'rekruitmen';

    protected $fillable = [
        'id',
        'id_pegawai',
        'posisi',
        'nik',
        'nama',
        'tgllahir',
        'email',
        'agama',
        'jenis_kelamin',
        'alamat',
        'no_hp',
        'no_kk',
        'tipe_karyawan',
        'gaji',
    ];
    protected $guarded = [];

    public function lowongan()
    {
        return $this->belongsTo(Lowongan::class, 'id_lowongan', 'id');
    }
}
