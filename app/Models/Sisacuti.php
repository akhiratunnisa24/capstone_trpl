<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sisacuti extends Model
{
    use HasFactory;
    protected $table= 'sisacuti';
    protected $fillable = ['id_pegawai','id_jeniscuti','jumlah_cuti','periode'];
}
