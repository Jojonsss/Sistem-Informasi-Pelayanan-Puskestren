<?php

namespace Database\Factories;

use App\Models\Poli;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Poli>
 */
class PoliFactory extends Factory
{
    protected $model = Poli::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'nama_poli' => fake()->unique()->randomElement([
                'Poli Umum',
                'Poli Gigi',
                'Poli KIA',
            ]),

            'deskripsi' => fake()->sentence(),

            'status' => 'aktif',
        ];
    }
}