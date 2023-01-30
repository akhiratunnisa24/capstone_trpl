<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lowongan extends Model
{
    use HasFactory;

    protected $table = 'lowongan';

    protected $fillable = [
        'id',
        'posisi',
        'jumlah_dibutuhkan',
        'status',
        'persyaratan',
    ];
    protected $guarded = [];

    public function rekruitmen()
    {
        return $this->hasMany(Rekruitmen::class, 'id_lowongan', 'id');
    }
}
