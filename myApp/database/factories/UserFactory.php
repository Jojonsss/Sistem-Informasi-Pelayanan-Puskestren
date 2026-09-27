<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Password default untuk data dummy.
     */
    protected static ?string $password = null;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),

            'email' => fake()->unique()->safeEmail(),

            'email_verified_at' => now(),

            'password' => static::$password ??= Hash::make('password'),

            'role' => 'pasien',

            'status' => 'aktif',

            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Data user sebagai admin.
     */
    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'admin',
        ]);
    }

    /**
     * Data user sebagai dokter.
     */
    public function dokter(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'dokter',
        ]);
    }

    /**
     * Data user sebagai pasien.
     */
    public function pasien(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'pasien',
        ]);
    }
}