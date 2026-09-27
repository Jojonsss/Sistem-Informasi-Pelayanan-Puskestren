<?php

namespace Database\Factories;

use App\Models\Dokter;
use App\Models\Poli;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Dokter>
 */
class DokterFactory extends Factory
{
    protected $model = Dokter::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory()->state([
                'role' => 'dokter',
                'status' => 'aktif',
            ]),

            'poli_id' => Poli::inRandomOrder()->first()?->id
                ?? Poli::factory(),

            'nama' => fake()->name(),

            'spesialisasi' => fake()->randomElement([
                'Dokter Umum',
                'Dokter Gigi',
                'KIA',
            ]),

            'no_sip' => fake()->unique()->numerify('SIP-##########'),

            'no_hp' => fake()->phoneNumber(),
        ];
    }
}