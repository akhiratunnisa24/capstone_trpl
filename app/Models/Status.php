<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;
    protected $table = 'statuses';
    protected $fillable = ['nama_status'];

    public function cuttis()
    {
        return $this->hasMany(Cuti::class);
    }

    public function resigns()
    {
        return $this->hasMany(Resign::class);
    }
    public function cuti()
    {
        return $this->hasMany(Cuti::class, 'status', 'id');
    }

    public function izin()
    {
        return $this->hasMany(Izin::class, 'status', 'id');
    }
}
