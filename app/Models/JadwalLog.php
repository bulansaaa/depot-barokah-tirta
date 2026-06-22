<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JadwalLog extends Model
{
    use HasFactory;

    protected $table = 'jadwal_log';

    protected $fillable = [
        'jadwal_rutin_id',
        'tanggal',
        'status',
        'catatan',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function jadwalRutin()
    {
        return $this->belongsTo(JadwalRutin::class, 'jadwal_rutin_id');
    }
}
