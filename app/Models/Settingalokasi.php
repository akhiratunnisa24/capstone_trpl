<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settingalokasi extends Model
{
    use HasFactory;
    protected $table = 'settingalokasi';
    protected $fillable = ['id','id_jeniscuti','id_departement','durasi','mode_alokasi','lama_kerja'];

    public function jeniscutis()
    {
        return $this->belongsTo(Jeniscuti::class,'id_jeniscuti','id');
    }

    public function departement()
    {
        return $this->belongsTo(Departemen::class,'departemen','id');
    }
}
