<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Pelanggan;
use App\Models\Produk;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

$pelanggan = Pelanggan::firstOrCreate(
    ['nama' => 'Pabrik JJ Gloves'],
    [
        'no_hp'      => '081234567890',
        'alamat'     => 'Pabrik JJ Gloves',
        'catatan'    => 'Pelangan pabrik JJ Gloves',
        'created_at' => now(),
        'updated_at' => now(),
    ]
);
echo "Pelanggan id: {$pelanggan->id}\n";

$produk = Produk::firstOrCreate(
    ['nama_produk' => 'Isi Ulang Galon'],
    [
        'harga'        => 5000,
        'satuan'       => 'galon',
        'status_aktif' => true,
        'created_at'   => now(),
        'updated_at'   => now(),
    ]
);
echo "Produk id: {$produk->id}, harga: {$produk->harga}\n";

$user = User::first();
if (! $user) {
    $user = User::create([
        'name'       => 'Admin Barokah',
        'email'      => 'admin@barokah.local',
        'password'   => Hash::make('password123'),
        'created_at' => now(),
        'updated_at' => now(),
    ]);
    echo "Created default user id: {$user->id}\n";
} else {
    echo "Using existing user id: {$user->id}\n";
}

DB::transaction(function () use ($pelanggan, $produk, $user) {
    for ($day = 1; $day <= 22; $day++) {
        $tanggal = Carbon::create(2026, 6, $day, 9, 0, 0);
        $kode = sprintf('%03d-%02d%02d', $day, $day, 6);

        if (Transaksi::where('kode_transaksi', $kode)->exists()) {
            echo "Skip existing kode {$kode}\n";
            continue;
        }

        $total = $produk->harga * 40;

        $transaksi = Transaksi::create([
            'kode_transaksi'    => $kode,
            'pelanggan_id'      => $pelanggan->id,
            'user_id'           => $user->id,
            'tipe_transaksi'    => 'antar',
            'metode_pemesanan'  => 'whatsapp',
            'alamat_pengiriman' => $pelanggan->alamat,
            'no_hp_pengiriman'  => $pelanggan->no_hp,
            'status_transaksi'  => 'selesai',
            'tanggal_transaksi' => $tanggal,
            'total_harga'       => $total,
            'catatan'           => 'Isi ulang 40 galon per hari',
        ]);

        $transaksi->detail()->create([
            'produk_id' => $produk->id,
            'qty'       => 40,
            'harga'     => $produk->harga,
        ]);

        echo "Created transaksi {$kode} for {$tanggal->toDateString()}\n";
    }
});

echo "Done inserting transaksi 1 Juni sampai 22 Juni.\n";
