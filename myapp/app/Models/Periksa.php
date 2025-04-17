<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Periksa extends Model
{
    use HasFactory;

    protected $table = 'periksas';

    protected $fillable = [
        'id_pasien',
        'id_dokter',
        'tgl_periksa',
        'catatan',
        'biaya_periksa',
    ];

    public function pasien()
    {
        return $this->belongsTo(User::class, 'id_pasien');
    }

    public function dokter()
    {
        return $this->belongsTo(User::class, 'id_dokter');
    }

    public function detailPeriksa()
    {
        return $this->hasMany(DetailPeriksa::class, 'id_periksa');
    }

    // Akses langsung ke obat melalui detail_periksa
    public function obat()
    {
        return $this->hasManyThrough(
            Obat::class,
            DetailPeriksa::class,
            'id_periksa', // Foreign key di tabel detail_periksa
            'id',         // Foreign key di tabel obat
            'id',         // Local key di periksas
            'id_obat'     // Local key di detail_periksa
        );
    }
}
