<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NamaTahap extends Model
{
    use HasFactory;

    protected $table = 'namatahapan';

    protected $fillable = [
        'id',
        'id_lowongan',
        'id_mrekruitmen',
    ];
    protected $guarded = [];

    public function mrekruitmen()
    {
        return $this->belongsTo(MetodeRekruitmen::class, 'id_mrekruitmen', 'id');
    }
 
}
