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
        Schema::create('antreans', function (Blueprint $table) {
            // Primary Key
            $table->id();

            // Relasi ke tabel kunjungans
            $table->foreignId('kunjungan_id')
                ->unique()
                ->constrained('kunjungans')
                ->cascadeOnDelete();

            // Nomor antrean
            $table->string('nomor_antrian');

            // Status antrean
            $table->enum('status', [
                'menunggu',
                'dipanggil',
                'dilayani',
                'selesai',
                'dibatalkan',
            ])->default('menunggu');

            // Waktu pendaftaran antrean
            $table->dateTime('waktu_daftar');

            // Timestamp
            $table->timestamps();

            // Mencegah nomor antrean yang sama pada waktu yang sama
            $table->unique([
                'nomor_antrian',
                'waktu_daftar',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('antreans');
    }
};