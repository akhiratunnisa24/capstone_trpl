<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Izin extends Model
{
    use HasFactory;
    protected $table ='izin';
    protected $fillable = [
                            'id_karyawan','id_jenisizin','keperluan',
                            'tgl_mulai','tgl_selesai','jam_mulai','jam_selesai',
                            'jml_hari','jml_jam','status'
                        ];
    
    public function jenisizins()
    {
        return $this->belongsTo(Jenisizin::class,'id_jenisizin','id');
    }

    public function karyawans()
    {
        return $this->belongsTo(Karyawan::class, 'id_karyawan','id');
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
