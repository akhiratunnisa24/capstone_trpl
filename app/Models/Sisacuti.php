<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sisacuti extends Model
{
    use HasFactory;
    protected $table= 'sisacuti';
    protected $fillable = ['id_pegawai','id_setting','jenis_cuti','jumlah_cuti','sisa_cuti','periode','dari','sampai','status'];

    public function jeniscutis()
    {
        return $this->belongsTo(Jeniscuti::class,'id_jeniscuti','id');
    }

    public function karyawans()
    {
        return $this->belongsTo(Karyawan::class,'id_pegawai','id');
    }
}
