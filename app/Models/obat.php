<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Obat extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_obat',
        'kemasan',
        'harga',
    ];

    public function detail_periksas(): HasMany
    {
        return $this->hasMany(Detail_periksa::class, 'id_obat', 'id');
    }

    //
}