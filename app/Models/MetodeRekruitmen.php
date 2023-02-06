<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MetodeRekruitmen extends Model
{
    use HasFactory;

    protected $table = 'mrekruitmen';
    protected $fillable = ['nama_metode'];

    public function lowongan()
    {
        return $this->hasMany(lowongan::class, 'id', 'tahapan');
    }
}
