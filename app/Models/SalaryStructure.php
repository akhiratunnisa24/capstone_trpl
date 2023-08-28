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
        'id_level_jabatan',
        'status_karyawan',
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

    public function level_jabatans()
    {
        return $this->belongsTo(LevelJabatan::class,'id_level_jabatan');
    }

    public function benefits()
    {
        return $this->belongsToMany(Benefit::class, 'detail_salary_structure', 'id_salary_structure', 'id_benefit');
    }

    public function informasigajis()
    {
        return $this->hasMany(Informasigaji::class, 'id_strukturgaji', 'id');
    }

}
