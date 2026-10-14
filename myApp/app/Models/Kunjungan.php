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
    protected $primaryKey = 'id_kunjungan';

    protected $fillable = [
        'id_pasien',
        'id_dokter',
        'id_poli',
        'tanggal',
        'status',
        'keluhan_awal',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function pasien(): BelongsTo
    {
        return $this->belongsTo(
            Pasien::class,
            'id_pasien',
            'id_pasien'
        );
    }

    public function dokter(): BelongsTo
    {
        return $this->belongsTo(
            Dokter::class,
            'id_dokter',
            'id_dokter'
        );
    }

    public function poli(): BelongsTo
    {
        return $this->belongsTo(
            Poli::class,
            'id_poli',
            'id_poli'
        );
    }

    public function antrean(): HasOne
    {
        return $this->hasOne(
            Antrean::class,
            'id_kunjungan',
            'id_kunjungan'
        );
    }

    public function pemeriksaan(): HasOne
    {
        return $this->hasOne(
            Pemeriksaan::class,
            'id_kunjungan',
            'id_kunjungan'
        );
    }

    public function diagnosis(): HasOne
    {
        return $this->hasOne(
            Diagnosis::class,
            'id_kunjungan',
            'id_kunjungan'
        );
    }
}
