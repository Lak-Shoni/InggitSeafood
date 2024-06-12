<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('menus')->insert([
            [
                'kategori_paket' => 'Utama',
                'nama_menu' => 'Nasi Goreng',
                'gambar_menu' => 'nasi-goreng.jpg',
                'isi_menu' => 'Nasi goreng dengan bumbu khas',
                'harga_menu' => 20000.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kategori_paket' => 'Utama',
                'nama_menu' => 'Ayam Bakar',
                'gambar_menu' => 'ayam-bakar.jpg',
                'isi_menu' => 'Ayam bakar dengan bumbu rempah',
                'harga_menu' => 25000.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Tambahkan item menu lainnya
        ]);
    }
}
