<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tarif extends Model
{
    use HasFactory;

    protected $fillable = [
        'jenis',
        'kode',
        'perawatan',
        'pelayanan',
        'tipe_kamar',
        'kapasitas',
        'departemen',
        'tarif',
    ];

    public function scopeRawatJalan(Builder $query): Builder
    {
        return $query->where('jenis', 'rawat_jalan');
    }

    public function scopeRawatInap(Builder $query): Builder
    {
        return $query->where('jenis', 'rawat_inap');
    }
}
