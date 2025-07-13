<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PredictionHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_karyawan', 'nama', 'status_karyawan', 'status_kerja',
        'rasio_keterlambatan', 'rasio_pulang_cepat',
        'total_hari_izin', 'total_hari_sakit', 'jumlah_cuti',
        'resign_probability', 'risk_score', 'prediksi_resign', 'prediction_number'
    ];

}
