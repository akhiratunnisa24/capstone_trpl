<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detailinformasigaji extends Model
{
    use HasFactory;

    protected $table = 'detail_informasigaji';

    protected $fillable = [
                    'id_karyawan',
                    'id_informasigaji',
                    'id_struktur',
                    'id_benefit',
                    'siklus_bayar',
                    'nominal',
                    'partner'
                ];
    protected $guarded = [];

    public function strukturgaji()
    {
        return $this->belongsTo(SalaryStructure::class, 'id_struktur','id');
    }

    public function karyawans()
    {
        return $this->belongsTo(Karyawan::class, 'id_karyawan','id');
    }

    public function benefit()
    {
        return $this->belongsTo(Benefit::class, 'id_benefit','id');
    }

    public function informasigajis()
    {
        return $this->belongsTo(Informasigaji::class, 'id_infrmasigaji','id');
    }

    
}
