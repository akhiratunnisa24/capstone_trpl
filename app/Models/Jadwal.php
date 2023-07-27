<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    use HasFactory;
    protected $table = 'jadwal';
    protected $fillable =['id_pegawai','id_shift','tanggal','jadwal_masuk','jadwal_pulang'];

    public function karyawans()
    {
        return $this->belongsTo(Karyawan::class,'id_pegawai','id');
    }

    public function shifts()
    {
        return $this->belongsTo(Shift::class,'id_shift','id');
    }
}
