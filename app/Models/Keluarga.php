<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keluarga extends Model
{
    use HasFactory;
    
    protected $table = 'keluarga';

    protected $fillable = [
        'id',
        'id_pegawai',
        'hubungan',
        'status_pernikahan',
        'nama',
        'tgllahir',
        'alamat',
        'pendidikan_terakhir',
        'pekerjaan',
    ];

    protected $hidden = [
         
    ];

    // public function karyawan()
    // {
    //     return $this->belongsTo(Karyawan::class, 'id');
    // }

    // public function Karyawan()
    // {
    //     return $this->belongsTo('App\Models\Karyawan','id_karyawan');
    // }

    // public function karyawan(){
    //     return $this->hasMany(Karyawan::class,'id');
    // }
    

    // public function karyawan()
    // {
    //     return $this->belongsTo(Karyawan::class, 'id_pegawai', 'id');
    // }

    public function karyawan()
    {
        return $this->hasMany(Karyawan::class, 'id');
    }
 
    
    

    //   public function karyawan()
    // {
    //     return $this->belongsTo(Karyawan::class, 
    //     'id', 
    //     'departemen', 
    //     );
    // }
}
