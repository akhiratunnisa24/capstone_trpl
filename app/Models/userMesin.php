<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserMesin extends Model
{
    use HasFactory;
    protected $table='user_mesin';
    protected $fillable=['id_pegawai','nik','pin','departemen']; 
}
