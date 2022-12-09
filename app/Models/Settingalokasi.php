<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settingalokasi extends Model
{
    use HasFactory;
    protected $table = 'settingalokasi';
    protected $guard = [];

    public function jeniscutis()
    {
        return $this->belongsTo(Jeniscuti::class,'id_jeniscuti','id');
    }
}
