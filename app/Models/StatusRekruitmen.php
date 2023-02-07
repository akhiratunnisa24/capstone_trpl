<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusRekruitmen extends Model
{
    use HasFactory;
    protected $table = 'statusrekruitmen';

    protected $fillable = [
        'id',
        'nama_status',
    ];

    protected $hidden = [];

    public function namatahap()
    {
        return $this->belongsTo(NamaTahap::class, 'id_mrekruitmen', 'id');
    }
}
