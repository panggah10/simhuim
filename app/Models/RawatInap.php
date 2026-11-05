<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RawatInap extends Model
{
    use HasFactory;

    protected $fillable = [
        'pasien_id',
        'tarif_id',
        'id_ruang',
        'tanggal_checkin',
        'tanggal_checkout',
        'hari_menginap',
        'diagnosa',
        'biaya',
        'bayar',
        'status',
    ];

    protected $casts = [
        'tanggal_checkin' => 'date',
        'tanggal_checkout' => 'date',
    ];

    public function pasien(): BelongsTo
    {
        return $this->belongsTo(Pasien::class, 'pasien_id');
    }

    public function tarif(): BelongsTo
    {
        return $this->belongsTo(Tarif::class, 'tarif_id');
    }

    public function isLunas(): bool
    {
        return $this->bayar >= $this->biaya;
    }
}
