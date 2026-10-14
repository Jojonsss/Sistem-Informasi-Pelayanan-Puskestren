<?php

namespace Database\Seeders;

use App\Models\Pasien;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PasienSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::updateOrCreate(
            ['email' => 'pasien@puskestren.test'],
            [
                'name' => 'Pasien Demo',
                'password' => Hash::make('password'),
                'role' => 'pasien',
                'status' => 'aktif',
            ]
        );

        Pasien::updateOrCreate(
            ['user_id' => $user->id],
            [
                'jenis_pasien' => 'santri',
                'no_identitas' => '0000000000000001',
                'alamat' => 'Pesantren Puskestren',
                'no_hp' => '081234567892',
            ]
        );

        $remaining = max(0, 10 - Pasien::count());

        if ($remaining > 0) {
            Pasien::factory()->count($remaining)->create();
        }
    }
}
