<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rpekerjaan extends Model
{
    use HasFactory;

    protected $table = 'rpekerjaan';
    
    protected $fillable = [
        'id',
        'id_pegawai',
        'nama_perusahaan',
        'alamat',
        'jenis_usaha',
        'jabatan',
        'nama_atasan',
        'nama_direktur',
        'lama_kerja',
        'alasan_berhenti',
        'gaji',
    ];

    protected $hidden = [
         
    ];

    public function karyawan()
    {
        return $this->hasMany(Karyawan::class, 'id');
    }

    ///icha
    // public function karyawans(){
    //     return $this->hasOne(Karyawan::class,'id_user','id');
    // }
}
