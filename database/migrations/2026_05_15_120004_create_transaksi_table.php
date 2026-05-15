<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id();
            $table->string('kode_transaksi', 30)->unique();
            $table->foreignId('pelanggan_id')->nullable()->constrained('pelanggan')->nullOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->enum('tipe_transaksi', ['langsung', 'antar', 'langganan'])->default('langsung');
            $table->enum('metode_pemesanan', ['langsung', 'whatsapp', 'telepon'])->default('langsung');
            $table->enum('status_transaksi', ['pending', 'diproses', 'diantar', 'selesai', 'dibatalkan'])->default('pending');
            $table->datetime('tanggal_transaksi');
            $table->decimal('total_harga', 12, 2)->default(0);
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};