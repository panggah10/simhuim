<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Resep extends Model
{
    use HasFactory;

    protected $fillable = [
        'pasien_id',
        'dokter_id',
        'rawat_jalan_id',
        'nama_resep',
        'rincian_resep',
        'tanggal',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function pasien(): BelongsTo
    {
        return $this->belongsTo(Pasien::class, 'pasien_id');
    }

    public function dokter(): BelongsTo
    {
        return $this->belongsTo(Dokter::class, 'dokter_id');
    }

    public function rawatJalan(): BelongsTo
    {
        return $this->belongsTo(RawatJalan::class, 'rawat_jalan_id');
    }
}
