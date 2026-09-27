<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Jalankan seluruh seeder aplikasi.
     */
    public function run(): void
    {
        // ==========================================
        // 1. DATA MASTER
        // ==========================================

        // Poli harus tersedia sebelum Dokter dan Kunjungan.
        $this->call([
            PoliSeeder::class,
        ]);

        // ==========================================
        // 2. DATA PENGGUNA
        // ==========================================

        // Membuat akun dan profil:
        // - 10 Pasien
        // - 2 Admin
        // - 3 Dokter
        $this->call([
            PasienSeeder::class,
            AdminSeeder::class,
            DokterSeeder::class,
        ]);

        // ==========================================
        // 3. DATA TRANSAKSI
        // ==========================================

        // Kunjungan membutuhkan Pasien, Dokter, dan Poli.
        $this->call([
            KunjunganSeeder::class,
        ]);

        // ==========================================
        // 4. DATA DETAIL PELAYANAN
        // ==========================================

        // Setiap kunjungan memiliki:
        // - Antrean
        // - Pemeriksaan
        // - Diagnosis
        $this->call([
            AntreanSeeder::class,
            PemeriksaanSeeder::class,
            DiagnosisSeeder::class,
        ]);

        // ==========================================
        // 5. DATA LAPORAN
        // ==========================================

        // Laporan dibuat oleh Admin.
        $this->call([
            LaporanSeeder::class,
        ]);
    }
}