<?php

namespace Database\Seeders;

use App\Models\Poli;
use Illuminate\Database\Seeder;

class PoliSeeder extends Seeder
{
    /**
     * Jalankan seeder.
     */
    public function run(): void
    {
        $dataPoli = [
            [
                'nama_poli' => 'Poli Umum',
                'deskripsi' => 'Pelayanan pemeriksaan kesehatan umum.',
                'status' => 'aktif',
            ],
            [
                'nama_poli' => 'Poli Gigi',
                'deskripsi' => 'Pelayanan pemeriksaan dan perawatan gigi.',
                'status' => 'aktif',
            ],
            [
                'nama_poli' => 'Poli KIA',
                'deskripsi' => 'Pelayanan kesehatan ibu dan anak.',
                'status' => 'aktif',
            ],
        ];

        foreach ($dataPoli as $poli) {
            Poli::create($poli);
        }
    }
}