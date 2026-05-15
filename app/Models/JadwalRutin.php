<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JadwalRutin extends Model
{
    use HasFactory;

    protected $table = 'jadwal_rutin';

    protected $fillable = [
        'pelanggan_id',
        'hari_pengiriman',
        'alamat_pengiriman',
        'status_aktif',
        'catatan',
    ];

    protected $casts = [
        'status_aktif' => 'boolean',
    ];

    // Relasi: jadwal dimiliki oleh satu pelanggan
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'pelanggan_id');
    }

    // Scope: hanya jadwal yang aktif
    public function scopeAktif($query)
    {
        return $query->where('status_aktif', true);
    }

    // Scope: filter berdasarkan hari
    public function scopeHari($query, string $hari)
    {
        return $query->where('hari_pengiriman', $hari);
    }

    // Helper: cek apakah jadwal ini aktif hari ini
    public function isHariIni(): bool
    {
        $hariIni = now()->locale('id')->dayName; // Senin, Selasa, dst.
        return strtolower($this->hari_pengiriman) === strtolower($hariIni);
    }
}