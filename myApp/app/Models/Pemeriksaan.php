<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pemeriksaan extends Model
{
    use HasFactory;

    protected $table = 'pemeriksaans';

    protected $fillable = [
        'kunjungan_id',
        'keluhan',
        'hasil_pemeriksaan',
        'riwayat_penyakit',
        'tanggal_periksa',
    ];

    protected $casts = [
        'tanggal_periksa' => 'datetime',
    ];

    /**
     * Satu pemeriksaan dimiliki oleh satu kunjungan.
     */
    public function kunjungan(): BelongsTo
    {
        return $this->belongsTo(Kunjungan::class);
    }
}