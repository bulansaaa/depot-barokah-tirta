<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jadwal_log', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jadwal_rutin_id')->constrained('jadwal_rutin')->cascadeOnDelete();
            $table->date('tanggal');
            $table->enum('status', ['terkirim', 'gagal', 'terlewat']);
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jadwal_log');
    }
};
