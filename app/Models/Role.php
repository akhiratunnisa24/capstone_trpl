<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $table = 'role';
    protected $fillable = [
        'id',
        'role',
        'status',
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'id');
    }
}
