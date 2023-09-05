<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenggajianGrup extends Model
{
    use HasFactory;
    protected $fillable = ['nama_grup','id_struktur','tglawal','tglakhir','tglgajian','partner'];

    public function slipgrup()
    {
        return $this->belongsTo(SalaryStructure::class, 'id_struktur', 'id');
    }
}



