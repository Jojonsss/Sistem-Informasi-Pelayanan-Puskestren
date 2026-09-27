<?php

namespace Database\Factories;

use App\Models\Kunjungan;
use App\Models\Pemeriksaan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pemeriksaan>
 */
class PemeriksaanFactory extends Factory
{
    protected $model = Pemeriksaan::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'kunjungan_id' => Kunjungan::inRandomOrder()->first()?->id
                ?? Kunjungan::factory(),

            'keluhan' => fake()->sentence(),

            'hasil_pemeriksaan' => fake()->randomElement([
                'Tekanan darah normal, suhu tubuh normal.',
                'Tekanan darah sedikit meningkat.',
                'Suhu tubuh meningkat dan pasien tampak lemah.',
                'Kondisi umum pasien stabil.',
            ]),

            'riwayat_penyakit' => fake()->randomElement([
                'Tidak ada riwayat penyakit khusus.',
                'Memiliki riwayat hipertensi.',
                'Memiliki riwayat maag.',
                'Memiliki riwayat alergi obat tertentu.',
            ]),

            'tanggal_periksa' => fake()->dateTimeBetween(
                '-30 days',
                'now'
            ),
        ];
    }
}