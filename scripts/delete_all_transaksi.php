<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

$transaksiCount = DB::table('transaksi')->count();
$detailCount = DB::table('transaksi_detail')->count();

echo "Before delete: transaksi={$transaksiCount}, detail={$detailCount}\n";

DB::transaction(function () {
    DB::table('transaksi_detail')->delete();
    DB::table('transaksi')->delete();
});

$transaksiCountAfter = DB::table('transaksi')->count();
$detailCountAfter = DB::table('transaksi_detail')->count();

echo "After delete: transaksi={$transaksiCountAfter}, detail={$detailCountAfter}\n";
