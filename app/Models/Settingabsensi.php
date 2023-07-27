<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settingabsensi extends Model
{
    use HasFactory;
    protected $table = 'setting_absensi';
    protected $fillable = ['toleransi_terlambat','jumlah_terlambat','sanksi_terlambat','status_tidakmasuk','jumlah_tidakmasuk','sanksi_tidak_masuk'];
}
