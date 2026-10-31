<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Dokter extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama_dokter',
        'departemen',
        'jadwal_praktik',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function rawatJalans(): HasMany
    {
        return $this->hasMany(RawatJalan::class, 'dokter_id');
    }

    public function reseps(): HasMany
    {
        return $this->hasMany(Resep::class, 'dokter_id');
    }
}
