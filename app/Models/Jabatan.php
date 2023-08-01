<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
    use HasFactory;

    protected $table='jabatan';
    protected $fillable=['level_jabatan','nama_jabatan','partner']; 

    public function partners()
    {
        return $this->belongsTo(Partner::class, 'partner', 'id');
    }
}
