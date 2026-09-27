<?php

namespace Database\Factories;

use App\Models\Antrean;
use App\Models\Kunjungan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Antrean>
 */
class AntreanFactory extends Factory
{
    protected $model = Antrean::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'kunjungan_id' => Kunjungan::inRandomOrder()->first()?->id
                ?? Kunjungan::factory(),

            'nomor_antrian' => fake()->unique()->numerify('A-###'),

            'status' => fake()->randomElement([
                'menunggu',
                'dipanggil',
                'dilayani',
                'selesai',
                'dibatalkan',
            ]),

            'waktu_daftar' => fake()->dateTimeBetween(
                '-30 days',
                'now'
            ),
        ];
    }
}