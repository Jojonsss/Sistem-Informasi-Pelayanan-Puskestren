<?php

namespace Database\Seeders;

use App\Models\Diagnosis;
use App\Models\Kunjungan;
use Illuminate\Database\Seeder;

class DiagnosisSeeder extends Seeder
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
            Diagnosis::create([
                'kunjungan_id' => $kunjungan->id,

                'diagnosis' => fake()->randomElement([
                    'Infeksi Saluran Pernapasan Akut (ISPA)',
                    'Gastritis',
                    'Demam akibat infeksi virus',
                    'Hipertensi ringan',
                    'Sakit gigi',
                    'Batuk dan pilek',
                ]),

                'tindakan' => fake()->randomElement([
                    'Pemberian obat dan edukasi kesehatan.',
                    'Pemeriksaan lanjutan dan pemberian terapi.',
                    'Pemberian obat sesuai hasil pemeriksaan.',
                    'Edukasi pola hidup sehat dan kontrol ulang.',
                ]),

                'catatan' => fake()->optional()->sentence(),

                'tanggal_diagnosis' => now()->subDays(
                    fake()->numberBetween(0, 30)
                ),
            ]);
        }
    }
}