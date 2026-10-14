<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Antrean extends Model
{
    use HasFactory;

    protected $table = 'antreans';
    protected $primaryKey = 'id_antrean';

    protected $fillable = [
        'id_kunjungan',
        'nomor_antrean',
        'status',
        'waktu_panggil',
    ];

    protected $casts = [
        'waktu_panggil' => 'datetime',
    ];

    public function kunjungan(): BelongsTo
    {
        return $this->belongsTo(
            Kunjungan::class,
            'id_kunjungan',
            'id_kunjungan'
        );
    }
}
