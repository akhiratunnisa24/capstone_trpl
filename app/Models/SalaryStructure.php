<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalaryStructure extends Model
{
    use HasFactory;

    protected $table = 'salary_structure';

    protected $fillable = [
        'id',
        'nama',
        'partner',
        'parent',
        'reference',
    ];
    protected $guarded = [];

    public function partners()
    {
        return $this->belongsTo(Partner::class,'partner','id');
    }

    public function detail_salary()
    {
        return $this->hasMany(DetailSalaryStructure::class, 'id_salary_structure');
    }
}
