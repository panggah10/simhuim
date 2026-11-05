<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RawatJalan extends Model
{
    use HasFactory;

    protected $fillable = [
        'pasien_id',
        'dokter_id',
        'departemen',
        'tanggal',
        'keluhan',
        'diagnosa',
        'tindakan',
        'biaya',
        'bayar',
        'status_periksa',
    ];

    protected $casts = [
        'tanggal' => 'datetime',
    ];

    public function pasien(): BelongsTo
    {
        return $this->belongsTo(Pasien::class, 'pasien_id');
    }

    public function dokter(): BelongsTo
    {
        return $this->belongsTo(Dokter::class, 'dokter_id');
    }

    public function reseps(): HasMany
    {
        return $this->hasMany(Resep::class, 'rawat_jalan_id');
    }

    public function isLunas(): bool
    {
        return $this->bayar >= $this->biaya;
    }
}
