<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Poli extends Model
{
    use HasFactory;

    protected $table = 'polis';

    protected $fillable = [
        'nama_poli',
        'deskripsi',
        'status',
    ];

    /**
     * Satu poli dapat memiliki banyak dokter.
     */
    public function dokters(): HasMany
    {
        return $this->hasMany(Dokter::class);
    }

    /**
     * Satu poli dapat memiliki banyak kunjungan.
     */
    public function kunjungans(): HasMany
    {
        return $this->hasMany(Kunjungan::class);
    }
}