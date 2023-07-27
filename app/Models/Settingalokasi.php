<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settingalokasi extends Model
{
    use HasFactory;
    protected $table = 'settingalokasi';
    protected $fillable = ['id','id_jeniscuti','durasi','mode_karyawan','cuti_bersama_terhutang','periode','status'];

    public function jeniscutis()
    {
        return $this->belongsTo(Jeniscuti::class,'id_jeniscuti','id');
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
