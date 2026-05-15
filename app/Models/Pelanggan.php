<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pelanggan extends Model
{
    use HasFactory;

    protected $table = 'pelanggan';

    protected $fillable = [
        'nama',
        'no_hp',
        'alamat',
        'catatan',
    ];

    // Relasi: satu pelanggan memiliki banyak transaksi
    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'pelanggan_id');
    }

    // Relasi: satu pelanggan memiliki banyak jadwal rutin
    public function jadwalRutin()
    {
        return $this->hasMany(JadwalRutin::class, 'pelanggan_id');
    }
}