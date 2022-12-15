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
        'id_karyawan','settingalokasi','id_jeniscuti','durasi',
        'mode_alokasi','aktif_dari','sampai'
    ];

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
