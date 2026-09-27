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
        Schema::create('pasiens', function (Blueprint $table) {
            // Primary Key
            $table->id();

            // Relasi ke tabel users
            $table->foreignId('user_id')
                ->unique()
                ->constrained('users')
                ->cascadeOnDelete();

            // Jenis pasien
            $table->enum('jenis_pasien', [
                'santri',
                'umum',
            ]);

            // Identitas pasien
            $table->string('no_identitas')->nullable();
            $table->text('alamat')->nullable();
            $table->string('no_hp')->nullable();

            // Timestamp
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pasiens');
    }
};