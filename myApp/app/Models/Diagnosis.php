<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Diagnosis extends Model
{
    use HasFactory;

    protected $table = 'diagnoses';

    protected $fillable = [
        'kunjungan_id',
        'diagnosis',
        'tindakan',
        'catatan',
        'tanggal_diagnosis',
    ];

    protected $casts = [
        'tanggal_diagnosis' => 'datetime',
    ];

    /**
     * Satu diagnosis dimiliki oleh satu kunjungan.
     */
    public function kunjungan(): BelongsTo
    {
        return $this->belongsTo(Kunjungan::class);
    }
}