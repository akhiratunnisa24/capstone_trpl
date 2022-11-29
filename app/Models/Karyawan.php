<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    use HasFactory;

    protected $table = 'karyawan';

    protected $guarded = [];

    public function kdarurat()
    {
        return $this->hasMany(Kdarurat::class, 
        'id_pegawai', 
        'nama', 
        'alamat', 
        'no_hp', 
        'hubungan');
    }
    
    public function keluarga()
    {
        return $this->hasMany(Kdarurat::class, 
        'id_pegawai', 
        'status_pernikahan', 
        'hubungan', 
        'nama', 
        'tgllahir', 
        'alamat', 
        'pendidikan_terakhir', 
        'pekerjaan');
    }
    
    public function rpekerjaan()
    {
        return $this->hasMany(Rpekerjaan::class, 
        'id_pegawai', 
        'nama_perusahaan', 
        'alamat', 
        'jenis_usaha', 
        'jabatan', 
        'nama_atasan', 
        'nama_direktur', 
        'lama_kerja',
        'alasan_berhenti',
        'gaji');
    }

    public function rpendidikan()
    {
        return $this->hasMany(Rpendidikan::class, 
        'id_pegawai', 
        'tingkat', 
        'nama_sekolah', 
        'kota', 
        'jurusan', 
        'tahun_lulus', 
        'jenis_pendidikan' );
    }
}
