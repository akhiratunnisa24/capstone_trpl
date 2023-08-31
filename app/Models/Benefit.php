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
        'kode',
        'aktif',
        'dikenakan_pajak',
        'kelas_pajak',
        'tipe',
        'muncul_dipenggajian',
        'siklus_pembayaran',
        'besaran_bulanan',
        'besaran_mingguan',
        'besaran_harian',
        'besaran_jam',
        'besaran',
        'partner',
        'jumlah',
        'urutan',
        'dibayarkan_oleh',
        'gaji_minimum',
        'gaji_maksimum'
    ];

    public function partners()
    {
        return $this->belongsTo(Partner::class,'partner','id');
    }

    public function kategoribenefits()
    {
        return $this->belongsTo(Kategoribenefit::class,'id_kategori','id');
    }
    public function detail_salarys()
    {
        return $this->hasMany(DetailSalaryStructure::class, 'id_benefit','id');
    }
    public function benefits()
    {
        return $this->belongsToMany(Benefit::class, 'detail_salary_structure', 'id_salary_structure', 'id_benefit');
    }

    public function detailinformasigaji()
    {
        return $this->hasMany(Detailinformasigaji::class, 'id_benefit','id');
    }

    public function manfaat()
    {
        return $this->belongsToMany(Benefit::class, 'detail_informasigaji', 'id_informasigaji', 'id_benefit');
    }
}
