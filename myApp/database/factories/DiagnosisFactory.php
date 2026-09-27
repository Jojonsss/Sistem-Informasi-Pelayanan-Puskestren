<?php

namespace Database\Factories;

use App\Models\Diagnosis;
use App\Models\Kunjungan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Diagnosis>
 */
class DiagnosisFactory extends Factory
{
    protected $model = Diagnosis::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'kunjungan_id' => Kunjungan::factory(),

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

            'tanggal_diagnosis' => fake()->dateTimeBetween(
                '-30 days',
                'now'
            ),
        ];
    }
}