<?php

namespace Database\Seeders;

use App\Models\Kunjungan;
use Illuminate\Database\Seeder;

class KunjunganSeeder extends Seeder
{
    public function run(): void
    {
        $target = 15;
        $jumlahSekarang = Kunjungan::count();

        if ($jumlahSekarang < $target) {
            Kunjungan::factory()
                ->count($target - $jumlahSekarang)
                ->create();
        }
    }
}