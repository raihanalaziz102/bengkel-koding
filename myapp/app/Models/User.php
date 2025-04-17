<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'nama',
        'alamat',
        'no_hp',
        'role',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function cast(): array
    {
            return [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    
    }


    public function periksa_pasien(){
    return $this->hasMany(periksa_pasien::class, 'id_pasien', 'id');
    }
    
    public function periksa_dokter(){
    return $this->hasMany(periksa_dokter::class, 'id_dokter', 'id');
    }
}


