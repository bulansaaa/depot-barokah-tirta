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

    // Relasi: satu jadwal memiliki banyak log harian
    public function logs()
    {
        return $this->hasMany(JadwalLog::class, 'jadwal_rutin_id');
    }

    // Scope: hanya jadwal yang aktif
    public function scopeAktif($query)
    {
        return $query->where('status_aktif', true);
    }

    // Scope: filter berdasarkan hari
    public function scopeHari($query, string $hari)
    {
        return $query->where(function($q) use ($hari) {
            $q->where('hari_pengiriman', $hari)
              ->orWhere('hari_pengiriman', 'Setiap Hari');
        });
    }

    // Helper: cek apakah jadwal ini aktif hari ini
    public function isHariIni(): bool
    {
        $hariIni = now()->locale('id')->dayName; // Senin, Selasa, dst.
        return strtolower($this->hari_pengiriman) === strtolower($hariIni);
    }
}