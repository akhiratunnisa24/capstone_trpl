<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cuti extends Model
{
    use HasFactory;
    protected $table ='cuti';
    protected $fillable = ['id_karyawan','id_jeniscuti','id_alokasi','keperluan',
                            'tgl_mulai','tgl_selesai','jml_cuti','status'
                        ];
    
    public function jeniscutis(){
        return $this->belongsTo(Jeniscuti::class,'id_jeniscuti','id');
    }

    public function karyawans(){
        return $this->belongsTo(Karyawan::class,'id_karyawan','id');
    }

    public function alokasi(){
        return $this->belongsTo(Alokasicuti::class,'id_alokasi','id');
    }
}
