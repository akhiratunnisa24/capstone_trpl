<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Izin extends Model
{
    use HasFactory;
    protected $table ='izin';
    protected $fillable = [
                            'tgl_permohonan','nik','id_karyawan','jabatan','departemen',
                            'id_jenisizin','keperluan','tgl_mulai','tgl_selesai','jam_mulai',
                            'jam_selesai','tgl_setuju_a', 'tgl_setuju_b'
                            ,'tgl_ditolak','jml_hari','jml_jam','status','codeizin'
                        ];
    
    public function jenisizins()
    {
        return $this->belongsTo(Jenisizin::class,'id_jenisizin','id');
    }

    public function karyawans()
    {
        return $this->belongsTo(Karyawan::class, 'id_karyawan','id');
    }

    public function departemens()
    {
        return $this->belongsTo(Departemen::class, 'departemen','id');
    }
    
    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'id_karyawan', 'id');
    }

    public function datareject()
    {
        return $this->hasMany(Datareject::class,'id');
    }    
}
