<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Atasan extends Model
{
    use HasFactory;
    protected $table = 'atasan';
    protected $fillable = ['id_karyawan','nik','nama','jabatan','level_jabatan'];

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'id_karyawan');
    }
}
