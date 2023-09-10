<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detailkehadiran extends Model
{
    use HasFactory;
    protected $table = 'detail_kehadiran';
    protected $fillable = [
        'id_karyawan',
        'tgl_awal',
        'tgl_akhir',
        'jumlah_hadir',
        'jumlah_lembur',
        'jumlah_cuti',
        'jumlah_izin',
        'jumlah_sakit',
        'partner',
        'jam_hadir',
        'jam_lembur',
        'jam_cuti',
        'jam_izin',
        'jam_sakit',
        'total_jadwal'  
    ];

    public function karyawans()
    {
        return $this->belongsTo(Karyawan::class, 'id_karyawan','id');
    }


}
