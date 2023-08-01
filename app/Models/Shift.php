<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    use HasFactory;
    protected $table = 'shift';
    protected $fillable = ['id_pegawai','nama_shift','jam_masuk','jam_pulang','partner'];

    public function jadwal()
    {
        return $this->hasMany(Jadwal::class, 'id');
    }

    public function partners()
    {
        return $this->belongsTo(Partner::class,'partner','id');
    }
}
