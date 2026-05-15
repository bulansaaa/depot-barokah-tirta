<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TransaksiDetail extends Model
{
    use HasFactory;

    protected $table = 'transaksi_detail';

    protected $fillable = [
        'transaksi_id',
        'produk_id',
        'qty',
        'harga',
        'subtotal',
    ];

    protected $casts = [
        'harga'    => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];

    // Relasi: detail dimiliki oleh satu transaksi
    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'transaksi_id');
    }

    // Relasi: detail merujuk ke satu produk
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }

    // Hitung subtotal otomatis sebelum disimpan
    protected static function booted(): void
    {
        static::saving(function (TransaksiDetail $detail) {
            $detail->subtotal = $detail->harga * $detail->qty;
        });
    }
}