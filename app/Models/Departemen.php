<?php

namespace App\Models;

use App\Models\Karyawan;
use App\Models\Settingalokasi;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Departemen extends Model
{
    use HasFactory;

    protected $table='departemen';
    protected $fillable=['nama_departemen']; 
    
    public function karyawans()
    {
        return $this->hasMany(Karyawan::class, 
            'id_departement','id'
        );
    }

    public function settingalokasi()
    {
        return $this->hasMany(Settingalokasi::class, 
            'id_departement','id'
        );
    }
}
