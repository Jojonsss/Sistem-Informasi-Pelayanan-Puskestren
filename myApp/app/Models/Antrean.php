<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Antrean extends Model
{
    use HasFactory;

    protected $table = 'antreans';

    protected $fillable = [
        'kunjungan_id',
        'nomor_antrian',
        'status',
        'waktu_daftar',
    ];

    protected $casts = [
        'waktu_daftar' => 'datetime',
    ];

    /**
     * Satu antrean dimiliki oleh satu kunjungan.
     */
    public function kunjungan(): BelongsTo
    {
        return $this->belongsTo(Kunjungan::class);
    }
}