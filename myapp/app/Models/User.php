<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'nama',
        'alamat',
        'no_hp',
        'role',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function periksa_pasien(): HasMany
    {
        return $this->hasMany(Periksa::class, 'id_pasien', 'id');
    }

    public function periksa_dokter(): HasMany
    {
        return $this->hasMany(Periksa::class, 'id_dokter', 'id');
    }

    public function periksas(): HasMany
    {
        return $this->hasMany(Periksa::class, 'id_pasien', 'id')
            ->orWhere('id_dokter', $this->id);
    }
}
