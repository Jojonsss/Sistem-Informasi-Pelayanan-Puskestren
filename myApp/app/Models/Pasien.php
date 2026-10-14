<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pasien extends Model
{
    use HasFactory;

    protected $table = 'pasiens';
    protected $primaryKey = 'id_pasien';

    protected $fillable = [
        'user_id',
        'jenis_pasien',
        'nama',
        'alamat',
        'asrama',
        'no_identitas',
        'tanggal_lahir',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id_user');
    }

    public function kunjungans(): HasMany
    {
        return $this->hasMany(Kunjungan::class, 'id_pasien', 'id_pasien');
    }
}
