<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settingalokasi extends Model
{
    use HasFactory;
    protected $table = 'settingalokasi';
    protected $fillable = ['id','id_jeniscuti','durasi','mode_alokasi','departemen','mode_karyawan','tipe_approval'];

    public function jeniscutis()
    {
        return $this->belongsTo(Jeniscuti::class,'id_jeniscuti','id');
    }

    public function departemens()
    {
        return $this->belongsTo(Departemen::class,'departemen','id');
    }

    public function getModeKaryawanArrayAttribute() {
        if(!empty($this->mode_karyawan)) {
        return explode(",", $this->mode_karyawan);
        }
        
        return [];
    }

    public function cuti()
    {
        return $this->hasMany(Cuti::class, 'id');
    }
}
