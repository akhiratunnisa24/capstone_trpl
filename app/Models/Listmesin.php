<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listmesin extends Model
{
    use HasFactory;
    protected $table = 'listmesin';
    protected $fillable = ['nama_mesin','ip_mesin','port','comm_key','partner','status'];

    public function partners()
    {
        return $this->belongsTo(Partner::class,'partner','id');
    }
}
