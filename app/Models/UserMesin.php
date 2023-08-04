<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserMesin extends Model
{
    use HasFactory;
    protected $table='user_mesin';
    protected $fillable=['id_pegawai','nik','noid','noid2','departemen','partner']; 

    public function departemens()
    {
        return $this->belongsTo(Departemen::class,'divisi','id');
    }
        
    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'id_pegawai', 'id');
    }
}
