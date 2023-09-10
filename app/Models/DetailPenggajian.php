<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPenggajian extends Model
{
    use HasFactory;
    protected $table ='detail_penggajian';
    protected $fillable=[
        'id_karyawan',
        'id_penggajian',
        'id_benefit',
        'id_detailinformasigaji',
        'nominal',
        'jumlah',
        'total'
    ];

    public function karyawans()
    {
        return $this->belongsTo(Karyawan::class, 'id_karyawan','id');
    }

    public function penggajians()
    {
        return $this->belongsTo(Penggajian::class, 'id_penggajian','id');
    }

    public function detailinformasigajis()
    {
        return $this->belongsTo(Detailinformasigaji::class, 'id_detailinformasigaji','id');
    }

    public function benefit()
    {
        return $this->belongsTo(Benefit::class, 'id_benefit','id');
    }
    
}
