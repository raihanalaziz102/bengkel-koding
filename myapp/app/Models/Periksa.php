<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Periksa extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_pasien',
        'id_dokter',
        'tgl_periksa',
        'catatan',
        'biaya_pemeriksaan',
    ];

    public function pasien(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_pasien');
    }
    public function dokter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_dokter');
    }
    public function detail_periksa(): HasMany
    {
        return $this->hasMany(DetailPeriksa::class, 'id_periksa', 'id');
    }
}
