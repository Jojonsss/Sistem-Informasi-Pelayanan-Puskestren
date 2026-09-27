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
        Schema::create('laporans', function (Blueprint $table) {
            // Primary Key
            $table->id();

            // Relasi ke tabel admins
            $table->foreignId('admin_id')
                ->constrained('admins')
                ->restrictOnDelete();

            // Informasi laporan
            $table->string('jenis_laporan');
            $table->string('periode');
            $table->dateTime('tanggal_cetak');
            $table->string('file_laporan')->nullable();

            // Timestamp
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporans');
    }
};