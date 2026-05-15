<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin user
        DB::table('users')->insert([
            'name'       => 'Admin Barokah',
            'email'      => 'admin@barokah.com',
            'password'   => Hash::make('password123'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Produk awal
        DB::table('produk')->insert([
            [
                'nama_produk'  => 'Isi Ulang Galon',
                'harga'        => 5000,
                'satuan'       => 'galon',
                'status_aktif' => true,
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'nama_produk'  => 'Aqua Galon',
                'harga'        => 20000,
                'satuan'       => 'galon',
                'status_aktif' => true,
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
        ]);

        // Pelanggan contoh
        DB::table('pelanggan')->insert([
            [
                'nama'       => 'Budi Santoso',
                'no_hp'      => '08123456789',
                'alamat'     => 'Jl. Mawar No. 1, Magelang',
                'catatan'    => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama'       => 'Siti Rahayu',
                'no_hp'      => '08987654321',
                'alamat'     => 'Jl. Melati No. 5, Magelang',
                'catatan'    => 'Pelanggan langganan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}