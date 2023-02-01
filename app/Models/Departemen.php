<?php

namespace App\Models;

use App\Models\Karyawan;
use App\Models\Settingalokasi;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Departemen extends Model
{
    use HasFactory;

    protected $table='departemen';
    protected $fillable=['nama_departemen']; 

    public function absensi()
    {
        return $this->hasMany(Absensi::class, 'id_departement','id');
    }
    
    public function karyawans()
    {
        return $this->hasMany(Karyawan::class, 'id_departement','id');
    }

    public function settingalokasi()
    {
        return $this->hasMany(Settingalokasi::class, 'departemen','id');
    }

    // public function karyawan()
    // {
    //     return $this->belongsTo(Karyawan::class,'id','departemen');
    // }
    public function karyawan()
    {
        return $this->hasMany(Karyawan::class, 'divisi', 'id');
    }
    public function tidakmasuk()
    {
        return $this->hasMany(Tidakmasuk::class, 'divisi', 'id');
    }
    public function resign()
    {
        return $this->hasMany(Resign::class, 'departemen', 'id');
    }
}
