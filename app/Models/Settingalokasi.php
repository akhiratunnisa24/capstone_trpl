<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settingalokasi extends Model
{
    use HasFactory;
    protected $table = 'settingalokasi';
    protected $fillable = ['id','id_jeniscuti','tipe_alokasi','durasi','mode_alokasi','lama_kerja'];

    public function jeniscutis()
    {
        return $this->belongsTo(Jeniscuti::class,'id_jeniscuti','id');
    }

    // public function setModekaryawanAttribute($value)
    // {
    //     $this->attributes['mode_karyawan'] = json_encode($value);
    // }
  
    // public function getModekaryawanAttribute($value)
    // {
    //     return $this->attributes['mode_karyawan'] = json_decode($value);
    // }
}
