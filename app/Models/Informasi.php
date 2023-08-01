<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Informasi extends Model
{
    use HasFactory;
    protected $table ='informasi';
    protected $fillable = ['judul','konten','tanggal_aktif','tanggal_berakhir'];

    public function partners()
    {
        return $this->belongsTo(Partner::class,'partner','id');
    }
}
