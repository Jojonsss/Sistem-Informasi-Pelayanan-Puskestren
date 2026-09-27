<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Kunjungan extends Model
{
    use HasFactory;

    protected $table = 'kunjungans';

    protected $fillable = [
        'pasien_id',
        'dokter_id',
        'poli_id',
        'tanggal_kunjungan',
        'keluhan',
        'status',
    ];

    protected $casts = [
        'tanggal_kunjungan' => 'date',
    ];

    /**
     * Satu kunjungan dimiliki oleh satu pasien.
     */
    public function pasien(): BelongsTo
    {
        return $this->belongsTo(Pasien::class);
    }

    /**
     * Satu kunjungan ditangani oleh satu dokter.
     */
    public function dokter(): BelongsTo
    {
        return $this->belongsTo(Dokter::class);
    }

    /**
     * Satu kunjungan berada pada satu poli.
     */
    public function poli(): BelongsTo
    {
        return $this->belongsTo(Poli::class);
    }

    /**
     * Satu kunjungan memiliki satu antrean.
     */
    public function antrean(): HasOne
    {
        return $this->hasOne(Antrean::class);
    }

    /**
     * Satu kunjungan memiliki satu pemeriksaan.
     */
    public function pemeriksaan(): HasOne
    {
        return $this->hasOne(Pemeriksaan::class);
    }

    /**
     * Satu kunjungan memiliki satu diagnosis.
     */
    public function diagnosis(): HasOne
    {
        return $this->hasOne(Diagnosis::class);
    }
}