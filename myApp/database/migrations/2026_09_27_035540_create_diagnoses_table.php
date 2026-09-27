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
        Schema::create('diagnoses', function (Blueprint $table) {
            // Primary Key
            $table->id();

            // Relasi ke tabel kunjungans
            $table->foreignId('kunjungan_id')
                ->unique()
                ->constrained('kunjungans')
                ->cascadeOnDelete();

            // Data diagnosis
            $table->text('diagnosis');
            $table->text('tindakan')->nullable();
            $table->text('catatan')->nullable();

            // Waktu diagnosis
            $table->dateTime('tanggal_diagnosis');

            // Timestamp
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diagnoses');
    }
};