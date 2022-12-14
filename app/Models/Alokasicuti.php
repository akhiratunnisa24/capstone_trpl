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
    protected $guard = [];

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
