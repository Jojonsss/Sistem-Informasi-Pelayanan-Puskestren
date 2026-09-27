<?php

namespace Database\Factories;

use App\Models\Admin;
use App\Models\Laporan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Laporan>
 */
class LaporanFactory extends Factory
{
    protected $model = Laporan::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'admin_id' => Admin::factory(),

            'jenis_laporan' => fake()->randomElement([
                'Laporan Data Pasien',
                'Laporan Kunjungan',
                'Laporan Pelayanan Poli',
                'Laporan Antrean',
            ]),

            'periode' => fake()->randomElement([
                'Januari 2026',
                'Februari 2026',
                'Maret 2026',
                'April 2026',
                'Mei 2026',
                'Juni 2026',
            ]),

            'tanggal_cetak' => fake()->dateTimeBetween(
                '-30 days',
                'now'
            ),

            'file_laporan' => fake()->optional()->lexify('laporan-????.pdf'),
        ];
    }
}