<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('push_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_pasien')
                ->constrained('pasien', 'id_pasien')
                ->cascadeOnDelete();

            $table->text('endpoint')->unique();
            $table->text('public_key');
            $table->text('auth_token');
            $table->string('content_encoding')->default('aes128gcm');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('push_subscriptions');
    }
};
