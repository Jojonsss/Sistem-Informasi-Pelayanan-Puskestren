<?php

namespace Database\Seeders;

use App\Models\Kunjungan;
use Illuminate\Database\Seeder;

class KunjunganSeeder extends Seeder
{
    /**
     * Jalankan seeder.
     */
    public function run(): void
    {
        // Membuat 15 data kunjungan dummy
        Kunjungan::factory(15)->create();
    }
}