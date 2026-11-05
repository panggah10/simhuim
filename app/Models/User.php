<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'role',
        'grup',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'status' => 'boolean',
    ];

    public function isAdmin(): bool
    {
        return $this->role === 'Admin';
    }

    public function isFrontOffice(): bool
    {
        return $this->role === 'Front Office';
    }

    public function isDokter(): bool
    {
        return $this->role === 'Dokter';
    }

    public function isDepartemen(): bool
    {
        return $this->role === 'Departemen';
    }


    public function dokter(): HasOne
    {
        return $this->hasOne(Dokter::class, 'user_id');
    }
}
