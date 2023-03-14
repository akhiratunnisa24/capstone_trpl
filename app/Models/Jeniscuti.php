<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jeniscuti extends Model
{
    use HasFactory;
    protected $table ='jeniscuti';
    protected $fillable = [
                            'jenis_cuti',
                        ];

    public function cuti()
    {
        return $this->hasMany(Cuti::class, 'id');
    }

    public function settingcuti()
    {
        return $this->hasMany(Settingcuti::class, 'id');
    }

    public function sisacuti()
    {
        return $this->hasMany(Sisacuti::class, 'id');
    }
}
