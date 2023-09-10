<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SettingOrganisasi extends Model
{
    use HasFactory;
    protected $table= 'setting_organisasi';
    protected $fillable = [
        'nama_perusahaan','email','alamat', 'daerah' ,'no_telp','kode_pos','logo','partner'
    ];

    public function partners()
    {
        return $this->belongsTo(Partner::class,'partner','id');
    }
}
