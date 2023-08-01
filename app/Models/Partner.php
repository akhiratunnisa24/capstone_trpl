<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    use HasFactory;
    protected $table = 'partner';
    protected $fillable = ['nama_partner'];

    public function listmesins()
    {
        return $this->hasMany(Listmesin::class, 'partner', 'id');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'partner', 'id');
    }

    public function shifts()
    {
        return $this->hasMany(Shift::class, 'partner', 'id');
    }

    public function jadwals()
    {
        return $this->hasMany(Jadwal::class, 'partner', 'id');
    }

    public function departemens()
    {
        return $this->hasMany(Departemen::class, 'partner', 'id');
    }

    public function jabatans()
    {
        return $this->hasMany(Jabatan::class, 'partner', 'id');
    }

    public function informasis()
    {
        return $this->hasMany(Informasi::class, 'partner', 'id');
    }

}
