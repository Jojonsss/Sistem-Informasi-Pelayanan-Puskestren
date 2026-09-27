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
            Laporan::create([
                'admin_id' => $admins[$index % $admins->count()]->id,
                'jenis_laporan' => $jenis,
                'periode' => $periode[$index],
                'tanggal_cetak' => now()->subDays($index + 1),
                'file_laporan' => 'laporan-' . ($index + 1) . '.pdf',
            ]);
        }
    }
}