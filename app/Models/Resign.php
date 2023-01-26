<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resign extends Model
{
    use HasFactory;
    protected $table ='resign';
    protected $fillable = [
                            'id_karyawan','tgl_resign','alasan','status'
                            
                        ];
    
    // public function jenisizins()
    // {
    //     return $this->belongsTo(Jenisizin::class,'id_jenisizin','id');
    // }

    public function karyawans()
    {
        return $this->belongsTo(Karyawan::class, 'id_karyawan','id');
    }
    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'id_karyawan', 'id');
    }
}
