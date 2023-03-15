<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SettingHarilibur extends Model
{
    use HasFactory;
    protected $table = 'setting_harilibur';
    protected $fillable = ['tanggal','tipe','keterangan'];
}
