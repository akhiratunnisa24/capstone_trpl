<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Masterkpi extends Model
{
    use HasFactory;
    protected $table='masterkpi';
    protected $fillable=[
                            'id_departemen',
                            'nama_master',
                            'tglaktif',
                            'tglberakhir',
                            'status'
                        ];
                        
    public function departemens()
    {
        return $this->belongsTo(Departemen::class,'id_departemen','id');
    }
}
