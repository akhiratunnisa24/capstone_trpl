<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategoribenefit extends Model
{
    protected $table='kategoribenefit';
    protected $fillable=['nama_kategori','kode','partner']; 

    public function benefits()
    {
        return $this->hasMany(Benefit::class, 'id_kategori','id');
    }

    public function partners()
    {
        return $this->belongsTo(Partner::class,'partner','id');
    }

}
