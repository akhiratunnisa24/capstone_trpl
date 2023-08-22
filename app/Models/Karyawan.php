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
        'tempatlahir',
        'email',
        'agama',
        'gol_darah',
        'jenis_kelamin',
        'alamat',
        'no_hp',
        'status_karyawan',
        'tipe_karyawan',
        'atasan_pertama',
        'atasan_kedua',
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
        'partner',
        'status_pernikahan',
        'jumlah_anak'
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

    public function atasan_pertamaa()
    {
        return $this->belongsTo(Karyawan::class, 'atasan_pertama','id');
    }

    public function atasan_keduab()
    {
        return $this->belongsTo(Karyawan::class, 'atasan_kedua','id');
    }

    //hrms_git
    public function userss()
    {
        return $this->hasOne(User::class, 'id_user', 'id');
    }

    //dipakai untuk mengambil data nama_departemen <---
    public function departemens()
    {
        return $this->belongsTo(Departemen::class,'divisi','id');
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
    public function tidakmasuk()
    {
        return $this->belongsTo(Tidakmasuk::class, 'id', 'id_pegawai');
    }
    public function user2()
    {
        return $this->belongsTo(User::class, 'id', 'id_pegawai');
    }
    public function rorganisasi()
    {
        return $this->belongsTo(Rorganisasi::class, 'id', 'id_pegawai');
    }
    public function rprestasi()
    {
        return $this->belongsTo(Rprestasi::class, 'id', 'id_pegawai');
    }
    
    public function cuti()
    {
        return $this->hasMany(Cuti::class, 'id');
    }

    public function atasan()
    {
        return $this->hasOne(Atasan::class, 'id_karyawan');
    }

    public function izin()
    {
        return $this->hasMany(Izin::class, 'id');
    }
    public function absensi()
    {
        return $this->hasMany(Absensi::class, 'id');
    }

    public function absensis()
    {
        return $this->hasMany(Absensis::class, 'id');
    }
    public function departemen()
    {
        return $this->belongsTo(Departemen::class, 'divisi', 'id');
    }

    public function settingcuti()
    {
        return $this->hasMany(Settingcuti::class, 'id');
    }

    public function sisacuti()
    {
        return $this->hasMany(Sisacuti::class, 'id');
    }

    public function jadwal()
    {
        return $this->hasMany(Jadwal::class, 'id');
    }

    public function timkaryawans()
    {
        return $this->hasMany(Timkaryawan::class,'id_karyawan','id');
    }

}
