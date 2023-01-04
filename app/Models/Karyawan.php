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
        'id',
        'nip',
        'nik',
        'nama',
        'tgllahir',
        'email',
        'agama',
        'gol_darah',
        'jenis_kelamin',
        'alamat',
        'no_hp',
        'status_karyawan',
        'tipe_karyawan',
        'manager',
        'no_kk',
        'status_kerja',
        'cuti_tahunan',
        'divisi',
        'no_rek',
        'no_bpjs_kes',
        'no_npwp',
        'no_bpjs_ket',
        'kontrak',
        'jabatan',
        'gaji',
        'tglmasuk',
        'tglkeluar',
    ];
    protected $guarded = [];

    public function user()
    {
        return $this->hasMany(
            user::class,
            'role',
            'name',
            'email'
        );
    }

    //hrms_git
    public function userss()
    {
        return $this->hasOne(User::class, 'id_user', 'id');
    }

    //dipakai untuk mengambil data nama_departemen <---
    public function departemens()
    {
        return $this->belongsTo(
            Departemen::class,
            'divisi',
            'id',
            'nama_departemen',
        );
    }

    public function departemen()
    {
        return $this->hasMany(
            Departemen::class, 
            'id',
            'nama_departemen',
        );
    }
    
    public function keluarga()
    {
        return $this->belongsTo(Keluarga::class, 'id', 'id_pegawai');
    }
    public function kdarurat()
    {
        return $this->belongsTo(Kdarurat::class, 'id', 'id_pegawai');
    }
    public function rpekerjaan()
    {
        return $this->belongsTo(Rpekerjaan::class, 'id', 'id_pegawai');
    }
    public function rpendidikan()
    {
        return $this->belongsTo(Rpendidikan::class, 'id', 'id_pegawai');
    }
    
}
