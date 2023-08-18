<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Benefit extends Model
{
    use HasFactory;

    protected $table ="benefit";
    protected $fillable = [
        'nama_benefit',
        'id_kategori',
        'kode','aktif',
        'dikenakan_pajak',
        'kelas_pajak',
        'tipe',
        'muncul_dipenggajian',
        'siklus_pembayaran',
       
        'partner'
    ];

    public function partners()
    {
        return $this->belongsTo(Partner::class,'partner','id');
    }

    public function kategoribenefits()
    {
        return $this->belongsTo(Kategoribenefit::class,'id_kategori','id');
    }
}
