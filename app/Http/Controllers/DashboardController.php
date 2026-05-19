<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Pelanggan;
use App\Models\JadwalRutin;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = today();
        $hariIni = Carbon::now()->locale('id')->isoFormat('dddd'); // Senin, Selasa, dst.

        // Statistik harian
        $transaksiHariIni = Transaksi::hariIni()->count();
        $pendapatanHariIni = Transaksi::hariIni()
            ->where('status_transaksi', 'selesai')
            ->sum('total_harga');

        // Statistik bulanan
        $transaksibulanIni = Transaksi::bulanIni()->count();
        $pendapatanBulanIni = Transaksi::bulanIni()
            ->where('status_transaksi', 'selesai')
            ->sum('total_harga');

        // Transaksi pending & diproses
        $transaksiPending = Transaksi::byStatus('pending')->count();
        $transaksiDiproses = Transaksi::byStatus('diproses')->count();

        // Jadwal pengantaran hari ini (hanya yang belum terkirim)
        $jadwalHariIni = JadwalRutin::with('pelanggan')
            ->aktif()
            ->hari($hariIni)
            ->whereDoesntHave('pelanggan.transaksi', function ($query) {
                $query->whereDate('tanggal_transaksi', Carbon::today());
            })
            ->get();

        // Transaksi terbaru (5 terakhir)
        $transaksiTerbaru = Transaksi::with('pelanggan')
            ->latest()
            ->limit(5)
            ->get();

        // Total pelanggan
        $totalPelanggan = Pelanggan::count();

        return view('dashboard', compact(
            'transaksiHariIni',
            'pendapatanHariIni',
            'transaksibulanIni',
            'pendapatanBulanIni',
            'transaksiPending',
            'transaksiDiproses',
            'jadwalHariIni',
            'transaksiTerbaru',
            'totalPelanggan'
        ));
    }
}