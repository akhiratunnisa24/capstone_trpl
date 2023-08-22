<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailSalaryStructure extends Model
{
    use HasFactory;

    protected $table = 'detail_salary_structure';

    protected $fillable = [
        'id',
        'id_salary_structure',
        'id_benefit',
    ];
    protected $guarded = [];

    public function salary()
    {
        return $this->belongsTo(SalaryStructure::class, 'id_salary_structure','id');
    }

    public function benefit()
    {
        return $this->belongsTo(Benefit::class, 'id_benefit','id');
    }
}
