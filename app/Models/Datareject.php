<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Datareject extends Model
{
    use HasFactory;
    protected $table='datareject';
    protected $fillable=['id','id_cuti','id_izin','alasan']; 

    public function cuti()
    {
        return $this->belongsTo(Cuti::class, 'id_cuti', 'id');
    }

    public function izin()
    {
        return $this->belongsTo(Izin::class, 'id_izin','id');
    }
}
