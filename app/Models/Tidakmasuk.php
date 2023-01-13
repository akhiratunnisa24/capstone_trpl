<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tidakmasuk extends Model
{
    use HasFactory;

    protected $table = 'tidakmasuk';

    protected $fillable = [
        'id',
        'id_pegawai',
        'nama',
        'divisi ',
        'tanggal',
    ];
}
