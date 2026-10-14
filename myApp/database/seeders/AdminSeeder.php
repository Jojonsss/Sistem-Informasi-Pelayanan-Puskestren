<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::updateOrCreate(
            ['email' => 'admin@puskestren.test'],
            [
                'name' => 'Admin Puskestren',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'status' => 'aktif',
            ]
        );

        Admin::updateOrCreate(
            ['user_id' => $user->id],
            [
                'nama' => 'Admin Puskestren',
                'no_hp' => '081234567891',
            ]
        );

        $remaining = max(0, 2 - Admin::count());

        if ($remaining > 0) {
            Admin::factory()->count($remaining)->create();
        }
    }
}
