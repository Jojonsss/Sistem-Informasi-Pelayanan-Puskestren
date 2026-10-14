<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Laporan;
use Illuminate\Database\Seeder;

class LaporanSeeder extends Seeder
{
    public function run(): void
    {
        $admins = Admin::orderBy('id')->get();

        if ($admins->isEmpty()) {
            return;
        }

        $jenisLaporan = [
            'Laporan Data Pasien',
            'Laporan Kunjungan',
            'Laporan Pelayanan Poli',
        ];

        $periode = [
            'Januari 2026',
            'Februari 2026',
            'Maret 2026',
        ];

        foreach ($jenisLaporan as $index => $jenis) {
            Laporan::updateOrCreate(
                [
                    'jenis_laporan' => $jenis,
                    'periode' => $periode[$index],
                ],
                [
                    'admin_id' => $admins[$index % $admins->count()]->id,
                    'tanggal_cetak' => now()->subDays($index + 1),
                    'file_laporan' => 'laporan-' . ($index + 1) . '.pdf',
                ]
            );
        }
    }
}