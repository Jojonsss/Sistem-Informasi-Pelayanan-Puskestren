<?php

namespace Database\Factories;

use App\Models\Dokter;
use App\Models\Kunjungan;
use App\Models\Pasien;
use App\Models\Poli;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Kunjungan>
 */
class KunjunganFactory extends Factory
{
    protected $model = Kunjungan::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'pasien_id' => Pasien::inRandomOrder()->first()?->id
                ?? Pasien::factory(),

            'dokter_id' => Dokter::inRandomOrder()->first()?->id
                ?? Dokter::factory(),

            'poli_id' => Poli::inRandomOrder()->first()?->id
                ?? Poli::factory(),

            'tanggal_kunjungan' => fake()->dateTimeBetween(
                '-30 days',
                'now'
            )->format('Y-m-d'),

            'keluhan' => fake()->sentence(),

            'status' => fake()->randomElement([
                'menunggu',
                'diperiksa',
                'selesai',
                'dibatalkan',
            ]),
        ];
    }
}