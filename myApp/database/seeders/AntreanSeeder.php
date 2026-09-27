<?php

namespace Database\Seeders;

use App\Models\Antrean;
use App\Models\Kunjungan;
use Illuminate\Database\Seeder;

class AntreanSeeder extends Seeder
{
    public function run(): void
    {
        $kunjungans = Kunjungan::orderBy('id')
            ->limit(15)
            ->get();

        foreach ($kunjungans as $index => $kunjungan) {
            Antrean::create([
                'kunjungan_id' => $kunjungan->id,
                'nomor_antrian' => 'A-' . str_pad($index + 1, 3, '0', STR_PAD_LEFT),
                'status' => fake()->randomElement([
                    'menunggu',
                    'dipanggil',
                    'dilayani',
                    'selesai',
                ]),
                'waktu_daftar' => now()->subDays(
                    fake()->numberBetween(0, 30)
                ),
            ]);
        }
    }
}