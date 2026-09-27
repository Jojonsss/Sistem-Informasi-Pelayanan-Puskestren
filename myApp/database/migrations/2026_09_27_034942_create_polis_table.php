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
        Schema::create('polis', function (Blueprint $table) {
            // Primary Key
            $table->id();

            // Data poli
            $table->string('nama_poli');
            $table->text('deskripsi')->nullable();

            // Status poli
            $table->enum('status', [
                'aktif',
                'nonaktif',
            ])->default('aktif');

            // Timestamp
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('polis');
    }
};