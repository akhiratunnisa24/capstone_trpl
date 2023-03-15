<?php

namespace App\Models;

use App\Models\Karyawan;
use App\Models\Jeniscuti;
use App\Models\Settingalokasi;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Alokasicuti extends Model
{
    use HasFactory;

    protected $table ='alokasicuti';
    protected $fillable = [
        'id_karyawan','id_settingalokasi','id_jeniscuti','durasi',
        'mode_alokasi','tgl_masuk','tgl_sekarang','aktif_dari','sampai','status'
    ];

    public function cuti()
    {
        return $this->hasMany(Cuti::class, 'id_alokasi','id');
    }

    public function jeniscutis()
    {
        return $this->belongsTo(Jeniscuti::class,'id_jeniscuti','id');
    }

    public function karyawans()
    {
        return $this->belongsTo(Karyawan::class,'id_karyawan','id');
    }

    public function settingalokasis()
    {
        return $this->belongsTo(Settingalokasi::class,'id_settingalokasi','id');
    }
}
