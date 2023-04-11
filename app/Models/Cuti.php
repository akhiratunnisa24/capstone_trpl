<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cuti extends Model
{
    use HasFactory;
    protected $table ='cuti';
    protected $fillable = [
                            'tgl_permohonan','nik','id_karyawan','jabatan','departemen',
                            'id_jeniscuti','keperluan','id_alokasi','id_settingalokasi',
                            'tgl_mulai','tgl_selesai','tgldisetujui_a','tgldisetujui_b',
                            'tglditolak','jml_cuti','status'
                        ];
    
    public function jeniscutis(){
        return $this->belongsTo(Jeniscuti::class,'id_jeniscuti','id');
    }

    public function karyawans(){
        return $this->belongsTo(Karyawan::class,'id_karyawan','id');
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'status', 'id');
    }

    public function departemens()
    {
        return $this->belongsTo(Departemen::class, 'departemen','id');
    }
    
    public function alokasi(){
        return $this->belongsTo(Alokasicuti::class,'id_alokasi','id');
    }

    public function settingalokasi(){
        return $this->belongsTo(Settingalokasi::class,'id_settingalokasi','id');
    }

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'id_karyawan', 'id');
    }

    public function jeniscuti()
    {
        return $this->belongsTo(Jeniscuti::class, 'id_jeniscuti', 'id');
    }

    public function datareject()
    {
        return $this->hasMany(Datareject::class,'id');
    } 
}
