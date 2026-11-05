<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pasien extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_rekam_medis',
        'nama_pasien',
        'tmp_lahir',
        'tgl_lahir',
        'jenis_kelamin',
        'alamat',
        'no_telepon',
        'agama',
        'pend_terakhir',
        'pekerjaan',
        'nama_pj_pasien',
        'hub_pj_pasien',
        'pekerjaan_pj',
        'no_pj',
    ];

    protected $casts = [
        'tgl_lahir' => 'date',
    ];

    public function rawatJalans(): HasMany
    {
        return $this->hasMany(RawatJalan::class, 'pasien_id');
    }

    public function rawatInaps(): HasMany
    {
        return $this->hasMany(RawatInap::class, 'pasien_id');
    }

    public function reseps(): HasMany
    {
        return $this->hasMany(Resep::class, 'pasien_id');
    }

    public function getUsiaAttribute(): ?int
    {
        return $this->tgl_lahir ? Carbon::parse($this->tgl_lahir)->age : null;
    }
}
