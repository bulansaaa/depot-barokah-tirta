<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi';

    protected $fillable = [
        'kode_transaksi',
        'pelanggan_id',
        'user_id',
        'tipe_transaksi',
        'metode_pemesanan',
        'status_transaksi',
        'tanggal_transaksi',
        'total_harga',
        'catatan',
    ];

    protected $casts = [
        'tanggal_transaksi' => 'datetime',
        'total_harga'       => 'decimal:2',
    ];

    // Relasi: transaksi dimiliki oleh satu pelanggan
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'pelanggan_id');
    }

    // Relasi: transaksi dimiliki oleh satu admin
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi: satu transaksi memiliki banyak detail
    public function detail()
    {
        return $this->hasMany(TransaksiDetail::class, 'transaksi_id');
    }

    // Generate kode transaksi otomatis: TRX-20250515-001
    public static function generateKode(): string
    {
        $tanggal = now()->format('Ymd');
        $prefix  = 'TRX-' . $tanggal . '-';

        $last = self::where('kode_transaksi', 'like', $prefix . '%')
            ->orderByDesc('kode_transaksi')
            ->first();

        if ($last) {
            $lastNumber = (int) substr($last->kode_transaksi, -3);
            $newNumber  = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '001';
        }

        return $prefix . $newNumber;
    }

    // Scope filter berdasarkan status
    public function scopeByStatus($query, string $status)
    {
        return $query->where('status_transaksi', $status);
    }

    // Scope transaksi hari ini
    public function scopeHariIni($query)
    {
        return $query->whereDate('tanggal_transaksi', today());
    }

    // Scope transaksi bulan ini
    public function scopeBulanIni($query)
    {
        return $query->whereMonth('tanggal_transaksi', now()->month)
                     ->whereYear('tanggal_transaksi', now()->year);
    }
}