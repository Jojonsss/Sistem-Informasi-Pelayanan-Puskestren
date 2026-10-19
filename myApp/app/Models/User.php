<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function pasien(): HasOne
    {
        return $this->hasOne(Pasien::class, 'user_id', 'id');
    }

    public function admin(): HasOne
    {
        return $this->hasOne(Admin::class, 'user_id', 'id');
    }

    public function dokter(): HasOne
    {
        return $this->hasOne(Dokter::class, 'user_id', 'id');
    }
}
