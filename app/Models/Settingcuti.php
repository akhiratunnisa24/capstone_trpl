<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settingcuti extends Model
{
    use HasFactory;
    protected $table= 'setting_cuti';
    protected $fillable = ['id_pegawai','id_jeniscuti','jumlah_cuti','sisa_cuti','periode'];

    public function jeniscutis()
    {
        return $this->belongsTo(Jeniscuti::class,'id_jeniscuti','id');
    }

    public function karyawans()
    {
        return $this->belongsTo(Karyawan::class,'id_pegawai','id');
    }
}
