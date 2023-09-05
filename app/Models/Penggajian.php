<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penggajian extends Model
{
    use HasFactory;

    protected $table = "penggajian";
    protected $fillable = [
        'id_karyawan',
        'id_informasigaji',
        'tglawal',
        'tglakhir',
        'tglgajian',
        'gaji_pokok',
        'lembur',
        'tunjangan',
        'gaji_kotor',
        'asuransi',
        'potongan',
        'pajak',
        'gaji_bersih',
        'nama_bank',
        'no_rek',
        'partner'
    ];

    public function karyawans()
    {
        return $this->belongsTo(Karyawan::class, 'id_karyawan','id');
    }

    public function informasigajis()
    {
        return $this->belongsTo(Informasigaji::class, 'id_informasigaji','id');
    }
}
