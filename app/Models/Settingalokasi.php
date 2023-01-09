<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settingalokasi extends Model
{
    use HasFactory;
    protected $table = 'settingalokasi';
    protected $fillable = ['id','id_jeniscuti','durasi','mode_alokasi','departemen','mode_karyawan'];

    public function jeniscutis()
    {
        return $this->belongsTo(Jeniscuti::class,'id_jeniscuti','id');
    }

    public function departemens()
    {
        return $this->belongsTo(Departemen::class,'departemen','id');
    }
}
