<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Role;

class User extends Authenticatable
{
    protected $primaryKey = 'id_user';
    use HasFactory, Notifiable;

    /**
     * Kolom yang boleh diisi secara mass assignment.
     */
    protected $fillable = [
    'role_id',
    'nama',
    'email',
    'password',
    ];

    /**
     * Kolom yang disembunyikan dari array / JSON.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casting tipe data.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Satu user dapat memiliki satu profil pasien.
     */
    public function pasien(): HasOne
    {
    return $this->hasOne(Pasien::class, 'user_id', 'id_user');
    }

    /**
     * Satu user dapat memiliki satu profil admin.
     */
    public function admin(): HasOne
    {
        return $this->hasOne(Admin::class);
    }

    /**
     * Satu user dapat memiliki satu profil dokter.
     */
    public function dokter(): HasOne
    {
        return $this->hasOne(Dokter::class);
    }

    public function roleData(): BelongsTo
{
    return $this->belongsTo(Role::class, 'role_id', 'id_role');
}

}
