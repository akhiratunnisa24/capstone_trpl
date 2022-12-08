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
                            'id_departemen','h_normal',
                            'ap','hl','jam_kerja',
                            'lemhanor','lemakpek','lemhali',
                        ];
    
    //relasi ke tabel employee/personel
    // public function jadwals(){
    //     return $this->belongsTo(Jadwal::class,'id_jadwal','id');
    // }

    public function userss(){
        return $this->belongsTo(User::class,'id_user','id');
    }
    
    public function departemens(){
        return $this->belongsTo(Departemen::class,'id_departemen','id');
    }

    public function karyawans()
    {
        return $this->belongsTo(Karyawan::class, 'id_karyawan','id');
    }
}
