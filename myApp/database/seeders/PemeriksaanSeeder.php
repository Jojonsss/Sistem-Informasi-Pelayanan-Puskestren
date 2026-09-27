<?php

namespace Database\Seeders;

use App\Models\Kunjungan;
use App\Models\Pemeriksaan;
use Illuminate\Database\Seeder;

class PemeriksaanSeeder extends Seeder
{
    /**
     * Jalankan seeder.
     */
    public function run(): void
    {
        // Ambil 15 kunjungan yang sudah dibuat.
        $kunjungans = Kunjungan::orderBy('id')
            ->limit(15)
            ->get();

        foreach ($kunjungans as $kunjungan) {
            Pemeriksaan::create([
                'kunjungan_id' => $kunjungan->id,

                'keluhan' => fake()->sentence(),

                'hasil_pemeriksaan' => fake()->randomElement([
                    'Kondisi umum pasien stabil.',
                    'Tekanan darah normal dan suhu tubuh normal.',
                    'Tekanan darah sedikit meningkat.',
                    'Suhu tubuh meningkat dan pasien tampak lemah.',
                ]),

                'riwayat_penyakit' => fake()->randomElement([
                    'Tidak ada riwayat penyakit khusus.',
                    'Memiliki riwayat hipertensi.',
                    'Memiliki riwayat maag.',
                    'Memiliki riwayat alergi obat tertentu.',
                ]),

                'tanggal_periksa' => now()->subDays(
                    fake()->numberBetween(0, 30)
                ),
            ]);
        }
    }
}