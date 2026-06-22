<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\JadwalRutin;
use App\Models\JadwalLog;
use Carbon\Carbon;

class CheckMissedSchedules extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-missed-schedules';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cek jadwal rutin hari ini yang terlewat (tidak ada transaksi atau status gagal)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $hariIni = Carbon::now()->locale('id')->isoFormat('dddd');
        $tanggal = Carbon::today();

        $jadwalAktif = JadwalRutin::aktif()
            ->hari($hariIni)
            ->get();

        foreach ($jadwalAktif as $jadwal) {
            // Cek apakah sudah ada log atau transaksi hari ini
            $exists = JadwalLog::where('jadwal_rutin_id', $jadwal->id)
                ->where('tanggal', $tanggal)
                ->exists();

            if (!$exists) {
                // Cek apakah ada transaksi manual hari ini (backup check)
                $hasTransaksi = $jadwal->pelanggan->transaksi()
                    ->whereDate('tanggal_transaksi', $tanggal)
                    ->exists();

                if (!$hasTransaksi) {
                    JadwalLog::create([
                        'jadwal_rutin_id' => $jadwal->id,
                        'tanggal' => $tanggal,
                        'status' => 'terlewat',
                        'catatan' => 'Otomatis ditandai terlewat oleh sistem.',
                    ]);
                    $this->info("Jadwal ID {$jadwal->id} ({$jadwal->pelanggan->nama}) ditandai terlewat.");
                } else {
                    // Jika ada transaksi tapi belum ada log, buat log terkirim
                    JadwalLog::create([
                        'jadwal_rutin_id' => $jadwal->id,
                        'tanggal' => $tanggal,
                        'status' => 'terkirim',
                    ]);
                }
            }
        }

        $this->info('Pengecekan jadwal selesai.');
    }
}
