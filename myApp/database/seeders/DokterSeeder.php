<?php

namespace Database\Seeders;

use App\Models\Dokter;
use App\Models\Poli;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DokterSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::updateOrCreate(
            ['email' => 'dokter@puskestren.test'],
            [
                'name' => 'Dokter Demo',
                'password' => Hash::make('password'),
                'role' => 'dokter',
                'status' => 'aktif',
            ]
        );

        $poli = Poli::query()->firstOrFail();

        Dokter::updateOrCreate(
            ['user_id' => $user->id],
            [
                'poli_id' => $poli->id,
                'nama' => 'Dokter Demo',
                'spesialisasi' => 'Dokter Umum',
                'no_sip' => 'SIP-0000000001',
                'no_hp' => '081234567893',
            ]
        );

        $remaining = max(0, 3 - Dokter::count());

        if ($remaining > 0) {
            Dokter::factory()->count($remaining)->create();
        }
    }
}
