<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kamar;

class KamarSeeder extends Seeder
{
    public function run(): void
    {
        Kamar::insert([
            [
                'no_kamar' => '101',
                'tipe_kamar' => 'Standard',
                'harga_per_malam' => 150000,
                'status_kamar' => 'tersedia',
            ],
            [
                'no_kamar' => '102',
                'tipe_kamar' => 'Standard',
                'harga_per_malam' => 150000,
                'status_kamar' => 'tersedia',
            ],
            [
                'no_kamar' => '201',
                'tipe_kamar' => 'Deluxe',
                'harga_per_malam' => 250000,
                'status_kamar' => 'tersedia',
            ],
            [
                'no_kamar' => '202',
                'tipe_kamar' => 'Deluxe',
                'harga_per_malam' => 250000,
                'status_kamar' => 'tersedia',
            ],
            [
                'no_kamar' => '301',
                'tipe_kamar' => 'Suite',
                'harga_per_malam' => 350000,
                'status_kamar' => 'tersedia',
            ],
        ]);
    }
}