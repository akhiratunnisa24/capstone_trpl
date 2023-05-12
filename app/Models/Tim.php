<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tim extends Model
{
    use HasFactory;
    protected $table = 'tim';

    protected $fillable = [
        'namatim','divisi',
        'deskripsi',
    ];

    public function departemens()
    {
        return $this->belongsTo(Departemen::class,'divisi','id');
    }

    public function timkaryawans()
    {
        return $this->hasMany(Timkaryawan::class,'id_tim','id');
    } 
}
