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
}
