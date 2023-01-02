<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rpendidikan extends Model
{
    use HasFactory;

    protected $table = 'rpendidikan';

    protected $fillable = [
        'id',
        'id_pegawai',
        'tingkat',
        'nama_sekolah',
        'kota_pformal',
        'kota_pnonformal',
        'jurusan',
        'tahun_lulus_formal',
        'tahun_lulus_nonformal',
        'jenis_pendidikan',
    ];

    protected $hidden = [
         
    ];

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 
        'id_pegawai', 
        'tingkat', 
        'nama_sekolah', 
        'kota', 
        'jurusan', 
        'tahun_lulus', 
        'jenis_pendidikan' );
    }
}

