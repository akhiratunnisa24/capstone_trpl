<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Benefitkaryawan extends Model
{
    use HasFactory;

    protected $table = "benefit_karyawan";
    protected $fillable = [
        'id_karyawan','id_struktur_gaji','id_detailstrukturgaji','partner',
    ];

    public function partners()
    {
        return $this->belongsTo(Partner::class,'partner','id');
    }

    public function karyawans()
    {
        return $this->belongsTo(Karyawan::class,'id_karyawan','id');
    }

    public function strukturgajis()
    {
        return $this->belongsTo(Strukturgaji::class,'id_struktur_gaji','id');
    }

    public function detailstrukturgajis()
    {
        return $this->belongsTo(Detailstruktur::class,'id_detailstrukturgaji','id');
    }
}
