<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;
    protected $table ='absensi';
    protected $fillable = ['id_karyawan','nik',
                            'tanggal','shift',
                            'jadwal_masuk','jadwal_pulang',
                            'jam_masuk','jam_keluar',
                            'normal','riil',
                            'terlambat','plg_cepat',
                            'absent','lembur',
                            'jml_jamkerja', 'pengecualian',
                            'hci','hco',
                            'id_departement','h_normal',
                            'ap','hl','jam_kerja',
                            'lemhanor','lemakpek','lemhali','imported'
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
