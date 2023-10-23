<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GetUser extends Model
{
    use HasFactory;
    protected $table = 'get_user';

    protected $fillable = [
        'PIN',
        'Name',
        'Password',
        'Group',
        'Privilege',
        'Card',
        'status',
        'partner'
    ];

}
