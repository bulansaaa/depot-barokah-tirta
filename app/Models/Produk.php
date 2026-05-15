<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'produk';

    protected $fillable = [
        'nama_produk',
        'harga',
        'satuan',
        'status_aktif',
    ];

    protected $casts = [
        'status_aktif' => 'boolean',
        'harga'        => 'decimal:2',
    ];

    // Relasi: satu produk memiliki banyak detail transaksi
    public function transaksiDetail()
    {
        return $this->hasMany(TransaksiDetail::class, 'produk_id');
    }

    // Scope: hanya produk yang aktif
    public function scopeAktif($query)
    {
        return $query->where('status_aktif', true);
    }
}