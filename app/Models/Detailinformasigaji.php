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
                ];
    protected $guarded = [];

    public function strukturgaji()
    {
        return $this->belongsTo(SalaryStructure::class, 'id_struktur','id');
    }

    public function benefits()
    {
        return $this->belongsTo(Benefit::class, 'id_benefit','id');
    }

    
}
