<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jenisizin extends Model
{
    use HasFactory;
    protected $table ='jenisizin';
    protected $fillable = [
                            'jenis_izin','code'
                        ];
    public function izin()
    {
        return $this->hasMany(Izin::class, 'id');
    }
}
