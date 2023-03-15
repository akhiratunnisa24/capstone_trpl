<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    protected $table = 'file';

    protected $fillable = [
        'id',
        'id_pegawai',
        'ktp',
        'kk',
        'npwp',
        'bpjs_ket',
        'bpjs_kes',
        'as_akdhk',
        'buku_tabungan',
        'skck',
        'ijazah',
        'lamaran',
        'surat_pengalaman_kerja',
        'surat_penghargaan',
        'surat_pelatihan',
        'surat_perjanjian_kerja',
        'surat_pengangkatan_kartap',
        'surat_alih_tugas',
    ];
}
