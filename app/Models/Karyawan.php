<?php

namespace App\Models;

use App\Models\Departemen;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Karyawan extends Model
{
    use HasFactory;

    protected $table = 'karyawan';

    protected $fillable = [
        'id'
    ];
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
        return $this->hasMany(Keluarga::class, 
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

    public function user()
    {
        return $this->hasMany(user::class, 
        'role',
        'name',
        'email' );
    }

    //hrms_git
    public function userss(){
        return $this->hasOne(User::class,'id_user','id');
    }

    public function departemens()
    {
        return $this->belongsTo(Departemen::class, 
        'divisi',
        'id',
        'nama_departemen',);
    }

    public function departemen()
    {
        return $this->hasMany(Departemen::class, 
        'id', 
        'nama_departemen', 
        );
    }   
}
