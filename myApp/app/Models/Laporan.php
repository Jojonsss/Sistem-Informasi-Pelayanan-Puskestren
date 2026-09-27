<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Laporan extends Model
{
    use HasFactory;

    protected $table = 'laporans';

    protected $fillable = [
        'admin_id',
        'jenis_laporan',
        'periode',
        'tanggal_cetak',
        'file_laporan',
    ];

    protected $casts = [
        'tanggal_cetak' => 'datetime',
    ];

    /**
     * Satu laporan dibuat oleh satu admin.
     */
    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }
}