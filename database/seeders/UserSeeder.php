<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'username' => 'pelanggan',
            'nama_lengkap' => 'Pelanggan Percobaan',
            'email' => 'pelanggan@example.com',
            'no_hp' => '081234567890',
            'password' => Hash::make('pelanggan123'),
        ]);
    }
}