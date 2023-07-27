<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensis extends Model
{
    use HasFactory;
    protected $table ='absensis';
    protected $fillable = [
        'no_id',
        'id_karyawan',
        'tanggal',
        'jam_masuk',
        'jam_pulang',
        'scan_masuk',
        'scan_keluar',
        'terlambat',
        'plg_cpt',
        'lembur',
        'jam_kerja',
        'jml_hadir',
    ];

    public function userss(){
        return $this->belongsTo(User::class,'id_user','id');
    }
    
    public function departemens()
    {
        return $this->belongsTo(Departemen::class,'id_departement','id');
    }

    public function karyawans()
    {
        return $this->belongsTo(Karyawan::class,'id_karyawan','id');
    }
    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'id_karyawan', 'id');
    }
}
