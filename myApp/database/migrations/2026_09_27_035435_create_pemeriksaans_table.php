<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pemeriksaans', function (Blueprint $table) {
            // Primary Key
            $table->id();

            // Relasi ke tabel kunjungans
            $table->foreignId('kunjungan_id')
                ->unique()
                ->constrained('kunjungans')
                ->cascadeOnDelete();

            // Data pemeriksaan
            $table->text('keluhan')->nullable();
            $table->text('hasil_pemeriksaan')->nullable();
            $table->text('riwayat_penyakit')->nullable();

            // Waktu pemeriksaan
            $table->dateTime('tanggal_periksa');

            // Timestamp
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemeriksaans');
    }
};