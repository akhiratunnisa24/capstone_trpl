<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
        'id_pegawai',
        'role',
        'name',
        'email',
        'password', 
        'status_akun',
        'partner'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'id_pegawai', 'id');
    }

    //hrms_git
    public function karyawans(){
        return $this->hasOne(Karyawan::class,'id_pegawai','id');
    }

    public function roles()
    {
        return $this->belongsTo(Role::class,'role','id');
    }

    public function partners()
    {
        return $this->belongsTo(Partner::class,'partner','id');
    }
    
}

