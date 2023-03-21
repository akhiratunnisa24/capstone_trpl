<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kegiatan extends Model
{
    use HasFactory;
    protected $table = "kegiatan";
    protected $fillable = ['id_pegawai','judul','tglmulai','tglselesai'];
}
