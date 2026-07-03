<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

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
        'alamat_pengiriman',
        'no_hp_pengiriman',
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

    // Generate kode transaksi otomatis: TRX-22-06-26-001 (prefix + DD-MM-YY + nomor urut)
    public static function generateKode($tanggal = null): string
    {
        if (!$tanggal) {
            $tanggal = now();
        } else {
            $tanggal = is_string($tanggal) ? Carbon::parse($tanggal) : $tanggal;
        }

        $dateFormat = $tanggal->format('d-m-y'); // 22-06-26
        $prefix     = 'TRX-' . $dateFormat; // TRX-22-06-26
        $pattern    = $prefix . '%';

        $last = self::where('kode_transaksi', 'like', $pattern)
            ->orderByDesc('kode_transaksi')
            ->lockForUpdate()
            ->first();

        if ($last) {
            // Format: TRX-22-06-26-001, extract nomor urut dari posisi 13 (setelah "TRX-22-06-26-")
            $lastNumber = (int) substr($last->kode_transaksi, strlen($prefix) + 1, 3);
            $newNumber  = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '001';
        }

        return $prefix . '-' . $newNumber;
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

    // Scope urutkan dari tanggal paling lama (oldest first)
    public function scopeOldestFirst($query)
    {
        return $query->orderBy('tanggal_transaksi', 'asc');
    }

    // Scope urutkan dari tanggal paling baru (newest first)
    public function scopeNewestFirst($query)
    {
        return $query->orderBy('tanggal_transaksi', 'desc');
    }
}