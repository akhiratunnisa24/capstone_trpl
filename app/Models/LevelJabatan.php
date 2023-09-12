<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LevelJabatan extends Model
{
    use HasFactory;
    protected $table='level_jabatan';
    protected $fillable=['nama_level'];

    public function informasigajis()
    {
        return $this->hasMany(Informasigaji::class, 'level_jabatan','id');
    }
    public function historyjabatans()
    {
        return $this->hasMany(HistoryJabatan::class, 'id_leveljabatan','id');
    }
}
