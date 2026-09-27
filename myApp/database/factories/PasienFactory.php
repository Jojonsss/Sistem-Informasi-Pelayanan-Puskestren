<?php

namespace Database\Factories;

use App\Models\Pasien;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pasien>
 */
class PasienFactory extends Factory
{
    protected $model = Pasien::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory()->state([
                'role' => 'pasien',
                'status' => 'aktif',
            ]),
            'jenis_pasien' => fake()->randomElement([
                'santri',
                'umum',
            ]),
            'no_identitas' => fake()->numerify('################'),
            'alamat' => fake()->address(),
            'no_hp' => fake()->phoneNumber(),
        ];
    }
}